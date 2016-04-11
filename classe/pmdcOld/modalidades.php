<?php 
require_once('../conexao.php');

class modalidades {
	
	/*------------- Fun��o para listar todas as modalidades --------------*/
	public function listar() {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select * from ouv_modalidade";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {	
			//retorna o resultado se n�o der erro
			return $resultado;
		}
	}
	
	/*------------- Fun��o para inicializar os arrays usados no gr�fico de pizza --------------*/
	public function inicializar() {
		//criar objeto da classe conex�o
		$conexao = new conexao();

		//buscar os assuntos
		$sql = "select * from ouv_modalidade";
		$resultado = $conexao -> query($sql);

		//inicializa os dados e a descricao de cada assunto
		$this -> respostas = array();
		$this -> descricao = array();
		
		while ($r = mysql_fetch_array($resultado)) {
			$this -> respostas[$r['modalidade']] = 0;
			$this -> descricao[$r['modalidade']] = $r['modalidade'];
		}
	}
	
}