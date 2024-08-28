<?php

include 'connect.php';

$id_tabla = $_POST['TablaID'];

if ($connect->connect_error) {
    die("Fallo en la conexión: " . $connect->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['Valor'] as $columnaID => $valor) {
        $datoID = $_POST['DatoID'][$columnaID];

        // Actualiza los datos en la base de datos
        $stmtUpdate = $connect->prepare("UPDATE datos SET Valor = ? WHERE DatoID = ?");
        $stmtUpdate->bind_param("si", $valor, $datoID);
        $stmtUpdate->execute();

        if ($stmtUpdate->error) {
            echo "Error al actualizar el registro con DatoID $datoID: " . $stmtUpdate->error;
        } else {
            header("Location: ../Interface/Examinar_tabla.php?TablaID=$id_tabla");

        }

        $stmtUpdate->close();
    }
}

$connect->close();
?>
