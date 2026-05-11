<?php
// Esto busca el archivo desde la raíz de tu htdocs/www
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';

// Ahora puedes usar las constantes en cualquier parte de la página:
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="autor" content="Santiago Servin">
<meta name="description" content="Pagina principal">

<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css/index.css">
<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css/formulario_estilos.css">
<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css/mapa_colectivo.css">

<script>
    window.BASE_URL = "<?= WEB_ROOT ?>";
</script>

<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/library_js/botones_hipervinculo.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/library_js/ubicador_elementos.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/library_js/Validacion.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/library_js/Validador_compraBoleto.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/library_js/renderizador.js"></script>

<script>
	document.addEventListener('DOMContentLoaded', function () {//DOMContentLoaded: evento que se produce al cargar la pagina
		const formulario = document.getElementById('id_fomr_compra_boleto');
        const select_rutas = document.getElementById("id_cod_ruta");
        


        //la lsita de rutas se recupera en forma de string
        const listaRutas_str = localStorage.getItem("Rutas_disponibles");
        const listaRutas = JSON.parse(listaRutas_str);
        
        
        function opciones_rutas(listaRutas){

            listaRutas.forEach(item => {
                //crea opcion
                let opcion = document.createElement("option");
                opcion.setAttribute("value", `${item.cod_ruta}`);
                opcion.textContent = `${item.cod_ruta}`;
                select_rutas.appendChild(opcion);
            });
        

        }

		opciones_rutas(listaRutas);
        renderizar_info_ruta_seleccionada (select_rutas.value, listaRutas)

        select_rutas.addEventListener("change", function (){
            renderizar_info_ruta_seleccionada (this.value, listaRutas)
        })

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

		


	});

</script>



<title>Compra de Boletos</title>
</head>
<body> 
	<header>
	<h1>Formulario para compra de Boleto</h1>
	</header>
    
    <div class= "contenedor_formulario">
        <form id="id_fomr_compra_boleto" class "formulario" method="post" action="<?= WEB_ROOT ?>CONTROLADOR/ProcesaCompra.php">
            <fieldset id="id_seccion_datos_viaje" class = "fieldset" name="datos viaje">
                <legend class = "legend" >Ingreso de datos del Viaje</legend>
                
                <span class="form_grupo">
                    <label class ="label" for ="id_cod_ruta">codigo de ruta</label>
                    <select class="select" id="id_cod_ruta" name="cod_ruta" size="1" required>
                    </select>
                    <span id="error_cod_ruta" class="error"></span>
                </span>

                <span class="form_grupo" id="id_contenedor_datos_ruta">
                
                </span>

                <span class="form_grupo">
                    <label class ="label" for ="id_fecha_seleccionada">fecha viaje</label>						
                    <input class="fecha" id ="id_fecha_seleccionada" type="date" name="fecha_viaje" min="2026-5-4" max="2026-12-31" required>
                    <span id="error_fecha_viaje" class="error"></span>
                </span>

            </fieldset>
            
            <fieldset id="id_seccion_acciones"class = "fieldset field_acciones" name="acciones_botones">
                <button id="id_siguiente" class="boton" type ="button" onclick = "validar_datos_viaje () && renderizar_seccion_mapas();">siguiente</button>
            </fieldset>
        </form>
    </div>
	<footer>
	<div id="descripcion_pagina">
		<p>autor: <span class="autor">Santiago Servin</span></p>
		<p>Final Libre 2026</p>		
	</div>
	</footer>
	
</body>

</html>