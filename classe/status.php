<?php
require_once ('conexao.php');
class status {
	
	//listar todos os status
	public function listar() {
		$conexao = new conexao();
		
		$sql = "select * from ouv_status";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//descricao de um status
	public function desc_status($status) {
		$conexao = new conexao();
		
		$sql = "select ouv_status.status 
					from ouv_status 
						where ouv_status.id_status = ".$status;
		$resultado = $conexao -> query($sql);
		
		return mysql_result($resultado,0,'status');
	}
	
	/*------------- Função para inicializar os arrays usados no gráfico de pizza --------------*/
	public function inicializar() {
		//criar objeto da classe conexão
		$conexao = new conexao();

		//buscar os assuntos
		$sql = "select * from ouv_status";
		$resultado = $conexao -> query($sql);

		//inicializa os dados e a descricao de cada assunto
		$this -> respostas = array();
		$this -> descricao = array();
		
		while ($r = mysql_fetch_array($resultado)) {
			$this -> respostas[$r['status']] = 0;
			$this -> descricao[$r['status']] = $r['status'];
		}
	}
	
}
?>