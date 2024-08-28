<?php

include 'connect.php';

// Recuperar datos del formulario
$nombre_columna = $_POST['nombre_columna'];
$tipo = $_POST['tipo_columna']; // Esto será algo como "VARCHAR(80)"
$longitud_nueva = $_POST['longitud']; // La nueva longitud, por ejemplo, "30"
$nulo = isset($_POST['Nulo']) ? 'Si' : 'No';
$autoIncrement = isset($_POST['AutoIncrement']) ? 'Si' : 'No';
$pk = isset($_POST['PK']) ? 'Si' : 'No';
$columnaID = $_POST['ColumnaID'];
$TablaID = $_POST['TablaID']; 

// Extracción del tipo y la longitud actual
preg_match('/^(\w+)(?:\((\d+)\))?/', $tipo, $matches);
$tipo_sin_longitud = $matches[1]; // Tipo sin longitud, por ejemplo, "VARCHAR"
$longitud_actual = $matches[2] ?? ''; // Longitud actual, por ejemplo, "80"

// Si el usuario ha cambiado la longitud, actualizar el tipo con la nueva longitud
if (!empty($longitud_nueva)) {
    $tipo_con_nueva_longitud = "{$tipo_sin_longitud}({$longitud_nueva})";
} else {
    $tipo_con_nueva_longitud = $tipo;
}

// Prepara la consulta SQL para actualizar la información de la columna
$actualizacion = "UPDATE columnas SET Nombre = ?, Tipo = ?, Nulo = ?, AutoIncrement = ?, PK = ? WHERE ColumnaID = ?";
$stmt = $connect->prepare($actualizacion);

// Vincular parámetros a la consulta preparada
$stmt->bind_param("sssssi", $nombre_columna, $tipo_con_nueva_longitud, $nulo, $autoIncrement, $pk, $columnaID);

// Ejecutar la consulta
if ($stmt->execute()) {
    header("Location: ../Interface/Ver_estructura.php?TablaID=$TablaID");
    exit;
} else {
    echo "Error al actualizar la columna: " . $connect->error;
}

// Cerrar la declaración y la conexión
$stmt->close();
$connect->close();
?>
