<?php 
require_once('../../classe/conexao.php');

class assuntos {
	
	/*------------- Fun��o para listar todos os assuntos --------------*/
	public function listar() {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select * from ouv_assunto";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {	
			//retorna o resultado se n�o der erro
			return $resultado;
		}
	}
	
	/*------------- Fun��o para buscar a descri��o de um assunto --------------*/
	public function nome_assunto($assunto) {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select assunto from ouv_assunto where id_assunto = ".$assunto;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {	
			//retorna o resultado se n�o der erro
			return mysql_result($resultado,0,'assunto');
		}
	}
	
	/*------------- Fun��o para inicializar os arrays usados no gr�fico de pizza --------------*/
	public function inicializar() {
		//criar objeto da classe conex�o
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