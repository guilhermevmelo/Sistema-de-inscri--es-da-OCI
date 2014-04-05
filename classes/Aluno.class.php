<?php

class Aluno {
	private $id_aluno;
	private $nome;
	private $data_nascimento;
	private $serie;
	private $nivel;
	private $tutor;
	
	public function __get($o_que) {
		return $this->$o_que;
	}
	
	public function __set($o_que, $valor) {
		$this->$o_que = $valor;
	}
	 
}