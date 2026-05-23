if (typeof raiz === 'undefined') {
    window.raiz = (window.BASE_URL || "/sistema_web_venta_boletos/").replace(/\/$/, "") + "/";
}
class Ventana_emergente{
	
	
    constructor(nombre_ventana, ancho, alto) {
        this.new_window = window.open("", nombre_ventana, `width=${ancho},height=${alto},resizable=yes`);
        
        const doc = this.new_window.document;

        this.titulo_cabecera = doc.createElement("h1");
        this.cabecera = doc.createElement("header");
        this.seccion = doc.createElement("section");
        this.articulo = doc.createElement("article");

        this.cabecera.appendChild(this.titulo_cabecera);
        this.seccion.appendChild(this.articulo);

        doc.body.appendChild(this.cabecera);
        doc.body.appendChild(this.seccion);
    }
    

	
	get_titulo_cabecera (){
		return this.titulo_cabecera;
	}
	
	get_body (){
		return this.cuerpo_ventana;
	}
	
	get_head (){
		return this.cabeza_ventana;
	}

    get_header (){
		return this.cabecera;
	}
	
	get_section(){
		return this.seccion;
	}
	
	get_article(){
		return this.articulo;
	}
	
}

function ventana_bienvenida_viajes (json_datos){
    const ventana = new Ventana_emergente("ventana_bienvenida", 800, 600);
    const nuevaVentana = ventana.new_window;
    const doc = nuevaVentana.document;

    const usuario = json_datos.usuario;
    const viajes_pendientes = json_datos.viajes_pendientes;

    let contenedor_info_viajes = document.createElement("div");
    contenedor_info_viajes.setAttribute("id", "id_contenedor_info_viajes");

    const html_head = `
        <meta charset="UTF-8">
        <title>Viajes pendientes</title>
        <link rel="stylesheet" href="${raiz}VISTA/css/index.css">
        <link rel="stylesheet" href="${raiz}VISTA/css/formulario_estilos.css">
        <link rel="stylesheet" href="${raiz}VISTA/css/tabla.css">
    `;

    let mensaje_bienvenida= document.createElement("p");
    mensaje_bienvenida.innerHTML = `Bienvenido:${usuario.primer_nombre} ${usuario.apellido}`;

    

    doc.head.innerHTML = html_head;

    ventana.get_titulo_cabecera().textContent = "Viajes pendientes";
    ventana.get_header().appendChild(mensaje_bienvenida);
    ventana.get_article().appendChild(contenedor_info_viajes);


    if (viajes_pendientes.length > 0){
        let tabla = document.createElement("table");
    
        const html_encabezado = `
            <tr>
                <th>Fecha Salida</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Horario Salida</th>
                <th>DNI Pasajero</th>
                <th>Numero Asiento</th>
            </tr>
        `;
    
        tabla.innerHTML = html_encabezado;
        
    
        //array de objetos JSON
        viajes_pendientes.forEach(item => {
            let fila = document.createElement("tr");
            let fila_htmlRuta = `
                <td>${item.fecha_viaje}</td>
                <td>${item.lugar_origen}</td>
                <td>${item.lugar_destino}</td>
                <td>${item.hora_salida}</td>
                <td>${item.dni}</td>
                <td>${item.nro_asiento}</td>
            `;
            fila.innerHTML = fila_htmlRuta;
            tabla.appendChild(fila);
            
        });
        contenedor_info_viajes.appendChild(tabla);
    }else{
        contenedor_info_viajes.innerHTML = "<p>¡Aún no tiene viajes pendientes!</p>";
    }

}



