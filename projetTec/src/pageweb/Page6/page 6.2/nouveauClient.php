<!"réalisé par Liam Mayeux , Nicolas Deronsart et Victor Tancrez">
<!"page permettant d'ajouter une commande (c'est à dire retirer une quantité d'un article ) et de créer un nouveau client dans l'indice customer">
<?php
    ini_set("display_errors",TRUE);
    error_reporting(E_ALL);
    session_start();
    if(isset($_POST["pagePrecedente"])){
        header('Location: ../ajouteCommande.php');}
    if(isset($_POST["accueil"])){
        header('Location: ../../Page1/Accueil.php');}
    if (isset($_POST["vider"])){
        // on vide les inputs à l'écran
        $_SESSION["prenom"]="";
        $_SESSION["nom"]="";
        $_SESSION["civilité"]="";
        $_SESSION["quantité"]="";
        $_SESSION["article"]="";
        $_SESSION["dejaEnregistré"]="autre"; 

    }
    if( isset($_POST["confirmation"])){
        // fonction pour ajouter un client à la base elasticsearch à l'indice customer 
        function addCustomer($civilite,$prenom,$nom,$mail,$pointFidelite,$num){
                $output=shell_exec("curl -X GET \"localhost:9200/customer/_search?q=$prenom+$nom\"");
                if(strpos($output, $prenom) == true && strpos($output, $nom) == true  ){ // on vérifie s'il existe ou pas dans la base
                    $_SESSION["prenom"]=$prenom;
                    $_SESSION["nom"]=$nom;
                    $_SESSION["civilité"]=$civilite;
                    $_SESSION["quantité"]=$_POST["quantité"];
                    $_SESSION["article"]=$_POST["article"];
                    $_SESSION["dejaEnregistré"]="oui"; 

                    header('location: ../page 6.1/clientEnregistre.php');// on redirige vers la page pour les clients déjà enregistrés avec les informations stockés dans la session
                }
                
                else{
                    $_SESSION["dejaEnregistré"]="autre";
                    $array = Array ("civility" => $civilite, "firstName" =>  $prenom, "lastName " =>  $nom ,"mail" =>  $mail , "phone" =>  $num ,"loyaltyPoints" =>  "0");
                    $json = json_encode($array); 
                    shell_exec("curl -XPOST http://localhost:9200/customer/_doc/ -H \"Content-Type: application/json\" -d '$json'"); // on ajoute le client dans l'indice customer
            
                    }}

        
        addCustomer($_POST["civilité"],$_POST["prenom"],$_POST["nom"],$_POST["mail"],56,$_POST["num"]);
        // fonction qui permet de update le stock
        function updateStock($article,$quantité,$civilite,$prenom,$nom){
                $quantité=(int)$quantité;
                /* query pour décrementer la quantité de l"$article du stock*/
                $query="{
                    \"script\" : {
                            \"source\": \"ctx._source.quantity-=$quantité;\",
                            \"lang\": \"painless\"  
                        },
                        \"query\": {
                            \"term\" : {
                                \"item.keyword\":\"$article\"
                            }
                        }
                    }";

                /* query pour get le json de l'article*/
                $output=shell_exec("curl -X GET \"localhost:9200/inventory/_search?q=$article\"");
                $array = json_decode($output, true);
                $price=$array["hits"]["hits"][0]["_source"]["price"];
                $stock=$array["hits"]["hits"][0]["_source"]["quantity"];
                $pointFidelite=$price/100*$quantité;
                if ($stock-$quantité>=0){ // si le stock est suffisant
                    shell_exec("curl -XPOST \"http://localhost:9200/inventory/_update_by_query\" -H 'Content-Type: application/json' -d '$query'");
                    $turnover=$price*$quantité;
                    $heure=date('H');
                    if($heure=="07" || $heure=="08" ||$heure=="09"){
                        $heure=substr($heure,-1); // on enlève le 0
                    }
                    $annee=date('Y');
                    $annee=substr($annee,-2);
                    $date=date('m-d')."-".$annee;
                    if($civilite=="Mr" || $civilite=="mr"){ // on verifie si le client est un homme
                        $query4="
                        {
                            \"script\" : {
                                \"source\": \"ctx._source.$heure.numberMen+=1; ctx._source.$heure.numberCustomers+=1; ctx._source.$heure.turnover+=$turnover;\", 
                                \"lang\": \"painless\"  
                            },
                            \"query\": {
                                \"term\" : {
                                    \"date.keyword\": \"$date\"
                                }
                            }
                        }
                        }";
                        // permet d'augmenter le turnover et le nombre de customer et numberMen de l'indice shopdailydata à la date d'ajourd'hui
                        echo shell_exec("curl -XPOST \"http://localhost:9200/shopdailydata/_update_by_query\" -H 'Content-Type: application/json' -d '$query4'"); 
                             }
                    else{
                        // permet d'augmenter le turnover et le nombre de customer et numberWomen de l'indice shopdailydata à la date d'ajourd'hui
                        $query4="
                        {
                            \"script\" : {
                                \"source\": \"ctx._source.$heure.numberWomen+=1; ctx._source.$heure.numberCustomers+=1; ctx._source.$heure.turnover+=$turnover;\",
                                \"lang\": \"painless\"  
                            },
                            \"query\": {
                                \"term\" : {
                                    \"date.keyword\": \"$date\"
                                }
                            }
                        }
                        }";
                        echo shell_exec("curl -XPOST \"http://localhost:9200/shopdailydata/_update_by_query\" -H 'Content-Type: application/json' -d '$query4'");
                        echo" femme";}}
                else {
                    $var=$quantité-$stock;
                    echo "stock insuffisant vous ne pouvez commander que $stock".$article;
                }
            }
        updateStock($_POST["article"],$_POST["quantité"],$_POST["civilité"],$_POST["prenom"],$_POST["nom"]);
                }
            
          
    
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="nouveau client">
    <meta name="author" content="Liam Mayeux, Nicolas Deronsart, Victor Tancrez">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mystyle.css">
    <title>Nicotoriam-Ajoute-Commande</title>

