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
<meta name="description" content="Pagina rutas">
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
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; padding: 16px 24px;">
        <div style="display:flex; align-items:center; gap:14px;">
        <div class="avatar"><?= strtoupper(substr($usuario['primer_nombre'],0,1).substr($usuario['apellido'],0,1)) ?></div>
        <div>
            <p style="color:white; font-weight:700; font-size:15px; margin:0;"><?= $usuario['primer_nombre'].' '.$usuario['apellido'] ?></p>
            <p style="color:#aab; font-size:12px; margin:0;">DNI: <?= $usuario['dni'] ?></p>
        </div>
        </div>
        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
        <?php if($usuario['es_usuario_frecuente']): ?>
        <div class="badge-puntos"><?= $usuario['puntos'] ?> pts</div>
        <?php endif; ?>
        <button class="boton boton-outline" onclick="ir_historial_compras()">Historial</button>
        <button class="boton boton-danger" onclick="ir_comprar()">Comprar Boleto</button>
        <button class="boton boton-danger" onclick="ir_singOut()">Log out</button>
        </div>
    </div>

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