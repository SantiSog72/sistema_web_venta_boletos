<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';
require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';


$instancia = ConexionBDD::getInstancia();

// $json_respuesta = [
//     "exito" => false,
//     "mensaje" => "No se pudo viajes del usuario"
// ];
$lista_viajes = $instancia -> obtener_viajes ($_SESSION["usuario"]["dni"]);


// $json_respuesta = [
//     "exito" => true,
//     "mensaje" => "exito",
//     "viajes" => $lista_viaje
// ];

// Enviamos la respuesta
header('Content-Type: application/json');
echo json_encode($lista_viajes);
exit;

?>