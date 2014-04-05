<?php
session_start();
if ($_SESSION["login_oci_si"] != "allow")
	header("Location: home.php");

require_once("../classes/Usuario.DAO.class.php");
require_once("../classes/Aluno.DAO.class.php");

$uDAO = new UsuarioDAO();
$u = $uDAO->read($_SESSION["oci_user"]);

$con = new Conexao();

$sql = $u->nivel_acesso < 5 ? sprintf("SELECT * FROM alunos WHERE id_aluno = %d AND tutor = %d ORDER BY nome ASC", $_GET["a"], $_SESSION["oci_user"]) : sprintf("SELECT * FROM alunos WHERE id_aluno = %d ORDER BY nome ASC", $_GET["a"]);

$con->consulta($sql);
if ($con->num_rows() > 0) {
	$d = $con->fetch_array();
?>



<div class="informacoes">
	<p>Lembre-se de que os alunos devem, <strong>obrigatoriamente</strong>, apresentar documento de identificação no dia da prova, como especificado no Regulamento da Olimpíada.</p>
</div>


<form action="#verifica_inscritos" method="post" name="frm_edit">

<fieldset>
	<label for="insc_nome">Nome Completo</label>
	<input type="text" name="insc_nome" id="insc_nome" value="<?php echo $d["nome"]; ?>" size="50" />
</fieldset>

<fieldset>
	<input type="hidden" name="edit_id" value="<?php echo $d["id_aluno"]; ?>">
</fieldset>

<fieldset>
	<label for="insc_serie">Serie</label>
	<select name="insc_serie" id="insc_serie" onChange="muda_serie(this.value)">
		<option value="6EF" <?php if( $d["serie"] == "6EF" ) echo "selected"; ?>>6º ano - Ensino Fundamental</option>
		<option value="7EF" <?php if( $d["serie"] == "7EF" ) echo "selected"; ?>>7º ano - Ensino Fundamental</option>
		<option value="8EF" <?php if( $d["serie"] == "8EF" ) echo "selected"; ?>>8º ano - Ensino Fundamental</option>
		<option value="9EF" <?php if( $d["serie"] == "9EF" ) echo "selected"; ?>>9º ano - Ensino Fundamental</option>
		<option value="1EM" <?php if( $d["serie"] == "1EM" ) echo "selected"; ?>>1º ano - Ensino Médio</option>
		<option value="2EM" <?php if( $d["serie"] == "2EM" ) echo "selected"; ?>>2º ano - Ensino Médio</option>
		<option value="3EM" <?php if( $d["serie"] == "3EM" ) echo "selected"; ?>>3º ano - Ensino Médio</option>
	</select>
	<script>muda_serie($("#insc_serie").val());</script>
</fieldset>

<fieldset>
	<label for="insc_nivel">Nível</label>
	<input type="text" name="insc_nivel" id="insc_nivel" disabled="disabled" value="<?php echo $d["nivel"]; ?>" />
	<input type="hidden" name="insc_hidden" id="insc_hidden" value="<?php echo $d["nivel"]; ?>" />
</fieldset>

<fieldset>
	<label for="insc_local">Local de prova</label>
	<select name="insc_local" id="insc_local">
		<option value="1" <?php if( $d["local"] == 1 ) echo "selected"; ?>>Fortaleza</option>
		<option value="2" <?php if( $d["local"] == 2 ) echo "selected"; ?>>Sobral</option>
		<option value="3" <?php if( $d["local"] == 3 ) echo "selected"; ?>>Juazeiro do Norte</option>
	</select>
</fieldset>

<fieldset>
	<label for="insc_necessidade">Possui alguma necessidade especial?</label>
	<input type="radio" name="insc_necessidade" value="0" id="insc_necessidade_nao" <?php if( $d["necessidade"] == 0 ) echo "checked"; ?>><label style="display:inline-block;" for="insc_necessidade_nao">Não</label><br>
	<input type="radio" name="insc_necessidade" value="1" id="insc_necessidade_sim" <?php if( $d["necessidade"] == 1 ) echo "checked"; ?>><label style="display:inline-block;" for="insc_necessidade_sim">Sim</label>
</fieldset>

<fieldset>
	<input type="submit" name="edit_sbmt" value="Editar" />
</fieldset>

</form>
<?php

} else {
	echo "Você não tem um competidor inscrito com esse id.";
}

?>