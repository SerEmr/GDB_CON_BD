<?php

include 'connect.php';
session_start();

if (isset($_POST['nombre_tabla'], $_POST['numero_columna'], $_POST['nombre_db'], $_POST['motor_almacenamiento'])) {
    $nombre_tabla = $_POST['nombre_tabla'];
    $num_columna = $_POST['numero_columna'];
    $nombre_db = $_POST['nombre_db'];
    $motor_almacenamiento = $_POST['motor_almacenamiento'];

    // Buscar el BaseDeDatosID basado en nombre_db
    $sqlBuscarDB = "SELECT BaseDeDatosID FROM basesdedatos WHERE nombre = ?";
    $stmtBuscarDB = $connect->prepare($sqlBuscarDB);
    $stmtBuscarDB->bind_param("s", $nombre_db);
    $stmtBuscarDB->execute();
    $resultadoDB = $stmtBuscarDB->get_result();

    if ($resultadoDB->num_rows > 0) {
        $fila = $resultadoDB->fetch_assoc();
        $baseDeDatosID = $fila['BaseDeDatosID'];

        // Insertar la nueva tabla en 'tablas'
        $sqlInsertTabla = "INSERT INTO tablas (Nombre, BaseDeDatosID, Motor_alm) VALUES (?, ?, ?)";
        $stmtTabla = $connect->prepare($sqlInsertTabla);
        $stmtTabla->bind_param("sis", $nombre_tabla, $baseDeDatosID, $motor_almacenamiento); 
    

        if ($stmtTabla->execute()) {
            $tablaID = $connect->insert_id; // ID de la tabla recién insertada

            // Ahora, insertar cada columna en 'columnas'
            for ($i = 0; $i < $num_columna; $i++) {
                $nombreColumnaKey = "nombre_columna_$i";
                $tipoColumnaKey = "tipo_columna_$i";
                $longitudKey = "longitud$i";
                $pkKey = "pk$i";
                $autoIncrementKey = "AI$i";
                $nuloKey = "nulo$i";
                
                if (isset($_POST[$nombreColumnaKey], $_POST[$tipoColumnaKey], $_POST[$longitudKey])) {
                    $nombre_columna = $_POST[$nombreColumnaKey];
                    $tipo_columna = $_POST[$tipoColumnaKey];
                    $longitud = $_POST[$longitudKey];
                    $pk = isset($_POST[$pkKey]) ? 'Si' : 'No';
                    $autoIncrement = isset($_POST[$autoIncrementKey]) ? 'Si' : 'No';
                    $nulo = isset($_POST[$nuloKey]) ? 'Si' : 'No';
                    $tipoDatoCompleto = $longitud ? "$tipo_columna($longitud)" : $tipo_columna;

                    // Insertar la columna en 'columnas'
                    $sqlInsertColumna = "INSERT INTO columnas (Nombre, Tipo, TablaID, PK, AutoIncrement, Nulo) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmtColumna = $connect->prepare($sqlInsertColumna);
                    $stmtColumna->bind_param("ssisss", $nombre_columna, $tipoDatoCompleto, $tablaID, $pk, $autoIncrement, $nulo);

                    if (!$stmtColumna->execute()) {
                        echo "Error al insertar la columna $nombre_columna: " . $connect->error;
                        exit;
                    }
                } else {
                    echo "Error: Faltan datos para la columna $i.";
                    exit;
                }
            }

            // Redirección con el BaseDeDatosID en la URL
            echo 
            "<script>
                window.location.href = '../Interface/tablas_bd.php?BaseDeDatosID=' + $baseDeDatosID;
            </script>";
            exit;
        } else {
            echo "Error al insertar la tabla: " . $stmtTabla->error;
            exit;
        }
    } else {
        echo "Error: La base de datos especificada no existe.";
        exit;
    }
} else {
    echo "Error: Faltan datos de la tabla o de la base de datos.";
    exit;
}
?>
