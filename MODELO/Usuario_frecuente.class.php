<?php

require_once $_SERVER['DOCUMENT_ROOT']. '/sistema_web_venta_boletos/config.php';
require_once BASE_PATH.'MODELO/Usuario.class.php';
class Usuario_frecuente extends Usuario{

	private int $puntos;

    public function __construct($dni, $contrasena, $nombre_usuario, $primer_nombre, $segundo_nombre, $apellido, $nro_celular, $email, $puntos = 0) {
        parent::__construct($dni, $contrasena, $nombre_usuario, $primer_nombre, $segundo_nombre, $apellido, $nro_celular, $email);
        $this -> puntos = $puntos;
    }

    public function get_puntos()       { return $this->puntos; }
    public function pagar_puntos ($cantidad_puntos){
        //acceder a la base de datos, al usuario restarle la cantidad
    }
}

?>