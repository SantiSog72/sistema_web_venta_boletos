<?php
session_start();
// Esto busca el archivo desde la raíz de tu htdocs/www
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_venta_boletos/config.php';

$usuario = $_SESSION["usuario"];
// print_r($usuario);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="autor" content="Santiago Servin">
<meta name="description" content="Pagina compra pasaje">

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
        const fecha_seleccionada = document.getElementById("id_fecha_seleccionada");
        const mapa_colectivo = document.getElementById("id_mapa_colectivo");
        const precio_normal_selec = document.getElementById("id_precio_normal_asiento_seleccionado");
        const precio_final_efectivo_selec = document.getElementById("id_precio_final_efectivo_asiento_seleccionado");
        const tipo_tarifa_selec = document.getElementById("id_tipo_tarifa_asiento_seleccionado");
        // recuperar si es usuario frecuente como booleano
        const es_usuario_frecuente = JSON.parse (localStorage.getItem("es_usuario_frecuente"));


        //la lsita de rutas se recupera en forma de string
        const listaRutas_str = localStorage.getItem("Rutas_disponibles");
        const listaRutas = JSON.parse(listaRutas_str);
        
        function vista_asientos_ocupados(lista_asientos_ocupados){
            // resetear_mapa();
            let lista_asientos = Array.from(document.getElementsByClassName("asiento"));

            lista_asientos.forEach(asiento_viaje => {
                lista_asientos_ocupados.forEach(asiento_ocupado => {
                    if (parseInt (asiento_viaje.textContent) == asiento_ocupado){
                        asiento_viaje.setAttribute("class", "tarjeta ocupado");
                    }
                });    
            });
        }

        function opciones_rutas(listaRutas){

            listaRutas.forEach(item => {
                //crea opcion
                let opcion = document.createElement("option");
                opcion.setAttribute("value", `${item.cod_ruta}`);
                opcion.textContent = `${item.cod_ruta}`;
                select_rutas.appendChild(opcion);
            });
        

        }

        

        async function actualizar_viaje(){
            if (validar_datos_viaje ()){
                //en este caso no hay un envio de formulario pero aun asi necesita los
                //datos del formulario
                let fecha_viaje = document.getElementById("id_fecha_seleccionada").value;
                let cod_ruta = document.getElementById("id_cod_ruta").value;

                let datos = new FormData();
                datos.append("fecha_viaje", fecha_viaje);
                datos.append("cod_ruta", cod_ruta);
                

                const respuesta = await fetch(
                    '<?= WEB_ROOT ?>CONTROLADOR/ProcesaTraerViaje.php',{
                        method:'POST',
                        body: datos
                });
                let lista_asientos_ocupados = await respuesta.json();
                console.log (lista_asientos_ocupados);

                resetear_mapa();

                vista_asientos_ocupados(lista_asientos_ocupados);
            }
        }

		opciones_rutas(listaRutas);
        renderizar_info_ruta_seleccionada (select_rutas.value, listaRutas);
        actualizar_viaje();

        let div_anterior = "";
        let str_clases = "";
        mapa_colectivo.addEventListener("click", async function(evento){
            // si se clickea a un elemento que contiene en su lista de clases al aasiento
            if (evento.target.classList.contains("asiento")){
                const hidden_nro_asiento = document.getElementById("id_nro_asiento");
                const hidden_precio_final_efectivo = document.getElementById("id_precio_final_efectivo");
                const hidden_tipo_tarifa = document.getElementById("id_tipo_tarifa");
                const asiento_seleccionado =  parseInt(evento.target.textContent);
                hidden_nro_asiento.value = asiento_seleccionado;
                
                let lista_asientos = Array.from(document.getElementsByClassName("asiento"));
                
                let div_asiento_seleccionado = lista_asientos.find(asiento_viaje =>parseInt (asiento_viaje.textContent)=== asiento_seleccionado);
                
                // la primera vez no se devuelve a las clases anteriores porque no hay anterior
                if (div_anterior!=""){
                    // añadir clases guardadas al elemnto anterior
                    div_anterior.setAttribute("class", str_clases);
                }
                // guardar div anteior
                div_anterior = div_asiento_seleccionado;

                // guardar clases actuales
                str_clases = Array.from(div_asiento_seleccionado.classList).join(" ");
                // añadir clase seleccion
                div_asiento_seleccionado.setAttribute("class", "tarjeta asiento seleccionado");
                // console.log (str_clases_elemento_seleccionado);

                
                // obtener tarifa y asiento
                let datos = new FormData();
                datos.append("nro_asiento", hidden_nro_asiento.value);
                datos.append("cod_ruta", select_rutas.value);
                

                const respuesta = await fetch(
                    '<?= WEB_ROOT ?>CONTROLADOR/Procesa_Tarifa_precioNormal.php',{
                        method:'POST',
                        body: datos
                    });
                let resultado = await respuesta.json();

                // convierte en sqring para guardarlo en el local storage
                localStorage.setItem("precios", JSON.stringify(resultado));


                // muestra los precios
                tipo_tarifa_selec.textContent = resultado.tipoTarifa;
                precio_normal_selec.textContent = resultado.precioNormal;
                precio_final_efectivo_selec.textContent = resultado.precio_final_efectivo;

                if (es_usuario_frecuente){
                    const precio_final_puntos_selec = document.getElementById("id_precio_final_puntos_asiento_seleccionado");
                    const hidden_precio_final_puntos = document.getElementById("id_precio_final_puntos");
                    const hidden_suma_puntos = document.getElementById("id_suma_puntos");

                    precio_final_puntos_selec.textContent = resultado.precio_final_puntos;
                    hidden_precio_final_puntos.value = resultado.precio_final_puntos;
                    hidden_suma_puntos.value = resultado.suma_puntos;
                }

                

                // envia los precios en un input hide
                hidden_tipo_tarifa.value = resultado.tipoTarifa;
                hidden_precio_final_efectivo.value = resultado.precio_final_efectivo;

            }

        });


        formulario.addEventListener('submit', async function(evento) {
			evento.preventDefault(); 
            if (validar_datos()){
                const datos = new FormData(formulario);

                const datosFormateados = Object.fromEntries(datos.entries());
                console.log("Datos del formulario:", datosFormateados);


                try {
                    // El "await" espera la respuesta del servidor (es lo que permie el asincronico)
                    const respuesta = await fetch('<?= WEB_ROOT ?>CONTROLADOR/ProcesaCompraBoleto.php', {
                        method: 'POST',
                        body: datos
                    });
    
                    const resultado = await respuesta.json();
                    console.log(resultado);
    
                    if (resultado.exito) {
                        alert(resultado.mensaje);

                        // imprimir pasaje
                        imprimir_boleto(datosFormateados, resultado.dni_usuario, resultado.id_boleto);
                        // ir_paginaRutas();
                    } else {
                        alert("Error: " + resultado.mensaje);
                    }
                } catch (error) {
                    // atrapar los errores duplocados
                    console.error("Error en la conexión:", error);
                }
            }

		});





        // para que se actualice el viaje al cambiar la ruta o la fecha
        fecha_seleccionada.addEventListener("change", async function(){
            actualizar_viaje();
            // div_anterior = "";
            // str_clases = "";
        });

        // la info de la ruta solo cambia al cambiar la ruta (no la fecha)
        select_rutas.addEventListener("change", async function(){
            renderizar_info_ruta_seleccionada (this.value, listaRutas);
            actualizar_viaje();
            // div_anterior = "";
            // str_clases = "";
        });
	});

