// const formulario = document.getElementById("id_fomr_registro");//aun no cargo la pagina
function borrar (){
	formulario = document.getElementById("id_fomr_compra_boleto");
	Validacion.limpiar_erorres();
	// formulario.reset();
}

function cancelar (){
	borrar();
	ir_paginaRutas();
}

function validar_seleccion_asiento(){
	let asiento =document.getElementById("id_nro_asiento");
	let error_seleccion = document.getElementById("error_seleccion_asiento");

	let valido_formulario = true;

	if (!Validacion.realizar_validacion(Validacion.texto, asiento, error_seleccion)) {
		valido_formulario = false;
	}

	return valido_formulario;
}

function validar_datos_viaje (){

	borrar();
	
	let fecha_viaje = document.getElementById("id_fecha_seleccionada");
	let erro_fecha_viaje = document.getElementById("error_fecha_viaje");

	let valido_formulario = true;

	if (!Validacion.realizar_validacion(Validacion.fecha_futura, fecha_viaje, erro_fecha_viaje)) {
		valido_formulario = false;
	}

	return valido_formulario;
}


function validar_datos_pasajero(){

	borrar();
	
	let dni = document.getElementById("id_dni");
	let error_dni = document.getElementById("error_dni");

	let nombre = document.getElementById("id_nombre");
	let error_nombre = document.getElementById("error_nombre");

	let apellido = document.getElementById("id_apellido");
	let error_apellido = document.getElementById("error_apellido");

	let valido_formulario = true;

	if (!Validacion.realizar_validacion(Validacion.dni, dni, error_dni)) {
		valido_formulario = false;
	}

	if (!Validacion.realizar_validacion(Validacion.texto, nombre, error_nombre)) {
		valido_formulario = false;
	}

	if (!Validacion.realizar_validacion(Validacion.texto, apellido, error_apellido)) {
		valido_formulario = false;
	}

	return valido_formulario;
}


function validar_datos (){
	return (validar_datos_viaje() 
		&& validar_seleccion_asiento() 
		&& validar_datos_pasajero()
	);
}







// function enviar_formulario (){
// 	Validacion.limpiar_erorres();
// 	formulario = document.getElementById("id_fomr_compra_boleto");
// 	// console.log(formulario);
	
// 	if (validar_datos()){
// 		console.log("el Usuario se valido exitosamente");
// 		formulario.submit();
// 	}
// }
