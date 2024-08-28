  var gifs = [
    'url("img/gif_cocodrilo2.gif")',
    'url("img/gif_cocodrilo4.gif")',
    'url("img/gif_cocodrilo3.gif")',
    'url("img/gif_cocodrilo5.gif")',
    'url("img/gif_cocodrilo6.gif")',
    'url("img/gif_cocodrilo7.gif")',
    'url("img/gif_cocodrilo8.gif")',
    'url("img/gif_cocodrilo9.gif")',
    
    
    
    
      ];
    
      var currentBackground = 0;
    
      // Función para cambiar el fondo
      function changeBackground() {
        currentBackground++;
        if (currentBackground == gifs.length) currentBackground = 0;
        document.body.style.backgroundImage = gifs[currentBackground];
      }
    
      // Cambia el fondo cada 5 segundos
      setInterval(changeBackground, 5000);
    
      // Establece el primer fondo al cargar
      document.body.style.backgroundImage = gifs[0];