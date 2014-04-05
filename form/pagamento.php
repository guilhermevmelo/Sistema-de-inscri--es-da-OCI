<h3>Instruções</h3>

<ol>
	<li>O valor da inscrição corresponde a:</li>
</ol>
	<p>(R$10,00) x (número de alunos da escola inscritos pelo tutor)</p>
	<p>Por exemplo: R$200,00, para 20 alunos inscritos.</p>

<ol start="2">
	<li>Fazer depósito nomeado com o título da Escola na conta abaixo:</li>
</ol>
<p>Conta corrente do banco Bradesco</p>

<table style="width:500px;">
	<tr>
		<th style="width: 60px;">Nome</th>
		<td>Francisco Thiago Gomes Vieira</td>
	</tr>
	<tr>
		<th>Agência</th>
		<td>0649</td>
	</tr>
	<tr>
		<th>Conta</th>
		<td>06781-4</td>
	</tr>
</table>
<ol start="3">
	<li>Enviar, em formato PDF, o comprovante de depósito e a lista de alunos aos quais o pagamento se refere pelo formulário abaixo.</li>
</ol>

<form method="post" action="sbmt_comp.php" name="frm_comp" enctype="multipart/form-data">
<fieldset>
	<label for="frm_comprovante">Comprovante</label>
	<input type="file" name="frm_comprovante" id="frm_comprovante">
</fieldset>
<!--
<fieldset>
	<label for="frm_lista">Lista de alunos</label>
	<input type="file" name="frm_lista" id="frm_lista">
</fieldset>
-->
<input type="submit" name="frm_sbmt_pagamento">
</form>
<?php
session_start();
require_once("../classes/Conexao.class.php");
require_once("../classes/Usuario.DAO.class.php");

$uDAO = new UsuarioDAO();
$u = $uDAO->read($_SESSION["oci_user"]);


$con = new Conexao();
$sql = $u->nivel_acesso > 3 ? sprintf("select c.*, u.nome as prof, u.escola from comprovantes c, usuarios u where c.id_usuario = u.id_usuario") : sprintf("select * from comprovantes where id_usuario = %d", $_SESSION["oci_user"]);
$con->consulta($sql);

if ($con->num_rows() > 0) {
	echo "<h3>Comprovantes já enviados</h3>";
	echo "<table>";
	while($d = $con->fetch_array()) {
		echo "<tr>";
		echo "<td><a href=".$d["caminho"].">".$d["nome"]."</a></td>";
		if ($u->nivel_acesso > 3)
			echo "<td>".$d["prof"]."</td>"."<td>".$d["escola"]."</td>";
		echo "</tr>";
	}
	echo "</table>";
}

?>