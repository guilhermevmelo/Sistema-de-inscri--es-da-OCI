<?php
session_start();
require_once("classes/Conexao.class.php");
require_once("classes/Usuario.class.php");
require_once("classes/Usuario.DAO.class.php");
require_once("classes/Aluno.class.php");
require_once("classes/Aluno.DAO.class.php");
require_once("recaptcha/recaptchalib.php");

$q = $_POST["q"];

if ($_GET["q"] == "e") {
	$aDAO = new AlunoDAO();
	$a = $aDAO->read($_GET["a"]);
	
	$uDAO = new UsuarioDAO();
	$u = $uDAO->read($_SESSION["oci_user"]);
		
	if ($a->tutor != $_SESSION["oci_user"] && $u->nivel_acesso < 5) {
		echo "<html><head><meta charset=\"utf-8\"><meta http-equiv=\"refresh\" content=\"2;url=index.php#verifica_inscritos\"></head><body><p>Esse aluno não é seu</p></body></html>";
	} else {
		$aDAO->delete($_GET["a"]);
		header("Location: index.php#verifica_inscritos");
		//echo "<html><head><meta charset=\"utf-8\"><meta http-equiv=\"refresh\" content=\"2;url=index.php#verifica_inscritos\"></head><body><p>".$d["nome"]." foi excluído(a) com sucesso.</p></body></html>";
	}
}

if ($q == "login") {
	$con = new Conexao();
	$sql = sprintf("SELECT * FROM usuarios WHERE email = '%s' AND senha = '%s'", $_POST["frm_login_email"], md5($_POST["frm_login_senha"]));
	$con->consulta($sql);
	
	if ($con->num_rows() > 0) {
		$d = $con->fetch_array();
		
		if ($d["ativado"] == 1) {
			$_SESSION["login_oci_si"] = "allow";
			$_SESSION["oci_user"] = $d["id_usuario"];
			echo "allow";
		} else {
			echo "not confirmed";
		}
	} else {
		echo "deny";
	}
}

if ($q == "validaCpf") {
	$con = new Conexao();
	$sql = sprintf("SELECT * FROM usuarios WHERE cpf = '%s'", $_POST["cpf"]);
	$con->consulta($sql);
	
	if ($con->num_rows() > 0)
		echo "deny";
	else
		echo "allow";
}

if ($q == "validaEmail") {
	$con = new Conexao();
	$sql = sprintf("SELECT * FROM usuarios WHERE email = '%s'", $_POST["email"]);
	$con->consulta($sql);
	
	if ($con->num_rows() > 0)
		echo "deny";
	else
		echo "allow";
}

if ($q == "validaCaptcha") {
	$privatekey = "6LdWVOISAAAAAMlmFlQPsyTe--xhIudEYtzLUSIi";
	$resp = recaptcha_check_answer ($privatekey,
								$_SERVER["REMOTE_ADDR"],
								$_POST["recaptcha_challenge_field"],
								$_POST["recaptcha_response_field"]);
	
	if (!$resp->is_valid) {
		// What happens when the CAPTCHA was entered incorrectly
		echo "nao passou";
	} else {
		// Your code here to handle a successful verification
		echo "passou";
	}
}

if ($q == "cadastrar") {
	$u = new Usuario();
	$u->id_usuario = NULL;
	$u->nome = $_POST["nome"];
	$u->cpf = $_POST["cpf"];
	$u->senha = $_POST["senha"];
	$u->email = $_POST["email"];
	$u->escola = $_POST["escola"];
	$u->nivel_acesso = 1;
	$u->uid = NULL;
	$u->ativado = 0;
	$u->cargo = $_POST["cargo"];
	$u->natureza = ($_POST["natureza"] == "publica") ? 0 : 1;
	
	$uDAO = new UsuarioDAO();
	$u = $uDAO->create($u);
	
	$to = $u->email;
	
	$servidor = "http://oci.org.br/sandbox/";
	
	$subject = "[OCI'13] Confirmação de cadastro de tutor";
	
	$headers = "From: Contato OCI <naoresponda@oci.org.br>\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	
	$message = '<!doctype html>
				<html>
				<head><meta charset="UTF-8"></head>
				<body>
				
				<table width="500">
					<tr>
						<td align="center">
							<img src="'.$servidor.'imagens/loguinha.png" />
						</td>
					</tr>
					<tr>
						<td>
						<p>Olá <strong>'.$u->nome.'</strong>, seu cadastro como tutor da escola '.$u->escola.' está quase finalizado. Para coclui-lo, precisamos que você clique no link de ativação abaixo. Isso garante que é você quem está se cadastrando no nosso sistema, e não outra pessoa.</p>
						<p>Caso o link abaixo não esteja funcinando, apenas copie-o e cole na barra de endereços do seu navegador.</p>
						<p align="center"><a href="'.$servidor.'home.php?q=ativar&uid='.$u->uid.'">'.$servidor.'home.php?q=ativar&uid='.$u->uid.'</a></p>
						<p>Se você não solicitou cadastro no sistema da OCI, então alguém o fez com seu endereço de email. Não se preocupe, o acesso somente será liberado para emails ativados e você só receberá comunicados nossos, caso ative o email.</p>
						<p align="right">Atenciosamente,<br>Coordenação da OCI.</p>
						</td>
					</tr>
				</table>
				
				</body>
				</html>';
	
	if (mail($to, $subject, $message, $headers)) {
		echo "tudo ok";
	} else {
		echo "deu pau";
	}
}

?>