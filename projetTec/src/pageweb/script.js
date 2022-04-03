



/*window.onload = function(){
    fadeInEffect(50);
}*/


function fadeOutEffect(ms) {
    var fadeEffect = setInterval(function () {
        if (!document.body.style.opacity) {
            document.body.style.opacity = 1;
        }
        if (document.body.style.opacity > 0) {
            document.body.style.opacity -= 0.1;
        } else {
            clearInterval(fadeEffect);
        }
    }, ms);
}

function fadeInEffect(ms){
    var var_opacity = 0;
    var fadeEffect = setInterval(function() {
        if (!document.body.style.opacity) {
            document.body.style.opacity = 0;
        }
        if (var_opacity < 1) {
            var_opacity += 0.075
            document.body.style.opacity = var_opacity;
        } else {
            clearInterval(fadeEffect);
        }
    }, ms);
}

function backHomepage(){
    fadeOutEffect(50); 
    setInterval(function(){
        window.location.href="Page1/Accueil.php";
    }, 500)
}

function detectCamera(){
    let canvas = document.querySelector("#canvas");
    let context = canvas.getContext("2d");
    let video = document.querySelector("#video");
    var img    = canvas.toDataURL("image/png");
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia){
        // recherche un appareil disponible sur le système (vidéo, son) et autorise à fonctionner
        // via une fonction stream
        navigator.mediaDevices.getUserMedia({video: true}).then(stream => {
            video.srcObject = stream;
            video.play;
        })
    }
    document.getElementById("b1").addEventListener("click", ()=>{
        context.drawImage(video, 0, 0, 800, 600);
        var canvas = document.getElementById("canvas");
        var ctx = canvas.getContext("2d");
        
        
        download_img = function(el) {
          // get image URI from canvas object
          var imageURI = canvas.toDataURL("image/jpg");
          el.href = imageURI;
        };
          });
    }

function addSong(){
    var file = document.getElementById("b1file").value;
    
    if (file != ""){
        var str=file.split("\\")[file.split("\\").length-1];

        var trNode = document.createElement("tr");
        var td1Node = document.createElement("td");
        var td2Node = document.createElement("td");

        var textNode = document.createTextNode(str.split(".")[0]);
        td1Node.appendChild(textNode);

        var audioNode = document.createElement("audio");
        audioNode.setAttribute("controls", true);
        var sourceNode = document.createElement("source");
        sourceNode.setAttribute("src", "./Songs/"+str);
        audioNode.appendChild(sourceNode);
        td2Node.appendChild(audioNode);

        trNode.appendChild(td1Node);
        trNode.appendChild(td2Node);


        document.getElementById("table").appendChild(trNode);

    }
    document.getElementById("b1file").value="";
    

    

    /*
    var newP = document.createElement("p"); 
    var textNode = document.createTextNode(" This is a new text node"); 
    newP.appendChild(textNode);
    document.getElementById("firstP").appendChild(newP);*/
}