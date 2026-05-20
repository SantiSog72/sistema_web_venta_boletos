<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';
require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $conexion = ConexionBDD::getInstancia()->getConexion();
    $instancia = ConexionBDD::getInstancia();

    $json_respuesta=[
        "exito" => false,
        "mensaje" => ""
    ];


    switch($_POST["tipo_usuario"]){
        case "usuario_frecuente":
            $_SESSION["usuario"]["es_usuario_frecuente"] = true;
            $consulta = $conexion->prepare("
                INSERT IGNORE INTO usuario_frecuente (dni)
                VALUES (?);
            ");
            $json_respuesta=[
                "exito" => true,
                "mensaje" => "Ahora sos un usuario frecuente"
            ];
            break;
        case "usuario_comun":
            $_SESSION["usuario"]["es_usuario_frecuente"] = false;
            $consulta = $conexion->prepare("
                DELETE FROM `usuario_frecuente` 
                WHERE `dni` = ?
            ");
            $json_respuesta=[
                "exito" => true,
                "mensaje" => "Ahora sos un usuario normal, se eliminaron los puntos"
            ];
            break;
    }

    $consulta -> bind_param("s", 
        $_SESSION["usuario"]["dni"]
    );

    if (!$consulta->execute()){
        $json_respuesta=[
            "exito" => false,
            "mensaje" => "ocurrio un error"
        ];
    };

    header('Content-Type: application/json');
    echo json_encode($json_respuesta);
    exit;
}
?>