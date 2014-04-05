<?php
require_once("Conexao.class.php");
require_once("Usuario.class.php");
require_once("Aluno.class.php");

class AlunoDAO {
	private $tutor;
	private $aluno;
	private $conexao;
	
	public function __get($o_que) {
		return $this->$o_que;
	}
	
	public function __construct() {
		$this->conexao = new Conexao();
		$this->aluno = new Aluno();
	}
	
	public function create(Aluno $u) {
		$sql = sprintf("INSERT INTO alunos VALUES (NULL, '%s', NULL, '%s', %d, %d, %d, %d)", $u->nome/*, $u->data_nascimento*/, $u->serie, $u->nivel, $u->tutor, $u->local, $u->necessidade);
		
		$this->conexao->consulta($sql);
		
		return $u;
	}
	
	public function read($id) {
		$this->aluno = new Aluno();
		
		$sql = sprintf("SELECT * FROM alunos WHERE id_aluno = %d", $id);
		$this->conexao->consulta($sql);
		
		while ($d = $this->conexao->fetch_array()) {
			$this->aluno->id_aluno = $d["id_aluno"];
			$this->aluno->nome = $d["nome"];
			$this->aluno->data_nascimnto = $d["data_nascimnto"];
			$this->aluno->serie = $d["serie"];
			$this->aluno->nivel = $d["nivel"];
			$this->aluno->tutor = $d["tutor"];
			$this->aluno->local = $d["local"];
			$this->aluno->necessidade = $d["necessidade"];
		}
		
		return $this->aluno;
	}
	
	/*Não usar a funcao update em Alunos*/
	public function update(Aluno $u) {
		$this->read($u->id_aluno);
		
		$k = false;
		$sql = sprintf("UPDATE alunos SET ");
		
		if ($this->aluno->nome != $u->nome) {
			$sql .= sprintf("nome = '%s'", $u->nome);
			$k = true;
		}
		
		if ($this->aluno->serie != $u->serie) {
			if ($k)
				$sql .= sprintf(", ");
			
			$sql .= sprintf("serie = '%s'", $u->serie);
			$k = true;
		}
		
		if ($this->aluno->nivel != $u->nivel) {
			if ($k)
				$sql .= sprintf(", ");
			
			$sql .= sprintf("nivel = '%d'", $u->nivel);
			$k = true;
		}
		
		if ($this->aluno->local != $u->local) {
			if ($k)
				$sql .= sprintf(", ");
			
			$sql .= sprintf("local = '%d'", $u->local);
			$k = true;
		}
		
		if ($this->aluno->necessidade != $u->necessidade) {
			if ($k)
				$sql .= sprintf(", ");
			
			$sql .= sprintf("necessidade = '%d'", $u->necessidade);
			$k = true;
		}
		$sql .= sprintf(" WHERE id_aluno = %d", $u->id_aluno);
		
		$this->conexao->consulta($sql);
		
		return $u;
	}
	
	public function delete($id) {
		$sql = sprintf("DELETE FROM alunos WHERE id_aluno = %d", $id);
		if ($this->conexao->consulta($sql)) return true;
		return false;
	}
}

?>