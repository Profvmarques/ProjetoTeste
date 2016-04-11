<?php
require_once('../conexao.php');

class permissoes {

	/*------------- Funчуo para incluir dados no banco --------------*/
	//$permissao (1 => Visualizar Tudo, 2 => Visualizar Status)
	public function incluir($usuario,$segmento,$permissao) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		//inserir, se houver duplicacao atualiza a permissуo
		$sql = "insert into permissoes (usuario_id,segmento_id,permissao) 
				values ('".$usuario."','".$segmento."','".$permissao."')
				on duplicate key update permissao = '".$permissao."'";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se nуo der erro
			return 1;
		}
	}
	
	/*------------- Funчуo para listar todos as permissoes do usuario --------------*/
	public function listar($usuario) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select permissoes.id, segmentos.nome, if(permissao = 1, 'Visualizar Tudo', 'Visualizar Status') as permissao
					from permissoes 
						left join segmentos on segmentos.id = permissoes.segmento_id
							where usuario_id = ".$usuario."
								order by segmentos.nome";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return $resultado;
		}
	}
	
	/*------------- Funчуo para excluir uma permissуo do usuario --------------*/
	public function excluir($id) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		//excluir
		$sql = "delete from permissoes where id = ".$id;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se nуo der erro
			return 1;
		}
	}
}
?>