<?php
session_start();

require_once("recaptcha/recaptchalib.php");
require_once("classes/Usuario.DAO.class.php");
$q = $_GET["q"];

if ($q == "logout") $_SESSION["login_oci_si"] = "deny";

if ($q == "ativar") {
	$uid = $_GET["uid"];
	
	$uDAO = new UsuarioDAO();
	$u = $uDAO->readByUid($uid);
	
	if (!$u)
		$msg = "Não existe um usuário cadastrado com esse código de ativação.";
	else if ($u->ativado == 1)
		$msg = "Esse usuário já foi ativado.";
	else if ($u->ativado == 0) {
		$u->ativado = 1;
		$uDAO->update($u);
		$msg = "Usuário ativado com sucesso.";
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>III Olimpíada Cearense de Informática - Sistema de Inscrição</title>
<link rel="stylesheet" type="text/css" href="estilos/all.css" media="all">
<link rel="stylesheet" type="text/css" href="estilos/home.css" media="all">
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/home.js"></script>
</head>

<body>

<div id="Page">
	<?php
		if ($msg) {
			echo "<script>
			$(document).ready(function(){
				$('#Warnings p').html('".$msg."');
				$('#Warnings').slideDown('slow');
			});</script>";
		}
	?>
	<div id="Warnings">
		<p>All warnings will appear here</p>
	</div>

	<div id="Content">
		<div class="wrapper960">
			<div id="MainPanel">
				<div id="Passo0">	
					<div id="Login">
						<form name="frm_login" method="post" action="#" onSubmit="login()">
							<fieldset>
								<label for="frm_login_email">email</label>
								<input type="text" name="frm_login_email" id="frm_login_email" size="25" />
							</fieldset>
						
							<fieldset>
								<label for="frm_login_password">senha</label>
								<input type="password" name="frm_login_senha" id="frm_login_senha" size="25" />
							</fieldset>
							
							<fieldset>
								<input type="button" style="margin-top: 4px; margin-right: 10px;" class="floatLeft" name="frm_login_submit" id="frm_login_submit" value="login" />
								
								<!-- <a href="#" id="novo_cadastro">não possuo cadastro</a><br />-->
 								<!--<a href="#">esqueci a senha</a>-->
							</fieldset>
						</form>
					</div>
					<div id="Panel">
						<p>
							<img src="imagens/logo_oci.png" alt="OCI'13" />
						</p>
					</div>
				</div>
				
				<div id="Passo1">
					<h1>Cadastro de tutor - passo 1</h1>
					<p>Olá, para iniciarmos seu cadastro precisaremos de algumas informações. Cadastros realizados no ano passado não poderão ser utilizados esse ano.</p>
					<p>Cada tutor deve ter um cadastro único e não pode ser responsável por mais de uma escola, embora uma escola possa ter mais de um tutor. Para iniciar, digite abaixo somente os números de seu cpf.</p>
					
					<form id="frm_cad_passo1" name="frm_cad_passo1" method="post" onSubmit="submit_passo1();">
						<fieldset>
							<label for="frm_cad_cpf">cpf (somente números)</label>
							<input type="text" name="frm_cad_cpf" id="frm_cad_cpf" maxlength="11" size="25" />
						</fieldset>
						<fieldset>
							<input type="button" style="margin-top: 4px; margin-right: 10px;" class="floatLeft"  value="Voltar à tela de login" onClick="voltar(1);" />
							<input type="button" style="margin-top: 4px; margin-right: 10px;" class="floatLeft" name="frm_cad_passo1_sbmt" id="frm_cad_passo1_sbmt" value="Próximo passo" />
						</fieldset>
					</form>
				</div>
				
				<div id="Passo2">
					<h1>Cadastro de tutor - passo 2</h1>
					<p>Agora que sabemos que você não possui cadastro no sistema, precisamos estabelecer nosso principal meio de comunicação: seu email. Informe abaixo o endereço de email que você mais utiliza. Lembre-se de que o mesmo endereço de email também não pode ser utilizado duas vezes.</p>
					
					<form id="frm_cad_passo2" action="#" method="post" name="frm_cad_passo2">
						<fieldset>
							<label for="frm_cad_email">email</label>
							<input type="text" name="frm_cad_email" id="frm_cad_email" size="40" />
						</fieldset>
						<fieldset>
							<input type="button" style="margin-top: 4px; margin-right: 10px;" class="floatLeft"  value="Passo anterior" onClick="voltar(2);" />
							<input type="button" style="margin-top: 4px; margin-right: 10px;" class="floatLeft" name="frm_cad_passo2_sbmt" id="frm_cad_passo2_sbmt" value="Próximo passo" />
						</fieldset>
					</form>
				</div>
				
				<div id="Passo3">
					<h1>Cadastro de tutor - passo 3</h1>
					<p>Insira agora os seu nome completo e uma senha que garantirá seu acesso ao sistema.</p>
					
					<form id="frm_cad_passo3" action="#" method="post" name="frm_cad_passo3">
						<fieldset>
							<label for="frm_cad_nome">nome completo</label>
							<input type="text" name="frm_cad_nome" id="frm_cad_nome" size="40" />
						</fieldset>
						
						<fieldset class="inlineBlock">
							<label for="frm_cad_senha">senha</label>
							<input type="password" name="frm_cad_senha" id="frm_cad_senha" size="30" />
						</fieldset>
						<fieldset class="inlineBlock">
							<label for="frm_cad_conf_senha">repita a senha</label>
							<input type="password" name="frm_cad_conf_senha" id="frm_cad_conf_senha" size="30" />
						</fieldset>
						
						<fieldset>
							<input type="button" style="margin-top: 4px; margin-right: 10px;" class="floatLeft"  value="Passo anterior" onClick="voltar(3);" />
							<input type="button" style="margin-top: 4px; margin-right: 10px;" class="floatLeft" name="frm_cad_passo3_sbmt" id="frm_cad_passo3_sbmt" value="Próximo passo" />
						</fieldset>
					</form>
				</div>
				
				<div id="Passo4">
					<h1>Cadastro de tutor - passo 4</h1>
					<p>Seu cadastro está quase completo. Precisamos agora que você insira os dados da escola a qual você representará.</p>
					<p>Caso a escola possua mais de uma sede, insira o nome separado por um hífen:</p>
					<p class="exemplo">Colégio OCI - sede Pici</p>
					
					<form id="frm_cad_passo4" action="#" method="post" name="frm_cad_passo4">
						<fieldset>
							<label for="frm_cad_escola">escola</label>
							<input type="text" name="frm_cad_escola" id="frm_cad_escola" size="40" />
						</fieldset>
						
						<fieldset>
							<label for="frm_cad_cargo">seu cargo nela (professor, coordenador de turmas olímpicas)</label>
							<input type="text" name="frm_cad_cargo" id="frm_cad_cargo" size="40" />
						</fieldset>
						<fieldset>
							<label>a natureza da escola</label>
							
							<input type="radio" class="rd" name="frm_cad_tipo" id="frm_cad_tipo_part" value="particular" />
							<label for="frm_cad_tipo_part" class="inlineBlock">Particular</label>
							
							<br />
							
							<input type="radio" class="rd" name="frm_cad_tipo" id="frm_cad_tipo_pub" value="publica" checked />
							<label for="frm_cad_tipo_pub"  class="inlineBlock">Pública</label>
						</fieldset>
						
						<fieldset>
							<input type="button" style="margin-top: 4px; margin-right: 10px;" class="floatLeft"  value="Passo anterior" onClick="voltar(4);" />
							<input type="button" style="margin-top: 4px; margin-right: 10px;" class="floatLeft" name="frm_cad_passo4_sbmt" id="frm_cad_passo4_sbmt" value="Próximo passo" />
						</fieldset>
					</form>
				</div>
				
				<div id="Passo5">
					<h1>Cadastro de tutor - último passo</h1>
					<p>Precisamos apenas confirmar que você não é um robô tentando <span class="italic">spamar</span> nosso sistema. Por favor, preencha o captcha abaixo.</p>
					<?php
					  $publickey = "6LdWVOISAAAAAL8M0if_-QLt5TVw5bEevBZVGzeI";
					  echo recaptcha_get_html($publickey);
					?>
					<fieldset>
						<input type="button" style="margin-top: 4px; margin-right: 10px;" class="floatLeft"  value="Passo anterior" onClick="voltar(5);" />
						<input type="button" style="margin-top: 4px; margin-right: 10px;" class="floatLeft" name="frm_cad_passo5_sbmt" id="frm_cad_passo5_sbmt" value="Finalizar" />
					</fieldset>
				</div>
				
				<div id="Passo6">
					<h1>Cadastro de tutor - finalizado</h1>
					<p>Seu cadastro já foi concluído. Para ativá-lo e obter acesso ao sistema, acesse o email que cadastrou e use o link de ativação a ele enviado. Lembre-se de que o nosso email, enviado por <span class="italic">contato.oci@gmail.com</span> pode ter sido enviado para sua lixeira eletrônica/pasta de SPAM. Verifique lá e adicione nosso endereço a sua lista de contatos para que isso não aconteça novamente.</p>
				</div>
			</div>
		</div>
	</div>
	
	<footer>
		<div id="Footer">
			<div class="wrapper960">
				<p>copyright OCI'13 &copy 2013</p>
			</div>
		</div>
	</footer>
</div>

</body>
</html>