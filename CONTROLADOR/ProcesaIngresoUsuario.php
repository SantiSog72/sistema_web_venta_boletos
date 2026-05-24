<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';
require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $instancia = ConexionBDD::getInstancia();
    $usuario_bdd = $instancia->obtener_usuario($_POST['nombre_usuario']);

    $json_respuesta = [
        "exito" => false,
        "mensaje" => "El usuario o la contraseña es incorrecta",
    ];

    if ($usuario_bdd){
        if ($usuario_bdd['contrasena'] === $_POST['contrasena']){



            // obtengo viajes y filtro los que estan vigentes
            $fechaActual = date('Y-m-d');
            $lista_viajes = $instancia -> obtener_viajes ($usuario_bdd["dni"]);
            $lista_viajes_pendientes = [];
            // lo filtra como tipo objeto
            $filtrados = array_filter($lista_viajes, fn($elemento) => $elemento["fecha_viaje"] >= $fechaActual);
            // convierte ese objeto en un array
            $lista_viajes_pendientes = array_values($filtrados);

            

            $json_usuario = [
                "dni" => $usuario_bdd['dni'],
                "nombre_usuario" => $usuario_bdd['nombre_usuario'],
                "primer_nombre" => $usuario_bdd['primer_nombre'],
                "apellido" => $usuario_bdd['apellido'],
                "es_usuario_frecuente" => false
            ];

            // si es usuario frecuente
            if ($instancia -> es_usuario_frecuente ($usuario_bdd["dni"])){
                $json_usuario["es_usuario_frecuente"] = true;
                $json_usuario["puntos"] = $usuario_bdd['puntos'];
            }

            $json_respuesta = [
                "exito" => true,
                "usuario" => $json_usuario,
                "mensaje" => "Ingreso exitoso",
                "viajes_pendientes" => $lista_viajes_pendientes
            ];

            $_SESSION["usuario"] = $json_usuario;
        }
    }
    // Enviamos la respuesta
    header('Content-Type: application/json');
    echo json_encode($json_respuesta);
    exit;
}
?>