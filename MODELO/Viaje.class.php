<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';
require_once BASE_PATH.'MODELO/Ruta.class.php';
class Viaje {

    private string $nro_viaje;
    private string $fecha_hora_arrivo;
    private string $fecha_hora_estimada_llegada;
    private Ruta $ruta;


    public function __construct($nro_viaje, $ruta, $fecha_hora_arrivo, $fecha_hora_arrivo) {
        $this->nro_viaje = $nro_viaje;
        $this->ruta = $ruta;
        $this->fecha_hora_arrivo = $fecha_hora_arrivo;
        $this->fecha_hora_arrivo = $fecha_hora_arrivo;
    }

    public function get_nro_viaje(): string {
        return $this->nro_viaje;
    }

    public function get_lugar_destino(): string {
        return $this->lugar_destino;
    }

    public function get_lugar_origen(): string {
        return $this->lugar_origen;
    }

    public function get_frecuencia_salidas_diarias(): array {
        return $this->frecuencia_salidas_diarias;
    }

    public function get_tramos(): array {
        return $this->tramos;
    }

    public function get_tarifa_normal(): float {
        return $this->tarifa_normal;
    }

    public function get_tarifa_promocional(): float {
        return ($this->tarifa_normal*(30/100));
    }

    public function get_tarifa_ejecutiva(): float {
        return ($this->tarifa_normal*(200/100));
    }
}
?>