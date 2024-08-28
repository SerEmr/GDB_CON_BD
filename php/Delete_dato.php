<?php

include 'connect.php'; 

$TablaID = $_GET['TablaID'];

if (isset($_GET['DatosIDs'])) {
    // Obtiene la cadena de DatoIDs y conviértela en un array
    $datoIDs = explode(',', $_GET['DatosIDs']);

    // Preparar la parte de la declaración SQL para los placeholders
    $placeholders = implode(',', array_fill(0, count($datoIDs), '?'));

    // Comenzar la transacción
    $connect->begin_transaction();

    try {
        // Prepara la declaración de SQL para eliminar múltiples registros
        $consulta = "DELETE FROM datos WHERE DatoID IN ($placeholders)";
        $stmt = $connect->prepare($consulta);

        // Vincula los DatoID al statement preparado
        $stmt->bind_param(str_repeat('i', count($datoIDs)), ...$datoIDs);

        // Ejecuta la consulta
        $stmt->execute();

        // Si todo va bien, confirma la transacción
        $connect->commit();

        // Redirige o notifica al usuario del éxito
        header("Location: ../Interface/Examinar_tabla.php?TablaID=$TablaID");
    } catch (Exception $e) {
        // Si algo sale mal, revierte la transacción
        $connect->rollback();

        // Notifica al usuario del error
        echo "Error al eliminar los datos: " . $e->getMessage();
    }

    $stmt->close();
} else {
    echo "No se proporcionaron DatoIDs para eliminar.";
}

// Cierra la conexión
$connect->close();
?>
