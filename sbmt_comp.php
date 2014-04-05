<?php
session_start();
if ($_SESSION["login_oci_si"] != "allow")
	header("Location: home.php");

require_once("classes/Conexao.class.php");

echo $_SESSION["oci_user"];

if (isset($_POST["frm_sbmt_pagamento"])) {
	$id_tutor = $_SESSION["oci_user"];
	
	$fnome = addslashes($_FILES["frm_comprovante"]["name"]);
	$fnome = str_replace(" ", "_", $fnome);
	
	$destino = "comprovantes/";
	$half = $id_tutor."_".uniqid()."_".$fnome;
	$arquivo = $destino.$half;
	
	//$destino.$_SESSION["oci_user"]."_".uniqid()."_".$_FILES['frm_comprovante']['name']
	if (move_uploaded_file($_FILES['frm_comprovante']['tmp_name'], $arquivo)) {
		$msg = "O arquivo é valido e foi carregado com sucesso. Redirecionando...";
		$conn = new Conexao(); //$_SESSION["oci_user"]."_".uniqid()."_".$_FILES['frm_comprovante']['name']
		$sql = sprintf("INSERT INTO comprovantes (id_comprovante, id_usuario, nome, caminho) VALUES (NULL, %d, '%s', '%s')", $id_tutor, $_FILES["frm_comprovante"]["name"], $arquivo);
		$conn->consulta($sql);
		
	} else {
		$msg = "Ocorreu um erro com o envio do arquivo. Tente novamente e se o erro persistir, contate-nos em faleconosco@oci2012.com. Redirecionando...";
		
	}
} else {
	$msg = "Nenhum arquivo foi enviado. Redirecionando...";
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>III Olimpíada Cearense de Informática - Sistema de Inscrição</title>
<link rel="stylesheet" type="text/css" href="estilos/all.css" media="all">
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/index.js"></script>
<?php
	if (@$msg) {
		echo "<script>
		$(document).ready(function(){
			$('#Warnings p').html('".$msg."');
			$('#Warnings').slideDown('slow');
		});</script>";
	}
?>
<meta http-equiv="refresh" content="1;url=index.php#pagamento">
</head>

<body>

<div id="Page">
	<div id="Warnings">
		<p>All the warnings will appear here.</p>
	</div>

	<header>
		<div class="wrapper960">
			<div id="Logo"><img src="imagens/loguinha.png" alt="" /></div>
		</div>
	</header>
	
	<div id="MainMenu">
		<div class="wrapper960">
			
		</div>	
	</div>
	
	<div id="Content">
		<div class="wrapper960">
			<p><?php echo $msg; ?></p>
			
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