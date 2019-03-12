function show_descripcion(idOpcion){
	$.post(
  	"egresado/getOpcionInfo", 
  	{'idOpcion':idOpcion}, 
  	function(data, status){
  		$("#modal-title").html('OPCION:' + data["info"][0]["nombre"]);
  	    $("#modal-descripcion").html('DESCRICPION: ' + data["info"][0]["descripcion"]);
  	  	$("#modal-requisitos").html('REQUISITOS:<br>');

  	  	data["requisitos"].forEach(setRequisito);
  	  	document.getElementById("form_select").action=
  	  	"javascript:mostrar_info('" 
  	  		+ data["info"][0]["idOpciones"] + "','"
  	  		+ data["info"][0]["nombre"]+ "')";
  	  	$("#opcion_hidden").val(data["info"][0]["idOpciones"]);
  	  	$("#opcionModal").modal({show: true});
  	});
}