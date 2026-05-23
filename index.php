<?php
// Esto busca el archivo desde la raíz de tu htdocs/www
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="autor" content="Santiago Servin">
<meta name="description" content="Pagina ingreso">
<script>
    window.BASE_URL = "<?= WEB_ROOT ?>";
</script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/library_js/botones_hipervinculo.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/library_js/ventana_emergente.js"></script>
<!-- <script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/library_js/libreria_js/ubicador_elementos.js"></script> -->

<script>
    document.addEventListener('DOMContentLoaded', function (){
        const formulario_ingreso = document.getElementById("id_fomr_ingreso");
        
        formulario_ingreso.addEventListener('submit', async function(evento) {
			evento.preventDefault(); 

			const datos = new FormData(formulario_ingreso);

			try {
				const respuesta = await fetch('<?= WEB_ROOT ?>CONTROLADOR/ProcesaingresoUsuario.php', {
					method: 'POST',
					body: datos
				});

				const resultado = await respuesta.json();

				//guardo si es usuario frecuente, guardo con stringfy recupero con parse
				localStorage.setItem("es_usuario_frecuente", JSON.stringify(resultado.usuario.es_usuario_frecuente));

				if (resultado.exito) {
					console.log (resultado);
					ventana_bienvenida_viajes(resultado);
					ir_paginaRutas();
				} else {
					alert("Error: " + resultado.mensaje);
				}
			} catch (error) {
				console.error("Error en la conexión:", error);
			}
		});
    })
</script>

<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css/index.css">
<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css/formulario_estilos.css">

<title>Sing In</title>
</head>

<body>
	<header>
	<h1>Ingreso Usuario</h1>
	</header>
	<section>
		<article class= "contenedor_formulario">
			<form id="id_fomr_ingreso" class "formulario" method="POST">
				<fieldset class = "fieldset" name="Singin">
					
					<span class="form_grupo">
						<label class ="label" for ="id_dni">DNI: </label>						
						<input id ="id_dni" type="text" name="dni" placeholder="ingrese su dni" value="12345678">
						<span id="error_dni" class="error"></span>
					</span>
				
					<span class="form_grupo">
						<label class ="label" for ="id_contraseña">Contraseña: </label>
						<input id ="id_contraseña" type="password" name="contrasena" maxlength="20" placeholder="ingrese su contraseña" value="12345678">
						<span id="error_contraseña" class="error"></span>
					</span>
				</fieldset>
				
				
				<fieldset class = "fieldset field_acciones" name="acciones_botones">
					<button id="id_envio" class="boton" type ="submit">ingresar</button>
					<button id="id_registrarse" class="boton" type ="button" onclick = "ir_singUp();">registrarse</button>
					<!-- <button id="id_borrar" class="boton" type ="button" onclick="ir_index();">atras</button> -->
				</fieldset>
				
			</form>
		
		</article>
	</section>
	<footer>
	<div id="descripcion_pagina">
		<p>autor: <span class="autor">Santiago Servin</span></p>
		<p>Final Libre 2026</p>		
	</div>
	</footer>
	
</body>

</html>