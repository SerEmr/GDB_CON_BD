<?php

    session_start();
    include '../php/connect.php';


    $id_tabla = $_GET['TablaID'];


    $info_tabla = mysqli_query($connect, "SELECT Nombre FROM tablas  WHERE TablaID ='$id_tabla'");
    $data= mysqli_fetch_array($info_tabla);

    $nombre_tabla = $data['Nombre'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../Css/menu.css">
    <link rel="stylesheet" href="../Css/Examinar_estructura.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">

    <title>Ex. Tabla "<?php echo $nombre_tabla ?>"</title>

    <nav class="navbar bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <h5 class="navbar-brand" href="#">CocoDB<img src="../img/coco_db.png" alt="coco_img" class="img_coco-nav"></h5>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">CocoDB</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>

                </div>
                
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">

                        <img src="../img/coco_db.png" alt="coco_img" class="img_coco">

                    </li>

                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <h4>Bases de Datos</h4>
                        <?php
                        $query_bd = "SELECT BaseDeDatosID, nombre FROM basesdedatos";
                        $resultado = mysqli_query($connect, $query_bd);
                        if (mysqli_num_rows($resultado) > 0) {
                            while ($bd = mysqli_fetch_assoc($resultado)) {
                                $collapseTablesId = 'collapseTables' . $bd['BaseDeDatosID'];
                                ?>
                                <li class="nav-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <img src="../img/logo_bd.png" class="logo_bdC me-2">
                                        <span class="flex-grow-1">
                                            <a href="tablas_bd.php?BaseDeDatosID=<?php echo htmlspecialchars($bd['BaseDeDatosID']); ?>">
                                                <?php echo htmlspecialchars($bd['nombre']); ?>
                                            </a>
                                        </span>
                                        <button class="btn float-end" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $collapseTablesId; ?>">
                                            +
                                        </button>
                                    </div>
                                    <div id="<?php echo $collapseTablesId; ?>" class="collapse">
                                        <ul class="list-unstyled">
                                            <?php
                                            $query_tablas = "SELECT TablaID, nombre FROM tablas WHERE BaseDeDatosID = ?";
                                            if ($stmt_tablas = $connect->prepare($query_tablas)) {
                                                $stmt_tablas->bind_param('i', $bd['BaseDeDatosID']);
                                                $stmt_tablas->execute();
                                                $resultado_tablas = $stmt_tablas->get_result();
                                                while ($tabla = $resultado_tablas->fetch_assoc()) {
                                                    $collapseColumnsId = 'collapseColumns' . $tabla['TablaID'];
                                                    echo '<li class="d-flex align-items-center">';
                                                    echo '<img src="../img/logo_tablas.png" class="img_tabla">';
                                                    echo '<span class="flex-grow-1">' . htmlspecialchars($tabla['nombre']) . '</span>';
                                                    echo '<button class="btn float-end" type="button" data-bs-toggle="collapse" data-bs-target="#' . $collapseColumnsId . '">';
                                                    echo '+';
                                                    echo '</button>';
                                                    echo '</li>';
                                                    ?>
                                                    <div id="<?php echo $collapseColumnsId; ?>" class="collapse">
                                                        <ul class="list-unstyled">

                                                            <?php
                                                                $query_columnas = "SELECT nombre, tipo FROM columnas WHERE TablaID = ?";
                                                                if ($stmt_columnas = $connect->prepare($query_columnas)) {
                                                                    $stmt_columnas->bind_param('i', $tabla['TablaID']);
                                                                    $stmt_columnas->execute();
                                                                    $resultado_columnas = $stmt_columnas->get_result();
                                                                    while ($columna = $resultado_columnas->fetch_assoc()) {
                                                                        echo '<li class="d-flex align-items-center">';
                                                                        echo '<img src="../img/logo_columna.png" class="img_columna me-2">'; 
                                                                        echo htmlspecialchars($columna['nombre']) . ' - ' . htmlspecialchars($columna['tipo']);
                                                                        echo '</li>';
                                                                    }
                                                                    $stmt_columnas->close();
                                                                }
                                                            ?>

                                                        </ul>
                                                    </div>

                                                    <?php
                                                }
                                                $stmt_tablas->close();
                                            }else {

                                                echo '<div class="bd_nombres"><p>No hay Tablas asignadas a esta base de datos</p></div>';
                                            
                                            }
                                            ?>

                                        </ul>
                                    </div>
                                </li>

                            <?php
                                }
                                
                                } else {
                                
                                    echo '<div class="bd_nombres"><p>No hay bases de datos disponibles :(</p></div>';
                                
                                }
                            
                            ?>

                        </ul>
                    </div>
            </div>
        </div>
    </nav>




</head>
<body>


    <div>

        <div>

            <div class="seccion_titulo_examinar">

                <div>

                    <h1>Tabla "<?php echo $nombre_tabla?>"</h1>

                    <a class="btn btn-success" href="Insertar_datos.php?TablaID=<?php echo $id_tabla;?>">Insertar Datos</a>
                    
                </div>

            </div>

            <div class="seccion_examinar">

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <?php
                            // Primero, obtenemos los nombres de las columnas y almacenamos los IDs en un array.
                            $columnas = "SELECT ColumnaID, Nombre FROM columnas WHERE TablaID = ?";
                            $idsColumnas = [];
                            if ($stmt = $connect->prepare($columnas)) {
                                $stmt->bind_param("i", $id_tabla);
                                $stmt->execute();
                                $resultado = $stmt->get_result();
                                while ($fila = $resultado->fetch_assoc()) {
                                    echo "<th>" . htmlspecialchars($fila['Nombre']) . "</th>";
                                    // Guardar los IDs de las columnas para su uso posterior
                                    $idsColumnas[] = $fila['ColumnaID'];
                                }
                                $stmt->close();
                            }
                            ?>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
    <?php
    // Suponemos que ya has obtenido $idsColumnas como antes
    // Suponemos que $id_tabla es el ID de la tabla específica que estás examinando
    $datosConsulta = "SELECT d.DatoID, d.ColumnaID, d.Valor FROM datos d INNER JOIN columnas c ON d.ColumnaID = c.ColumnaID WHERE c.TablaID = ?";
    if ($stmtDatos = $connect->prepare($datosConsulta)) {
        $stmtDatos->bind_param("i", $id_tabla);
        $stmtDatos->execute();
        $resultadosDatos = $stmtDatos->get_result();

        // Organizar los datos por ColumnaID para facilitar su acceso
        $valoresPorColumnaID = [];
        $datosIDPorColumnaID = []; // Nuevo arreglo para almacenar los DatoID
        while ($filaDatos = $resultadosDatos->fetch_assoc()) {
            $valoresPorColumnaID[$filaDatos['ColumnaID']][] = $filaDatos['Valor'];
            $datosIDPorColumnaID[$filaDatos['ColumnaID']][] = $filaDatos['DatoID']; // Guardar los DatoID
        }
        $stmtDatos->close();

        // Verificar si hay datos para mostrar
        if (!empty($valoresPorColumnaID)) {
            // Encuentra el número máximo de filas por ColumnaID
            $maxFilas = max(array_map('count', $valoresPorColumnaID));

            // Iterar sobre el número máximo de filas para mostrar los datos
            for ($i = 0; $i < $maxFilas; $i++) {
                echo "<tr>";
                $datoIDsPorFila = []; // Almacenar los DatoID de la fila actual

                // Este bucle recorre cada ColumnaID para la fila $i
                foreach ($idsColumnas as $columnaID) {
                    $valor = $valoresPorColumnaID[$columnaID][$i] ?? '';
                    $datoID = $datosIDPorColumnaID[$columnaID][$i] ?? ''; // Obtener el DatoID correspondiente
                    echo "<td>" . htmlspecialchars($valor) . "</td>";

                    // Si hay un DatoID, lo agrega al arreglo de DatoID para esta fila
                    if (!empty($datoID)) {
                        $datoIDsPorFila[] = $datoID;
                    }
                }

                // Comprueba si recogiste algún DatoID para esta fila
                if (!empty($datoIDsPorFila)) {
                    // Concatena los DatoID con comas para formar la cadena del enlace
                    $datoIDsCadena = implode(',', $datoIDsPorFila);
                    echo "<td>";
                    // Inserta la cadena de DatoID en la URL del enlace
                    echo "<a class='btn btn-warning' href='Configurar_datos.php?DatosIDs=" . htmlspecialchars($datoIDsCadena) .  '&TablaID=' . $id_tabla . "'>Configurar</a> ";
                    echo "<a class='btn btn-warning' href='../php/Delete_dato.php?DatosIDs=" . htmlspecialchars($datoIDsCadena) .  '&TablaID=' . $id_tabla .  "'>Eliminar</a>";
                    echo "</td>";
                } else {
                    echo "<td>No hay acciones disponibles para esta fila</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='" . (count($idsColumnas) + 1) . "'>Aun no hay registros disponibles.</td></tr>";
        }
    }
    ?>
</tbody>


                </table>
             </div>
        </div>
    </div>
</body>


<script src="../Bootstrap/js/bootstrap.js"></script>


</html>