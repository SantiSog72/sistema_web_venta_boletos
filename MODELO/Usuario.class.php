<?php

class Usuario {

    private string $dni;
    private string $contrasena;
    private string $nombre_usuario="";
    private string $primer_nombre="";
    private string $segundo_nombre="";
    private string $apellido="";
	private string $nro_celular="";
	private string $email="";

    public function __construct($dni, $contrasena, $nombre_usuario, $primer_nombre, $segundo_nombre, $apellido, $nro_celular, $email) {
        $this -> dni           = $dni;
        $this -> contrasena    = $contrasena;
        $this -> nombre_usuario    = $nombre_usuario;
        $this -> primer_nombre    = $primer_nombre;
        $this -> segundo_nombre    = $segundo_nombre;
		$this -> apellido = $apellido;
		$this -> nro_celular = $nro_celular;
		$this -> email = $email;
    }

    public function get_dni()            { return $this->dni; }
    public function get_contrasena()     { return $this->contrasena; }
    public function get_nombre_usuario()         { return $this->nombre_usuario; }
    public function get_primer_nombre()         { return $this->primer_nombre; }
    public function get_segundo_nombre()         { return $this->segundo_nombre; }
    public function get_apellido()       { return $this->apellido; }

	public function getNro_celular (){
		return $this -> nro_celular;
	}
	
	public function getEmail (){
		return $this -> email;
	}
    
}

?>