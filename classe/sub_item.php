<?php
class sub_item {
	
	//incluir dados de um subitem
	public function incluir($valores) {
		require_once('conexao.php');
		$conexao = new conexao();
		
		$sql = "insert into ouv_subitem (subitem, id_entidade, id_assunto) 
				values ('".$valores['descricao']."','".$_SESSION['entidade']."',".$valores['assunto'].")";
		$resultado = $conexao -> query($sql);
		
		/*if ($resultado) {
			session_start();
			//ultim subitem inserido
			$ultimo = mysql_insert_id();
			//numero de registros no array de assuntos
			$max = count($valores['assunto']);
			
			if ($max > 0) {
				//assuntos do subitem para uma entidade
				$sql = "insert into ouv_assunto_subitem (id_assunto, id_subitem, ativo)
						values ";
				for ($i=0;$i<$max;$i++) {
					if ($i < $max-1) {
						$sql .= "(".$valores['assunto'][$i].", ".$ultimo.", 1),";
					}
					else {
						$sql .= "(".$valores['assunto'][$i].", ".$ultimo.", 1)";
					}
				}
				
				$resultado = $conexao -> query($sql);
			}
		}*/
	}
	
	//listar subitens de uma entidade
	public function listar_subitens($entidade) {
		require_once('conexao.php');
		$conexao = new conexao();
		
		$sql = "select ouv_subitem.*
					from ouv_subitem
						where ouv_subitem.id_entidade = ".$entidade."
							group by ouv_subitem.id_subitem";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//listar subitens de uma diretoria
	public function listar_subitensdir($diretoria) {
		require_once('conexao.php');
		$conexao = new conexao();
		
		$sql = "select ouv_subitem.*
					from ouv_subitem
						where ouv_subitem.id_diretoria = ".$diretoria."
							group by ouv_subitem.id_subitem";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//detalhes de um subitem
	public function detalhes($sub) {
		require_once('conexao.php');
		$conexao = new conexao();
		
		$sql = "select ouv_subitem.*
					from ouv_subitem
						where ouv_subitem.id_subitem = ".$sub;
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//assuntos de um subitem
	public function assuntos($sub) {
		require_once('conexao.php');
		$conexao = new conexao();
		
		$sql = "select ouv_assunto_subitem.id_assunto
					from ouv_subitem
						inner join ouv_assunto_subitem on ouv_assunto_subitem.id_subitem = ouv_subitem.id_subitem
						inner join ouv_assunto on ouv_assunto.id_assunto = ouv_assunto_subitem.id_assunto
							where ouv_assunto_subitem.id_subitem = ".$sub."
							and ativo = 1";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//subitens de um assunto
	/*public function subitens($assunto) {
		require_once('conexao.php');
		$conexao = new conexao();
		session_start();
		
		/*$sql = "select ouv_subitem.* 
					from ouv_subitem
						inner join ouv_assunto_subitem on ouv_subitem.id_subitem = ouv_assunto_subitem.id_subitem
						inner join ouv_assunto on ouv_assunto_subitem.id_assunto = ouv_assunto.id_assunto
							where ouv_assunto.id_assunto = ".$assunto."
							and ouv_subitem.id_entidade = ".$_SESSION['entidade']."
							and ouv_assunto_subitem.ativo = 1";
		
		$sql = "select ouv_subitem.* 
					from ouv_subitem
						where ouv_subitem.id_entidade = ".$_SESSION['entidade']."
						and ouv_subitem.id_assunto = ".$assunto."
						and ouv_subitem.ativo = 1";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}*/
	
	//editar um subitem
	public function editar($descricao,$id,$ativo,$assunto) {
		require_once('conexao.php');
		$conexao = new conexao();
		
		$sql = "update ouv_subitem set 
					subitem = '".$descricao."',
					id_assunto = ".$assunto.",
					ativo = ".$ativo."
						where id_subitem = ".$id;
		$conexao -> query($sql);
		
		/*
		//desativar os subitens
		$sql = "update ouv_assunto_subitem 
					set ativo = 0
						where id_subitem = ".$id;
		$conexao -> query($sql);
		
		//inserir ou ativar assuntos selecionados para o subitem
		session_start();
		//numero de registros no array de assuntos
		$max = count($assuntos);
		
		if ($max > 0) {
			//assuntos do subitem para uma entidade
			$sql = "insert into ouv_assunto_subitem (id_assunto, id_subitem, ativo)
					values ";
			for ($i=0;$i<$max;$i++) {
				if ($i < $max-1) {
					$sql .= "(".$assuntos[$i].", ".$id.", 1),";
				}
				else {
					$sql .= "(".$assuntos[$i].", ".$id.", 1)";
				}
			}
			
			$sql .= "  on duplicate key update ativo = 1";
			$conexao -> query($sql);
		}*/
	}
	
}
?>