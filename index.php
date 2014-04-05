<?php
session_start();
if ($_SESSION["login_oci_si"] != "allow")
	header("Location: home.php");

require_once("classes/Usuario.DAO.class.php");
require_once("classes/Aluno.DAO.class.php");

$uDAO = new UsuarioDAO();
$u = $uDAO->read($_SESSION["oci_user"]);

if(isset($_POST["insc_sbmt"])) {
	$aDAO = new AlunoDAO();
	$a = new Aluno();
	
	if ($_POST["insc_nome"]) {
		$a->nome = $_POST["insc_nome"];
		$a->serie = $_POST["insc_serie"];
		$a->nivel = $_POST["insc_hidden"];
		$a->local = $_POST["insc_local"];
		$a->necessidade = $_POST["insc_necessidade"];
		$a->tutor = $u->id_usuario;
		
		$aDAO->create($a);
		$msg = "Competidor inscrito com sucesso.";
	} else {
		$msg = "Todos os campos são obrigatórios.";	
	}
}

if (isset($_POST["edit_sbmt"])) {
	$aDAO = new AlunoDAO();
	$a = new Aluno();
	
	$a->nome = $_POST["insc_nome"];
	$a->serie = $_POST["insc_serie"];
	$a->nivel = $_POST["insc_hidden"];
	$a->id_aluno = $_POST["edit_id"];
	$a->local = $_POST["insc_local"];
	$a->necessidade = $_POST["insc_necessidade"];
	
	$aDAO->update($a);
	$msg = "Alterações efetivadas com sucesso.";
	
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
</head>

<body>

<div id="Page">
	<div id="Warnings">
		<p>All the warnings will appear here.</p>
	</div>

	<header>
		<div class="wrapper960">
			<div id="Logo"><img src="imagens/loguinha.png" alt="" /></div>
			<p class="alignRight">Olá <span class="bold"><?php echo $u->nome; ?></span> | <a href="home.php?q=logout">sair</a></p>
		</div>
	</header>
	
	<div id="MainMenu">
		<div class="wrapper960">
			<ul>
				<!--<li><a href="#inscreve_competidor">Inscrever competidor</a></li>-->
				<li><a href="#verifica_inscritos">Verificar Inscritos</a></li>
				<!-- <?php if ($u->natureza || $u->nivel_acesso > 1) {?><li><a href="#pagamento">Pagamento</a></li><?php } ?> -->
				<?php if ($u->nivel_acesso > 4) {?><li><a href="#lista_tutores">Listar Tutores</a></li><?php } ?>
				<!--<li><a href="#">menu item</a></li>-->
			</ul>
		</div>	
	</div>
	
	<div id="Content">
		<div class="wrapper960">
			<h2>Sistema de inscrição de competidores</h2>
			<p>Aos modos da Olimpíada Brasileira de Informática, a partir de 2013 as inscrições para a OCI serão de apenas um competidor por vez. Nãoo serão aceitas planilhas com os dados dos competidores. Não serão aceitas incrições por email.</p>
			<p class="red">Senhores tutores. As inscrições foram encerradas, mas os comprovantes ainda podem ser enviados até o dia 11/10/2013.</p>
			<table class="no-width">
				<tr>
					<td>Abertura das inscrições</td>
					<td>10/09</td>
				</tr>
			</table>
			<div id="Dinamico">
			</div>
		</div>
	</div>
	
	<footer>
		<div id="Footer">
			<div class="wrapper960">
				<p>copyright OCI'13 &copy; 2013</p>
			</div>
		</div>
	</footer>
</div>

</body>
</html>