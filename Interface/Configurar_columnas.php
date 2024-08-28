<?php

    session_start();
    include '../php/connect.php';


    $id_tabla = $_GET['TablaID'];
    $id_columna = $_GET['ColumnaID'];


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
    <link rel="stylesheet" href="../Css/Ver_estructura.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">


    <title>Actualizar Columnas</title>


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
            <div class="seccion_titulo_estructura">

                
                <h1>Actualizar Columnas</h1>
                

            </div>

            <div class="seccion_estructura">

                <div>

                    <form action="../php/Update_columnas.php" method="post">

                        <input type="hidden" name="ColumnaID" value="<?php echo $id_columna; ?>">
                        <input type="hidden" name="TablaID" value="<?php echo $id_tabla; ?>">



                        <table class="table table-bordered">


                            <thead>

                                <tr>

                                    <!-- <td>#</td>                -->
                                    <td>Nombre</td>
                                    <td>Tipo</td>
                                    <td>Longitud</td>
                                    <td>Nulo</td>
                                    <td>PK</td>
                                    <td>A.I</td>

                                </tr>

                            </thead>

                            <tbody>

                                <?php
                                    
                                    $columna="SELECT Nombre, Tipo, AutoIncrement, PK, Nulo FROM columnas WHERE ColumnaID = $id_columna";
                                    $resultado=mysqli_query($connect,$columna);
                                    while($tabla=mysqli_fetch_array($resultado)){
                                        
                                            
                                                                                
                                ?>  

                                
                                    <td><input class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" type="text" name="nombre_columna" id="n_columna" value="<?php echo htmlspecialchars($tabla['Nombre']);?>"></td>
                                    <td>
                                        <Select class="form-select" aria-label="Default select example" name="tipo_columna">

                                            <option><?php echo htmlspecialchars($tabla['Tipo']);?></option>
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

                                        </Select>
                                    </td>

                                    <td><input class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" type="text" name="longitud" id="longitud"></td>
                                    
                                    <?php

                                        // Para Nulo
                                        $checkedNulo = $tabla['Nulo'] == 'Si' ? 'checked' : '';
                                        echo "<td><input type='checkbox' name='Nulo' id='Nulo' $checkedNulo /></td>";

                                        $checkedAutoIncrement = $tabla['AutoIncrement'] == 'Si' ? 'checked' : '';
                                        echo "<td><input type='checkbox' name='AutoIncrement' id='AutoIncrement' $checkedAutoIncrement /></td>";

                                        // Para PK
                                        $checkedPK = $tabla['PK'] == 'Si' ? 'checked' : '';
                                        echo "<td><input type='checkbox' name='PK' id='PK' $checkedPK /></td>";

                                    
                                    ?>



                                

                                            
                                <?php     
                                    }
                                    mysqli_free_result($resultado);
                                ?>



                            </tbody>

                        </table>

                        <input type="submit" class="btn btn-outline-success" value="Actualizar Columna">

                    </form>
                </div>
            </div>
        </div>
    </div>

    
</body>

<script src="../Bootstrap/js/bootstrap.js"></script>


</html>