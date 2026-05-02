<?php
// Esto busca el archivo desde la raíz de tu htdocs/www
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_inmobiliario/config.php';

// Ahora puedes usar las constantes en cualquier parte de la página:
require_once BASE_PATH . 'CONTROLADOR/ControladorCatalogo.class.php';
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

<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/javascript/botones_hipervinculo.js"></script>

<!-- <script>
	document.addEventListener('DOMContentLoaded', function () {//DOMContentLoaded: evento que se produce al cargar la pagina
		const formulario = document.getElementById('id_formulario_busqueda');
		const contenedor = document.getElementById('id_contenedor_catalogo');

		// cargo_cookies();

		// 1. Función para obtener y mostrar datos
		async function cargarCatalogo(parametros = "") {
			try {
				// Si hay parámetros agregamos el ?, si no, llamamos al archivo pelado
				//la URL de un archivo del servidor que procesa los datos
				const url = '<?= WEB_ROOT ?>CONTROLADOR/ProcesaBuscar.php' + (parametros ? '?' + parametros : '');
				//se realiza el pedido al servidor
				const respuesta = await fetch(url);
				// console.log (respuesta);
				//se recibe la respuesta y se la castea objeto json
				const lista_inmuebles = await respuesta.json();
				// console.log (lista_inmuebles);

				//combierte el json en string, luego guarda catalogo en local storage
				localStorage.setItem("catalogo_actual", JSON.stringify(lista_inmuebles));

				
				renderizarTarjetasJSON(lista_inmuebles);
			} catch (error) {
				console.error("Error al cargar el catálogo:", error);
				contenedor.innerHTML = "<p>Error al cargar los datos.</p>";
			}
		}

		// 2. CARGA INICIAL: Se ejecuta apenas abre la página
		cargarCatalogo(); 

		// 3. CARGA POR BÚSQUEDA: Se ejecuta al enviar el formulario
		formulario.addEventListener('submit', async function(evento) {
			evento.preventDefault(); //evita que se recargue la pagina (que se envie el formulario)
			const datos = new FormData(formulario);//recolecta la informacion del formulario que se estaba por enviar
			const params = new URLSearchParams(datos).toString();//transforma la info del formualrio a un string para el servidor
			//en un formato que el servidor entiede
			
			cargarCatalogo(params);
		});

		formulario.addEventListener('reset', async function(){
			localStorage.removeItem("catalogo_actual");
			cargarCatalogo();
		})

		//evento del mas-info
		contenedor.addEventListener("click", function(evento) {
			if (evento.target.classList.contains('boton_mas_info')) {
				// 1. Obtenemos los datos del botón
				const idOperacion_tipoOperacion = evento.target.getAttribute('data-id');
				const [idOperacion, tipoOperacion] = idOperacion_tipoOperacion.split(",");

				// 2. Buscamos en localStorage
				const lista_catalogo_str = localStorage.getItem("catalogo_actual");
				
				if (lista_catalogo_str) {
					const lista_catalogo = JSON.parse(lista_catalogo_str);

					// 3. Usamos .find() para recuperar el objeto directamente
					// Importante: Asegúrate de que idOperacion sea del mismo tipo (número o string)
					const operacion_seleccionada = lista_catalogo.find(item => 
						item.tipo === tipoOperacion && item.id_operacion == idOperacion
					);

					if (operacion_seleccionada) {
						console.log("Operación encontrada:", operacion_seleccionada);
						renderizarMasInfo(operacion_seleccionada);
					} else {
						console.warn("No se encontró la operación con ID:", idOperacion);
					}
				} else {
					console.error("No se encontró catálogo en local storage");
				}
			}
		});


	});

</script> -->

<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css/index.css">
<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css/formulario_estilos.css">

<title>Sistema Informacion Inmoviliaria</title>
</head>
<body> 
	<header>
	<h1>Sistema Informacion Inmobiliaria</h1>
	</header>

	<footer>
	<div id="descripcion_pagina">
		<p>autor: <span class="autor">Santiago Servin</span></p>
		<p>Final Libre 2026</p>		
	</div>
	</footer>
	
</body>

</html>