function checkDatos(form){
	var formData = new FormData(form);
    $.ajax({
    	url: $(form).attr('action'),
        type: $(form).attr('method'),
        data: formData,
        async: true,
        success: function (data) {
        	if(data["code"]=="OK"){
        		$("#datosForm :input").attr("disabled", true);
                $('#submit-cita-btn').css("display", "block");
                $('#submit-datos-btn').css("display", "none");
                $('#submit-btn').html("Agendar");
                }
            else if (typeof data["code"]!== 'undefined')alert ("Tu documento " + data["error"] + " tuvo un problema al ser guardado. " + data["code"]);
            else alert("Ha ocurrido un error desconocido al momento de subir tus documentos, verifica que estos sean del formato PDF/JPG/JPEG/PNG y no excedan los 2MB");
        },
        cache: false,
        contentType: false,
        processData: false
    });
	return false;
}