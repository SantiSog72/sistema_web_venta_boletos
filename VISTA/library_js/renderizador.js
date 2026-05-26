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




function renderizar_info_ruta_seleccionada(cod_ruta, listaRutas) {
    const ruta = listaRutas.find(r => r.cod_ruta === cod_ruta);
    if (!ruta) return;

    document.getElementById("id_ruta_origen").textContent   = ruta.lugar_origen;
    document.getElementById("id_ruta_destino").textContent  = ruta.lugar_destino;
    document.getElementById("id_ruta_hora").textContent     = ruta.hora_salida;
    document.getElementById("id_ruta_tarifa").textContent   = "$" + parseInt(ruta.tarifa_normal).toLocaleString("es-AR");
    document.getElementById("id_ruta_duracion").textContent = ruta.duracion + " hs";
}


function resetear_mapa (){

    const mapa_colectivo = document.getElementById("id_mapa_colectivo");

    // limpiar_contenedor("id_mapa_colectivo");
    html_mapa_colectivo = `
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
                        
    `;
    mapa_colectivo.innerHTML = html_mapa_colectivo;
}



function imprimir_boleto (json_datos_formulario, dni_usuario_str, nro_boleto_str){

    const nro_boleto = document.getElementById("id_print_nro_boleto");
    const pasajero = document.getElementById("id_print_pasajero");
    const dni_usuario = document.getElementById("id_print_dni");
    const origen = document.getElementById("id_print_origen");
    const destino = document.getElementById("id_print_destino");
    const fecha = document.getElementById("id_print_fecha");
    const hora = document.getElementById("id_print_hora");
    const asiento = document.getElementById("id_print_asiento");
    const tarifa = document.getElementById("id_print_tarifa");
    const precio = document.getElementById("id_print_precio");



    const es_usuario_frecuente = JSON.parse (localStorage.getItem("es_usuario_frecuente"));
    const precios = JSON.parse (localStorage.getItem("precios"));
    const rutas = JSON.parse (localStorage.getItem("Rutas_disponibles"));

    

    let ruta_seleccionada = rutas.find(elemento => {
        console.log (elemento.cod_ruta);
        console.log (json_datos_formulario.cod_ruta);
        return (elemento.cod_ruta === json_datos_formulario.cod_ruta);
    });


    let precio_final = ""
    switch (json_datos_formulario.tipo_pago) {
        case "efectivo":
            precio_final = precios.precio_final_efectivo;
            break;

        default:
            precio_final = precios.precio_final_puntos;
            break;
    }

    pasajero.textContent = `DNI: ${json_datos_formulario.dni}, Nombre y Apellido: ${json_datos_formulario.nombre} ${json_datos_formulario.apellido}`;
    // dni_usuario.textContent = dni_usuario_str;
    // nro_boleto.textContent = nro_boleto_str;
    origen.textContent = `${ruta_seleccionada.lugar_origen}`;
    destino.textContent = `${ruta_seleccionada.lugar_destino}`;
    hora.textContent = `${ruta_seleccionada.hora_salida}`;
    fecha.textContent = `${json_datos_formulario.fecha_viaje}`;
    asiento.textContent = `${json_datos_formulario.nro_asiento}`;
    tarifa.textContent = `${precios.tipoTarifa}`;
    precio.textContent = `${precio_final} (${json_datos_formulario.tipo_pago})`;

    window.print();

}
