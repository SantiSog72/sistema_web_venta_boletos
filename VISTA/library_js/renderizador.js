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
            <td>${item.lugar_origen}</td>
            <td>${item.lugar_destino}</td>
            <td>${item.tarifa_normal}</td>
            <td>${item.hora_salida}</td>
            <td>
                <button class="boton" type="button" data-id="${item.cod_ruta}">comprar</button>
            </td>
        `;
        fila.innerHTML = fila_htmlRuta;
        tabla.appendChild(fila);
        
    });
    contenedor.appendChild(tabla);
}