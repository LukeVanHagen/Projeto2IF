//Codigo script show an hidden do arquivo welcome.blade.php

function toggleHistoria() {
    var textoHistoria = document.getElementById("textoHistoria");
    if (textoHistoria.style.display === "none") {
      textoHistoria.style.display = "block";
      document.getElementById("btnHistoria").innerHTML = " Leia Mais <";
    } else {
      textoHistoria.style.display = "none";
      document.getElementById("btnHistoria").innerHTML = "Leia Mais >";
    }
  }
