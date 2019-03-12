function checkCita(mode, form, action, lugar){
	var datepicker = encodeURIComponent($("#datepicker").val());
  	var hour = encodeURIComponent($("#hour").val());
  	var nc = $("#nc").val();
  	$.post(
  			action,
  	    	{"datepicker":datepicker,
  	  	    "hour":hour,
  	  	    "mode":mode,
  	  	    "lugar":lugar,
  	  	    "nc":nc},
  	    	function(data, status){
  	  	    	if (data["agendado"]==true){  	   	  	    	  	
   	  	    		$("#" + form).removeAttr('onSubmit');
   	   	  	     	$("#" + form).submit();
   	  	    	}
   	  	    	else{
 	   	  	    	 alert("La fecha y hora que has escogido ya no se encuentran disponibles."); 
 	   	  	      	 horas("division/getHours", lugar);
 	   	  	    }});  
  	return false;
}