<?php 
require_once('../conexao.php');

class tipos {
	
	/*------------- Função para listar todos os tipos --------------*/
	public function listar() {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select * from ouv_tipo";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {	
			//retorna o resultado se não der erro
			return $resultado;
		}
	}
	
	/*------------- Função para buscar a descrição de um tipo --------------*/
	public function nome_tipo($tipo) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select tipo from ouv_tipo where id_tipo = ".$tipo;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {	
			//retorna o resultado se não der erro
			return mysql_result($resultado,0,'tipo');
		}
	}
	
	/*------------- Função para inicializar os arrays usados no gráfico de pizza --------------*/
	public function inicializar() {
		//criar objeto da classe conexão
		$conexao = new conexao();

		//buscar os tipos
		$sql = "select * from ouv_tipo";
		$resultado = $conexao -> query($sql);

		//inicializa os dados e a descricao de cada tipo
		$this -> respostas = array();
		$this -> descricao = array();
		
		while ($r = mysql_fetch_array($resultado)) {
			$this -> respostas[$r['id_tipo']] = 0;
			$this -> descricao[$r['id_tipo']] = $r['tipo'];
		}
	}
	
}