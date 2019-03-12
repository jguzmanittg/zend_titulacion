function buscar_egresado(){
	document.getElementById("b_egresado").disabled=true;
	nombre_e( $('#username_e').val());
}

function nombre_e(nc){
var x;
var estado;
url = "http://sii.ittg.edu.mx/api/index.php/alumnos/detalles?id="+nc+"&estatus=all&key=c56295f4db9f1e8de00274724f26ea45" ;
	$.ajax({
		url: url,
                async:false,
		success: function(data){
                    x=data;
		}
	});
if(x.error){
	
	alert('Usuario no encontrado, verifique <?php echo utf8_encode("número");?> de control');
	document.getElementById("b_egresado").disabled=false;
   	estado = null;
 }else{
   estado = x.estatus;
   console.log(x);
}

if (estado == "Egresado"){
	document.getElementById("nombre_e").value = x.nombre;
	document.getElementById("apellidos_e").value = x.apellidos;
	document.getElementById("nombreComp_e").value = x.nombre_completo;
	document.getElementById("carrera_e").value = x.carrera;
	document.getElementById("clave_e").value = x.clave;
	document.getElementById("adeudo_e").value = x.adeudo;
	document.forms['egresado'].submit();
}
else if(estado!=null){
	document.getElementById("b_egresado").disabled=false;
	alert('El usuario ingresado no se encuentra como egresado');
}
}
//********************************Sección búsqueda datos personal****************************************************
function buscar_personal(){
	document.getElementById("b_division").disabled=true;
	nombre_p( $('#username_p').val());
}

function nombre_p(nc){
var x;
var nombre;
url = "http://sii.ittg.edu.mx/api/index.php/personal/detalles?id="+nc+"&key=c56295f4db9f1e8de00274724f26ea45" ;
	$.ajax({
		url: url,
                async:false,
		success: function(data){
                    x=data;
		}
	});
if(x.error){
	document.getElementById("b_division").disabled=false;
	alert('Usuario no encontrado, verifique número de tarjeta');
 }
 else if(x.nombre){
	 console.log(x);
	 document.getElementById("nombre_p").value = x.nombre;
	 document.getElementById("apellidos_p").value = x.apellidos;
	 document.getElementById("nombreComp_p").value = x.nombre_completo;
	 document.getElementById("rfc_p").value = x.rfc;
	 document.getElementById("cedula_p").value = x.cedula;
	 document.forms['personal'].submit();
	 }
 
}