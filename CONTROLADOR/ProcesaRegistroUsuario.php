<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';
require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $conexion = ConexionBDD::getInstancia()->getConexion();
    
    $json_respuesta = [
        "exito" => false,
        "mensaje" => ""
    ];

    $consulta_registro_usuario = $conexion->prepare("
        INSERT INTO usuario (dni, contrasena, nombre_usuario, primer_nombre, segundo_nombre, apellido, nro_celular, email)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $consulta_registro_usuario->bind_param("ssssssss",
        $_POST['dni'],
        $_POST['contrasena'],
        $_POST['nombre_usuario'],
        $_POST['nombre'],
        $_POST['segundo_nombre'],
        $_POST['apellido'],
        $_POST['nro_celular'],
        $_POST['email']
    );

    $consulta_registro_usuario_frecuente = $conexion->prepare("
        INSERT INTO usuario_frecuente (dni)
        VALUES (?);
    ");

    $consulta_registro_usuario_frecuente -> bind_param("s", 
        $_POST['dni']
    );


    



    try{
        if ($consulta_registro_usuario->execute()){
            $json_respuesta["mensaje"] = 'El usuario se registró con éxito';
            $json_respuesta["exito"] = true;
            if (isset($_POST['usuario_frecuente']) && $_POST['usuario_frecuente'] === "1"){
                $consulta_registro_usuario_frecuente->execute();
            }
            
        }
    }catch(mysqli_sql_exception $e){
        if (str_contains($e -> getMessage(), "Duplicate entry")){
            $json_respuesta["mensaje"] = 'El usuario ya se encuentra registrado en la base de datos';
           
        }else{
            $json_respuesta["mensaje"] = 'El usuario no se pudo registrar';
            
        }
        header('Content-Type: application/json');
        echo json_encode($json_respuesta);
        exit;
    }

    header('Content-Type: application/json');
    echo json_encode($json_respuesta);
    exit;
        

}
?>