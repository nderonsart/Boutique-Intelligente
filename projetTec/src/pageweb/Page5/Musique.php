
<!"réalisé par Liam Mayeux , Nicolas Deronsart et Victor Tancrez">
<!"page permettant de gère la musique du magasin ">
<?php if(isset($_POST["accueil"])){
      header('Location: ../Page1/Accueil.php');}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Musique, 5e page">
    <meta name="author" content="Liam Mayeux, Nicolas Deronsart, Victor Tancrez">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mystyle.css">
    <link rel="shortcut icon" type="image/x-icon" href="../icon/img1.ico" />
    <script type="text/javascript" src="../script.js"></script> 
    <script type="text/javascript" src="./require.js"></script> 
    <title>Nicotoriam-Musique</title>
</head>
<script>
    window.onload = function() {
        document.body.style.opacity = 0;
        fadeInEffect(70);
    }
    /*
    const path = require('path');

    const EXTENSION = '.mp3';

    const targetFiles = files.filter(file => {
        return path.extname(file).toLowerCase() === EXTENSION;
    });
    console.log(targetFiles);*/

</script>

<body>

    <p id="titre">Musique d'ambiance</p>
    
    <div id="div_table">
        <table id="table">
            <tr>
                <td>keep-running-markvard</td>
                <td><audio controls ><source src="./Songs/keep-running-markvard.mp3"></audio></td> 
            </tr>
            <tr>
                <td>jarico-island-music</td>
                <td><audio controls ><source src="./Songs/jarico-island-music.mp3"></audio></td> 
            </tr>
            <tr>
                <td>kato-spyker-tobsik-odyssey-ncs-release</td>
                <td><audio controls ><source src="./Songs/kato-spyker-tobsik-odyssey-ncs-release.mp3"></audio></td> 
            </tr>
            <tr>
                <td>serenity-lofi-hip-hop-beat</td>
                <td><audio controls ><source src="./Songs/serenity-lofi-hip-hop-beat.mp3"></audio></td> 
            </tr>
            <tr>
                <td>free-music-no-copyright-music-<br>background-music-instrumental</td>
                <td><audio controls ><source src="./Songs/free-music-no-copyright-music-background-music-instrumental.mp3"></audio></td> 
            </tr>
            
        </table>
    </div>
     
    <input type="file" name="fichier" accept=".mp3" id="b1file">
    <input type="submit" id="submit" value="Ajouter le son" onclick="addSong()">

    <form action= "<?php echo $_SERVER["PHP_SELF"]?>" method="post">
        <button id="b2" type="submit" value="ENVOI" name="accueil">retourner à la page d'accueil </button>
    </form>

</body>

<footer>
    
    <p>Authors : Nicolas Deronsart, Victor Tancrez, Liam Mayeux</p>
    
</footer>
</html>