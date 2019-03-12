function datePicker(){
	$.datepicker.setDefaults($.datepicker.regional['es']);
	var minData = new Date();
	minData.setDate(minData.getDate() + 1);
	$( "#datepicker" ).datepicker({
		minDate: minData,
		beforeShowDay: 
    		function(date){
				var datestring = jQuery.datepicker.formatDate('yy-mm-dd', date);
				var parts_d = datestring.split('-');
				var dia = Date.UTC(parts_d[0], parts_d[1]-1, parts_d[2]);
    			if (dia >= inicio && dia <= fin){
					var finDeSemana=$.datepicker.noWeekends(date);
					if (finDeSemana[0]){
		    			return [ holidays.indexOf(datestring) == -1 ];
					}
		    		else return finDeSemana;
    			}
    			else return true;        		    	
		}
    	});
}

function horas(action, lugar){
	var dia = encodeURIComponent($("#datepicker").val());
  	$.post(
  			"division/getHours",
  	    	{"dia":dia, "lugar":lugar},
  	    	function(data, status){
  	    		var ocupado=organiza_arreglo(data["horas"], "hora");
  	  	    	crea_horas(data["cfg"][0]["h_inicio"], data["cfg"][0]["h_fin"], data["cfg"][0]["intervalo"], ocupado);
  	    	});
}

function crea_horas(inicio, fin, intervalo, ocupado){
		var select = document.getElementById("hour");
		select.options.length=0;
		var salto = parseInt(intervalo);
		var option; var horario;
		var hora_i = new Date();
		var hora_f = new Date();  		

	ocupado.forEach(function (item, index){
		ocupado[index] = item.substring(0,5);
		});
		
		hora_i.setHours(inicio.substring(0,2));
		hora_i.setMinutes(inicio.substring(3,5));
		hora_f.setHours(fin.substring(0,2));
		hora_f.setMinutes(fin.substring(3,5));
	while (hora_i < hora_f){	
		option 			= document.createElement("option");
		horario		 	= hourToString(hora_i.getHours(), hora_i.getMinutes());
			option.text 	= horario;
			option.value 	= horario;
			if (ocupado.indexOf(horario)>=0)
			option.disabled = true;  			
			select.add(option);
			hora_i.setMinutes(hora_i.getMinutes() + salto);
	}
}

function organiza_arreglo(arreglo, clave){
	  	var arreglo_final = [];
	  	arreglo.forEach(function (item, index){
	  	  		arreglo_final.push(item[clave]);
	  	  	});
	  	return arreglo_final;
}

function hourToString(hora, minutos){
	  	if (hora<10)hora = "0" + hora;
	if (minutos<10)minutos = "0" + minutos;
	  	return hora+ ":" + minutos;
}