<?php
session_start();
// Esto busca el archivo desde la raíz de tu htdocs/www
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';
$usuario = $_SESSION["usuario"];
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
	boton_sing_out = document.getElementById("id_boton_sing_out");
	const radios = document.querySelectorAll('input[name="tipo_usuario"]');

	// const radio_usuario_frecuente = document.getElementById("id_radio_usuario_frecuente");
	// const radio_usuario_comun = document.getElementById("id_radio_usuario_comun");
	// if (JSON.parse (localStorage.getItem("es_usuario_frecuente"))){
	// 	radio_usuario_frecuente.checked;
	// }

	async function cargarRutas() {
		try {
			const respuesta = await fetch('<?= WEB_ROOT ?>CONTROLADOR/Procesa_cargarRutas.php');
			const lista_rutas = await respuesta.json();

			renderizarTablaRutaJSON(lista_rutas);

			//combierte el json en string, luego guarda catalogo en local storage
			localStorage.setItem("Rutas_disponibles", JSON.stringify(lista_rutas));			

			} catch (error) {
				console.error("Error al cargar las rutas:", error);
				contenedor.innerHTML = "<p>Error al cargar los datos.</p>";
			}
		}
	cargarRutas(); 


	boton_sing_out.addEventListener("click", function(){
		//desloguearse
		localStorage.clear();
		ir_singIn();
	});

	radios.forEach(radio => {
		radio.addEventListener('change', async function() {
			let datos = new FormData();
			datos.append("tipo_usuario", this.value);
			

			const respuesta = await fetch(
				'<?= WEB_ROOT ?>CONTROLADOR/ProcesaCambioTipoUsuario.php',{
					method:'POST',
					body: datos
				});
			let resultado = await respuesta.json();

			if (resultado.exito) {
				localStorage.setItem("es_usuario_frecuente", JSON.stringify(resultado.es_usuario_frecuente));
				alert(resultado.mensaje);
			} else {
				alert("Error: " + resultado.mensaje);
			}
		});
	});




	




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
		<button id="id_boton_sing_out" class= "boton">Log out</button>
		<button class= "boton" onclick="ir_comprar()">Comprar Boleto</button>

		<p>Tipo de Usuario</p>
		<span class="">
			<input id ="id_radio_usuario_comun" type="radio" name="tipo_usuario" value="usuario_comun" checked>
			<label class="label">usuario común</label><br>
			<?php if ($usuario["es_usuario_frecuente"]){?>
			<input id ="id_radio_usuario_frecuente" type="radio" name="tipo_usuario" value="usuario_frecuente" checked>
			<?php }else{?>
			<input id ="id_radio_usuario_frecuente" type="radio" name="tipo_usuario" value="usuario_frecuente">
			<?php }?>
			<label class="label">usuario frecuente</label><br>
		</span>
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