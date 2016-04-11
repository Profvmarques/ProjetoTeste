<?php 
require_once('/home/pmdc/public_html/portal/ouvidoria/classe/conexao.php');

class assuntos {
	
	/*------------- Função para listar todos os assuntos --------------*/
	public function listar($ativo=0) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$comp = '';
		if ($ativo == 1) {
			$comp = " where ativo = 1";
		}
		
		//faz a busca
		$sql = "select * from ouv_assunto".$comp." order by assunto";
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
		
		while ($r = mysql_fetch_array($resultado)) {
			$this -> respostas[$r['assunto']] = 0;
			$this -> descricao[$r['assunto']] = $r['assunto'];
		}
	}
	
}