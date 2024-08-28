<?php

session_start();
include ('connect.php');

$usuario = $_POST['usuario'];
$contraseña =$_POST['contraseña'];

//Encriptar Contraseña
// $contraseña = hash('sha512', $contraseña);


$inicio_sesion = mysqli_query($connect, "SELECT Usuario, PasswordHash FROM usuarios 
WHERE Usuario= '$usuario' and PasswordHash= '$contraseña'");


if(mysqli_num_rows($inicio_sesion)>0){
    $_SESSION['usuario']=$usuario;
  
    echo 
    '
     <script>
      alert("Bienvenido '.$usuario.'");
      window.location = "../Interface/Menu.php";
     </script>
  
    ';
    exit;
  
   }else{
   echo '
    <script>
     alert("El usuario No Existe, Porfavor Revisa tus datos");
     window.location = "../index.html";
    </script>
   ';
   exit;
  
   
}

$connect->close();

?>
