<?php 
require_once('../../classe/conexao.php');

class tipos {
	
	/*------------- Funчуo para listar todos os tipos --------------*/
	public function listar() {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select * from ouv_tipo";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {	
			//retorna o resultado se nуo der erro
			return $resultado;
		}
	}
	
	/*------------- Funчуo para buscar a descriчуo de um tipo --------------*/
	public function nome_tipo($tipo) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select tipo from ouv_tipo where id_tipo = ".$tipo;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {	
			//retorna o resultado se nуo der erro
			return mysql_result($resultado,0,'tipo');
		}
	}
	
	/*------------- Funчуo para inicializar os arrays usados no grсfico de pizza --------------*/
	public function inicializar() {
		//criar objeto da classe conexуo
		$conexao = new conexao();

		//buscar os tipos
		$sql = "select * from ouv_tipo order by id_tipo";
		$resultado = $conexao -> query($sql);

		//inicializa os dados e a descricao de cada tipo
		$this -> respostas = array();
		$this -> descricao = array();
		$i=1;
		
		while ($r = mysql_fetch_array($resultado)) {
			$this -> respostas[$i] = 0;
			$this -> descricao[$i] = $r['tipo'];
			$i++;
		}
	}
	
	
}
?>