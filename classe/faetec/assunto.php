<?php 
require_once('/home/pmdc/public_html/portal/ouvidoria/classe/conexao.php');
class assunto {

	/*------------- Fun��o para incluir dados no banco --------------*/
	public function incluir($valores) {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//inserir
		$sql = "insert into ouv_assunto (assunto, ativo) 
				values ('".$valores['assunto']."','".$valores['ativo']."')";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se n�o der erro
			return 1;
		}
	}
	
	/*------------- Fun��o para alterar dados de um assunto --------------*/
	public function alterar($valores) {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//faz a alteracao
		$sql = "update ouv_assunto set
					assunto = '".$valores['assunto']."', ativo = '".$valores['ativo']."'
						where id_assunto = ".$valores['id_assunto'];
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se n�o der erro
			return 1;
		}
	}
	
	/*------------- Fun��o para listar todos os assunto --------------*/
	public function listar() {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select * from ouv_assunto order by assunto";
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
	
	/*------------- Fun��o para buscar os dados de um assunto --------------*/
	public function detalhes($id) {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		if ($id != '')
			$comp = " where id_assunto = ".$id;
		else
			$comp = " where id_assunto > 0 ";
		
		//faz a busca
		$sql = "select * from ouv_assunto".$comp; 
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

		//buscar os tipos
		$sql = "select * from ouv_assunto order by id_assunto";
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