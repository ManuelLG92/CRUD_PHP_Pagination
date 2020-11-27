<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Registro</title>
    <link rel="stylesheet" href="./styles/estilo.css?v=<?php echo time(); ?>">
</head>
<body>

    <?php 
    require './database.php';

        if(isset($_POST['aceptar_x'])){
        $ancestorPageInput = $_POST['ancestorPage'];
        $numeroPaginaAncestorInput = $_POST['ancestorPageNumer'];
        $pageAndNumber = '?pagina='.trim($numeroPaginaAncestorInput);
        $ancestorPageWithpage = $ancestorPageInput .$pageAndNumber;
        header('Location:'.$ancestorPageWithpage);   
        }

        $idOnRequest = false;
        $invalidRegisterId = true;
        if($_GET['rg'] && $_GET['from'] && $_GET['np']){

            $ancestorPage = $_GET['from'];
            $id = $_GET['rg']; 
            $numeroPaginaAncestor = $_GET['np'];
            $idOnRequest = true;
            $resultado = SearchRegister($id);
            if ($resultado != null) {
            $invalidRegisterId = false;

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
    ?>

    <div class="container">
    <?php if($_GET): ?>
        <?php if($idOnRequest && !$invalidRegisterId): ?>
        <span class="tituloCrud">CONSULTAR REGISTRO Nº: </span>
        <hr>
        <div class="centrar">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="ChoicesRegistroTextAlign">
            <fieldset>
                <legend>Identificacion </legend>
                <label for="idQuery">Id:</label>
                <input type="text" name="idQuery" id="idQuery" value="<?php echo $idQuery ?>" readonly size="1">
                <br>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo $nombre ?>" readonly >
                <label for="apellido">&nbsp;&nbsp;&nbsp;&nbsp;Apellido:</label>
                <input type="text" name="apellido" id="apellido" size="30" value="<?php echo $apellidos ?>" readonly>
            </fieldset>

            <fieldset>
                <legend>Datos personales </legend>
                <label for="direccion">Direccion:</label>
                <input type="text" name="direccion" id="direccion" value="<?php echo $direccion ?>" readonly>
                <label for="codigoPostal">&nbsp;&nbsp; Codigo postal:</label>
                <input type="text" name="codigoPostal" id="codigoPostal" size="6" value="<?php echo $cp ?>" readonly>
                <br>
                <label for="localidad">Localidad:</label>
                <input type="text" name="localidad" id="localidad" value="<?php echo $localidad ?>" readonly>
                <br>
                <label for="provincia">Provincia:</label>
                <input type="text" name="provincia" id="provincia" value="<?php echo $provincia ?>" readonly>
            </fieldset>

            <fieldset>
                <legend>Datos de contacto </legend>
                <label for="tlf1">Tlf 1:</label>
                <input type="text" name="tlf1" id="tlf1" size="12" value="<?php echo $tlf1 ?>" readonly>
                <label for="tlf2">&nbsp;Tlf 2:</label>
                <input type="text" name="tlf2" id="tlf2" size="12" value="<?php echo $tlf2 ?>" readonly>
                <label for="fax"&nbsp;>Fax:</label>
                <input type="text" name="fax" id="fax" size="12" value="<?php echo $fax ?>" readonly>
                <br>
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" size="30" value="<?php echo $mail ?>" readonly>
            </fieldset>
            </div>
            <div>
                
                <input type="hidden" name="ancestorPage" value=" <?php echo $ancestorPage ?>">
                <input type="hidden" name="ancestorPageNumer" value=" <?php echo $numeroPaginaAncestor ?>">
                <input type="image" class="imagenUltimaFila" src="./media/apply.png" alt="aceptar" title="aceptar" name="aceptar">
               
            </div>
            </form>
            <div>
                <a href="editar_registro.php?rg=<?php echo $idQuery?>&from=<?php echo $ancestorPage?>&np=<?php echo $numeroPaginaAncestor?>">Pulsando aqui puedes editar el registro.</a>
            </div>
        </div>
        <?php elseif($idOnRequest && $invalidRegisterId):?>
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