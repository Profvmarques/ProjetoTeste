<?php
require_once('../../classe/conexao.php');

class entidades {

	/*------------- Funчуo para incluir dados no banco --------------*/
	public function incluir($valores) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		//inserir
		$sql = "insert into ouv_entidade (entidade, id_entidade_pai, descricao) 
				values ('".$valores['nome']."','".$valores['pai']."','".$valores['descricao']."')";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se nуo der erro
			return 1;
		}
	}
	
	public function listar_dir() {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		//faz a busca
		$sql = "SELECT e.id_entidade, e.entidade FROM ouv_entidade as e
				INNER JOIN ouv_entidade_diretoria as r ON r.id_entidade = e.id_entidade
				INNER JOIN ouv_diretoria as d ON r.id_diretoria = d.id_diretoria
				AND d.id_diretoria = ".$id." 
				GROUP BY r.id";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return $resultado;
		}
	}
	
	/*------------- Funчуo para listar todas as entidades --------------*/
	//$usuario => se for informado lista apenas as entidades que o usuario pode acessar
	//$entidade_usuario => se for informado nуo lista a entidade do usuario
	public function listar($usuario=0, $entidade_usuario=0) {
			//criar objeto da classe conexуo
		$conexao = new conexao();
		
		//faz a busca
		$sql = "SELECT * FROM ouv_entidade";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return $resultado;
		}
	}
	
	
	
	
	
	public function listar_desig($entidade) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		$sql = "select * from ouv_entidade where id_entidade not in(select id_entidade from ouv_entidade_diretoria) order by entidade;";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
		
		
		//faz a busca
		$sql = "select * from ouv_entidade where id_entidade not in(select id_entidade from ouv_entidade_diretoria) order by entidade;";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return $resultado;
		}
	}
	
		public function listar_alt($entidade) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		$sql = "select * from ouv_entidade where id_entidade in(select id_entidade from ouv_entidade_diretoria) order by entidade;";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
		
		
		//faz a busca
		$sql = "select * from ouv_entidade where id_entidade in(select id_entidade from ouv_entidade_diretoria) order by entidade;";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return $resultado;
		}
	}
	
	/*------------- Funчуo para buscar os dados de uma entidade --------------*/
	public function detalhes($id) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		if ($id != '')
			$comp = " where id_entidade = ".$id;
		else
			$comp = " where id_entidade > 0 ";
		
		//faz a busca
		$sql = "select * from ouv_entidade".$comp; 
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return $resultado;
		}
	}
	
	/*------------- Funчуo para alterar dados de um entidade --------------*/
	public function alterar($valores) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		//faz a alteracao
		$sql = "update ouv_entidade set entidade = '".$valores['nome']."', id_entidade_pai = '".$valores['pai']."', descricao = '".$valores['descricao']."' 
				where id_entidade = ".$valores['entidade'];
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se nуo der erro
			return 1;
		}
	}
	
	/*------------- Funчуo para contar o numero de mensagens para um entidade --------------*/
	//$datas => complemento para o sql limitar a data inicial e final
	public function contar($entidade,$datas='') {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		if ($entidade != '')
			$comp = "where entidade_id = ".$entidade;
		else
			$comp = "where entidade_id > 0";
			
		
		//faz a busca
		$sql = "select id from ouvidoria".$comp.$datas;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return mysql_num_rows($resultado);
		}
	}

}
?>