<?php
require_once("class.Conexao.php");

if(isset($_POST["submit_form_confirmar"])) {

	$cod = $_POST["form_confirmar_cod_ativacao"];

	$con = new Conexao();
	$con->conectar();
	
	$sql = sprintf("SELECT * FROM tutores WHERE codigo_ativacao = '%s' ORDER BY id_tutor DESC", $cod);
	$con->consulta($sql);

	if ($con->num_rows() == 0)
		$err = "Nenhum registro encontrado para o seguinte código de ativação: ".$cod;
	else {
		while ($d = $con->fetch_array()) {
			$cad_nome = $d["nome"];
			$cad_escola = $d["escola"];
			$cad_email = $d["email"];
			$uid = $cod;
	
			$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>Solicitação de Cadastro de Tutor para a OCI</title>
			</head>
			
			<body style="font-family: Baskerville, "Baskerville Old Face", "Times New Roman", Times, serif;line-height:25px;">
			
			<table align="center" style="width:600px;" border="0">
				<tr>
					<td style="width:245px;font-size:13px;text-align:center;">II Olimpíada Cearense<br />de Informática</td>
					<td align="center" ><h3>Quase lá!</h3></td>
					<td align="center" style="width:245px;"><img src="http://oci.org.br/tutores/imagens/loguinha.png" /></td>
				</tr>
				<tr>
					<td colspan="3" align="justify">
						<p>Olá <strong>'.$cad_nome.'</strong>, foi solicitado para este email um cadastro como tutor na II Olimpíada Cearense de Informática. Este cadastro é a única forma que a escola <em>'.$cad_escola.'</em> tem de cadastrar seus alunos na competição, e é por meio de você.</p>
						<p>Já foi confirmada junto à escola a autenticidade da sua solicitação e, portanto, liberada.</p>
						<p>Para confirmar o cadastro deste email, clique no link abaixo. Você será redirecionado para a página de confirmação na área de tutores e só então você terá acesso à área restrita.</p>
						<p align="center"><a href="http://oci.org.br/tutores/auth.php?cod='.$uid.'">http://oci.org.br/tutores/auth.php?cod='.$uid.'</a></p>
						<p>Está diponível na <a href="http://oci.org.br/tutores/">área dos tutores</a> um campo para download do modelo da planilha de inscrição e envio desta preenchida. Todos os alunos que participarão da competição deverão ter seus dados de inscrição devidamente colocados nesta planilha e esta deverá ser renomeada como orientado no site.</p>
						<p>Seus dados de login são:</p>
						<table align="center">
							<tr>
								<td>email:</td>
								<td>'.$cad_email.'</td>
							</tr>
							
						</table>
						
						<p>Os PET Computação UFC e UECE agradecem a participação do <em>'.$cad_escola.'</em> na II OCI e desejam boa sorte a todos os alunos inscritos.</p>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="font-size: 12px; font-style:italic;line-height:13px;text-align:center;">Se você não solicitou cadastro como tutor da OCI ou se você não for <strong>'.$cad_nome.'</strong>, então seu email foi usado (provavelmente acidentalemente) por alguém. Neste caso, não clique no link acima. O cadastro de seu email não será efetivado e este não poderá ser usado para um novo cadastro. Para contato, use faleconosco@oci2012.com</td>
				</tr>
				<tr>
				<td width"30%" align="center"><img src="http://oci.org.br/tutores/imagens/ufc.png" style="width:100px;" /></td>
				<td style="">Parceiros</td>
				<td width"30%" align="center"><img src="http://oci.org.br/tutores/imagens/uece.png" style="width:100px;" /></td>
				</tr>
			</table>
			
			</body>
			</html>
			';
		
			$headers = "From: OCI<naoresponda@oci.org.br>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		
			if (mail($cad_email, "OCI Seu cadastro como tutor está quase completo.", $msg, $headers)) {
				$err = "Enviado com sucesso.";
				
				$co = new Conexao();
				$co->conectar();
				$sql = sprintf("UPDATE tutores SET enviado = 1 WHERE codigo_ativacao = '%s'", $cod);
				$con->consulta($sql);
				$co->fechar();
				} else {
				$err = "Ocorreu um erro ao enviar o email de confirmação.<br />Por favor contate-nos em faleconosco@oci2012.com";	
			}
		}
	}
	$con->fechar();
} else {
	$err = "Nenhum email a confirmar.";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>OCI | Área restrita a tutores</title>
<link rel="stylesheet" href="tela.css" type="text/css" />
<meta http-equiv="refresh" content="3;URL='index.php?t=<?php echo $_POST["form_confirmar_voltar"]; ?>'" />
</head>

<body>
<div style="text-align:center;background:none;margin: 10px;">
	<a href="http://www.oci.org.br/"><img src="imagens/loguinha.png" alt="Olimpíada Cearense de Informática" /></a>
</div>
<div id="Login">
	<p><?php echo $err; ?></p>
</div>
<div id="Rodape">
	<p>Qualquer dúvida, envie um email para faleconosco@oci2012.com</p>
	<p style="padding-top:5px;">
		<a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
		<a href="http://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="CSS válido!" /></a>
	</p>
</div>
</body>
</html>