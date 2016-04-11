<?php 
function cadastra()
{
	require_once '../../classe/usuario.php';
	if($_POST['cadastrar'])
	{
		global $res_cadastra;
		$usuario = new usuario();
		if ($_POST['entidade'] == '') {
			$_POST['entidade'] = $_SESSION['entidade'];
		}
		$res_cadastra=$usuario->cadastrar($_POST);
		
		if ($res_cadastra) {
			echo "<script>alert('Usuário cadastrado com sucesso')</script>";
		}
	}

	require_once '../../classe/entidades.php';
	global $res_entidade;
	$entidades = new entidades();
	$res_entidade = $entidades -> listar($_SESSION['entidade']);

	require_once '../../classe/perfil.php';
	global $res_perfil;
	$perfil = new perfil();
	$res_perfil = $perfil ->consultar();

	
}

function consulta_dados()
{
	require_once '../classe/usuario.php';
	global $res_consulta;
	$usuario=new usuario();
	$res_consulta=$usuario->consultar_dados();
}

function consulta_exc()
{
	require_once '../../classe/usuario.php';
	global $res;
	$usuario=new usuario();
	$res=$usuario->consultar_exc();
}

function excluir_usuario($id)
{
	require_once '../../classe/usuario.php';
	global $res;
	$usuario=new usuario();
	$res=$usuario->excluir($id);
}

function troca_senha()
{
	require_once '../../classe/usuario.php';
	global $res_senha;
	$usuario=new usuario();
	$res_senha=$usuario->trocar_senha($_POST);
}

//editar usuario
function altera() {
	//listar usuarios
	//criar objeto da classe usuario
	$usuario = new usuario();
	
	global $lista;
	
	//usuario escolhido
	if ($_POST['usuario'] != '' || $_GET['usuario'] != '') {
		//criar objeto da classe usuarios
		$usuario = new usuario();				
		//criar objeto da classe entidade
		require_once '../../classe/entidades.php';
		$entidades = new entidades();
		//criar objeto da classe perfil
		require_once '../../classe/perfil.php';
		$perfil = new perfil();
		
		global $detalhes;
		global $lista;
		global $res_entidade;
		global $res_perfil;
		global $excluir;
		
		//usuario informado por post ou get
		if ($_POST['usuario'] != '') {
			$u = $_POST['usuario'];
		}
		else {
			$u = $_GET['usuario'];
		}
		
		//atualizar dados
		if ($_POST['alterar']) {
			if ($_POST['entidade'] == '') {
				$_POST['entidade'] = $_SESSION['entidade'];
			}
			//chama a função de alteração da classe usuarios
			$resultado = $usuario -> alterar($_POST);
			if ($resultado != 0) {
				//exibe mensagem
				echo "<script>alert('Dados alterados');</script>";
			}
			else {
				echo "<script>alert('Já existe um usuário com este login para esta entidade');</script>";
			}
		}
		
		//excluir usuario
		/*if ($_POST['excluir']) {
			//chama a função de exclusão da classe usuarios
			$resultado = $usuario -> excluir($_POST['usuario']);
			if ($resultado != 0) {
				//exibe mensagem e redireciona se der certo
				echo "<script>alert('Usuário excluído');</script>";
			}
		}*/
		
		//chama a função para listar os dados de um usuario	
		$resultado = $usuario -> detalhes($u);
		$detalhes = mysql_fetch_array($resultado);
		
		//listar todos as entidades
		$res_entidade = $entidades -> listar($_SESSION['entidade']);
		
		//listar todos os perfis
		$res_perfil = $perfil -> consultar();
		
		//permissoes
		$permissoes = $usuario -> permissoes($_SESSION['usuario']);
		$excluir = $permissoes['excluir'];
	}
	
	//chama a função de listagem da classe usuario
	$lista = $usuario -> listar();
}

function sair() {
	require_once '../../classe/usuario.php';
	session_start();
	session_destroy();

	echo "<script>window.location='../../view'</script>";
}
?>