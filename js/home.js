/**
 *
 *
 **/

var passo = 1;

function login() {
	$("#frm_login_submit").attr("disabled", "disabled");
	$("#Warnings").slideUp("slow");
	$.ajax({
		url: "action.php",
		type: "POST",
		data: {
			"q" : "login",
			"frm_login_email" : $("#frm_login_email").val(),
			"frm_login_senha" : $("#frm_login_senha").val()
		}
	}).done(function(r){
		if (r ==  "allow")
			document.location = "index.php";
		else {
			$("#frm_login_submit").removeAttr("disabled");
			if (r == "not confirmed")
				$("#Warnings p").html("Esse endereço de email ainda não foi confirmado. Verifique sua caixa de entrada.");
			else
				$("#Warnings p").html("Email ou senha não identificados.");
			$("#Warnings").slideDown("slow");
		}
	});
} 

function validarCPF(cpf) {
 
    cpf = cpf.replace(/[^\d]+/g,'');
 
    if(cpf == '') return false;
 
    // Elimina CPFs invalidos conhecidos
    if (cpf.length != 11 || 
        cpf == "00000000000" || 
        cpf == "11111111111" || 
        cpf == "22222222222" || 
        cpf == "33333333333" || 
        cpf == "44444444444" || 
        cpf == "55555555555" || 
        cpf == "66666666666" || 
        cpf == "77777777777" || 
        cpf == "88888888888" || 
        cpf == "99999999999")
        return false;
     
    // Valida 1o digito
    add = 0;
    for (i=0; i < 9; i ++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
     
    // Valida 2o digito
    add = 0;
    for (i = 0; i < 10; i ++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;
         
    return true;
    
}

function validarEmail(email){
    var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
    var check=/@[\w\-]+\./;
    var checkend=/\.[a-zA-Z]{2,3}$/;
    if(((email.search(exclude) != -1)||(email.search(check)) == -1)||(email.search(checkend) == -1)){return false;}
    else {return true;}
}

function submit_passo1() {
	$("#frm_cad_passo1_sbmt").attr("disabled", "disabled");
	$("#Warnings").slideUp("slow", function() {
		if(validarCPF($("#frm_cad_cpf").val())) {
			$.ajax({
				url: "action.php",
				type: "POST",
				data: {
					"q": "validaCpf",
					"cpf": $("#frm_cad_cpf").val()
				}
			}).done(function(r){
				if (r == "allow") {
					$("#Passo1").fadeOut("slow", function() {
						$("#Passo2").fadeIn("slow");
					});
				} else {
					$("#Warnings p").html("O cpf informado já foi utilizado.");
					$("#Warnings").slideDown("slow");
				}
				$("#frm_cad_passo1_sbmt").removeAttr("disabled");
			});
			
		} else {
			$("#Warnings p").html("O cpf informado não é válido.");
			$("#Warnings").slideDown("slow");
			$("#frm_cad_passo1_sbmt").removeAttr("disabled");
		}
	});
}

function voltar(passo) {
	$("#Warnings").slideUp("slow");
		$("#Passo"+passo).fadeOut("slow", function() {
			$("#Passo"+(passo-1)).fadeIn("slow");
		});
}

$(document).ready(function(e) {
	$("#novo_cadastro").click(function(e) {
		$("#Warnings").slideUp("slow");
		$("#Passo0").fadeOut("slow", function() {
			$("#Passo1").fadeIn("slow");
		});
	});
	
	$("#Warnings").click(function(e) {
		$("#Warnings").slideToggle("slow");
	});
	
	$("#frm_login_submit").click(login);
	
	$("#frm_cad_passo1_sbmt").click(function(e) {
		submit_passo1();
	});
	
	$("#frm_cad_passo2_sbmt").click(function(e) {
		$("#frm_cad_passo2_sbmt").attr("disabled", "disabled");
		$("#Warnings").slideUp("slow", function() {
			if(validarEmail($("#frm_cad_email").val())) {
				$.ajax({
					url: "action.php",
					type: "POST",
					data: {
						"q": "validaEmail",
						"email": $("#frm_cad_email").val()
					}
				}).done(function(r){
					if (r == "allow") {
						$("#Passo2").fadeOut("slow", function() {
							$("#Passo3").fadeIn("slow");
						});
					} else {
						$("#Warnings p").html("O email informado já foi utilizado.");
						$("#Warnings").slideDown("slow");
					}
					$("#frm_cad_passo2_sbmt").removeAttr("disabled");
				});
				
			} else {
				$("#Warnings p").html("O email informado não é válido.");
				$("#Warnings").slideDown("slow");
				$("#frm_cad_passo2_sbmt").removeAttr("disabled");
			}
		});
	});
	
	$("#frm_cad_passo3_sbmt").click(function(e) {
		$("#frm_cad_passo3_sbmt").attr("disabled", "disabled");
		$("#Warnings").slideUp("slow", function() {
			if ($("#frm_cad_senha").val() && $("#frm_cad_nome").val()) {
				if($("#frm_cad_senha").val() == $("#frm_cad_conf_senha").val()) {
					$("#Passo3").fadeOut("slow", function() {
						$("#Passo4").fadeIn("slow");
					});
				} else {
					$("#Warnings p").html("Os senhas informadas não são iguais.");
					$("#Warnings").slideDown("slow");
				}
				$("#frm_cad_passo3_sbmt").removeAttr("disabled");
			} else {
				$("#Warnings p").html("Todos os campos devem ser preenchidos.");
				$("#Warnings").slideDown("slow");
				$("#frm_cad_passo3_sbmt").removeAttr("disabled");
			}
		});
	});
	
	$("#frm_cad_passo4_sbmt").click(function(e) {
		$("#frm_cad_passo4_sbmt").attr("disabled", "disabled");
		$("#Warnings").slideUp("slow", function() {
			if($("#frm_cad_escola").val() && $("#frm_cad_cargo").val()) {
				$("#Passo4").fadeOut("slow", function() {
					$("#Passo5").fadeIn("slow");
				});
			} else {
				$("#Warnings p").html("Todos os campos devem ser preenchidos.");
				$("#Warnings").slideDown("slow");
			}
			$("#frm_cad_passo4_sbmt").removeAttr("disabled");
		});
	});
	
	$("#frm_cad_passo5_sbmt").click(function(e) {
		$("#frm_cad_passo5_sbmt").attr("disabled", "disabled");
		$("#Warnings").slideUp("slow", function() {
			$.ajax({
				url: "action.php",
				type: "POST",
				data: {
					"q": "validaCaptcha",
					"recaptcha_challenge_field": $("#recaptcha_challenge_field").val(),
					"recaptcha_response_field": $("#recaptcha_response_field").val()
				}
			}).done(function(r){
				if (r == "passou") {
					$("#Passo5").fadeOut("slow", function() {
						$("#Passo6").html("Aguarde alguns instantes.");
						$("#Passo6").fadeIn("slow");
						$.ajax({
							url: "action.php",
							type: "POST",
							data: {
								"q": "cadastrar",
								"nome" : $("#frm_cad_nome").val(),
								"cpf" : $("#frm_cad_cpf").val(),
								"senha" : $("#frm_cad_senha").val(),
								"email" : $("#frm_cad_email").val(),
								"escola" : $("#frm_cad_escola").val(),
								"cargo" : $("#frm_cad_cargo").val(),
								"natureza" : $(".rd:checked").val()
							}
						}).done(function(r){
							if (r == "tudo ok")  {
								$("#Passo6").fadeOut("slow");
								$("#Passo6").html("<h1>Cadastro de tutor - finalizado</h1><p>Seu cadastro já foi concluído. Para ativá-lo e obter acesso ao sistema, acesse o email que cadastrou e use o link de ativação a ele enviado. Lembre-se de que o nosso email, enviado por <span class=\"italic\">contato.oci@gmail.com</span> pode ter sido enviado para sua lixeira eletrônica/pasta de SPAM. Verifique lá e adicione nosso endereço a sua lista de contatos para que isso não aconteça novamente.</p>");
							} else {
								$("#Passo6").fadeOut("slow");
								$("#Passo6").html("Aconteceu um problema com o sistema de cadastro. Nossa equipe já foi contatada para resolvê-lo. Por favor, tente novamente amanhã. Muito provavelmente seus dados já estão no sistema, mas o link de ativação pode não ter sido enviado. Nesse caso, nossa equipe entrará em contato com você para que obtenha esse link. Pedimos desculpas pelo transtorno e agradecemos a compreensão.");
								/* cod pra contatar equipe */
							}
							$("#Passo6").fadeIn("slow");
						});
						
					});
				} else {
					Recaptcha.reload();
					$("#Warnings p").html("O código informado para o captcha está errado.");
					$("#Warnings").slideDown("slow");
					$("#frm_cad_passo5_sbmt").removeAttr("disabled");
				}
			});
		});
	});
	$("#frm_cad_passo1").submit(function(e) {
		stop();
		submit_passo1();
	});
	
});