<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';
// se puede usar el BASE_PATH al ingresar y tomar las fotos url

require_once BASE_PATH.'MODELO/Asiento.class.php';
require_once BASE_PATH.'MODELO/Boleto.class.php';
require_once BASE_PATH.'MODELO/Pasajero.class.php';
require_once BASE_PATH.'MODELO/Ruta.class.php';
require_once BASE_PATH.'MODELO/Usuario.class.php';
require_once BASE_PATH.'MODELO/Usuario_frecuente.class.php';

class ConexionBDD {
    // singleton
    private $conexion = null;
    private static $instancia = null; //instancia de la clase debe ser estatica

    private function __construct() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);//para que mysql pueda lanzar excepciones
        $this->conexion = new mysqli("localhost", "root", "", "db_sistema_boletos");
        $this->conexion->set_charset("utf8mb4");
    }

    public static function getInstancia() {
        if (self::$instancia == null) {
            self::$instancia = new ConexionBDD();
        }//si esta la devuelvo
        return self::$instancia;
    }

    public function getConexion(){
        return $this -> conexion;
    }

 

    // 
    
    // public function existe_viaje ($fecha_viaje, $cod_ruta){
    //     $consulta = $this -> conexion -> prepare("
    //     UPDATE alquiler a
    //     SET a.disponibilidad = 0
    //     WHERE a.nro_operacion = ?
    //     ");

    //     $consulta -> bind_param("s", $nro_alquiler);
    //     $consulta -> execute();
    // }

    // public function set_disponibilidad_venta ($nro_venta){
    //     $consulta = $this -> conexion -> prepare("
    //         UPDATE venta v
    //         SET v.disponibilidad = 0
    //         WHERE v.nro_operacion = ?
    //     ");

    //     $consulta -> bind_param("s", $nro_venta);
    //     $consulta -> execute();
    // }

    public function obtener_rutas() {
        $consulta = $this->conexion->prepare("
            SELECT * FROM `ruta` r WHERE 1
            ORDER BY r.lugar_origen, r.lugar_destino
        ");
        $consulta->execute();
        $resultado = $consulta->get_result();
        $lista = [];
        while ($fila = $resultado->fetch_assoc()) {
            $lista[] = $fila;
        }

        $resultado->free();
        return $lista;
    }


    public function obtener_viaje($fecha_viaje, $cod_ruta) {
        $consulta = $this->conexion->prepare("
            SELECT * FROM `ruta` r WHERE 1
            ORDER BY r.lugar_origen, r.lugar_destino
        ");
        $consulta->execute();
        $resultado = $consulta->get_result();
        $lista = [];
        while ($fila = $resultado->fetch_assoc()) {
            $lista[] = $fila;
        }

        $resultado->free();
        return $lista;
    }

    // public function ingresar_usuario(UsuarioAdministrador $usuario) {
    //     $consulta = $this->conexion->prepare("
    //         INSERT INTO usuario_administrador 
    //         (dni, contrasena, nombre, apellido, nro_celular, email)
    //         VALUES (?, ?, ?, ?, ?, ?)
    //     ");

    //     $dni      = $usuario->get_dni();
    //     $pass     = $usuario->get_contrasena();
        
    //     $contacto = $usuario->get_contacto();
    //     $apellido = $contacto->get_apellido();
    //     $nombre   = $contacto->get_nombre();
    //     $celular  = $contacto->getNro_celular();
    //     $email    = $contacto->getEmail();

    //     $consulta->bind_param("ssssss", 
    //         $dni, 
    //         $pass, 
    //         $nombre, 
    //         $apellido, 
    //         $celular, 
    //         $email
    //     );

    //     return $consulta->execute();
    // }

    public function obtener_usuario ($dni_usuario){
        $consulta = $this -> conexion -> prepare("
            SELECT u.*, uf.puntos
            FROM usuario u LEFT OUTER JOIN usuario_frecuente uf ON u.dni = uf.dni
            WHERE u.dni = ?
        ");
        $consulta -> bind_param("s", $dni_usuario);
        $consulta -> execute();
        $resultado = $consulta -> get_result();
        $usuario = $resultado -> fetch_assoc();
        $resultado->free();
        return $usuario;
    }

    public function __destruct() {
        if ($this->conexion != null) {
            $this->conexion->close();
        }
    }
}
?>
