<?php 
require_once('../conexao.php');

class tipos {
	
	/*------------- Fun��o para listar todos os tipos --------------*/
	public function listar() {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select * from ouv_tipo";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {	
			//retorna o resultado se n�o der erro
			return $resultado;
		}
	}
	
	/*------------- Fun��o para buscar a descri��o de um tipo --------------*/
	public function nome_tipo($tipo) {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select tipo from ouv_tipo where id_tipo = ".$tipo;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {	
			//retorna o resultado se n�o der erro
			return mysql_result($resultado,0,'tipo');
		}
	}
	
	/*------------- Fun��o para inicializar os arrays usados no gr�fico de pizza --------------*/
	public function inicializar() {
		//criar objeto da classe conex�o
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