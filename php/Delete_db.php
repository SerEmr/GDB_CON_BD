<?php

include 'connect.php';

$BaseDeDatosID = $_GET['BaseDeDatosID'];

$eliminar = "DELETE FROM basesdedatos WHERE BaseDeDatosID = '$BaseDeDatosID'";


$resultado = mysqli_query($connect, $eliminar);

if($resultado){

    header("location: ../Interface/Menu.php");

}else{

    echo '
    <script>alert("No se pudo eliminar la base de datos: '.mysqli_error($conexion).'");
        
        window.location= "../Interface/Menu.php";
    </script>
    ';

}

?>