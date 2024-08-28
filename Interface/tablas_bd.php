<?php

    session_start();
    include '../php/connect.php';


    $id_bd = $_GET['BaseDeDatosID'];


    $info_bd = mysqli_query($connect, "SELECT Nombre FROM basesdedatos  WHERE BaseDeDatosID ='$id_bd'");
    $data= mysqli_fetch_array($info_bd);

    $nombre_db = $data['Nombre'];

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


    <title>Tablas de la base de datos: <?php echo $nombre_db?></title>

    <!-- INICIO NAVEGACION -->

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

                        <li class="nav-item">

                            <?php

                                $query_bd = "SELECT nombre FROM basesdedatos";
                                $resultado = mysqli_query($connect, $query_bd);

                                if(mysqli_num_rows($resultado) > 0){

                                    while($bd = mysqli_fetch_assoc($resultado)){
                                        echo '<div class="bd_nombres"><img src="../img/logo_bd.png" class="logo_bdC"> <a class="nav-link" href="">' . htmlspecialchars($bd['nombre']) . '</a></div>';
                                    }
                                    } else {

                                        echo '<div class="bd_nombres"><p>No hay base de datos disponibles :(</p></div>';
                                    
                                    }
                            ?>
                            
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- FIN NAVEGACION -->


</head>
<body>

    <div>

        <div class="botones_accion">

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Nueva Tabla</button>
            <button type="button" class="btn btn-danger">SQL</button>


        </div>


        <div class="seccion_tablas">

            <div>
            
                <h3>Base de Datos "<?php echo $nombre_db ?>"</h3>

            </div>

            <div>

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <td>Tabla</td>
                            <td>Columnas</td>
                            <td>Motor</td>
                            <td>Acciones</td>
                            

                        </tr>

                    </thead>
                    

                    <tbody>

                        <?php
                        
                        $info_tablas = "SELECT TablaID, Nombre, Motor_alm FROM tablas WHERE BasedeDatosID = $id_bd";
                        $resultado_tablas = $connect->query($info_tablas);

                        if ($resultado_tablas->num_rows > 0) {
                            // Recorrer cada tabla y obtener el número de columnas
                            while($tabla = $resultado_tablas->fetch_assoc()) {
                                $TablaID = $tabla['TablaID'];
                                $nombre_tabla = $tabla['Nombre'];
                                $motor_almacenamiento = $tabla['Motor_alm'];
                                
                        
                                // Consulta para contar el número de columnas de esta tabla
                                $sql_columnas = "SELECT COUNT(*) AS numero_columnas FROM columnas WHERE TablaID IN (SELECT TablaID FROM tablas WHERE Nombre = '$nombre_tabla' AND BaseDeDatosID = $id_bd)";
                                $resultado_columnas = $connect->query($sql_columnas);

                                $numero_columnas = 0;
                                if ($resultado_columnas->num_rows > 0) {
                                    $fila = $resultado_columnas->fetch_assoc();
                                    $numero_columnas = $fila['numero_columnas'];
                                }            

                        
                        ?>

                        <tr>

                            <td><?php echo $nombre_tabla?></td>
                            <td><?php echo $numero_columnas?></td>
                            <td><?php echo $motor_almacenamiento?></td>
                            <td>
                                
                                <a class="btn btn-success" href="Examinar_tabla.php?TablaID=<?php echo $tabla["TablaID"]; ?>">Examinar</a>
                                <a class="btn btn-warning" href="Ver_estructura.php?TablaID=<?php echo $tabla["TablaID"]; ?>">Ver Estructura</a>
                                <a class="btn btn-danger" href="../php/Delete_table.php?TablaID=<?php echo $tabla["TablaID"]; ?>&BaseDeDatosID=<?php echo $id_bd ?>">Eliminar</a>
        
                            </td>
                            
                        </tr>

                        
                        <?php }} ?>

                    </tbody>


                </table>

            </div>


        </div>

    </div>



    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva Tabla</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form action="config_tabla.php" method="get">
                <input type="hidden" name="nombre_db" value="<?php echo $nombre_db?>">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Nombre de la Tabla:</label>
                    <input type="text" class="form-control" id="recipient-name" name="nombre_tabla">
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Numero de Columnas:</label>
                    <input type="number" name="numer_columna" id="numero_columnas">
                </div>

                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Motor de Almacenamiento:</label>
                    <select class="form-select" aria-label="Default select example" name="motor" id="motor">
                        <option disabled selected value="">Selecciona un Motor de Almacenamiento</option>
                        <option value="MyISAM">MyISAM</option>
                        <option value="InnoDB">InnoDB</option>
                    </select>
                </div>

                <div class="modal-footer">
                        <button class="btn btn-primary">Crear Tabla</button>
                </div>
            </form>

        </div>
       
        </div>
    </div>
    </div>


    
</body>

<script src="../Bootstrap/js/bootstrap.js"></script>

</html>