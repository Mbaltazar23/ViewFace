<?php

require_once ('../config.php');
require_once ('../model/Conexion.php');
require_once ('../model/Personal.php');

$personal = new Personal();

$funcion = "";


if (isset($_GET["funcion"])) {
    $funcion = $_GET["funcion"];
    if ($funcion == "login") {
        $claveEncryp = "";
//        echo "Estamos dentro de la funcion " . $funcion;
        $correo = (isset($_POST["correoPer"])) ? $_POST["correoPer"] : "";
        $clave = (isset($_POST["clavePer"])) ? $_POST["clavePer"] : "";
        $resultado = $personal->login($correo, $clave);
        $claveEncryp = md5($clave);
        if (!empty($resultado) && $resultado['ClavePersonal'] == $claveEncryp) {
            echo json_encode($resultado);
        }else{
            $resultado = "";
            echo json_encode($resultado);
        }
    } else if ($funcion == "logout") {
        $respuesta = $personal->logout();
        if ($respuesta == true) {
            echo json_encode($respuesta);
        }
    }
} else {
    echo "<script>$(location).attr('href', '" . URL . "');</script>";
}
    
   

