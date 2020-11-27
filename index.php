<?php 
  session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Base de datos. Ordenado por id</title>
    <link rel="stylesheet" href="./styles/estilo.css">
</head>
<body>
    <?php
        require_once './database.php';
        $nombrePagina = "index.php";
        $variableGet = "pagina";
        $variableGetRegistros = "rg";
        $nombrePaginaConsultarRegistro = "consultar_registro.php";
        $nombrePaginaCrearRegistro = "nuevo_registro.php";
        $nombrePaginaEditarRegistro = "editar_registro.php";
        $varGetAncestorPage = "from";
        //Redirige a la pagina sort_name.php que ordena los registros por apellido y nombre.
        if(isset($_POST['noid'])){
            header('Location:sort_name.php');
        }

        // sacar la cuenta de cuantas paginas en funcion de las filas
        $numeroFilas = 5;
        $totalPaginas = (int)ceil($totalRegistros/$numeroFilas);
        $_SESSION['totalPaginas'] = $totalPaginas;
        //Si no hay una peticion GET redirige la web a la primer pagina de los registros
        if (!$_GET) {
            header('Location:index.php?pagina=1');
        } 

        if ($_GET) {
            if ($_GET['pagina'] > $totalPaginas){
                header('Location:index.php?pagina='.$totalPaginas);
            }

            if ($_GET['pagina'] < 1){
                header('Location:index.php?pagina=1');
            }
            $_SESSION['paginaActual'] = $_GET['pagina'];
        } 

        $inicioPagina = ((int)$_GET['pagina']-1)*$numeroFilas;

        $consulta =  "SELECT id, cognoms, nom FROM contactes ORDER BY id LIMIT " . $inicioPagina . "," . $numeroFilas;

        $resultadoPaginacion = mysqli_query($db, $consulta);
        CompruebaErrorMySQL('Error realizando la consulta', $db);

        function afterPage ($paginaActual)
        {
            $paginaActual = (int)$paginaActual;
            global $totalPaginas;
            if($paginaActual == $totalPaginas) {
                return $totalPaginas;
            } else {
                return $paginaActual+1;
            }
        }

        function beforePage ($paginaActual)
        {
            $paginaActual = (int)$paginaActual;
            if($paginaActual == 1) {
                return 1;
            } else {
                return $paginaActual-1;
            }
        }

        //Check si el resultado tiene almenos una fila.
        if (mysqli_num_rows($resultado) > 0)
        {
            $files = true;
        }

        // Libera el resultado de la consulta.
        mysqli_free_result($resultado);

        mysqli_close($db);

    ?>

    
