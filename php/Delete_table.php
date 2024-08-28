<?php
include 'connect.php';

$TablaID = $_GET['TablaID'];
$id_bd = $_GET['BaseDeDatosID'];

$eliminar = "DELETE FROM tablas WHERE TablaID = '$TablaID'";

$resultado = mysqli_query($connect, $eliminar);

if($resultado){

    header("Location: ../Interface/tablas_bd.php?BaseDeDatosID=$id_bd");

} else {

    echo '<script>alert("No se pudo eliminar la Tabla: ' . mysqli_error($conexion) . '");';
    echo 'window.location="../Interface/Menu.php";</script>';

}
?>
