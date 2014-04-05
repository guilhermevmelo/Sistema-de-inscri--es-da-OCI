<?php

class Conexao {
	private $conexao;
	private $consulta;
	
	public function __construct() {
		$this->conexao = mysql_connect("localhost", "ociorgbr", "8egSn50eA5", true);
		//$this->conexao = mysql_connect("localhost", "root", "iqh5riv9", true);
		
		if($this->conexao)
			mysql_select_db("ociorgbr_oci", $this->conexao);
			//mysql_select_db("oci", $this->conexao);
	}
	
	public function __destruct() {
		mysql_close($this->conexao);
	}
	
	public function consulta($sql) {
		$this->consulta = mysql_query($sql, $this->conexao);
	}
	
	public function num_rows() {
		return mysql_num_rows($this->consulta);
	}
	
	public function fetch_array() {
		return mysql_fetch_array($this->consulta);
	}
}

?>