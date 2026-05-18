function renderizarTablaRutaJSON(lista_rutas) {

    const contenedor = document.getElementById("id_contenedor_rutas");
    limpiar_contenedor('id_contenedor_rutas');

    if (lista_rutas.length === 0) {
        agregar_elemento_final("<p>No se encontraron resultados.</p>", 'id_contenedor_rutas');
        return;
    }

    let tabla = document.createElement("table");
    // tabla.setAttribute("id", "id_tabla_rutas");

    const html_encabezado = `
        <tr>
            <th>Codigo de Ruta</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Tarifa Normal</th>
            <th>Hora Salida Diaria</th>
        </tr>
    `;

    tabla.innerHTML = html_encabezado;
    

    //array de objetos JSON
    lista_rutas.forEach(item => {
        let fila = document.createElement("tr");
        let fila_htmlRuta = `
            <td>${item.cod_ruta}</td>
            <td>${item.lugar_origen}</td>
            <td>${item.lugar_destino}</td>
            <td>${item.tarifa_normal}</td>
            <td>${item.hora_salida}</td>
        `;
        fila.innerHTML = fila_htmlRuta;
        tabla.appendChild(fila);
        
    });
    contenedor.appendChild(tabla);
}

function renderizar_info_ruta_seleccionada (cod_ruta_seleccionado, listaRutas){
    const contenedor_datos_ruta = document.getElementById("id_contenedor_datos_ruta");
    
    limpiar_contenedor ("id_contenedor_datos_ruta");
    let ruta_elegida = listaRutas.find(element => element.cod_ruta == cod_ruta_seleccionado);

    let html_info_ruta =`
    <strong>Ruta Seleccionada</strong>
    <p>origen: ${ruta_elegida.lugar_origen}</p>
    <p>destino:${ruta_elegida.lugar_destino}</p>
    <p>tarifa normal:${ruta_elegida.tarifa_normal}</p>
    <p>hora salida:${ruta_elegida.hora_salida}</p>
    `;

    contenedor_datos_ruta.innerHTML = html_info_ruta;
}

// function renderizar_seccion_mapas(lista_asientos_ocupados){
//     limpiar_contenedor("id_fomr_compra_boleto", "id_seccion_asiento_tarifa");

//     const boton_siguiente = document.getElementById("id_siguiente_mapa_colectivo");
//     boton_siguiente.setAttribute("onclick", "validar_seleccion_asiento() && renderizar_entrada_pasajero();");
//     if (validar_seleccion_asiento()){
//         boton_siguiente.setAttribute("id", "id_siguiente_datos_pasajero");
//     }


//     // let boton_siguiente = document.getElementById("id_siguiente_mapa_colectivo");
//     // if (validar_seleccion_asiento()){
//     //     boton_siguiente.setAttribute("id", "id_siguiente_datos_pasajero");
//     //     boton_siguiente.setAttribute("onclick", "validar_seleccion_asiento() && renderizar_entrada_pasajero();;");
//     // }
//     // boton_siguiente = document.getElementById("id_siguiente_datos_pasajero");

    
//     // const boton_siguiente = document.getElementById("id_siguiente_datos_pasajero");
//     // boton_siguiente.setAttribute("onclick", "validar_seleccion_asiento() && renderizar_entrada_pasajero();");

//     let html_seccion_mapa_asientos = `
//     <fieldset id="id_seccion_asiento_tarifa" class="fieldset">
//         <legend class = "legend" >Seleccione el Asiento/Tarifa</legend>
//         <input id="id_nro_asiento" type="hidden" name="nro_asiento" value="">
//         <div id="id_mapa_colectivo">
//             <div id="id_contenedor_asientos_planta_baja">
                
//                 <div class="tarjeta ES">ES</div>
//                 <div class="tarjeta ES">ES</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta vacio"></div>

//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta vacio"></div>

//                 <div class="tarjeta TV">TV</div>
//                 <div class="tarjeta WC">WC</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta PU">PU</div>

