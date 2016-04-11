<?php
require_once('conexao.php');

class entidades {

	/*------------- Funчуo para incluir dados no banco --------------*/
	public function incluir($valores) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		//inserir
		$sql = "insert into ouv_entidade (entidade, id_entidade_pai, descricao) 
				values ('".$valores['nome']."','".$_SESSION['entidade']."','".$valores['descricao']."')";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se nуo der erro
			return 1;
		}
	}
	
	/*------------- Funчуo para listar todas as entidades --------------*/
	//$usuario => se for informado lista apenas as entidades que o usuario pode acessar
	//$entidade_usuario => se for informado nуo lista a entidade do usuario
/*	public function listar($entidade_usuario=0) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		//usuario informado
		if ($usuario != 0) {
			$comp = "inner join ouv_usuario on (ouv_usuario.id_entidade = ouv_entidade.id_entidade or ouv_usuario.id_entidade = ouv_entidade.id_entidade_pai)
						where ouv_usuario.id_usuario = ".$usuario;
						
			//excluir entidade do usuario
			if ($entidade_usuario != 0) {
				$comp = "and id_entidade_pai = ".$entidade_usuario;
			}
		}
		//usuario nao informado
		else {
			//excluir entidade do usuario
			if ($entidade_usuario != 0) { 
				$comp = "where id_entidade = ".$entidade_usuario." or id_entidade_pai = ".$entidade_usuario;
			}
		}
		
		//faz a busca 
	    $sql = "select ouv_entidade.* from ouv_entidade order by entidade";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return $resultado;
		}
	}
	*/
	
	public function listar($entidade,$ativo=0) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		$comp = '';
		
		if ($entidade != '') {
			$comp = " where (id_entidade = ".$entidade." or id_entidade_pai = ".$entidade.")";
			if ($ativo == 1) {
				$comp .= " and ativo = 1";
			}
		}
		
		$sql = "select * from ouv_entidade ".$comp." order by entidade";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
		
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return $resultado;
		}
	}
	
	public function listardir($entidade_usuario=0) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		//usuario informado
		/*if ($usuario != 0) {
			$comp = "inner join ouv_usuario on (ouv_usuario.id_entidade = ouv_entidade.id_entidade or ouv_usuario.id_entidade = ouv_entidade.id_entidade_pai)
						where ouv_usuario.id_usuario = ".$usuario;
						
			//excluir entidade do usuario
			if ($entidade_usuario != 0) {
				$comp = "and id_entidade_pai = ".$entidade_usuario;
			}
		}
		//usuario nao informado
		else {*/
			//excluir entidade do usuario
			if ($entidade_usuario != 0) { 
				$comp = "where id_entidade = ".$entidade_usuario." or id_entidade_pai = ".$entidade_usuario;
			}
		//}
		
		//faz a busca 
	    $sql = "SELECT e.id_entidade, e.entidade FROM ouv_entidade as e
				INNER JOIN ouv_entidade_diretoria as r ON r.id_entidade = e.id_entidade
				INNER JOIN ouv_diretoria as d ON r.id_diretoria = d.id_diretoria
				AND d.id_diretoria = 20 
				GROUP BY r.id";
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
		
		$comp = '';
		
		if ($id != ''){
			$comp = " where id_entidade = ".$id;
		}
		else {
			$comp = " where id_entidade >= 0";
		}
		
		//faz a busca
		$sql = "select * from ouv_entidade ".$comp;
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
		$sql = "update ouv_entidade set 
					entidade = '".$valores['nome']."', 
					descricao = '".$valores['descricao']."',
					ativo = ".$valores['ativo']."
						where id_entidade = ".$valores['entidade'];
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se nуo der erro
			return 1;
		}
	}
	
	/*------------- Funчуo para contar o numero de mensagens para uma entidade --------------*/
	//$datas => complemento para o sql limitar a data inicial e final
	public function contar($entidade,$datas='',$status='',$tipo='',$subitem='') {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		session_start();
		
		if ($entidade != ''){
			$comp = " where ouv_processo.id_entidade = ".$entidade;
		}
		else{
			$comp = " where ouv_processo.id_entidade >= 0 ";
		}
		
		if ($status != '') {
			$comp .= " and ouv_ouvidoria.id_status_atual = ".$status;
		}
		
		if ($tipo != '') {
			$comp .= " and ouv_ouvidoria.id_tipo_usuario = ".$tipo;
		}
		
		if ($subitem != '') {
			$comp .= " and ouv_ouvidoria.id_subitem = ".$subitem;
		}
	
		//faz a busca 
		
		$sql = "select id_processo
					from ouv_processo
						inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
						inner join ouv_entidade on ouv_processo.id_entidade = ouv_entidade.id_entidade"
						.$comp.$datas;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return mysql_num_rows($resultado);
		}
	}

	/*------------- Funчуo para inicializar os arrays usados no grсfico de pizza --------------*/
	public function inicializar() {
		//criar objeto da classe conexуo
		$conexao = new conexao();

		//buscar as entidades
		$sql = "select distinct ouv_entidade.id_entidade, entidade from ouv_processo
					inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade 
						where (ouv_processo.id_entidade in
						(select ouv_entidade.id_entidade from ouv_entidade where id_entidade = ".$_SESSION['entidade']." or id_entidade_pai = ".$_SESSION['entidade']."))
							order by ouv_entidade.id_entidade";
		$resultado = $conexao -> query($sql);
				
		//inicializa os dados e a descricao de cada entidades
		$this -> respostas = array();
		$this -> descricao = array();
		$i=1;
		
		while ($r = mysql_fetch_array($resultado)) {
			$this -> respostas[$r['id_entidade']] = 0;
			$this -> descricao[$r['id_entidade']] = $r['entidade'];
			$i++;
		}
	}
	
	public function excluir($id) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		//excluir
		$sql = "delete from ouv_entidade where id_entidade = ".$id;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			return 1;
		}
	}
	
										/*------------- utilizado no backup do sistema ----------------------------------------------------*/
	
	/*------------- Funчуo para inicializar os arrays usados no grсfico de pizza --------------*/
	public function inicializar_backup() {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		session_start();

		//buscar as entidades
		$sql = "select distinct ouv_entidade.id_entidade, entidade from _processo".$_SESSION['periodo']."
					inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade 
						where (_processo".$_SESSION['periodo'].".id_entidade in
						(select ouv_entidade.id_entidade from ouv_entidade where id_entidade = ".$_SESSION['entidade']." or id_entidade_pai = ".$_SESSION['entidade']."))
							order by ouv_entidade.id_entidade";
		$resultado = $conexao -> query($sql);
				
		//inicializa os dados e a descricao de cada entidade
		$this -> respostas = array();
		$this -> descricao = array();
		$i=1;
		
		while ($r = mysql_fetch_array($resultado)) {
			$this -> respostas[$r['id_entidade']] = 0;
			$this -> descricao[$r['id_entidade']] = $r['entidade'];
			$i++;
		}
	}
	
	/*------------- Funчуo para contar o numero de mensagens para uma entidade --------------*/
	//$datas => complemento para o sql limitar a data inicial e final
	public function contar_backup($entidade,$datas='',$status='', $tipo='') {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		session_start();
		
		if ($status != '') {
			$comp = " and _ouvidoria".$_SESSION['periodo'].".id_status_atual = ".$status;
		}
		
		if ($tipo != '') {
			$comp .= " and _ouvidoria".$_SESSION['periodo'].".id_tipo_usuario = ".$tipo;
		}
		
		//faz a busca
		$sql = "select id_processo from _processo".$_SESSION['periodo']."
					inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
						where _processo".$_SESSION['periodo'].".id_entidade = ".$entidade."
								and	form = ".$_SESSION['entidade'].$comp.$datas."
								and _processo".$_SESSION['periodo'].".ativo = 1";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return mysql_num_rows($resultado);
		}
	}
	
}
?>