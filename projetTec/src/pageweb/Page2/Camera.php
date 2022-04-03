<!"réalisé par Liam Mayeux , Nicolas Deronsart et Victor Tancrez">
<!"page permettant d'allumer la caméra et enregistré une capture d'écran">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Camera, 2e page">
    <meta name="author" content="Liam Mayeux, Nicolas Deronsart, Victor Tancrez">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mystyle.css">
    <link rel="shortcut icon" type="image/x-icon" href="../icon/img1.ico" />
    <script type="text/javascript" src="../script.js"></script> 
    <script src='script_songs.php'></script>
    <title>Nicotoriam-Camera</title>
</head>
<script>
    window.onload = function() {
        document.body.style.opacity = 0;
        fadeInEffect(70);
        detectCamera();
    }
    
</script>

<body>

    
    <table >
        <tr>
            <td><p id="titre">Camera de sécurité</p></td>   
            <td><button id="b1">capturer une image</button></td>
        </tr>
        <tr>
            <td><video id="video" width="800" height="600" autoplay></video></td>
            <td><canvas id="canvas" width="800" height="600"></canvas></td>
        </tr>
    </table>
    <a id="download" download="myImage.jpg" href="" onclick="download_img(this);">télécharger l'image</a>
    <form action= "../Page1/Accueil.php" method="post">
    <button id="b2" >
        Revenir à la page d'accueil
    </button>
    
</body>

<footer>
    
    <p>Authors : Nicolas Deronsart, Victor Tancrez, Liam Mayeux</p>
    
</footer>
</html>