//                 <div class="tarjeta tarifa_ejecutiva asiento">49</div>
//                 <div class="tarjeta tarifa_ejecutiva asiento">50</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta tarifa_ejecutiva asiento">51</div>

//                 <div class="tarjeta tarifa_ejecutiva asiento">52</div>
//                 <div class="tarjeta tarifa_ejecutiva asiento">53</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta tarifa_ejecutiva asiento">54</div>

//                 <div class="tarjeta tarifa_ejecutiva asiento">55</div>
//                 <div class="tarjeta tarifa_ejecutiva asiento">56</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta tarifa_ejecutiva asiento">57</div>

//                 <div class="tarjeta tarifa_ejecutiva asiento">58</div>
//                 <div class="tarjeta tarifa_ejecutiva asiento">59</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta tarifa_ejecutiva asiento">60</div>

//             </div>

//             <div id="id_contenedor_asientos_planta_alta">

//                 <!-- FILA 1 — normal -->
//                 <div class="tarjeta tarifa_normal asiento">1</div>
//                 <div class="tarjeta tarifa_normal asiento">2</div>
//                 <div class="tarjeta TV">TV</div>
//                 <div class="tarjeta tarifa_normal asiento">3</div>
//                 <div class="tarjeta tarifa_normal asiento">4</div>

//                 <!-- FILA 2 — normal -->
//                 <div class="tarjeta tarifa_normal asiento">5</div>
//                 <div class="tarjeta tarifa_normal asiento">6</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta ES">ES</div>

//                 <!-- FILA 3 — normal -->
//                 <div class="tarjeta tarifa_normal asiento">7</div>
//                 <div class="tarjeta tarifa_normal asiento">8</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta ES">ES</div>

//                 <!-- FILA 4 — normal -->
//                 <div class="tarjeta tarifa_normal asiento">9</div>
//                 <div class="tarjeta tarifa_normal asiento">10</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta tarifa_normal asiento">11</div>
//                 <div class="tarjeta tarifa_normal asiento">12</div>

//                 <!-- FILA 5 — normal -->
//                 <div class="tarjeta tarifa_normal asiento">13</div>
//                 <div class="tarjeta tarifa_normal asiento">14</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta tarifa_normal asiento">15</div>
//                 <div class="tarjeta tarifa_normal asiento">16</div>

//                 <!-- FILA 6 — normal -->
//                 <div class="tarjeta tarifa_normal asiento">17</div>
//                 <div class="tarjeta tarifa_normal asiento">18</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta tarifa_normal asiento">19</div>
//                 <div class="tarjeta tarifa_normal asiento">20</div>

//                 <!-- FILA 7 — promocional -->
//                 <div class="tarjeta tarifa_promocional asiento">21</div>
//                 <div class="tarjeta tarifa_promocional asiento">22</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta tarifa_promocional asiento">23</div>
//                 <div class="tarjeta tarifa_promocional asiento">24</div>

//                 <!-- FILA 8 — promocional -->
//                 <div class="tarjeta tarifa_promocional asiento">25</div>
//                 <div class="tarjeta tarifa_promocional asiento">26</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta tarifa_promocional asiento">27</div>
//                 <div class="tarjeta tarifa_promocional asiento">28</div>

//                 <!-- FILA 9 — promocional -->
//                 <div class="tarjeta tarifa_promocional asiento">29</div>
//                 <div class="tarjeta tarifa_promocional asiento">30</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta tarifa_promocional asiento">31</div>
//                 <div class="tarjeta tarifa_promocional asiento">32</div>

//                 <!-- FILA 10 — promocional -->
//                 <div class="tarjeta tarifa_promocional asiento">33</div>
//                 <div class="tarjeta tarifa_promocional asiento">34</div>
//                 <div class="tarjeta TV">TV</div>
//                 <div class="tarjeta tarifa_promocional asiento">35</div>
//                 <div class="tarjeta tarifa_promocional asiento">36</div>

