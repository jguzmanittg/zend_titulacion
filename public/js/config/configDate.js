function updateDates(action){
	var f_inicio = $("#f_inicio").val();
	var f_fin = $("#f_fin").val();
	var h_inicio = $("#h_inicio").val();
	var h_fin = $("#h_fin").val();
	var intervalo = $("#intervalo").val();
	if (h_inicio>h_fin){
		alert ("La hora de inicio debe ser menor a la hora final.");
	}
	else
	$.post(
  			action,
  	    	{"f_inicio":f_inicio, 
  			"f_fin":f_fin,
  	  	    "h_inicio":h_inicio,
  	  	    "h_fin":h_fin,
  	  	    "intervalo":intervalo
  	  	    },
  	    	function(data, status){
  	  	    	alert("Se han actualizado las fechas.");
  	  	    	location.reload();
  	  	    	});
	return false;
}