</script>



<title>Compra de Boletos</title>
</head>
<body> 
	<!-- <header>
        <h1>Formulario para compra de Boleto</h1>
        <?php
            // print ("<p>dni usuario: ".$usuario["dni"]."</p>");
            // print ("<p>nombre: ".$usuario["primer_nombre"]."</p>");
            // print ("<p>apellido: ".$usuario["apellido"]."</p>");
            // if ($usuario["es_usuario_frecuente"]){
            //     print ("<p>puntos acumulados: ".$usuario["puntos"]."</p>");
            // }
        ?>

        <nav class="contenedor_mapa">
            <button id="id_boton_sing_out" class= "boton" onclick="ir_singOut();">Log out</button>
            <button class= "boton" onclick="ir_historial_compras()">Ver historial de compras</button>
            <button class= "boton" onclick="ir_paginaRutas()">ver Rutas disponibles</button>
        </nav>
	</header> -->

    <header>
    <h1>Formulario para compra de Boleto</h1>
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
        <button class="boton boton-outline" onclick="ir_paginaRutas()">Rutas</button>
        <button class="boton boton-danger" onclick="ir_singOut()">Log out</button>
        </div>
    </div>
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

                <span class="form_grupo">
                    <label class ="label" for ="id_fecha_seleccionada">fecha viaje</label>						
                    <input class="fecha" id ="id_fecha_seleccionada" type="date" name="fecha_viaje" min="2026-5-4" max="2026-12-31" required value="2026-06-30">
                    <span id="error_fecha_viaje" class="error"></span>
                </span>

                <span class="form_grupo" id="id_contenedor_datos_ruta">
                    <div class="info-ruta">
                        <div class="info-ruta-item">
                            <p class="info-ruta-label">Origen</p>
                            <p class="info-ruta-valor" id="id_ruta_origen"></p>
                        </div>
                        <div class="info-ruta-flecha">→</div>
                        <div class="info-ruta-item">
                            <p class="info-ruta-label">Destino</p>
                            <p class="info-ruta-valor" id="id_ruta_destino"></p>
                        </div>
                        <div class="info-ruta-separador"></div>
                        <div class="info-ruta-item">
                            <p class="info-ruta-label">Hora salida</p>
                            <p class="info-ruta-valor" id="id_ruta_hora"></p>
                        </div>
                        <div class="info-ruta-separador"></div>
                        <div class="info-ruta-item">
                            <p class="info-ruta-label">Tarifa normal</p>
                            <p class="info-ruta-valor verde" id="id_ruta_tarifa"></p>
                        </div>
                        <div class="info-ruta-separador"></div>
                        <div class="info-ruta-item">
                            <p class="info-ruta-label">Duración</p>
                            <p class="info-ruta-valor" id="id_ruta_duracion"></p>
                        </div>
                    </div>
                </span>

                

            </fieldset>

            <fieldset id="id_seccion_asiento_tarifa" class="fieldset">
                <legend class = "legend" >Seleccione el Asiento/Tarifa</legend>
                <input id="id_nro_asiento" type="hidden" name="nro_asiento" value="">
                <div id="id_mapa_colectivo">
                    <div id="id_contenedor_asientos_planta_baja">
                        
                        <div class="tarjeta ES">ES</div>
                        <div class="tarjeta ES">ES</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta vacio"></div>

                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta vacio"></div>

                        <div class="tarjeta TV">TV</div>
                        <div class="tarjeta WC">WC</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta PU">PU</div>

                        <div class="tarjeta tarifa_ejecutiva asiento">49</div>
                        <div class="tarjeta tarifa_ejecutiva asiento">50</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta tarifa_ejecutiva asiento">51</div>

                        <div class="tarjeta tarifa_ejecutiva asiento">52</div>
                        <div class="tarjeta tarifa_ejecutiva asiento">53</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta tarifa_ejecutiva asiento">54</div>

                        <div class="tarjeta tarifa_ejecutiva asiento">55</div>
                        <div class="tarjeta tarifa_ejecutiva asiento">56</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta tarifa_ejecutiva asiento">57</div>

                        <div class="tarjeta tarifa_ejecutiva asiento">58</div>
                        <div class="tarjeta tarifa_ejecutiva asiento">59</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta tarifa_ejecutiva asiento">60</div>

                    </div>

                    <div id="id_contenedor_asientos_planta_alta">

                        <!-- FILA 1 — normal -->
                        <div class="tarjeta tarifa_normal asiento">1</div>
                        <div class="tarjeta tarifa_normal asiento">2</div>
                        <div class="tarjeta TV">TV</div>
                        <div class="tarjeta tarifa_normal asiento">3</div>
                        <div class="tarjeta tarifa_normal asiento">4</div>

                        <!-- FILA 2 — normal -->
                        <div class="tarjeta tarifa_normal asiento">5</div>
                        <div class="tarjeta tarifa_normal asiento">6</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta ES">ES</div>

                        <!-- FILA 3 — normal -->
                        <div class="tarjeta tarifa_normal asiento">7</div>
                        <div class="tarjeta tarifa_normal asiento">8</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta ES">ES</div>

                        <!-- FILA 4 — normal -->
                        <div class="tarjeta tarifa_normal asiento">9</div>
                        <div class="tarjeta tarifa_normal asiento">10</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta tarifa_normal asiento">11</div>
                        <div class="tarjeta tarifa_normal asiento">12</div>

                        <!-- FILA 5 — normal -->
                        <div class="tarjeta tarifa_normal asiento">13</div>
                        <div class="tarjeta tarifa_normal asiento">14</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta tarifa_normal asiento">15</div>
                        <div class="tarjeta tarifa_normal asiento">16</div>

                        <!-- FILA 6 — normal -->
                        <div class="tarjeta tarifa_normal asiento">17</div>
                        <div class="tarjeta tarifa_normal asiento">18</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta tarifa_normal asiento">19</div>
                        <div class="tarjeta tarifa_normal asiento">20</div>

                        <!-- FILA 7 — promocional -->
                        <div class="tarjeta tarifa_promocional asiento">21</div>
                        <div class="tarjeta tarifa_promocional asiento">22</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta tarifa_promocional asiento">23</div>
                        <div class="tarjeta tarifa_promocional asiento">24</div>

                        <!-- FILA 8 — promocional -->
                        <div class="tarjeta tarifa_promocional asiento">25</div>
                        <div class="tarjeta tarifa_promocional asiento">26</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta tarifa_promocional asiento">27</div>
                        <div class="tarjeta tarifa_promocional asiento">28</div>

                        <!-- FILA 9 — promocional -->
                        <div class="tarjeta tarifa_promocional asiento">29</div>
                        <div class="tarjeta tarifa_promocional asiento">30</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta tarifa_promocional asiento">31</div>
                        <div class="tarjeta tarifa_promocional asiento">32</div>

                        <!-- FILA 10 — promocional -->
                        <div class="tarjeta tarifa_promocional asiento">33</div>
                        <div class="tarjeta tarifa_promocional asiento">34</div>
                        <div class="tarjeta TV">TV</div>
                        <div class="tarjeta tarifa_promocional asiento">35</div>
                        <div class="tarjeta tarifa_promocional asiento">36</div>

                        <!-- FILA 11 — promocional -->
                        <div class="tarjeta tarifa_promocional asiento">37</div>
                        <div class="tarjeta tarifa_promocional asiento">38</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta tarifa_promocional asiento">39</div>
                        <div class="tarjeta tarifa_promocional asiento">40</div>

                        <!-- FILA 12 — promocional -->
                        <div class="tarjeta tarifa_promocional asiento">41</div>
                        <div class="tarjeta tarifa_promocional asiento">42</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta tarifa_promocional asiento">43</div>
                        <div class="tarjeta tarifa_promocional asiento">44</div>

                        <!-- FILA 13 — promocional -->
                        <div class="tarjeta tarifa_promocional asiento">45</div>
                        <div class="tarjeta tarifa_promocional asiento">46</div>
                        <div class="tarjeta vacio"></div>
                        <div class="tarjeta tarifa_promocional asiento">47</div>
                        <div class="tarjeta tarifa_promocional asiento">48</div>

                    </div>

                </div>

                <span class="form_grupo" id="id_contenedor_datos_asiento_seleccionado">
                    <input id="id_tipo_tarifa" type="hidden" name="tipo_tarifa" value="">
                    <input id="id_precio_final_efectivo" type="hidden" name="precio_final_efectivo" value="">
                    <span id="error_seleccion_asiento" class="error"></span>
                    <p>Tipo Tarifa:<span id="id_tipo_tarifa_asiento_seleccionado"></span></p>
                    <p>Precio Normal:<span id="id_precio_normal_asiento_seleccionado"></span></p>
                    <p>Precio Final Efectivo:<span id="id_precio_final_efectivo_asiento_seleccionado"></span></p>
                    
                    <?php
                        if ($usuario["es_usuario_frecuente"]){
                    ?>
                    <p>Precio Final Puntos:<span id="id_precio_final_puntos_asiento_seleccionado"></span></p>
                    <input id="id_precio_final_puntos" type="hidden" name="precio_final_puntos" value="">
                    <input id="id_suma_puntos" type="hidden" name="suma_puntos" value="0">
                    <?php
                        }
                    ?>
                </span>
            </fieldset>

            <fieldset id="id_seccion_entrada_pasajero" class = "fieldset" name="datos pasajero">
                <legend class = "legend" >Ingreso Datos del Pasajero</legend>

                <span class="form_grupo">
                    <label class ="label" for ="id_dni">DNI: </label>						
                    <input id ="id_dni" type="text" name="dni" placeholder="dni pasajero" value="">
                    <span id="error_dni" class="error"></span>
                </span>

                <span class="form_grupo">
                    <label class ="label" for ="id_nombre">nombre:</label>						
                    <input  onblur="" id ="id_nombre" type="text" name="nombre" maxlength="20" placeholder="nombre pasajero" value ="">
                    <span id="error_nombre" class="error"></span>
                </span>
                <span class="form_grupo">
                    <label class ="label" for ="id_apellido">apellido:</label>						
                    <input onblur="" id ="id_apellido" type="text" name="apellido" maxlength="20" placeholder="apellido pasajero" value="">
                    <span id="error_apellido" class="error"></span>
                </span>
            </fieldset>
            <?php
            
            if ($usuario["es_usuario_frecuente"]){
            ?>
            <fieldset id="id_seccion_forma_pago" class = "fieldset">
                <legend class = "legend" >seleccione la forma de pago</legend>
                
                <span class="form_grupo">
                    <input type="radio" name="tipo_pago" value="efectivo" checked>
                    <label class="label">efectivo</label><br>
                </span>
                <span class="form_grupo">
                    <input type="radio" name="tipo_pago" value="puntos">
                    <label class="label">puntos</label><br>
                </span>

            </fieldset>
            <?php
            }else{
            ?>
            <input type= "hidden" name="tipo_pago" value="efectivo">
            <?php
            }
            ?>
            <fieldset id="id_seccion_acciones"class = "fieldset field_acciones" name="acciones_botones">
                <legend class = "legend" >acciones</legend>
                <button id="id_envio" class="boton" type ="submit">Comparar</button>
                <button id="id_borrar" class="boton" type ="button" onclick = "ir_comprar();">borrar</button>
            </fieldset>
        </form>
    </div>
	<footer>
	<div id="descripcion_pagina">
		<p>autor: <span class="autor">Santiago Servin</span></p>
		<p>Final Libre 2026</p>		
	</div>
	</footer>

    <div id="id_boleto_imprimible">
        <h2>Boleto de Viaje</h2>
        <p><strong>Nro boleto:</strong> <span id="id_print_nro_boleto"></span></p>
        <p><strong>Pasajero:</strong> <span id="id_print_pasajero"></span></p>
        <p><strong>DNI:</strong> <span id="id_print_dni"></span></p>
        <p><strong>Origen:</strong> <span id="id_print_origen"></span></p>
        <p><strong>Destino:</strong> <span id="id_print_destino"></span></p>
        <p><strong>Fecha:</strong> <span id="id_print_fecha"></span></p>
        <p><strong>Hora:</strong> <span id="id_print_hora"></span></p>
        <p><strong>Asiento:</strong> <span id="id_print_asiento"></span></p>
        <p><strong>Tarifa:</strong> <span id="id_print_tarifa"></span></p>
        <p><strong>Precio:</strong> <span id="id_print_precio"></span></p>
    </div>
	
</body>

</html>