</head>



<body>

    <div>
        <p id="p1">Ajouter une commande</p>
    </div>
    <body>
    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
    <fieldset>
    <legend><b>Saisissez vos coordonnées </b></legend>
    <table border="0" >
    <tr>
    <td>Civilité : </td>
    <td><input type="text" name="civilité" value= "<?php
                                                         if($_SESSION["dejaEnregistré"]="non"){  
                                                          if(isset($_SESSION["civilité"])){
                                                            echo $_SESSION["civilité"];}} ?>" /></td>
    <tr>
    <td>Nom : </td>
    <td><input type="text" name="nom" value= "<?php 
                                                          if($_SESSION["dejaEnregistré"]="non"){ if(isset($_SESSION["nom"])){echo $_SESSION["nom"];}}?>" /></td>
    </tr>
    <tr>
    <td>Prénom : </td>
    <td> <input type="text" name="prenom" value="<?php 
                                                          if($_SESSION["dejaEnregistré"]="non"){if(isset($_SESSION["prenom"])){  echo $_SESSION["prenom"];}}?>" /></td>
    </tr>
    <tr>
    <td>Adresse mail: </td>
    <td><input type="text" name="mail" /></td>
    </tr>
    <tr>
    <td>Num :</td>
    <td><input type="text" name="num" /></td>
    </tr>
    <tr>
    <td>article :</td>
    <td><input type="text" name="article" value="<?php 
                                                          if($_SESSION["dejaEnregistré"]="non"){ if(isset($_SESSION["civilité"])){ echo $_SESSION["article"];}}?>" }/></td>
    </tr>
    <tr>
    <td>quantité :</td>
    <td><input type="text" name="quantité" value="<?php
                                                          if($_SESSION["dejaEnregistré"]="non"){ if(isset($_SESSION["civilité"])){ echo $_SESSION["quantité"];}}?>" /></td>
    </tr>
    <td>CONFIRMER</td>
    <td><input type="submit" value="ENVOI" name="confirmation"/><input type="submit" value="VIDER" name="vider"/></td>
       
    <form action= "<?php echo $_SERVER["PHP_SELF"]?>" method="post">
        <button id="b1" type="submit" value="ENVOI" name="pagePrecedente">retourner à la page précédente</button>
    </form>
        
    <form action= "<?php echo $_SERVER["PHP_SELF"]?>" method="post">
        <button id="b2" type="submit" value="ENVOI" name="accueil">retourner à la page d'accueil </button>
    </form>
</body>


</html>