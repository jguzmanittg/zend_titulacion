function datePickerEscolares(){
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
    			if (dia >= inicioE && dia <= finE){
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