<?php

session_start();
include '../php/connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../Css/menu.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">


    <title>Menu |Gbd|</title>


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
                                                                $query_columnas = "SELECT ColumnaID, Nombre, Tipo, PK, Autoincrement FROM columnas WHERE TablaID = ?";
                                                                if ($stmt_columnas = $connect->prepare($query_columnas)) {
                                                                    $stmt_columnas->bind_param('i', $tabla['TablaID']);
                                                                    $stmt_columnas->execute();
                                                                    $resultado_columnas = $stmt_columnas->get_result();
                                                                    while ($columna = $resultado_columnas->fetch_assoc()) {
                                                                        echo '<li class="d-flex align-items-center">';

                                                                        // Verifica si la columna es clave primaria y autoincrementable
                                                                        if ($columna['PK'] == 'Si' && $columna['Autoincrement'] == 'Si') {
                                                                            // Imprime la imagen para columnas PK y Autoincrement
                                                                            echo '<img src="../img/logo_pk.png" class="img_pk me-2">';
                                                                        } else {
                                                                            // Imprime la imagen estándar para las demás columnas
                                                                            echo '<img src="../img/logo_columna.png" class="img_columna me-2">';
                                                                        }

                                                                        echo htmlspecialchars($columna['Nombre']) . ' - ' . htmlspecialchars($columna['Tipo']);
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
                    <a class="btn btn-success" href="../php/logout.php">Cerrar Sesion</a>

            </div>
        </div>

    </nav>

</head>

<body>

    <div class="info_gestor">

        <div>
        
            <div class="div_bienvenida">
                <h5>Bienvenido a CocoDB</h5>


                <div>
                
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Nueva Base de Datos</button>
                    <a href="SQL_Seccion.php" class="btn btn-warning">SQL</a>

                </div>

            </div>

        

        </div>


        <div>

            <div class="div_bd_actuales">
            
                <table class="table table-striped table-hover">

                    <thead>
                        <tr>
                            <td>Bases de datos</td>
                            <td>Cotejamiento</td>
                            <td>acciones</td>
                        </tr>

                    </thead>

                    <tbody class="table-group-divider">

                        <?php
                        
                            $bd="SELECT BaseDeDatosID, nombre, cotejamiento, BaseDeDatosID FROM basesdedatos";
                            $resultado=mysqli_query($connect,$bd);
                            while($tabla=mysqli_fetch_array($resultado)){

                        
                        ?>

                        <tr>
                            <td>
                                <img src="../img/logo_bd.png" class="logo_bdC" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <a href="tablas_bd.php?BaseDeDatosID=<?php echo htmlspecialchars($tabla['BaseDeDatosID']); ?>"><?php echo htmlspecialchars($tabla['nombre']); ?></a>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($tabla['cotejamiento']); ?>
                            </td>
                            
                            <td>
                                <a class="link_delete btn btn-outline-danger" href="../php/Delete_db.php?BaseDeDatosID=<?php echo $tabla["BaseDeDatosID"]; ?>">Eliminar</a>
                            </td>
                        </tr>


                        <?php
                            } mysqli_free_result($resultado)
                        ?>

                    </tbody>

                </table>
                    

            </div>       

        </div>

    </div>






    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva Base de datos</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="../php/Create_db.php" method="post">
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Nombre de la Base de Datos:</label>
                <input type="text" class="form-control" id="recipient-name" name="nombre_bd">
            </div>
            <div class="mb-3">
                <label for="message-text" class="col-form-label">Cotejamiento:</label>
                <select class="form-select form-select-sm" aria-label="Small select example" id="collation" name="cotejamiento">
                    <option disabled selected>Elige Un Cotejamiento</option>
                    <option value="utf8mb4_general_ci">utf8mb4_general_ci</option>
                    <option value="utf8mb4_unicode_ci">utf8mb4_unicode_ci</option>
                    <option value="utf8_general_ci">utf8_general_ci</option>
                    <option value="latin1_swedish_ci">latin1_swedish_ci</option>
                    <option value="utf8mb4_0900_ai_ci">utf8mb4_0900_ai_ci</option>
                </select>
            </div>

            <div class="modal-footer">
                    <button class="btn btn-primary">Crear Base de Datos</button>
            </div>
            </form>
        </div>
        </div>
    </div>
    </div>

        
</body>

<script src="../Bootstrap/js/bootstrap.js"></script>

</html>