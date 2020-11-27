<?php
    function CompruebaErrorConexionMySQL($mensaje)
    {
        if (mysqli_connect_errno() != 0)
        {
        echo $mensaje.': '.mysqli_connect_error();
        exit();
        }
    }

    // Función que comprueba errores devueltos por MySQL
    function CompruebaErrorMySQL($mensaje, $conexion)
    {
        if (mysqli_errno($conexion) != 0)
        {
        echo $mensaje.': '.mysqli_error($conexion);
        mysqli_close($conexion);
        exit();
        }
    }
    
    function LimpiaResultados(&$fila)
        {
            foreach ($fila as $campo => $valor)
            if(is_string($valor) === true)
            $fila[$campo] = stripslashes($fila[$campo]);
        }

    // Establece conexión.
    @ $db = mysqli_connect('localhost', 'root', '');
    $databaseName = 'agenda';
    $createDB = "CREATE DATABASE IF NOT EXISTS ". $databaseName . ";";
    mysqli_query($db, $createDB);

    mysqli_select_db($db, 'agenda');

    $consultaRegistros = "SELECT * FROM contactes";
    $resultado = mysqli_query($db, $consultaRegistros);
    $totalRegistros = mysqli_num_rows($resultado);

    $crearTablaInicial = /*"DROP TABLE IF EXISTS `contactes`";*/
     "CREATE TABLE IF NOT EXISTS `contactes` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `nom` varchar(20) CHARACTER SET utf8 NOT NULL,
      `cognoms` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
      `direccio` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
      `localitat` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
      `provincia` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
      `cp` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
      `telefon1` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
      `telefon2` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
      `fax` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
      `mail` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16;"; 

    $datosBDInicial = "INSERT INTO contactes (nom, cognoms, direccio, localitat, provincia, cp, telefon1, telefon2, fax, mail) VALUES
    ('Andreu', 'Boltanya Pitarch', 'C/ Mealla, 19', 'Castelló de la Plana', 'Castelló', '12003', '964041235', NULL, NULL, 'mailo@gmail.com'),
    ('Pedro', 'Amor Beltran', 'C/- Amadeo López, 23', 'Castelló de la Plana', 'Castelló', '12001', '964244312', '619989898', '964244313', 'mailo@gmail.com'),
    ('Ana', 'Ansuategui Roig', 'C/- Amadeo López, 23', 'Castelló de la Plana', 'Castelló', '12001', '964244312', '619989898', '964244313', 'mailo@gmail.com'),
    ('Arcadi', 'Montes Gasulla', 'C/ Mealla, 19', 'Castelló de la Plana', 'Castelló', '12003', '964041235', NULL, NULL, 'mailo@gmail.com'),
    ('Pep', 'Gimeno Bernat', 'C/- Amadeo López, 23', 'Castelló de la Plana', 'Castelló', '12001', '964244312', '619989898', '964244313', 'mailo@gmail.com'),
    ('Pedro', 'Garrido Delas','C/ Mealla, 19', 'Castelló de la Plana', 'Castelló', '12003', '964041235', NULL, NULL, 'mailo@gmail.com'),
    ('Juan', 'Bartoll Mon', 'C/- Amadeo López, 23', 'Castelló de la Plana', 'Castelló', '12001', '964244312', '619989898', '964244313', 'mailo@gmail.com'),
    ('Paco', 'Llopis','C/ Mealla, 19', 'Castelló de la Plana', 'Castelló', '12003', '964041235', NULL, NULL, 'mailo@gmail.com'),
    ('Dani', 'Polo Segarra', 'C/- Amadeo López, 23', 'Castelló de la Plana', 'Castelló', '12001', '964244312', '619989898', '964244313', 'mailo@gmail.com'),
    ('Daniela', 'Polo Segarra', 'C/ Mealla, 19', 'Castelló de la Plana', 'Castelló', '12003', '964041235', NULL, NULL, 'mailo@gmail.com'),
    ('Aranxa', 'Pulido Benafeli', 'C/- Amadeo López, 23', 'Castelló de la Plana', 'Castelló', '12001', '964244312', '619989898', '964244313', 'mailo@gmail.com'),
    ('Jorge', 'Roig Mendoza', 'C/ Mealla, 19', 'Castelló de la Plana', 'Castelló', '12003', '964041235', NULL, NULL, 'mailo@gmail.com'),
    ('Sara', 'Tirado Polo', 'C/- Amadeo López, 23', 'Castelló de la Plana', 'Castelló', '12001', '964244312', '619989898', '964244313', 'mailo@gmail.com'),
    ('Bartolo', 'Bartali Polo', 'C/ Mealla, 19', 'Castelló de la Plana', 'Castelló', '12003', '964041235', NULL, NULL, 'mailo@gmail.com'),
    ('Diego', 'Polo Segarra', 'C/- Amadeo López, 23', 'Castelló de la Plana', 'Castelló', '12001', '964244312', '619989898', '964244313', 'mailo@gmail.com');
    ";

    if (mysqli_query($db, $crearTablaInicial)) {
       //Tabla creada
        
    } else {
        echo "No se pudo crear la tabla";
    }

    if(1 > $totalRegistros) {
        if(mysqli_multi_query($db, $datosBDInicial)){
           // 'contacto iniciales creados';
        } else {
            echo 'No se pusieron intertar los datos';   
        }
    }

    function SearchRegister($idParam) {
        $consulta = "SELECT id, nom, cognoms, direccio, localitat, provincia, cp, telefon1, telefon2,fax, mail from contactes WHERE id='". $idParam . "'";
        $resultado = mysqli_query($GLOBALS['db'], $consulta);
        $fila = mysqli_fetch_assoc($resultado);
        return $fila;

    }


    


    

    
?>