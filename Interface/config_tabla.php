<?php

include '../php/connect.php';
session_start();

$nombre_tabla = $_GET['nombre_tabla'];
$num_columna = $_GET['numer_columna'];
$nombre_db = $_GET['nombre_db'];
$motor_almacenamiento = $_GET['motor']

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



    <title>Document</title>

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
                                $query_bd = "SELECT BaseDeDatosID, nombre FROM basesdedatos";
                                $resultado = mysqli_query($connect, $query_bd);

                                if (mysqli_num_rows($resultado) > 0) {
                                    while ($bd = mysqli_fetch_assoc($resultado)) {
                                        $url = "tablas_bd.php?BaseDeDatosID=" . htmlspecialchars($bd['BaseDeDatosID']);
                                        echo '<div class="bd_nombres">';
                                        echo '<img src="../img/logo_bd.png" class="logo_bdC"> ';
                                        echo '<a class="nav-link" href="' . $url . '">' . htmlspecialchars($bd['nombre']) . '</a>';
                                        echo '</div>';
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



</head>
<body>

<div class="">
    <div class="seccion_conf_column">
        <div>
            <h3>Tabla "<?php echo $nombre_tabla ?>"</h3>
        </div>  

        <!-- El formulario ahora engloba todas las columnas -->
        <form action="../php/save_tabla.php" method="post">
            <input type="hidden" name="nombre_tabla" value="<?php echo $nombre_tabla; ?>">
            <input type="hidden" name="numero_columna" value="<?php echo $num_columna; ?>">
            <input type="hidden" name="motor_almacenamiento" value="<?php echo $motor_almacenamiento?>">

            <?php
            // Genera dinámicamente el contenido de cada sección de columna
            for ($i = 0; $i < $num_columna; $i++) {
            ?>
                <div class="section">
                    <label for="nombre_columna_<?php echo $i; ?>">Nombre de la columna:</label>
                    <input type="text" id="nombre_columna_<?php echo $i; ?>" name="nombre_columna_<?php echo $i; ?>">
                    <input type="hidden" name="nombre_db" value="<?php echo $nombre_db?>">

                    <label for="tipo_columna_<?php echo $i; ?>">Tipo de dato:</label>
                    <select id="tipo_columna_<?php echo $i; ?>" name="tipo_columna_<?php echo $i; ?>">
                        <option disabled selected>Tipo de Dato</option>
                        <option value="INT">INT</option>
                        <option value="BIGINT">BIGINT</option>
                        <option value="SMALLINT">SMALLINT</option>
                        <option value="TINYINT">TINYINT</option>
                        <option value="BIT">BIT</option>
                        <option value="DECIMAL">DECIMAL</option>
                        <option value="NUMERIC">NUMERIC</option>
                        <option value="MONEY">MONEY</option>
                        <option value="SMALLMONEY">SMALLMONEY</option>
                        <option value="FLOAT">FLOAT</option>
                        <option value="REAL">REAL</option>
                        <option value="DATE">DATE</option>
                        <option value="TIME">TIME</option>
                        <option value="DATETIME">DATETIME</option>
                        <option value="DATETIME2">DATETIME2</option>
                        <option value="SMALLDATETIME">SMALLDATETIME</option>
                        <option value="DATETIMEOFFSET">DATETIMEOFFSET</option>
                        <option value="CHAR">CHAR</option>
                        <option value="VARCHAR">VARCHAR</option>
                        <option value="TEXT">TEXT</option>
                        <option value="NCHAR">NCHAR</option>
                        <option value="NVARCHAR">NVARCHAR</option>
                        <option value="NTEXT">NTEXT</option>
                        <option value="BINARY">BINARY</option>
                        <option value="VARBINARY">VARBINARY</option>
                        <option value="IMAGE">IMAGE</option>
                        <option value="VARCHAR(MAX)">VARCHAR(MAX)</option>
                        <option value="NVARCHAR(MAX)">NVARCHAR(MAX)</option>
                        <option value="VARBINARY(MAX)">VARBINARY(MAX)</option>
                        <option value="XML">XML</option>
                
                    </select>


                    <label for="longitud<?php echo $i; ?>">Longitud:</label>
                    <input type="text" id="longitud<?php echo $i; ?>" name="longitud<?php echo $i; ?>">

                    <label for="pk<?php echo $i; ?>">Primary Key</label>
                    <input type="checkbox" name="pk<?php echo $i; ?>" id="pk<?php echo $i; ?>">

                    <label for="nulo<?php echo $i; ?>">Nulo</label>
                    <input type="checkbox" name="nulo<?php echo $i; ?>" id="nulo<?php echo $i; ?>">

                    <label for="AI<?php echo $i; ?>">AutoIncremental</label>
                    <input type="checkbox" name="AI<?php echo $i; ?>" id="AI<?php echo $i; ?>">
                </div>
            <?php
            }
            ?>

            

            <button class="btn btn-warning" type="submit">Aceptar</button>
        </form>
    </div> 
</div>


    
</body>

<script src="../Bootstrap/js/bootstrap.js"></script>


</html>