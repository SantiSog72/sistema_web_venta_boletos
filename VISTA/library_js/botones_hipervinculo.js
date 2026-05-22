// Usamos la variable global definida en el PHP. 
if (typeof raiz === 'undefined') {
    window.raiz = (window.BASE_URL || "/sistema_web_venta_boletos/").replace(/\/$/, "") + "/";
}
function ir_paginaRutas(){
    window.location.href = `${raiz}VISTA/paginaRutas.php`;  
}

function ir_singUp(){
    window.location.href = `${raiz}VISTA/singUp.php`;   
}

function ir_singIn(){
    window.location.href = `${raiz}index.php`;   
}

function ir_comprar(){
    window.location.href = `${raiz}VISTA/comprarPasaje.php`;   
}

function ir_historial_compras(){
    window.location.href = `${raiz}VISTA/historialCompras.php`;   
}
