function setRequisito(item, index){
  	  	var html = $("#modal-requisitos").html();
  	  	html = html + '<ul>';
		$("#modal-requisitos").html(html + '<li style="list-style-type:disc;margin-left:4px;"><a href=ejemplos/' + item["ejemplo"] + " target='_blank'>" + item["nombre"] + "</a></li>");	
		html = html + '</ul>';
}