<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Registro de participantes</title>
	<!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
            
</head>
<body>

<style>
	nav{
		box-shadow: none;
	}
</style>


<nav class="yellow yellow lighten-3">
    <div class="nav-wrapper">
      <a href="#" class="brand-logo center">
      	<img src="logo_panorama.svg" alt="Logo_panorama" width="150px" height="65px">
      </a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
      </ul>
    </div>
  </nav>

  <?php

		// Datos de la base de datos
	$usuario = "root";
	$password = "";
	$servidor = "localhost";
	$basededatos = "actores";
	
	// creación de la conexión a la base de datos con mysql_connect()
	$conexion = mysqli_connect( $servidor, $usuario, "" ) or die ("No se ha podido conectar al servidor de Base de datos");
	
	// Selección del a base de datos a utilizar
	$db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );

	if (count($_POST) && (strpos($_POST['img'], 'data:image/png;base64') === 0)) {
		
	  $img = $_POST['img'];
	  $img = str_replace('data:image/png;base64,', '', $img);
	  $img = str_replace(' ', '+', $img);
	  $data = base64_decode($img);
	  $file = 'uploads/img'.date("YmdHis").'.png';

	  $nombre = $_POST['nombre'];
	  $apellidos = $_POST['apellidos'];
	  $email = $_POST['email'];
	  $telefono = $_POST['telefono'];
	  $ciudad = $_POST['ciudad'];
	  

	  $sql = "insert into actor (nombre, apellidos, email, telefono, ciudad, imagen) values ('$nombre','$apellidos','$email','$telefono','$ciudad','$file')";
	  
	  if (mysqli_query($conexion, $sql)) {
    	 echo "Información registrada";
    	 file_put_contents($file, $data);
		}else{
			echo "Error, intente de nuevo";
		}
	  /*

	  if (file_put_contents($file, $data)) {
	     echo "<p>Información enviada correctamente.</p>";
	  } else {
	     echo "<p>Ha ocurrido un error al momento de enviar.</p>";
	  }	
	  */
	  
	}
					 
?>



<div class="container">
	<div class="row">
		<div class="col s12">
			<h4>Registro de Actores</h4>
		</div>
		<form method="post" action="" onsubmit="prepareImg();">
			
			<div class="row">
				<div class="input-field col s12 m6">
          			<input id="first_name" type="text" class="validate" name="nombre">
          			<label for="first_name">Nombre</label>
        		</div>
        		<div class="input-field col s12 m6">
          			<input id="last_name" type="text" class="validate" name="apellidos">
          			<label for="last_name">Apellidos</label>
        		</div>
			</div>

			<div class="row">
				<div class="input-field col s12 m6">
          			<input id="correo" type="email" class="validate" name="email">
          			<label for="correo">Correo electrónico</label>
        		</div>
        		<div class="input-field col s12 m6">
          			<input id="telefono" type="tel" class="validate" name="telefono">
          			<label for="telefono">Teléfono</label>
        		</div>
			</div>

			<div class="row">
				<div class="input-field col s12 m6">
          			<input id="calle" type="text" class="validate" name="ciudad">
          			<label for="calle">Ciudad</label>
        		</div>
			</div>

			

			<div class="row">
				<div class="col s12">
					<video id="player" controls autoplay width="80%"></video>
					<p id="capture" style="color: #000;" class="waves-effect waves-light btn yellow yellow lighten-3">Tomar foto</p>
					<input id="inp_img" name="img" type="hidden" value="">
					<canvas id="snapshot" width=320 height=240></canvas>
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12 m6">
					<input id="bt_upload" type="submit" value="Enviar" class="waves-effect waves-light btn yellow darken-1">
				</div>
			</div>
		
		</form>
	</div>
</div>



<script>
  var player = document.getElementById('player');
  var snapshotCanvas = document.getElementById('snapshot');
  var captureButton = document.getElementById('capture');
  var videoTracks;

  

  var handleSuccess = function(stream) {
    // Attach the video stream to the video element and autoplay.
    player.srcObject = stream;
    videoTracks = stream.getVideoTracks();
  };

  captureButton.addEventListener('click', function() {
    var context = snapshot.getContext('2d');
    context.drawImage(player, 0, 0, snapshotCanvas.width, snapshotCanvas.height);

    // Stop all video streams.
    videoTracks.forEach(function(track) {track.stop()});
    var dataURL = snapshotCanvas.toDataURL();
    console.log(dataURL);
  });

  navigator.mediaDevices.getUserMedia({video: true})
      .then(handleSuccess);

  function prepareImg() {
     var snapshotCanvas = document.getElementById('snapshot');
     document.getElementById('inp_img').value = snapshotCanvas.toDataURL();
  }
</script>

</body>
</html>