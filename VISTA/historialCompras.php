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
                        <th>Precio Final</th>
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
        <button class="boton boton-outline" onclick="ir_paginaRutas()">Rutas</button>
        <button class="boton boton-danger" onclick="ir_comprar()">Comprar Boleto</button>
        <button class="boton boton-danger" onclick="ir_singOut()">Log out</button>
        </div>
    </div>
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