<?php
class usuarios {

	/*------------- Funчуo para incluir dados no banco --------------*/
	public function incluir($valores) {
		//criar objeto da classe conexуo
		require_once('../conexao.php');
		$conexao = new conexao();
		
		//inserir
		$sql = "insert into usuarios (login,senha) values ('".$valores['nome']."','".md5($valores['senha'])."')";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se nуo der erro
			return 1;
		}
	}
	
	/*------------- Funчуo para listar todos os usuarios --------------*/
	public function listar() {
		//criar objeto da classe conexуo
		require_once('../conexao.php');
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select * from usuarios order by login";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return $resultado;
		}
	}

	/*------------- Funчуo para listar os dados de um usuario --------------*/
	public function detalhes($id) {
		//criar objeto da classe conexуo
		require_once('../conexao.php');
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select * from usuarios where id = ".$id;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return $resultado;
		}
	}
	
	/*------------- Funчуo para fazer login no sistema --------------*/
	public function login($valores) {
		//criar objeto da classe conexуo
		require_once('../conexao.php');
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select * from ouv_usuario where login = '".$valores['login']."' and senha = '".md5($valores['senha'])."'";
		$resultado = $conexao -> query($sql);
		
		if (mysql_num_rows($resultado) > 0) {
			//achou o usuario
			session_start();
			$_SESSION['usuario'] = mysql_result($resultado,0,'id_usuario');
			return 1;
		}
	}

	function alterar_senha_unidade($senha,$nova_senha,$usuario) {
		//criar objeto da classe conexуo
		require_once('../../classe/conexao.php');
		$conexao = new conexao();
		
		$sql = "select *
					from ouv_usuario
						where id_usuario = ".$usuario."
						and senha = '".mysql_real_escape_string(md5($senha))."'";
		$resultado = $conexao -> query($sql);
		
		if (mysql_num_rows($resultado) > 0) {
			$sql = "update ouv_usuario
						set senha = '".mysql_real_escape_string(md5($nova_senha))."'
							where id_usuario = ".$usuario;
			$conexao -> query($sql);
			return 'Senha alterada';
		}
		else {
			return 'Senha atual invсlida';
		}
	}
	
	/*------------- Funчуo para alterar dados do usuario --------------*/
	public function alterar($valores) {
		//criar objeto da classe conexуo
		require_once('../conexao.php');
		$conexao = new conexao();
		
		//trocar senha
		if ($valores['senha'] != '') {
			$comp = ", senha = '".md5($valores['senha'])."'";
		}
		
		//alteraчуo
		$sql = "update usuarios set login = '".$valores['nome']."' ".$comp." where id = ".$valores['usuario'];
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//sucesso
			return 1;
		}
	}
	
}
?>