<?php
require_once('../../classe/entidades.php');

function controle_entidades($acao) {
	switch ($acao) {
		//incluir dados do formulário no banco
		case 'incluir':
			global $lista_entidades;
			
			//criar objeto da classe entidades
			$entidades = new entidades();
			
			$lista_entidades = $entidades -> listar($_SESSION['entidade']);
			
			//chama a funcao de listagem da classe entidades
			if ($_POST['incluir'] == 1) {				
				//chama a função de inclusão da classe entidades
				$resultado = $entidades -> incluir($_POST);
				
				if ($resultado == 1) {
					echo "<script>alert('Entidade cadastrada com sucesso')</script>";
				}
			}
		break;
		
		//incluir dados do formulário no banco
		case 'editar':
			//criar objeto da classe entidades
			$entidades = new entidades();
			
			require_once('../../classe/usuario.php');
			$usuario = new usuario();
			
			global $lista_entidades;
			global $entidade;
			global $det;
			global $excluir;

			//segmento informado por post ou get
			if ($_POST['entidade'] != '') {
				$entidade = $_POST['entidade'];
			}
			else {
				$entidade = $_GET['entidade'];
			}
			
			if ($_POST['enviar']) { 		
				//chama a função de alteração da classe entidades
				$resultado = $entidades -> alterar($_POST);
				
				if ($resultado == 1) {
					//exibe mensagem se der certo
					echo "<script>alert('Dados alterados');</script>";
				}
			}
			
			//excluir entidade
			if ($_POST['deletar']) {
				//chama a função de exclusão da classe entidades
				$resultado = $entidades -> excluir($_POST['entidade']);
				if ($resultado != 0) {
					//exibe mensagem se der certo
					echo "<script>alert('Entidade excluída');</script>";
				}
			}
			
			//listar entidades
			$lista_entidades = $entidades -> listar($_SESSION['entidade']);
			
			//entidade escolhida
			if ($entidade != '') {
				$detalhes = $entidades -> detalhes($entidade);
				$det = mysql_fetch_array($detalhes);
			}
			
			//permissoes
			$permissoes = $usuario -> permissoes($_SESSION['usuario']);
			$excluir = $permissoes['excluir'];
		break;
	}
}