<?php 
require_once('conexao.php');

class resposta_padrao {

	/*------------- Fun��o para incluir dados no banco --------------*/
	public function incluir($valores) {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		session_start();
		
		//inserir
		$sql = "insert into ouv_resposta_padrao (resposta_padrao, observacao, id_entidade) 
				values ('".$valores['resposta']."','".$valores['obs']."',".$_SESSION['entidade'].")";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se n�o der erro
			return 1;
		}
	}
	
	/*------------- Fun��o para listar todos as respostas --------------*/
	public function listar() {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		session_start();

		//faz a busca
		$sql = "select * from ouv_resposta_padrao where id_entidade = ".$_SESSION['entidade']." order by id_resposta_padrao";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se n�o der erro
			return $resultado;
		}
	}
	
	/*------------- Fun��o para listar os dados de uma resposta --------------*/
	public function detalhes($id) {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select * from ouv_resposta_padrao where id_resposta_padrao = ".$id;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se n�o der erro
			return $resultado;
		}
	}
	
	/*------------- Fun��o para alterar dados de uma resposta padrao --------------*/
	public function alterar($valores) {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//faz a alteracao
		$sql = "update ouv_resposta_padrao set resposta_padrao = '".$valores['resposta']."',
				observacao = '".$valores['obs']."' where id_resposta_padrao = ".$valores['resposta_sel'];
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se n�o der erro
			return 1;
		}
	}
	
	public function excluir($id) {
		//criar objeto da classe conex�o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "delete from ouv_resposta_padrao where id_resposta_padrao = ".$id;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se n�o der erro
			return 1;
		}
	}
}
?>