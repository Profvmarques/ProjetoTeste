<?php
class tipo_usuario {
	
	//listar os tipos de usuarios
	public function listar() {
		require_once('conexao.php');
		$conexao = new conexao();
		
		$sql = "select * from ouv_tipo_usuario order by id_tipo_usuario";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//descricao de um tipo de usuario
	public function desc_tipo($tipo) {
		require_once('conexao.php');
		$conexao = new conexao();
		
		$sql = "select descricao from ouv_tipo_usuario where id_tipo_usuario = ".$tipo;
		$resultado = $conexao -> query($sql);
		
		return mysql_result($resultado,0,'descricao');
	}
	
	/*------------- Função para inicializar os arrays usados no gráfico de pizza --------------*/
	public function inicializar() {
		//criar objeto da classe conexão
		$conexao = new conexao();

		//buscar os assuntos
		$sql = "select * from ouv_tipo_usuario";
		$resultado = $conexao -> query($sql);

		//inicializa os dados e a descricao de cada assunto
		$this -> respostas = array();
		$this -> descricao = array();
		
		while ($r = mysql_fetch_array($resultado)) {
			$this -> respostas[$r['descricao']] = 0;
			$this -> descricao[$r['descricao']] = $r['descricao'];
		}
	}
	
}
?>