<?php
// Esto busca el archivo desde la raíz de tu htdocs/www
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="autor" content="Santiago Servin">
<meta name="description" content="Pagina principal">
<script>
    window.BASE_URL = "<?= WEB_ROOT ?>";
</script>

<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/library_js/botones_hipervinculo.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/library_js/ubicador_elementos.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/library_js/renderizador.js"></script>


<script>
	document.addEventListener('DOMContentLoaded', function () {//DOMContentLoaded: evento que se produce al cargar la pagina
	
	async function cargarRutas() {
		try {
			const respuesta = await fetch('<?= WEB_ROOT ?>CONTROLADOR/Procesa_cargarRutas.php');
			const lista_rutas = await respuesta.json();


			renderizarTablaRutaJSON(lista_rutas);

				//combierte el json en string, luego guarda catalogo en local storage
				// localStorage.setItem("catalogo_actual", JSON.stringify(lista_rutas));
				
				// renderizarTarjetasJSON(lista_rutas);
			} catch (error) {
				console.error("Error al cargar las rutas:", error);
				contenedor.innerHTML = "<p>Error al cargar los datos.</p>";
			}
		}
	cargarRutas(); 

	});

</script>

<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css/index.css">
<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css/tabla.css">
<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css/formulario_estilos.css">

<title>Sistema Venta de Boletos</title>
</head>
<!-- con el onload trae todo el catalogo para mostrar -->
<body> 
	<header>
	<h1>Venta de Boletos para Terminal de Colectivos</h1>
	<nav class="contenedor_mapa">
		<button class= "boton" onclick="ir_singIn();">Iniciar sesion</button>
		<button class= "boton" onclick="ir_singUp();">registrarse</button>
		<button class= "boton" onclick="">Mapa Catalogo Completo</button>
		<button class= "boton" onclick="ocultarMapa()">Ocultar Mapa</button>
	</nav>
	</header>

	<div id="id_contenedor_rutas">

	</div>

	<footer>
	<div id="descripcion_pagina">
		<p>autor: <span class="autor">Santiago Servin</span></p>
		<p>Final Libre 2026</p>		
	</div>
	</footer>
	
</body>

</html>