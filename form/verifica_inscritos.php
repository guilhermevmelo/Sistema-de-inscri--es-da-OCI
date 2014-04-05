<?php
session_start();
if ($_SESSION["login_oci_si"] != "allow")
	header("Location: home.php");

require_once("../classes/Usuario.DAO.class.php");
require_once("../classes/Aluno.DAO.class.php");

$uDAO = new UsuarioDAO();
$u = $uDAO->read($_SESSION["oci_user"]);

$con = new Conexao();

$sql = sprintf("SELECT * FROM alunos WHERE nivel = 1 AND tutor = %d ORDER BY nome ASC", $_SESSION["oci_user"]);
if ($u->nivel_acesso > 3)
	$sql = sprintf("SELECT * FROM alunos, usuarios WHERE alunos.nivel = 1  AND alunos.tutor = usuarios.id_usuario ORDER BY alunos.nome ASC");

$con->consulta($sql);
echo "<table>";
echo "<tr><th colspan=\"". ($u->nivel_acesso > 3 ? 4 : 3) ."\">Nível 1".($u->nivel_acesso > 3 ? " - ".$con->num_rows()." inscritos" : "")."</th></tr>\n";
if ($con->num_rows() > 0) {
	while ($d = $con->fetch_array()) {
		//print_r($d);
		switch($d["local"]){
			case 1: $l = "Fortaleza";break;
			case 2: $l = "Sobral";break;
			case 3: $l = "Juazeiro do Norte";break;
		}
		
		echo "<tr><td style=\"width:90px;\"><a href=\"action.php?q=e&a=".$d["id_aluno"]." \">excluir</a>&nbsp;|&nbsp;<a href=\"#editar_competidor?a=".$d["id_aluno"]."\">editar</a></td><td>" . ($d["necessidade"] ? "<img src=\"imagens/weelchair.png\">&nbsp" : "") . $d[1] . "</td><td>" . $d["serie"] . "</td>". ($u->nivel_acesso > 3 ? "<td>".$d["escola"]."</td>" : "") ."<td>".$l."</td></tr>";
	}
} else {
	echo "<tr><td colspan=\"3\">Ainda não há competidores inscritos nesse nível.</td></tr>";
}
echo "</table>";

$sql = sprintf("SELECT * FROM alunos WHERE nivel = 2 AND tutor = %d ORDER BY nome ASC", $_SESSION["oci_user"]);
if ($u->nivel_acesso > 3)
	$sql = sprintf("SELECT * FROM alunos, usuarios WHERE alunos.nivel = 2  AND alunos.tutor = usuarios.id_usuario ORDER BY alunos.nome ASC");
$con->consulta($sql);
echo "<table>";
echo "<tr><th colspan=\"3\">Nível 2".($u->nivel_acesso > 3 ? " - ".$con->num_rows()." inscritos" : "")."</th></tr>\n";
if ($con->num_rows() > 0) {
	while ($d = $con->fetch_array()) {
		switch($d["local"]){
			case 1: $l = "Fortaleza";break;
			case 2: $l = "Sobral";break;
			case 3: $l = "Juazeiro do Norte";break;
		}
		echo "<tr><td style=\"width:90px;\"><a href=\"action.php?q=e&a=".$d["id_aluno"]." \">excluir</a>&nbsp;|&nbsp;<a href=\"#editar_competidor?a=".$d["id_aluno"]."\">editar</a></td><td>" . ($d["necessidade"] ? "<img src=\"imagens/weelchair.png\">&nbsp" : "") . $d[1] . "</td><td>" . $d["serie"] . "</td>". ($u->nivel_acesso > 3 ? "<td>".$d["escola"]."</td>" : "") ."<td>".$l."</td></tr>";
	}
} else {
	echo "<tr><td colspan=\"3\">Ainda não há competidores inscritos nesse nível.</td></tr>";
}

$sql = sprintf("SELECT * FROM alunos WHERE nivel = 3  AND tutor = %d ORDER BY nome ASC", $_SESSION["oci_user"]);
if ($u->nivel_acesso > 3)
	$sql = sprintf("SELECT * FROM alunos, usuarios WHERE alunos.nivel = 3  AND alunos.tutor = usuarios.id_usuario ORDER BY alunos.nome ASC");
$con->consulta($sql);
echo "<table>";
echo "<tr><th colspan=\"3\">Nível 3".($u->nivel_acesso > 3 ? " - ".$con->num_rows()." inscritos" : "")."</th></tr>\n";
if ($con->num_rows() > 0) {
	while ($d = $con->fetch_array()) {
		switch($d["local"]){
			case 1: $l = "Fortaleza";break;
			case 2: $l = "Sobral";break;
			case 3: $l = "Juazeiro do Norte";break;
		}
		echo "<tr><td style=\"width:90px;\"><a href=\"action.php?q=e&a=".$d["id_aluno"]." \">excluir</a>&nbsp;|&nbsp;<a href=\"#editar_competidor?a=".$d["id_aluno"]."\">editar</a></td><td>" . ($d["necessidade"] ? "<img src=\"imagens/weelchair.png\">&nbsp" : "") . $d[1] . "</td><td>" . $d["serie"] . "</td>". ($u->nivel_acesso > 3 ? "<td>".$d["escola"]."</td>" : "") ."<td>".$l."</td></tr>";
	}
} else {
	echo "<tr><td colspan=\"3\">Ainda não há competidores inscritos nesse nível.</td></tr>";
}

?>