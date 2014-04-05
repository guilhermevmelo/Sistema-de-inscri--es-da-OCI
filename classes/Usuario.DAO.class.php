<?php
require_once("Conexao.class.php");
require_once("Usuario.class.php");

class UsuarioDAO {
	private $usuario;
	private $conexao;
	
	public function __get($o_que) {
		return $this->$o_que;
	}
	
	public function __construct() {
		$this->conexao = new Conexao();
		$this->usuario = new Usuario();
	}
	
	public function create(Usuario $u) {
		$u->senha = md5($u->senha);
		$u->uid = uniqid("", true);
		$u->nivel_acesso = 1;
		$u->ativado = 0;
		
		$sql = sprintf("INSERT INTO usuarios VALUES (NULL, '%s', '%s', '%s', '%s', '%s', 1, '%s', 0, '%s', %d)", $u->nome, $u->cpf, $u->senha, $u->email, $u->escola, $u->uid, $u->cargo, $u->natureza);
		$this->conexao->consulta($sql);
		
		return $u;
	}
	
	public function read($id) {
		$this->usuario = new Usuario();
		
		$sql = sprintf("SELECT * FROM usuarios WHERE id_usuario = %d", $id);
		$this->conexao->consulta($sql);
		
		while ($d = $this->conexao->fetch_array()) {
			$this->usuario->id_usuario = $d["id_usuario"];
			$this->usuario->senha = $d["senha"];
			$this->usuario->nome = $d["nome"];
			$this->usuario->email = $d["email"];
			$this->usuario->cpf = $d["cpf"];
			$this->usuario->uid = $d["uid"];
			$this->usuario->escola = $d["escola"];
			$this->usuario->cargo = $d["cargo"];
			$this->usuario->natureza = $d["natureza"];
			$this->usuario->ativado = $d["ativado"];
			$this->usuario->nivel_acesso = $d["nivel_acesso"];
		}
		
		return $this->usuario;
	}
	
	public function readByUid($uid) {
		$sql = sprintf("SELECT * FROM usuarios WHERE uid = '%s'", $uid);
		$this->conexao->consulta($sql);
		
		while ($d = $this->conexao->fetch_array()) {
			$this->usuario->id_usuario = $d["id_usuario"];
			$this->usuario->senha = $d["senha"];
			$this->usuario->nome = $d["nome"];
			$this->usuario->email = $d["email"];
			$this->usuario->cpf = $d["cpf"];
			$this->usuario->uid = $d["uid"];
			$this->usuario->escola = $d["escola"];
			$this->usuario->cargo = $d["cargo"];
			$this->usuario->natureza = $d["natureza"];
			$this->usuario->ativado = $d["ativado"];
			$this->usuario->nivel_acesso = $d["nivel_acesso"];
		}
	return $this->usuario;
	}
	
	public function update(Usuario $u) {
		$this->read($u->id_usuario);
		
		$k = false;
		$sql = sprintf("UPDATE usuarios SET ");
		
		if ($this->usuario->nome != $u->nome) {
			$sql .= sprintf("nome = '%s'", $u->nome);
			$k = true;
		}
		
		if ($this->usuario->senha != $u->senha) {
			if ($k)
				$sql .= sprintf(", ");
			
			$sql .= sprintf("senha = '%s'", $u->senha);
			$k = true;
		}
		
		if ($this->usuario->ativado != $u->ativado) {
			if ($k)
				$sql .= sprintf(", ");
			
			$sql .= sprintf("ativado = %d", $u->ativado);
			$k = true;
		}
		
		$sql .= sprintf(" WHERE id_usuario = %d", $u->id_usuario);
		$this->conexao->consulta($sql);
		
		return $u;
	}
	
	public function delete($id) {
		$sql = sprintf("DELETE FROM usuarios WHERE id_usuario = %d", $id);
		if ($this->conexao->consulta($sql)) return true;
		return false;
	}
}

?>