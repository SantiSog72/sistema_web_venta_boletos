<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';

require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $instancia = ConexionBDD::getInstancia();
    $conexion = ConexionBDD::getInstancia() -> getConexion();

    $json_respuesta = [
        "exito" => true,
        "mensaje" => "nada paso"
    ];

    

    // fecha actual en (AAAA-MM-DD)
    $fechaActual_str = date('Y-m-d');
    // dni usuario
    $dni_usuario = $_SESSION["usuario"]["dni"];
    // el usuario pago en efectivo?
    $pago_efectivo = ($_POST['tipo_pago']==="efectivo")?1:0;
    
    $es_usuario_frecuente = $_SESSION["usuario"]["es_usuario_frecuente"];

    
    $precio_final = $_POST['precio_final_efectivo'];

    // manejo de puntos con usuario frecuente
    if ($es_usuario_frecuente){
        if ($pago_efectivo){
            //sumar puntos
            $consulta_puntos = $conexion->prepare("
                UPDATE usuario_frecuente 
                SET puntos = puntos + ? 
                WHERE dni = ?
            ");
            $cantidad_puntos_a_operar = $_POST["suma_puntos"];
        }else{
            // unico caso en el que no se paga en efectivo
            $precio_final = $_POST['precio_final_puntos'];

            // restar_puntos
            $consulta_puntos = $conexion->prepare("
                UPDATE usuario_frecuente 
                SET puntos = puntos - ? 
                WHERE dni = ?
            ");
            $cantidad_puntos_a_operar = $_POST["precio_final_puntos"];
        }
        $consulta_puntos -> bind_param("is",
            $cantidad_puntos_a_operar,
            $dni_usuario
        );

    }


    // insertar boleto
    $consulta_ingresa_boleto = $conexion->prepare("
        INSERT INTO boleto (fecha_emision, fecha_viaje, cod_ruta, nro_asiento, tipo_tarifa, precio_final, dni_usuario, dni_pasajero, pago_efectivo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $consulta_ingresa_boleto->bind_param("sssisissi",
        $fechaActual_str,
        $_POST['fecha_viaje'],
        $_POST['cod_ruta'],
        $_POST['nro_asiento'],
        $_POST['tipo_tarifa'],
        $precio_final,
        $dni_usuario,
        $_POST['dni'],
        $pago_efectivo
    );

    //insertar pasajero ignora si ya existe
    $consulta_ingresa_pasajero = $conexion->prepare("
        INSERT IGNORE INTO pasajero (dni, nombre, apellido)
        VALUES (?, ?, ?)
    ");

    $consulta_ingresa_pasajero->bind_param("sss",
        $_POST['dni'],
        $_POST['nombre'],
        $_POST['apellido']
    );

    // para indicar si un pasajero esta en un viaje 
    

    
    if ($instancia -> existe_pasajero_en_viaje($_POST['dni'], $_POST['cod_ruta'], $_POST['fecha_viaje'])){
        $json_respuesta = [
            "exito" => false,
            "mensaje" => "El pasajero ya tiene un boleto para este viaje"
        ];
        // si es usuario frecuente, paga con puntos y la cantidad de puntos disponibles cubre el coste entonces
    }else if ($es_usuario_frecuente && !$pago_efectivo && ($instancia -> obtener_puntos_usuario($dni_usuario) < $precio_final)){
        $json_respuesta = [
            "exito" => false,
            "mensaje" => "Puntos insuficientes"
        ];
    }else{
        $consulta_ingresa_pasajero->execute();
        $consulta_ingresa_boleto->execute();
        $id_boleto = $conexion->insert_id;
        if ($es_usuario_frecuente){
            $consulta_puntos->execute();
            $_SESSION["usuario"]["puntos"] = $instancia ->obtener_puntos_usuario($dni_usuario);
        }

        $json_respuesta = [
        "exito" => true,
        "mensaje" => "El boleto se registro correctamente",
        "id_boleto" => $id_boleto,
        "dni_usuario" => $_SESSION["usuario"]["dni"]
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($json_respuesta);
    exit;
}
?>