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
    <link rel="stylesheet" href="../Css/Insertar_datos.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">


    <title>Tabla "<?php echo $nombre_tabla?>"</title>

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
            <div class="seccion_titulo_datos">

                <h1>Tabla "<?php echo $nombre_tabla?>"</h1>
                
            </div>

            <div class="seccion_tabla_datos">

                <form action="../php/Inserccion_datos.php" method="post">

                    <input type="hidden" name="id_tabla" value="<?php echo $id_tabla; ?>" />


                    <table class="table table-bordered">

                        <thead>

                            <th>
                                Nombre
                            </th>

                            <th>
                                Tipo de Dato
                            </th>

                            <th>
                                Valor
                            </th>

                        </thead>

                        <tbody>   
                            
                        <?php
                            $sqlColumnas = "SELECT ColumnaID, Nombre, Tipo FROM columnas WHERE TablaID = ?";
                            if ($stmtColumnas = $connect->prepare($sqlColumnas)) {
                                $stmtColumnas->bind_param("i", $id_tabla);
                                $stmtColumnas->execute();
                                $resultadoColumnas = $stmtColumnas->get_result();

                                while ($fila = $resultadoColumnas->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($fila['Nombre']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['Tipo']) . "</td>";
                                    // El name del input debe ser Dato[ColumnaID]
                                    echo '<td><input type="text" name="Dato[' . $fila['ColumnaID'] . ']" class="form-control" /></td>';
                                    echo "</tr>";
                                }

                                $stmtColumnas->close();
                            }
                        ?>

                        </tbody>


                    </table>

                    <input type="submit" class="btn btn-success" value="Insertar Datos">


                </form>
            </div>


        </div>
                    
    </div>

    
</body>

<script src="../Bootstrap/js/bootstrap.js"></script>


</html>