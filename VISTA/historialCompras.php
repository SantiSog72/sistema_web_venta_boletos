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
<meta name="description" content="Pagina historial compras">
<script>
    window.BASE_URL = "<?= WEB_ROOT ?>";
</script>

<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/library_js/botones_hipervinculo.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/library_js/ubicador_elementos.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/library_js/renderizador.js"></script>


<script>
	document.addEventListener('DOMContentLoaded', function () {//DOMContentLoaded: evento que se produce al cargar la pagina
	contenedor = document.getElementById("id_contenedor_historial");

	async function cargarHistorial() {
		try {
			const respuesta = await fetch('<?= WEB_ROOT ?>CONTROLADOR/ProcesaCargarHistorial.php');
			const lista_viajes = await respuesta.json();

            if (lista_viajes.length > 0){
                let tabla = document.createElement("table");
            
                const html_encabezado = `
                    <tr>
                        <th>Fecha Viaje</th>
                        <th>Fecha Compra</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Horario Salida</th>
                        <th>tipo tarifa</th>
                        <th>Numero Asiento</th>
                        <th>Tipo Moneda</th>
                        <th>Precio Total</th>
                        <th>DNI Pasajero</th>
                    </tr>
                `;
            
                tabla.innerHTML = html_encabezado;
                
            
                //array de objetos JSON
                lista_viajes.forEach(item => {
                    let fila = document.createElement("tr");
                    let fila_htmlRuta = `
                        <td>${item.fecha_viaje}</td>
                        <td>${item.fecha_emision}</td>
                        <td>${item.lugar_origen}</td>
                        <td>${item.lugar_destino}</td>
                        <td>${item.hora_salida}</td>
                        <td>${item.tipo_tarifa}</td>
                        <td>${item.nro_asiento}</td>
                        <td>${item.pago_efectivo ? "Efectivo":"Puntos"}</td>
                        <td>${item.precio_final}</td>
                        <td>${item.dni}</td>
                    `;
                    fila.innerHTML = fila_htmlRuta;
                    tabla.appendChild(fila);
                    
                });
                contenedor.appendChild(tabla);
            }else{
                contenedor.innerHTML = "<p>¡Aún no compro ningun pasaje!</p>";
            }


			} catch (error) {
				console.error("Error al cargar el historial de viaje:", error);
				contenedor.innerHTML = "<p>Error al cargar los datos.</p>";
			}
		}
	cargarHistorial(); 

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
        <h1>Historial de Compras</h1>
        <?php
            print ("<p>dni usuario: ".$usuario["dni"]."</p>");
            print ("<p>nombre: ".$usuario["primer_nombre"]."</p>");
            print ("<p>apellido: ".$usuario["apellido"]."</p>");
            if ($usuario["es_usuario_frecuente"]){
                print ("<p>puntos acumulados: ".$usuario["puntos"]."</p>");
            }
        ?>
        <nav class="contenedor_mapa">
            <button id="id_boton_sing_out" class= "boton">Log out</button>
            <button class= "boton" onclick="ir_comprar()">Comprar Boleto</button>
            <button class= "boton" onclick="ir_paginaRutas()">ver Rutas disponibles</button>
        </nav>

	</header>

	<div id="id_contenedor_historial">

	</div>

	<footer>
	<div id="descripcion_pagina">
		<p>autor: <span class="autor">Santiago Servin</span></p>
		<p>Final Libre 2026</p>		
	</div>
	</footer>
	
</body>

</html>