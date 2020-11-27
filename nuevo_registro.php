<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Registro</title>
    <link rel="stylesheet" href="./styles/estilo.css?v=<?php echo time(); ?>">
</head>
<body>

    <?php 
    require './database.php';

    $insertSuccess = false;
    $insertNoSuccess = false;

    if(isset($_POST['enviar_x'])){
        $previousPageInput = $_POST['previousPage'];
        $getUltimaPaginaInput = $_POST['lastPageNumber'];
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
        $sentencia="INSERT INTO contactes (nom,cognoms,direccio,localitat,provincia,cp,telefon1,telefon2,fax,mail) VALUES ('$nombre','$apellidos','$direccion','$localidad','$provincia','$cp','$tlf1','$tlf2','$fax','$mail')" ;
       if (mysqli_query($db,$sentencia)) {
        $insertSuccess = true ; 
       } else {
        echo "Error: " . $sentencia ;
        $insertNoSuccess = true;
       }
    } 

    $getBeforePage = false;
    $getUltimaPagina = false;
    if($_GET) {
      if($_GET['from'] && $_GET['np']){
        $previousPage = $_GET['from'];
        $getBeforePage = true;
        $ultimaPagina = $_GET['np'];
        $getUltimaPagina = false;
    }  
    }

    if(isset($_POST['cancel_x'])){
        $previousPageInput = $_POST['previousPage'];
        header('Location:'.$previousPageInput);
    }

    ?>

    <div class="container">
        <span class="tituloCrud">INSERTAR NUEVO REGISTRO</span>
        <hr>
        <div class="centrar">

            <?php if($insertSuccess):  ?>
                <h1>Registro insertado</h1>
                <div>
                    <div>
                    <a href="<?php echo $previousPageInput?>?pagina=<?php echo $getUltimaPaginaInput?>">Ver el registro en la tabla</a>
                    </div>
                    <br>
                    <div>
                    <a href="<?php echo $previousPageInput?>">Volver a la pagina de origen</a>
                    </div>
                </div>
                <?php exit; ?>
            <?php endif ?>

            <?php if($insertNoSuccess):  ?>
                <h1>Ha habido un error insertando el registro, intentelo mas tarde.</h1>
                <a href="<?php echo $previousPageInput?>">Volver a la pagina de origen</a>
                <?php exit; ?>
            <?php endif ?>

            <?php if($getBeforePage):  ?>
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="post">
                <div class="ChoicesRegistroTextAlign">
                    <fieldset>
                        <legend>Identificacion </legend>
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" maxlength="30">
                        <label for="apellido">&nbsp;&nbsp;&nbsp;&nbsp;Apellidos:</label>
                        <input type="text" name="apellido" id="apellido" size="30" maxlength="50">
                    </fieldset>

                    <fieldset>
                        <legend>Datos personales </legend>
                        <label for="direccion">Direccion:</label>
                        <input type="text" name="direccion" id="direccion"  maxlength="50">
                        <label for="codigoPostal">&nbsp;&nbsp; Codigo postal:</label>
                        <input type="text" name="codigoPostal" id="codigoPostal" size="5" maxlength="5">
                        <br>
                        <label for="localidad">Localidad:</label>
                        <input type="text" name="localidad" id="localidad"  maxlength="30">
                        <br>
                        <label for="provincia">Provincia:</label>
                        <input type="text" name="provincia" id="provincia"  maxlength="30">
                    </fieldset>

                    <fieldset>
                        <legend>Datos de contacto </legend>
                        <label for="tlf1">Tlf 1:</label>
                        <input type="text" name="tlf1" id="tlf1" size="12"  maxlength="12">
                        <label for="tlf2">&nbsp;Tlf 2:</label>
                        <input type="text" name="tlf2" id="tlf2" size="12" maxlength="12">
                        <label for="fax"&nbsp;>Fax:</label>
                        <input type="text" name="fax" id="fax" size="12" maxlength="12" >
                        <br>
                        <label for="email">Email:</label>
                        <input type="text" name="email" id="email" size="30" maxlength="30">
                    </fieldset>
                </div>
                <div>
                    <input type="hidden" name="previousPage" value="<?php echo $previousPage?>">
                    <input type="hidden" name="lastPageNumber" value="<?php echo $ultimaPagina?>">
                    <input type="image" src="./media/apply.png" class="imagenUltimaFila" alt="Aceptar" title="Aceptar" name="enviar">
                    <input type="image" class="imagenUltimaFila" src="./media/cancel.png" alt="Cancelar" title="Cancelar" name="cancel">
                </div>
            </form>
            <?php else: ?>
                <h1>Error. Debes epecificar de la pagina que procede.</h1>
            <?php endif ?>


        </div>
    </div>
        
</body>
</html>