<div class="container">
    <div class="centrar">
    
        <h1>Contactes</h1>
        <p>Ordenado por Id</p>
        <?php if ($files): ?>
            <div class="pagina_session">
            <p >Pagina: <?php echo $_SESSION['paginaActual'] ?>/<?php echo $_SESSION['totalPaginas'] ?></p>
            </div>
        <table width="80%"  cellspacing="1">
            
            <tr class="botones">

            <form  method="POST"> 
            <td>
                <input type="submit" name="id" value="Id" disabled/>
            </td>

            <td colspan="2">
                <input type="submit" name="noid" value="Cognoms,nom"/>
            </td>

            <td colspan="3"><span>Mantenimiento</span></td>

            </form>

            </tr>
            <?php while ($fila = mysqli_fetch_assoc($resultadoPaginacion)): ?>
            <?php LimpiaResultados($fila) ?>
            <tr>
                
                
            <td width="10%"><?php echo $fila['id'] ?> </td>
            <td width="30%"><?php echo $fila['cognoms'] ?></td>
            <td width="30%"><?php echo $fila['nom'] ?></td>
            
            <td width="10%">
                <a href="consultar_registro.php?<?php echo $variableGetRegistros?>=<?php echo $fila['id']?>&<?php echo $varGetAncestorPage?>=<?php echo $nombrePagina?>&np=<?php echo $_GET[$variableGet] ?>">
                <img src="./media/view.png" alt="buscar" title="Ver registro" class="imagenCeldas" >
                </a>
            </td>

            <td width="10%">
                <a href="editar_registro.php?<?php echo $variableGetRegistros?>=<?php echo $fila['id']?>&<?php echo $varGetAncestorPage?>=<?php echo $nombrePagina?>&np=<?php echo $_GET[$variableGet] ?>">
                <img src="./media/edit.png" alt="editar" title="Editar registro" class="imagenCeldas" >
                </a>
            </td>

            <td width="10%">
                <a href="eliminar_registro.php?<?php echo $variableGetRegistros?>=<?php echo $fila['id']?>&<?php echo $varGetAncestorPage?>=<?php echo $nombrePagina?>&np=<?php echo $_GET[$variableGet] ?>">
                <img src="./media/remove.png" alt="eliminar" title="Eliminar registro" class="imagenCeldas" >
                </a>
            </td>

            </tr>
            <?php endwhile?>


            <tr>
                <td colspan="3"> 

                    <?php if ($totalPaginas>1): ?>

                    <!-- Boton para la primera pagina -->
                    <?php if ((int)$_GET[$variableGet] != 1):?>
                    <span>
                    <a href="<?php echo $nombrePagina?>?<?php echo $variableGet?>=1">
                    <img src="./media/home.png" alt="Primera pagina" title="Primera pagina" class="imagenUltimaFila" class="boton-navegacion">
                    </a>
                    </span>
                    <?php else:?>
                    <span>
                    <img src="./media/home.png" alt="Ya estas en la primera pagina" title="Ya estas en la primera pagina" class="imagenUltimaFila" class="boton-navegacion">
                    </span>
                    <?php endif ?>


                    <!-- Boton pagina anterior -->
                    <?php if ((int)$_GET[$variableGet] != 1):?>
                    <span>
                    <a href="<?php echo $nombrePagina?>?<?php echo $variableGet?>=<?php echo beforePage($_GET[$variableGet])?>">
                    <img src="./media/left.png" alt="Pagina anterior" title="Pagina anterior "class="imagenUltimaFila" class="boton-navegacion">
                    </a>
                    </span>
                    <?php else:?>
                    <span>
                    <img src="./media/left.png" alt="No hay paginas anteriores" title="No hay paginas anteriores" class="imagenUltimaFila" class="boton-navegacion">
                    </span>
                    <?php endif ?>

                    
                    <!-- Boton pagina siguiente -->
                    <?php if ((int)$_GET[$variableGet] != $totalPaginas):?>
                    <span>
                    <a href="<?php echo $nombrePagina?>?<?php echo $variableGet?>=<?php echo afterPage($_GET[$variableGet])?>">
                    <img src="./media/right.png" alt="Pagina siguiente" title="Pagina siguiente "class="imagenUltimaFila" class="boton-navegacion">
                    </a>
                    </span>
                    <?php else:?>
                    <span>
                    <img src="./media/right.png" alt="No hay paginas siguientes" title="No hay paginas siguientes" class="imagenUltimaFila" class="boton-navegacion">
                    </span>
                    <?php endif ?>

                  
                    <!-- Boton para la ultima pagina -->
                    <?php if ((int)$_GET[$variableGet] != $totalPaginas):?>
                    <span>
                    <a href="<?php echo $nombrePagina?>?<?php echo $variableGet?>=<?php echo $totalPaginas?>">
                    <img src="./media/end.png" alt="Final PAgina" title="Pagina final" class="imagenUltimaFila" class="boton-navegacion">
                    </a>
                    </span>
                    <?php else:?>
                    <span>
                    <img src="./media/end.png" alt="Final PAgina"  title="No hay paginas siguientes" class="imagenUltimaFila" class="boton-navegacion">
                    </span>
                    <?php endif ?>
                
                <?php endif ?>
                </td>

                <td colspan="3">
                    <a href="nuevo_registro.php?from=<?php echo $nombrePagina?>&np=<?php echo $totalPaginas ?>">
                    <img src="./media/add.png" alt="Agregar registro" title="Agregar registro" class="imagenUltimaFila">
                    </a>
              
                </td>
            </tr>
            
        </table>
       
        <?php endif ?>
    </div>
</div>
   
</body>

</html>
<?php 
$_SESSION = array ();
session_destroy();


?>