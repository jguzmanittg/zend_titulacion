function checkCita(mode, form, action, lugar){
	var datepicker = encodeURIComponent($("#datepicker").val());
  	var hour = encodeURIComponent($("#hour").val());
  	$.post(
  			action,
  	    	{"datepicker":datepicker,
  	  	    "hour":hour,
  	  	    "mode":mode,
  	  	    "lugar":lugar},
  	    	function(data, status){
  	  	    	if (data["agendado"]==true){  	   	  	    	  	
   	  	    		$("#" + form).removeAttr('onsubmit');
   	   	  	     	$("#" + form).submit();
   	  	    	}
   	  	    	else{
 	   	  	    	 alert("La fecha y hora que has escogido ya no se encuentran disponibles."); 
 	   	  	      	 horas("egresado/getHours", lugar);
 	   	  	    }});  	
  	return false;
}