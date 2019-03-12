function mostrar_info(idOpcion, nombre, indice){
	$.post(
  	"egresado/getRequisitos",
  	{'idOpcion':idOpcion},
  	function(data, status){
  	  	$("#inputs_requisitos").html("");
  	  	data["requisitos"].forEach(createInput);
  	  	$("#nombre_opcion").html(nombre);
  	  	$("#bienvenida").fadeOut();
  	  	$("#opcionModal").modal("hide");
  	  	$("#citas").fadeIn('slow');
  	  	ajustaPozos();
  	});
}

function ajustaPozos(){
  	var altura;
  	if ($("#instrucciones").height() > $("#requisitos").height())altura = $("#instrucciones").css("height");
  	else altura = $("#requisitos").css("height");
  	$("#calendario").height(altura);
	$("#instrucciones").height(altura);
	$("#requisitos").height(altura);
}