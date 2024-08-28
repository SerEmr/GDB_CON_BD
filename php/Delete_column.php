<?php


include 'connect.php';

$TablaID = $_GET['TablaID'];
$ColumnaID = $_GET['ColumnaID'];

$eliminar = "DELETE FROM columnas WHERE ColumnaID = '$ColumnaID'";


$resultado = mysqli_query($connect, $eliminar);

if($resultado){

    header("Location: ../Interface/Ver_estructura.php?TablaID=$TablaID");

}else{

    echo '
    <script>alert("No se pudo eliminar la base de datos: '.mysqli_error($conexion).'");
        
        window.location= "../Interface/Menu.php";
    </script>
    ';

}



?>