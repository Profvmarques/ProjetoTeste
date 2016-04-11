<?php
function controle_usuarios($acao) {
	switch ($acao) {
		//incluir dados do formulário no banco
		case 'incluir':
			if ($_POST['incluir'] == 1) {
				//criar objeto da classe usuarios
				require_once('../faetec/classe/pmdc/usuarios.php');
				$usuarios = new usuarios();
				
				//chama a função de inclusão da classe usuarios
				$resultado = $usuarios -> incluir($_POST);
				
				if ($resultado == 1) {
					echo foi;
				}
			}
		break;
		
		//editar usuario
		case 'editar':
			//listar usuarios
			//criar objeto da classe usuarios
			require_once('../faetec/classe/pmdc/usuarios.php');
			$usuarios = new usuarios();
			
			global $lista;
			
			//chama a função de listagem da classe usuarios
			$lista = $usuarios -> listar();
			
			//usuario escolhido
			if ($_POST['usuario'] != '' || $_GET['usuario'] != '') {
				//criar objeto da classe usuarios
				$usuarios = new usuarios();				
				//criar objeto da classe segmentos
				require_once('../faetec/classes/segmentos.php');
				$segmentos = new segmentos();
				//criar objeto da classe permissoes
				require_once('../faetec/classes/permissoes.php');
				$permissoes = new permissoes();
				
				global $detalhes;
				global $lista;
				global $lista_permissoes;
				global $lista_segmentos;
				global $usuario;
				
				//usuario informado por post ou get
				if ($_POST['usuario'] != '') {
					$usuario = $_POST['usuario'];
				}
				else {
					$usuario = $_GET['usuario'];
				}
				
				//chama a função para listar os dados de um usuario	
				$resultado = $usuarios -> detalhes($usuario);
				$detalhes = mysql_fetch_array($resultado);
				
				//listar todos os segmentos
				$lista_segmentos = $segmentos -> listar();
				
				//listar todos as permissoes do usuario
				$lista_permissoes = $permissoes -> listar($usuario);

				//atualizar dados
				if ($_POST['editar'] == 1) {	
					//chama a função de alteração da classe usuarios
					$resultado = $usuarios -> alterar($_POST);
					if ($resultado) {
						//exibe mensagem e redireciona se der certo
						echo "<script>alert('Dados alterados');</script>";
						echo "<script>window.location='?pg=view/pmdc/editar_usuarios.php&usuario=".$usuario."';</script>";
					}
				}
				
				//adicionar permissão
				if ($_POST['editar'] == 2) {	
					//chama a função de inclusão da classe permissoes
					$resultado = $permissoes -> incluir($usuario,$_POST['segmento'],$_POST['permissao']);
					if ($resultado == 1) {
						//exibe mensagem e redireciona se der certo
						echo "<script>alert('Permissão adicionada');</script>";
						echo "<script>window.location='?pg=view/pmdc/editar_usuarios.php&usuario=".$usuario."';</script>";
					}
				}
				
				//remover permissão
				if ($_POST['editar'] == 3) {
					//chama a função de exclusão da classe permissoes
					$resultado = $permissoes -> excluir($_POST['remover']);
					if ($resultado == 1) {
						//exibe mensagem e redireciona se der certo
						echo "<script>alert('Permissão removida');</script>";
						echo "<script>window.location='?pg=view/pmdc/editar_usuarios.php&usuario=".$usuario."';</script>";
					}
				}				
			}
		break;
		
		//alterar senha de unidade
		case 'alterar_senha_unidade':
			if ($_POST) {
				require_once('../../classe/pmdc/usuarios.php');
				$usuarios = new usuarios();
				
				$resultado = $usuarios -> alterar_senha_unidade($_POST['senha_atual'],$_POST['nova_senha'],$_SESSION['usuario']);
				echo "<script>alert('".$resultado."');</script>";
			}
		break;
	}
}