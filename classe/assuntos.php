<?php 
require_once('../../classe/conexao.php');

class assuntos {
	
	/*------------- Função para listar todos os assuntos --------------*/
	public function listar() {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select * from ouv_assunto";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {	
			//retorna o resultado se não der erro
			return $resultado;
		}
	}
	
	/*------------- Função para buscar a descrição de um assunto --------------*/
	public function nome_assunto($assunto) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select assunto from ouv_assunto where id_assunto = ".$assunto;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {	
			//retorna o resultado se não der erro
			return mysql_result($resultado,0,'assunto');
		}
	}
	
	/*------------- Função para inicializar os arrays usados no gráfico de pizza --------------*/
	public function inicializar() {
		//criar objeto da classe conexão
		$conexao = new conexao();

		//buscar os assuntos
		$sql = "select * from ouv_assunto order by id_assunto";
		$resultado = $conexao -> query($sql);
				
		//inicializa os dados e a descricao de cada assunto
		$this -> respostas = array();
		$this -> descricao = array();
		$i=1;
		
		while ($r = mysql_fetch_array($resultado)) {
		//for ($i=1;$i<mysql_num_rows($resultado);$i++) {
			$this -> respostas[$i] = 0;
			$this -> descricao[$i] = $r['assunto'];
			$i++;
		}
	}
	
	
}
?>