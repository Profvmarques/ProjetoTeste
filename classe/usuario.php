<?php 
session_start();
require_once 'conexao.php';

class usuario
{
	public function cadastrar($i)
	{
		$conexao = new conexao ();
		$sql="select * from ouv_usuario 
				where login='".$i['login']."'";
		$c=$conexao->query($sql);
		if(mysql_num_rows($c)>0)
		{
			echo "<script>alert('Usuario existente !');</script>";
		}
		else
		{
			if($i['senha']==$i['csenha'])
			{
				$sql="insert into ouv_usuario (nome,login,senha,id_perfil,id_entidade,ativo)
						values ('".$i['nome']."','".$i['login']."','".md5($i['senha'])."',".$i['perfil'].",".$i['entidade'].",".$i['ativo'].")";
				
				return $conexao ->query($sql);
			}
			else
			{
				 echo "<script>alert('Senha Incorreta !');</script>";
			}
		}
	}
	
	public function consultar_dados()
	{
		$sql="select * from ouv_usuario where login='".$_SESSION['login']."' and ativo = 1";
		$conexao =new conexao ();
		return $conexao -> query($sql);
	}
	
	public function consultar_exc()
	{
		$sql="select entidade,nome,id_usuario from ouv_usuario
				inner join ouv_entidade on ouv_entidade.id_entidade=ouv_usuario.id_entidade
				where login!='".$_SESSION['login']."'";
		$conexao =new conexao ();
		return $conexao ->query($sql);
	}
	
	public function excluir($id)
	{
		$sql="delete from ouv_usuario where id_usuario=".$id;
		$conexao =new conexao ();
		return $conexao ->query($sql);
	}
	
	public function trocar_senha($i)
	{
		$conexao = new conexao ();
		
		$sql="select senha from ouv_usuario where login='".$_SESSION['login']."'";
		$senha=$conexao ->query($sql);
		$senha=mysql_result($senha,0,'senha');
		
		if($senha==md5($i['senhaa']) && $i['senhan']==$i['csenha'])
		{
			$sql="update ouv_usuario set senha='".md5($i['senhan'])."' where login='".$_SESSION['login']."'";
			return $conexao ->query($sql);
		}
		else
		{
			echo "<script>alert('Senhas Incorretas !!!');</script>";
		}
	}
	
	public function alterar($valores)
	{
		$conexao =new conexao ();
		$sql="select login from ouv_usuario where login='".$valores['login']."' 
			and id_usuario != ".$valores['usuario']." and id_entidade = ".$valores['entidade'];
		$login=$conexao ->query($sql);
		
		if(mysql_num_rows($login) == 0)
		{
			$comp = '';
			if ($valores['senha'] != '') {
				$comp = "senha = '".md5($valores['senha'])."',";
			}
			$sql="update ouv_usuario set 
					login='".$valores['login']."',nome='".$valores['nome']."',
					".$comp."
					ativo = ".$valores['ativo'].",
					id_perfil=".$valores['perfil'].",id_entidade=".$valores['entidade']."
					where id_usuario = '".$_POST['usuario']."'";
			return $conexao ->query($sql);
		}
		else {
			return 0;
		}
	}
	
	public function permissoes($usuario) {
		$conexao =new conexao ();
		$sql = "select ouv_perfil.*
					from ouv_perfil
						inner join ouv_usuario on ouv_usuario.id_perfil = ouv_perfil.id_perfil
							where ouv_usuario.id_usuario = ".$usuario;
		$resultado = $conexao -> query($sql);
		
		return mysql_fetch_array($resultado);
	}
	
	public function listar() {
		$conexao = new conexao ();
		$sql = "select * from ouv_usuario order by nome";
		
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	/*------------- Função para listar os dados de um usuario --------------*/
	public function detalhes($id) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select * from ouv_usuario where id_usuario = ".$id;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se não der erro
			return $resultado;
		}
	}	
}
?>