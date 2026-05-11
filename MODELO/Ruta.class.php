<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';
class Ruta {

    private string $cod_ruta;
    private string $lugar_destino;
    private string $lugar_origen;
    private float $tarifa_normal;
    private string $hora_salida; //horas en las que sale de la terminal


    public function __construct($cod_ruta, $lugar_destino, $lugar_origen, $tarifa_normal, $hora_salida) {
        $this->cod_ruta = $cod_ruta;
        $this->lugar_destino = $lugar_destino;
        $this->lugar_origen = $lugar_origen;
        $this->tarifa_normal = $tarifa_normal;
        $this->hora_salida = $hora_salida;
    }

    public function get_cod_ruta() {
        return $this->cod_ruta;
    }

    public function get_lugar_destino() {
        return $this->lugar_destino;
    }

    public function get_lugar_origen() {
        return $this->lugar_origen;
    }

    public function get_hora_salida() {
        return $this->hora_salida;
    }

    public function get_tarifa_normal() {
        return $this->tarifa_normal;
    }

    public function get_tarifa_promocional() {
        return ($this->tarifa_normal*(30/100));
    }

    public function get_tarifa_ejecutiva() {
        return ($this->tarifa_normal*(200/100));
    }
}
?>