<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <link rel="stylesheet" href="./styles/estilo.css?v=<?php echo time(); ?>">
</head>
<body>

    <?php 
        require './database.php';
        $editSucces = false;
        $editError = false;
   
        if(isset($_POST['cancel_x'])){
            $ancestorPageInput = $_POST['ancestorPage'];
            $numeroPaginaAncestorInput = $_POST['ancestorPageNumber'];
            $pageAndNumber = '?pagina='.trim($numeroPaginaAncestorInput);
            $ancestorPageWithNumer = $ancestorPageInput .$pageAndNumber;
            header('Location:'.$ancestorPageWithNumer);   
        }
        
        
        if(isset($_POST['enviar_x'])){
            $ancestorPageInput = $_POST['ancestorPage'];
            $numeroPaginaAncestorInput = $_POST['ancestorPageNumber'];
            $pageAndNumber = '?pagina='.trim($numeroPaginaAncestorInput);
            $ancestorPageWithNumer = $ancestorPageInput .$pageAndNumber;
            $idRg = $_POST['idQuery'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellido'];
            $direccion = $_POST['direccion'];
            $cp = $_POST['codigoPostal'];
            $localidad = $_POST['localidad'];
            $provincia = $_POST['provincia'];
            $tlf1 = $_POST['tlf1'];
            $tlf2 = $_POST['tlf2'];
            $fax = $_POST['fax'];
            $mail = $_POST['email']; 
            $sentenciaSql = "UPDATE contactes SET nom='". $nombre . "',cognoms='". $apellidos . "',direccio='". $direccion . "',localitat='". $localidad . "',provincia='". $provincia . "',cp='". $cp . "',telefon1='". $tlf1 . "',telefon2='". $tlf2 . "',fax='". $fax . "',mail='". $mail . "' WHERE id='" . $idRg . "'";
            if(mysqli_query($db,$sentenciaSql)) {
                $editSucces = true;
            } else {
                $editError= true;
            }
        }

            $idOnRequest = false;
            $idRegistroInvalido = true;
        if ($_GET) {          
            if($_GET['rg'] && $_GET['from'] && $_GET['np']) {
                $ancestorPage = $_GET['from'];
                $id = $_GET['rg'];
                $numeroPaginaAncestor = $_GET['np'];
                $idOnRequest = true;

                $resultado = SearchRegister($id);
                if ($resultado != null) {
                // var_dump($resultado);
                // echo $resultado['nom'];
                $idRegistroInvalido = false;
                    $idQuery = $resultado['id'];
                    $nombre = $resultado['nom'];
                    $apellidos = $resultado['cognoms'];
                    $direccion = $resultado['direccio'];
                    $localidad = $resultado['localitat'];
                    $provincia = $resultado['provincia'];
                    $cp = $resultado['cp'];
                    $tlf1 = $resultado['telefon1'];
                    $tlf2 = $resultado['telefon2'];
                    $fax = $resultado['fax'];
                    $mail = $resultado['mail'];
                }
            }
        }       
    ?>

    <div class="container">

    <?php if($editSucces):?>
        <h1>Registro modificado satisfactoriamente.</h1>
        <div>
        <a href="consultar_registro.php?rg=<?php echo $idRg?>&from=<?php echo $ancestorPageInput?>&np=<?php echo $numeroPaginaAncestorInput?>">Ver el registro modificado.</a>
        </div>
        <br>
        <div>
        <a href="<?php echo $ancestorPageWithNumer ?>">Volver al listado.</a>
        </div>
        <?php echo exit; ?> 
    <?php endif?>

    <?php if($editError):?>
        <h1>Ha habido un error al modificar el registro, intentalo de nuevo mas tarde.</h1>
        <a href="<?php echo $ancestorPageWithNumer ?>"></a>
        <?php echo exit; ?>
    <?php endif?>

    <?php if($_GET): ?>
        <?php if($idOnRequest && !$idRegistroInvalido): ?>
        <span class="tituloCrud">EDITAR REGISTRO Nº: </span>
        <hr>
        <div class="centrar">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="ChoicesRegistroTextAlign">
            <fieldset>
                <legend>Identificacion </legend>
                <label for="idQuery">Id:</label>
                <input type="text" name="idQuery" id="idQuery" value="<?php echo $idQuery ?>" size="1" readonly>
                <br>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo $nombre ?>" >
                <label for="apellido">&nbsp;&nbsp;&nbsp;&nbsp;Apellido:</label>
                <input type="text" name="apellido" id="apellido" size="30" value="<?php echo $apellidos ?>">
            </fieldset>

            <fieldset>
                <legend>Datos personales </legend>
                <label for="direccion">Direccion:</label>
                <input type="text" name="direccion" id="direccion" value="<?php echo $direccion ?>">
                <label for="codigoPostal">&nbsp;&nbsp; Codigo postal:</label>
                <input type="text" name="codigoPostal" id="codigoPostal" size="6" value="<?php echo $cp ?>">
                <br>
                <label for="localidad">Localidad:</label>
                <input type="text" name="localidad" id="localidad" value="<?php echo $localidad ?>">
                <br>
                <label for="provincia">Provincia:</label>
                <input type="text" name="provincia" id="provincia" value="<?php echo $provincia ?>">
            </fieldset>

            <fieldset>
                <legend>Datos de contacto </legend>
                <label for="tlf1">Tlf 1:</label>
                <input type="text" name="tlf1" id="tlf1" size="12" value="<?php echo $tlf1 ?>">
                <label for="tlf2">&nbsp;Tlf 2:</label>
                <input type="text" name="tlf2" id="tlf2" size="12" value="<?php echo $tlf2 ?>">
                <label for="fax"&nbsp;>Fax:</label>
                <input type="text" name="fax" id="fax" size="12" value="<?php echo $fax ?>">
                <br>
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" size="30" value="<?php echo $mail ?>">
            </fieldset>
            </div>
            <div>
                <input type="hidden" name="ancestorPage" value=" <?php echo $ancestorPage ?>">
                <input type="hidden" name="ancestorPageNumber" value=" <?php echo $numeroPaginaAncestor ?>">
                <input type="image" src="./media/apply.png" class="imagenUltimaFila" alt="Aceptar" title="Aceptar" name="enviar">

                <input type="image" class="imagenUltimaFila" src="./media/cancel.png" alt="Cancelar" title="cancel" name="cancel">

            </div>
            </form>
        </div>
        <?php elseif($idOnRequest && $idRegistroInvalido):?>
                <h1>Error: Id invalido.</h1>
                <h2>Asegurate de usar un ID valido para esta consulta.</h2>
            <?php else: ?>
                <h1>Error. El registro que buscas no existe.</h1>
                <h2>Intentalo de nuevo mas tarde</h2>
        <?php endif ?>
    <?php endif ?>
    </div>
</body>
</html>