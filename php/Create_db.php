<?php

session_start();
include 'connect.php';

$user = $_SESSION['usuario'];

$usuario = mysqli_query($connect, "SELECT UsuarioID FROM usuarios WHERE Usuario = '$user'");
$data= mysqli_fetch_array($usuario);

$id_user = $data['UsuarioID'];
$nombre_bd = $_POST['nombre_bd'];
$cotejamiento = $_POST['cotejamiento'];

$insert = "INSERT INTO basesdedatos (Nombre, Cotejamiento, UsuarioID) VALUES ('$nombre_bd', '$cotejamiento', '$id_user')";



$ejecutar = mysqli_query($connect, $insert); 

if($ejecutar){

    echo '
     <script>
      window.location = "../Interface/Menu.php";
     </script>

    ';

}else{

    echo 
    '
     <script>
      alert("Error");
      window.location = "../Interface/New_db.php";
     </script>

    ';

}

$connect->close();

?>