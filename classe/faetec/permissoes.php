<?php
require_once('../conexao.php');

class permissoes {

	/*------------- Fun��o para incluir dados no banco --------------*/
	//$permissao (1 => Visualizar Tudo, 2 => Visualizar Status)
	public function incluir($usuario,$segmento,$permissao) {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//inserir, se houver duplicacao atualiza a permiss�o
		$sql = "insert into permissoes (usuario_id,segmento_id,permissao) 
				values ('".$usuario."','".$segmento."','".$permissao."')
				on duplicate key update permissao = '".$permissao."'";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se n�o der erro
			return 1;
		}
	}
	
	/*------------- Fun��o para listar todos as permissoes do usuario --------------*/
	public function listar($usuario) {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select permissoes.id, segmentos.nome, if(permissao = 1, 'Visualizar Tudo', 'Visualizar Status') as permissao
					from permissoes 
						left join segmentos on segmentos.id = permissoes.segmento_id
							where usuario_id = ".$usuario."
								order by segmentos.nome";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se n�o der erro
			return $resultado;
		}
	}
	
	/*------------- Fun��o para excluir uma permiss�o do usuario --------------*/
	public function excluir($id) {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//excluir
		$sql = "delete from permissoes where id = ".$id;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se n�o der erro
			return 1;
		}
	}
}
?>