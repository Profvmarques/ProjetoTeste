<?php 
require_once('../../classe/conexao.php');

class canais {
	
	/*------------- Fun��o para listar todos os canais --------------*/
	public function listar() {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select * from ouv_canal";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {	
			//retorna o resultado se n�o der erro
			return $resultado;
		}
	}
	
	/*------------- Fun��o para buscar o nome de um canal --------------*/
	public function nome_canal($canal) {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select canal from ouv_canal where id_canal=".$canal;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {	
			//retorna o resultado se n�o der erro
			return mysql_result($resultado,0,'canal');
		}
	}
	
	/*------------- Fun��o para inicializar os arrays usados no gr�fico de pizza --------------*/
	public function inicializar() {
		//criar objeto da classe conex�o
		$conexao = new conexao();

		//buscar os canais
		$sql = "select * from ouv_canal";
		$resultado = $conexao -> query($sql);
				
		//inicializa os dados e a descricao de cada canal
		$this -> respostas = array();
		$this -> descricao = array();
		
		while ($r = mysql_fetch_array($resultado)) {
		//for ($i=1;$i<mysql_num_rows($resultado);$i++) {
			$this -> respostas[$r['id_canal']] = 0;
			$this -> descricao[$r['id_canal']] = $r['canal'];
		}
	}
}
?>