<?php
session_start();
if ($_SESSION["login_oci_si"] != "allow")
	header("Location: home.php");

require_once("../classes/Usuario.DAO.class.php");

$uDAO = new UsuarioDAO();
$u = $uDAO->read($_SESSION["oci_user"]);


if ($u->nivel_acesso > 3) {
	
	$con = new Conexao();
	$sql = sprintf("SELECT * FROM usuarios ORDER BY id_usuario ASC");
	
	$con->consulta($sql);
	
	while ($d = $con->fetch_array()) {
		echo $d["id_usuario"] . " - " . $d["escola"] . " - " . $d["nome"] . ": " . $d["email"] . "<br>";
	}
} else {
	echo "Você não tem permissão de acesso suficiente para visualizar esse conteúdo.";
}
?>