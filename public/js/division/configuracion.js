function opcionesMenu(){
	hideAll();
 	$("#opciones").fadeIn('fast');  	
}
	
function calendarioMenu(){
	hideAll();
	$("#calendario").fadeIn('fast');  
}
	
function planesMenu(){
	hideAll();
	$("#planes").fadeIn('fast');  
}
	
function egresadosMenu(){
	hideAll();
	$("#egresados").fadeIn('fast');  
}
	
function hideAll(){
	$("#opciones").fadeOut(0);
	$("#calendario").fadeOut(0);
	$("#planes").fadeOut(0);
	$("#egresados").fadeOut(0);	
}