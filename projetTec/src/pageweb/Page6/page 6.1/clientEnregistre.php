<!"réalisé par Liam Mayeux , Nicolas Deronsart et Victor Tancrez">
<!"page permettant d'ajouter une commande (c'est à dire retirer une quantité d'un article )">
<?php
    session_start();
    if(isset($_POST["pagePrecedente"])){
        header('Location: ../ajouteCommande.php');}
    if(isset($_POST["accueil"])){
        header('Location: ../../Page1/Accueil.php');}
    if( isset($_POST["envoyé"])){
        // fonction qui ajoute les points de fidélités au client puis met à jour shopdailydata
        function updatePointFidelite($civilite,$prenom,$nom,$pointFidelite,$turnover){      
              $_SESSION["dejaEnregistré"]="autre";
              
              $query="{
                        \"script\" : {
                          \"source\": \"ctx._source.loyaltyPoints+=$pointFidelite;\",
                          \"lang\": \"painless\"  
                        },
                      \"query\": {
                \"bool\": {
                  \"must\": [
                    {
                    \"match\": {
                        \"lastName .keyword\": \"$nom\"
                      }
                    },
                    {
                      \"match\": {
                        \"firstName.keyword\": \"$prenom\"
                      }
                    }
                  ]
                }
              }
              }";
            // on récupère la date et l'heure
            $heure=date('H');
            if($heure=="07" || $heure=="08" ||$heure=="09"){
                $heure=substr($heure,-1); // on enlève le 0
              }
            $annee=date('Y');
            $annee=substr($annee,-2);
            $date=date('m-d')."-".$annee; 

            if($civilite=="Mr" || $civilite=="mr"){
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
                
                shell_exec("curl -XPOST \"http://localhost:9200/shopdailydata/_update_by_query\" -H 'Content-Type: application/json' -d '$query4'");
              }
           else{
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
                // permet d'augmenter le turnover et le nombre de customer et numberWomen de l'indice shopdailydata à la date d'ajourd'hui
                 shell_exec("curl -XPOST \"http://localhost:9200/shopdailydata/_update_by_query\" -H 'Content-Type: application/json' -d '$query4'");
                }

                shell_exec("curl -XPOST \"http://localhost:9200/customer/_update_by_query\" -H 'Content-Type: application/json' -d '$query'");
    
                  }

        
        
      function updateStock1($article,$quantité,$civilite,$prenom,$nom){
          $output=shell_exec("curl -X GET \"localhost:9200/customer/_search?q=$prenom+$nom\"");
          if(strpos($output, $prenom) == false && strpos($output, $nom) == false  ){ // on vérifie que le client existe 
              $_SESSION["prenom"]=$prenom;
              $_SESSION["nom"]=$nom;
              $_SESSION["civilité"]=$civilite;
              $_SESSION["quantité"]=$_POST["quantité"];
              $_SESSION["article"]=$_POST["article"];
              $_SESSION["dejaEnregistré"]="non"; 
              header('location: ../page 6.2/nouveauClient.php'); // on le redirige s'il n'existe pas 
        }
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
          $turnover=$price*$quantité;
          $pointFidelite=$price/100*$quantité;
          $stock=$array["hits"]["hits"][0]["_source"]["quantity"];
          $pointFidelite=$price/100*$quantité;

          if ($stock-$quantité>=0){
            updatePointFidelite($_POST["civilité"],$_POST["prenom"],$_POST["nom"],$pointFidelite,$turnover);
            shell_exec("curl -XPOST \"http://localhost:9200/inventory/_update_by_query\" -H 'Content-Type: application/json' -d '$query'");
            }
          else {
              $var=$quantité-$stock;
              echo "stock insuffisant vous ne pouvez commander que $stock".$article;
          }
          
          }
          updateStock1($_POST["article"],$_POST["quantité"],$_POST["civilite"],$_POST["prenom"],$_POST["nom"]);
        
        
    }
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="client enregistré">
    <meta name="author" content="Liam Mayeux, Nicolas Deronsart, Victor Tancrez">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mystyle.css">
    <link rel="shortcut icon" type=".../image/x-icon" href="../../icon/img1.ico" />
    <title>Nicotoriam-Ajoute-Commande</title>

</head>



<body>

    <div>
        <p id="p1">Ajouter une commande</p>
    </div>
    <body>
    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
    <fieldset>
    <table border="0" >
    <tr>
    <td>Civilité : </td>
    <td><input type="text" name="civilité" value= "<?php 
                                                       if($_SESSION["dejaEnregistré"]=="non"){ echo $_SESSION["civilité"]; }?>" /></td>
    <tr>
    <td>Nom : </td>
    <td><input type="text" name="nom" value= "<?php 
                                                         if($_SESSION["dejaEnregistré"]=="non"){  
                                                          echo $_SESSION["nom"];}?>" /></td>
    </tr>
    <tr>
    <td>Prénom : </td>
    <td> <input type="text" name="prenom" value="<?php 
                                                           if($_SESSION["dejaEnregistré"]=="non"){echo $_SESSION["prenom"];}?>" /></td>
    </tr>
    <tr>
    <td>article :</td>
    <td><input type="text" name="article" value="<?php 
                                                           if($_SESSION["dejaEnregistré"]=="non"){echo $_SESSION["article"];}?>" /></td>
    </tr>
    <tr>
    <td>quantité :</td>
    <td><input type="text" name="quantité" value="<?php
                                                          if($_SESSION["dejaEnregistré"]=="non"){echo $_SESSION["quantité"];}?>"/></td>
    </tr>
    <td>CONFIRMER</td>
    <td><input type="submit" value="ENVOI" name="envoyé"/></td>
       
    <form action= "<?php echo $_SERVER["PHP_SELF"]?>" method="post">
        <button id="b1" type="submit" value="ENVOI" name="pagePrecedente">retourner à la page précédente</button>
    </form>
        
    <form action= "<?php echo $_SERVER["PHP_SELF"]?>" method="post">
        <button id="b2" type="submit" value="ENVOI" name="accueil">retourner à la page d'accueil </button>
    </form>
</body>


</html>
