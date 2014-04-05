<?php
require_once("classes/Usuario.DAO.class.php");
require_once("classes/Aluno.DAO.class.php");




$con = new Conexao();


$sql = sprintf("UPDATE usuarios SET nivel_acesso = 5 WHERE id_usuario = 56");
$con->consulta($sql);

/*
$aDAO = new AlunoDAO();

$a = new Aluno();

$a->nome="Beatriz";

$aDAO->create($a);



	$u = new Usuario();
	$u->id_usuario = NULL;
	$u->nome = "Thiago Isaías";
	$u->cpf = "";
	$u->senha = "q1w2e3";
	$u->email = "thiagoisaiasbrg@gmail.com";
	$u->escola ="PET Computaçao - UFC";
	$u->nivel_acesso = 5;
	$u->uid = NULL;
	$u->ativado = 1;
	$u->cargo = "bolsista";
	$u->natureza = 0;
*/
/*
	$uDAO = new UsuarioDAO();
	//$uDAO->delete(55);
	$u = $uDAO->read(56);
	$u->nivel_acesso = 5;
	$uDAO->update($u);

	$u = $uDAO->read(56);
	print_r($u);
	
	/*

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
	
	echo  $message;
	
	if (mail("guilhermevmelo@gmail.com", $subject, $message, $headers)) {
		echo "tudo ok";
	} else {
		echo "deu pau";
	}*/

?>