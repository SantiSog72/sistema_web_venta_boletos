// const formulario = document.getElementById("id_fomr_registro");//aun no cargo la pagina
function borrar (){
	formulario = document.getElementById("id_fomr_registro");
	Validacion.limpiar_erorres();
	// formulario.reset();
}

function cancelar (){
	borrar();
	ir_index();
}


function validar_datos (){

	let dni = document.getElementById("id_dni");
	let error_dni = document.getElementById("error_dni");

	let nombre = document.getElementById("id_nombre");
	let error_nombre = document.getElementById("error_nombre");

    let segundo_nombre = document.getElementById("id_segundo_nombre");
	let error_segundo_nombre = document.getElementById("error_segundo_nombre");
	
	let apellido = document.getElementById("id_apellido");
	let error_apellido = document.getElementById("error_apellido");
	
	let email = document.getElementById("id_email");
	let error_email = document.getElementById("error_email");
	
	let contraseña = document.getElementById("id_contraseña");
	let error_contraseña = document.getElementById("error_contraseña");

	let nro_celular = document.getElementById("id_numero_cel");
	let error_numero_cel = document.getElementById("error_numero_cel");

    let nombre_usuario = document.getElementById("id_nombre_usuario");
	let error_nombre_usuario = document.getElementById("error_nombre_usuario");
	
	
	
	let valido_formulario = true;

	if (!Validacion.realizar_validacion(Validacion.texto, nombre_usuario, error_nombre_usuario)) {
		valido_formulario = false;
	}
	if (!Validacion.realizar_validacion(Validacion.texto, nombre, error_nombre)) {
		valido_formulario = false;
	}
	if (!Validacion.realizar_validacion(Validacion.texto, apellido, error_apellido)) {
		valido_formulario = false;
	}
    if (!Validacion.realizar_validacion(Validacion.texto, segundo_nombre, error_segundo_nombre)) {
		valido_formulario = false;
	}
	if (!Validacion.realizar_validacion(Validacion.contrasenaBasica, contraseña, error_contraseña)) {
		valido_formulario = false;
	}
	if (!Validacion.realizar_validacion(Validacion.email, email, error_email)) {
		valido_formulario = false;
	}
	if (!Validacion.realizar_validacion(Validacion.dni, dni, error_dni)) {
		valido_formulario = false;
	}
	if (!Validacion.realizar_validacion(Validacion.numero_celular, nro_celular, error_numero_cel)) {
		valido_formulario = false;
	}

	
	return valido_formulario;
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

