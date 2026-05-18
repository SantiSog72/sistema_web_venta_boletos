<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';

require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $conexion = ConexionBDD::getInstancia() -> getConexion();
    $json_respuesta = [];





    header('Content-Type: application/json');
    echo json_encode($json_respuesta);
    exit;
}
?>