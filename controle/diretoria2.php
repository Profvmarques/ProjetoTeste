<?php
require_once('../../classe/diretoria.php');

function controle_diretoria($acao) {
	switch ($acao) {
		//incluir dados do formulário no banco
		case 'incluir':
			global $lista_diretoria;
			
			//criar objeto da classe dire
			$diretoria = new diretoria();
			
			$lista_diretoria = $diretoria -> listar($_SESSION['desc']);
			
			//chama a funcao de listagem da classe dire
			if ($_POST['incluir'] == 1) {				
				//chama a função de inclusão da classe dire
				$resultado = $diretoria -> incluir($_POST);
				
				if ($resultado == 1) {
					echo "<script>alert('Diretoria cadastrada com sucesso')</script>";
				}
			}
		break;
		
		//incluir dados do formulário no banco
		case 'editar':
			//criar objeto da classe diret
			$diretoria = new diretoria();
			
			require_once('../../classe/entidade.php');
			$entidade = new entidade();
			
			global $lista_diretoria;
			global $diretoria;
			global $det;
			global $excluir;

			//segmento informado por post ou get
			if ($_POST['desc'] != '') {
				$diretoria = $_POST['desc'];
			}
			else {
				$diretoria = $_GET['desc'];
			}
			
			if ($_POST['enviar']) { 		
				//chama a função de alteração da classe diret
				$resultado = $diretoria -> alterar($_POST);
				
				if ($resultado == 1) {
					//exibe mensagem se der certo
					echo "<script>alert('Dados alterados');</script>";
				}
			}
			
			//excluir diret
			if ($_POST['deletar']) {
				//chama a função de exclusão da classe entidades
				$resultado = $diretoria -> excluir($_POST['desc']);
				if ($resultado != 0) {
					//exibe mensagem se der certo
					echo "<script>alert('Diretoria excluída');</script>";
				}
			}
			
			//listar diret
			$lista_diretoria = $diretoria -> listar($_SESSION['desc']);
			
			//diret escolhida
			if ($diretoria != '') {
				$detalhes = $diretoria -> detalhes($diretoria);
				$det = mysql_fetch_array($detalhes);
			}
			
			//permissoes
			$permissoes = $entidade -> permissoes($_SESSION['entidade']);
			$excluir = $permissoes['excluir'];
		break;
	}
}