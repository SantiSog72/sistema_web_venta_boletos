<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';
require_once BASE_PATH.'MODELO/Ruta.class.php';
class Viaje {

    private int $nro_viaje;
    private Ruta $ruta;
    private string $fecha_viaje;
    private string $fecha_llegada;
 
    public function __construct($nro_viaje, $ruta, $fecha_viaje, $fecha_llegada) {
        $this->nro_viaje = $nro_viaje;
        $this->ruta = $ruta;
        $this->fecha_viaje = $fecha_viaje;
        $this->fecha_llegada = $fecha_llegada;
    }

    public function get_nro_viaje() {
        return $this->nro_viaje;
    }

    public function get_fecha_viaje() {
        return $this->fecha_viaje;
    }

    public function get_fecha_llegada() {
        return $this->fecha_llegada;
    }

    public function get_ruta(): Ruta {
        return $this->ruta;
    }

    public function get_tarifa_promocional(): float {
        return ($this->get_ruta()->get_tarifa_normal()*(30/100));
    }

    public function get_tarifa_ejecutiva(): float {
        return ($this->get_ruta()->get_tarifa_normal()*(200/100));
    }
}
?>