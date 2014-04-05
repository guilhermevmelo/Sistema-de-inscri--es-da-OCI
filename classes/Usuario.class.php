<?php
require_once("Conexao.class.php");

class Usuario {
	private $id_usuario;
	private $senha;
	private $nome;
	private $cpf;
	private $email;
	private $escola;
	private $nivel_acesso;
	private $uid;
	private $ativado;
	private $cargo;
	private $natureza;
	
	
	
	public function __get($o_que) {
		return $this->$o_que;
	}
	
	public function __set($o_que, $valor) {
		$this->$o_que = $valor;
	}
}

?>