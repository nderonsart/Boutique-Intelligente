<!"réalisé par Liam Mayeux , Nicolas Deronsart et Victor Tancrez">
<!"page principale permettant d'accèder à toutes les autres pages du magasin">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Accueil, 1ere page">
    <meta name="author" content="Liam Mayeux, Nicolas Deronsart, Victor Tancrez">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mystyle.css">
    <link rel="shortcut icon" type="image/x-icon" href="../icon/img1.ico" />
    <script type="text/javascript" src="../script.js"></script> 
    <script src="../genereData.js"></script>
    <title>Nicotoriam-Accueil</title>

</head>

<script>
    window.onload = function(){
        document.body.style.opacity = 0;
        fadeInEffect(70);
    }
</script>



<body>

    <div>
        <img src="../img_finales/devanture3.png" alt="Devanture magasin" border=5 height=493 width=1000>
        <p id="titre">BIENVENUE CHEZ NICTORIAM !</p>
        <p id="p1">Magasin de meublage à prix réduits</p>
    </div>

    <table>
        <tr>

            <td>  
                <form action= "../Page2/Camera.php" method="post">
                <button id="b1" action>Camera de sécurité</button>
                </form>
                <br>
                <form action= "../Page7/affichage.php" method="post">
                <button id="b2">Visualiser les statistiques des visiteurs</button>
                </form>
                <br>
            </td>
            <td>    
                <form action= "../Page4/pageInventory.html" method="post">
                <button id="b2"  type="submit" value="ENVOI">Accéder au stock des produits</button>
                </form>
                <form action= "../Page3/infoMagasin.php" method="post">
                <button id="b3"  type="submit" value="ENVOI">Information du magasin en temps réel </button>
                </form>
                
            </td>
            <td>   
                <form action= "../Page6/ajouteCommande.php" method="post">
                <button id="b4" type="submit" value="ENVOI">Ajouter une commande </button>
            </form>

            <form action= "../Page5/Musique.php" method="post">
                <button id="b2" type="submit" value="ENVOI">Changer la musique d'ambiance</button>
            </form>
            </td>
        </tr>
    </table>
    
</body>

<footer>
    
    <p>Authors : Nicolas Deronsart, Victor Tancrez, Liam Mayeux</p>
    
</footer>
</html>