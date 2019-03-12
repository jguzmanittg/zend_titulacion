function createInput(item, index){
  	  	var html = $("#inputs_requisitos").html();
  	  	if (item["tipo"]=="archivo")
			$("#inputs_requisitos").html(html + 
				"* <a href=ejemplos/" + 
				item["ejemplo"] + 
				" target='_blank'>" + 
				item["nombre"] + 
				"</a><br><input type=file name='" +
				item["idRequisitos"] +
				"' required><br>");
		if (item["tipo"]=="texto")
			$("#inputs_requisitos").html(html +
					"<label for='" +
					item["idRequisitos"] +
					"'>" +
					item["nombre"] +
					": </label><input type='text' name='" +
					item["idRequisitos"] +
					"' id='" +
					item["idRequisitos"] +
					"' class='form-control' required><br>");
		if (item["tipo"]=="textarea")
			$("#inputs_requisitos").html(html +
					"<label for='" +
					item["idRequisitos"] +
					"'>" +
					item["nombre"] +
					": </label><textarea cols='5' name='" +
					item["idRequisitos"] +
					"' id='" +
					item["idRequisitos"] +
					"' class='form-control' maxlength='350' required></textarea><br>");
}