<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Dato'], $_POST['id_tabla'])) {
    $id_tabla = $_POST['id_tabla']; // Asegúrate de sanitizar y validar esta entrada también

    foreach ($_POST['Dato'] as $columnaID => $valor) {
        // Proceso de inserción...
    
        // Asegúrate de que el ID de la columna es un número para evitar inyecciones SQL
        $columnaID = (int)$columnaID;
        $valor = trim($valor); // Sanitizar el valor si es necesario

        $sql = "INSERT INTO datos (ColumnaID, Valor) VALUES (?, ?)";
        if ($stmt = $connect->prepare($sql)) {
            $stmt->bind_param("is", $columnaID, $valor);
            $stmt->execute();
            
            if ($stmt->error) {
                echo "Error al insertar: " . $stmt->error;
                // Puedes decidir si quieres terminar la ejecución aquí
                // break; // Descomentar si quieres parar el proceso en caso de error
            }

            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $connect->error;
            // Puedes decidir si quieres terminar la ejecución aquí
            // break; // Descomentar si quieres parar el proceso en caso de error
        }
    }


        echo 
            "<script>
            window.location.href = '../Interface/Examinar_tabla.php?TablaID=' + $id_tabla;
            </script>";

} else {
    echo "Método no permitido o datos inválidos";
}
?>
