function atualizaConteudo() {
	hash = window.location.hash;
	url = "";
	
	var p = hash.split("?");
	hash = p[0];
	
	if (p[1]) {
		var a = p[1].split("=");
		var b = a[1];
	}
	
	switch (hash) {
		case "#inscreve_competidor":
			url = "form/inscricoes_encerradas.html";
			break;
			
		case "#editar_competidor":
			url = "form/editar_competidor.php?a=" + b;
			break;
		
		case "#verifica_inscritos":
			url = "form/verifica_inscritos.php";
			break;
			
		case "#lista_tutores":
			url = "form/lista_tutores.php";
			break;
		
		case "#pagamento":
			url = "form/pagamento.php";
			break; 
		
		default:
			url = "";
			break;
	}
	
	if (url != "") {
		$.ajax({
			"url" : url,
			type : "GET"
		}).done(function(r){
			$("#Dinamico").fadeOut("slow", function() {
				$("#Dinamico").html(r);
				$("#Dinamico").fadeIn("slow");
			});
		});
	
	}
}

window.onload = atualizaConteudo;

$(document).ready(function(e) {
	window.onhashchange = atualizaConteudo;
	
	$("#Warnings").click(function(e) {
		$("#Warnings").slideToggle("slow");
	});
});

function muda_serie(serie){
	var nivel;
	
	if (serie == "6EF" || serie == "7EF")
		nivel = 1;
		
	if (serie == "8EF" || serie == "9EF")
		nivel = 2;
		
	if (serie == "1EM" || serie == "2EM" || serie == "3EM")
		nivel = 3;
		
	document.getElementById("insc_nivel").value = nivel;
	document.getElementById("insc_hidden").value = nivel;
	
	//$("#insc_nivel").val(nivel);
	//$("#insc_hidden").val(nivel);
}