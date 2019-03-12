function regresar(){
  	$("#datosForm :input").removeAttr("disabled");
  	$("#citas").fadeOut();
  	$('#submit-datos-btn').css("display", "block");
    $('#submit-citas-btn').css("display", "none");
  	$('#submit-btn').html("Subir Documentos");
  	$("#bienvenida").fadeIn('slow');  		
}