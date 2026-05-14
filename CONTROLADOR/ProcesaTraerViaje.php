<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';

require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';

$conexion = ConexionBDD::getInstancia()->getConexion();
$consulta = $conexion->prepare("
    SELECT b.nro_asiento
    FROM viaje v NATURAL JOIN boleto b
    WHERE v.fecha_viaje = ? AND v.cod_ruta= ?
");

$consulta -> bind_param("ss", 
    $_POST['fecha_viaje'],
    $_POST['cod_ruta']
);
$consulta->execute();
$resultado = $consulta->get_result();
$lista = [];
while ($fila = $resultado->fetch_assoc()) {
    $lista[] = $fila['nro_asiento'];
}


$resultado->free();


header('Content-Type: application/json');
echo json_encode($lista);
exit;


?>