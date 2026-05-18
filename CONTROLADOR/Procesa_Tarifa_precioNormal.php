<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';

require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';
require_once BASE_PATH.'MODELO/Ruta.class.php';

$conexion = ConexionBDD::getInstancia()->getConexion();
$consulta = $conexion->prepare("
    SELECT r.*, a.tipo_tarifa
    FROM ruta r, asiento a
    WHERE r.cod_ruta = ? AND a.nro_asiento = ?
");

$consulta -> bind_param("si", 
    $_POST['cod_ruta'],
    $_POST['nro_asiento']
);

$consulta->execute();
$resultado = $consulta->get_result();

$json_respuesta = [
    "precioNormal" => 0,
    "tipoTarifa" => 0,
    "precio_final_efectivo" =>0, 
    "precio_final_puntos" => 0,
    "suma_puntos" => 0
];

if ($fila = $resultado -> fetch_assoc()){
    $json_respuesta["precioNormal"] = $fila ["tarifa_normal"];
    $json_respuesta["tipoTarifa"] = $fila ["tipo_tarifa"];
    
    $ruta = new Ruta(
        $fila ["cod_ruta"],
        $fila ["lugar_destino"],
        $fila ["lugar_origen"],
        $fila ["tarifa_normal"],
        $fila ["hora_salida"]
    );

    switch($fila ["tipo_tarifa"]){
        case "promocional":
            $json_respuesta["precio_final_efectivo"] = $ruta -> get_tarifa_promocional();
            break;
        case "normal":
            $json_respuesta["precio_final_efectivo"] = $ruta -> get_tarifa_normal();
            break;
        default:
            $json_respuesta["precio_final_efectivo"] = $ruta -> get_tarifa_ejecutiva();
        break;
    }


    $usuario = $_SESSION["usuario"];

    // la suma de puntos la hago sobre la tarifa final en efectivo, es decir si paga con puntos no suma puntos
    if ($usuario ['es_usuario_frecuente']){
        switch($fila ["tipo_tarifa"]){
        case "promocional":
            $json_respuesta["suma_puntos"] = $json_respuesta["precio_final_efectivo"]*(5/100);
            break;
        case "normal":
            $json_respuesta["suma_puntos"] = $json_respuesta["precio_final_efectivo"]*(25/100);
            break;
        default:
            $json_respuesta["suma_puntos"] = $json_respuesta["precio_final_efectivo"]*(50/100);
        break;
        }
    }
        
    $json_respuesta["precio_final_puntos"] = $json_respuesta["precio_final_efectivo"]*(250/100);
}
$resultado->free();
header('Content-Type: application/json');
echo json_encode($json_respuesta);
exit;
?>