//                 <!-- FILA 11 — promocional -->
//                 <div class="tarjeta tarifa_promocional asiento">37</div>
//                 <div class="tarjeta tarifa_promocional asiento">38</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta tarifa_promocional asiento">39</div>
//                 <div class="tarjeta tarifa_promocional asiento">40</div>

//                 <!-- FILA 12 — promocional -->
//                 <div class="tarjeta tarifa_promocional asiento">41</div>
//                 <div class="tarjeta tarifa_promocional asiento">42</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta tarifa_promocional asiento">43</div>
//                 <div class="tarjeta tarifa_promocional asiento">44</div>

//                 <!-- FILA 13 — promocional -->
//                 <div class="tarjeta tarifa_promocional asiento">45</div>
//                 <div class="tarjeta tarifa_promocional asiento">46</div>
//                 <div class="tarjeta vacio"></div>
//                 <div class="tarjeta tarifa_promocional asiento">47</div>
//                 <div class="tarjeta tarifa_promocional asiento">48</div>

//             </div>

//         </div>

//         <span class="form_grupo" id="id_contenedor_datos_asiento_seleccionado">
//             <span id="error_seleccion_asiento" class="error"></span>
        
//         </span>
//     </fieldset>
//     `;

//     agregar_elemento_despues_de(html_seccion_mapa_asientos, "id_seccion_datos_viaje") ;

//     let lista_asientos = Array.from(document.getElementsByClassName("asiento"));

//     lista_asientos.forEach(asiento_viaje => {
//         lista_asientos_ocupados.forEach(asiento_ocupado => {
//             if (parseInt (asiento_viaje.textContent) == asiento_ocupado){
//                 asiento_viaje.setAttribute("class", "tarjeta ocupado");
//             }
//         });    
//     });

    
// }

// function renderizar_entrada_pasajero(){
//     const boton_siguiente = document.getElementById("id_siguiente_datos_pasajero");
//     boton_siguiente.setAttribute("onclick", "validar_datos_pasajero() && renderizar_botones_formulario();");

//     limpiar_contenedor("id_fomr_compra_boleto", "id_seccion_entrada_pasajero");

//     let html_entrada_pasajero = `
//     <fieldset id="id_seccion_entrada_pasajero" class = "fieldset" name="datos pasajero">
//         <legend class = "legend" >Ingreso Datos del Pasajero</legend>

//         <span class="form_grupo">
//             <label class ="label" for ="id_dni">DNI: </label>						
//             <input id ="id_dni" type="text" name="dni" placeholder="dni pasajero" value="">
//             <span id="error_dni" class="error"></span>
//         </span>

//         <span class="form_grupo">
//             <label class ="label" for ="id_nombre">nombre:</label>						
//             <input  onblur="" id ="id_nombre" type="text" name="nombre" maxlength="20" placeholder="nombre pasajero" value ="">
//             <span id="error_nombre" class="error"></span>
//         </span>
//         <span class="form_grupo">
//             <label class ="label" for ="id_apellido">apellido:</label>						
//             <input onblur="" id ="id_apellido" type="text" name="apellido" maxlength="20" placeholder="apellido pasajero" value="">
//             <span id="error_apellido" class="error"></span>
//         </span>
//     </fieldset>
//     `;

//     agregar_elemento_despues_de(html_entrada_pasajero, "id_seccion_asiento_tarifa");

// }

// function renderizar_botones_formulario () {

//     let contenedor = document.getElementById("id_seccion_acciones");
//     limpiar_contenedor("id_seccion_acciones");
//     let html_botones = `
//         <legend class = "legend" >acciones</legend>
//         <button id="id_envio" class="boton" type ="button" onclick = "enviar_formulario();">Registrase</button>
//         <button id="id_borrar" class="boton" type ="button" onclick = "ir_comprar();">borrar</button>
//         <button id="id_cancelar" class="boton" type ="button" onclick = "ir_paginaRutas();">cancelar</button>
//     `;

//     contenedor.innerHTML = html_botones;
// }
