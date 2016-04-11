<?php 
require_once('../../classe/pmdc/diretoria.php');

function controle_diretoria($acao){
	switch ($acao){
		case 'incluir':
			global $lista_diretoria;
			
			//criar objeto da classe diretoria
			$diretoria = new diretoria();
			
			$lista_diretoria = $diretoria -> listar($_SESSION['desc_diretoria']);
			
			//chama a funcao de listagem da classe diretoria
			if ($_POST['incluir'] == 1) {				
				//chama a função de inclusão da classe diretoria
				$resultado = $diretoria -> incluir($_POST);
				
				if ($resultado == 1) {
					echo "<script>alert('Diretoria incluida com sucesso !')</script>";
				}
			}
		break;
		
		case 'designar':
			
			global $lista_diretoria;
			
			//criar objeto da classe diretoria
			$diretoria = new diretoria();
			
			$lista_diretoria = $diretoria -> listar($_SESSION['desc_diretoria']);
			
			//chama a funcao de listagem da classe diretoria
			/*if ($_POST['incluir'] == 1) {				
				//chama a função de inclusão da classe diretoria
				$resultado = $diretoria -> relacionar($_POST);
				
				if ($resultado == 1) {
					//echo foi;
				}
			}*/
			global $lista_entidade;
			
			require_once('../../classe/pmdc/entidades.php');
			//criar objeto da classe entidade

			$entidade = new entidades();
			
			$lista_entidade = $entidade -> listar_desig($_SESSION['entidade']);
			
			//chama a funcao de listagem da classe entidade
			/*if ($_POST['incluir'] == 1) {				
				//chama a função de inclusão da classe entidade
				$resultado = $entidade -> incluir($_POST);
				
				if ($resultado == 1) {
					//echo foi;
				}
			}*/
			
			if ($_POST['incluir'] == 1){
				$resultado = $diretoria -> relacionar($_POST['entidadeselect'], $_POST['diretoria']);
				echo "<script>alert('Entidade/Diretoria relacionado com sucesso')</script>";
			}

		break;
		
		//alteracao de diretorias/entidades
		case 'alterar':
			
			global $lista_diretoria;
			
			//criar objeto da classe diretoria
			$diretoria = new diretoria();
			
			$lista_diretoria = $diretoria -> listar($_SESSION['desc_diretoria']);
			
			//chama a funcao de listagem da classe diretoria
			/*if ($_POST['incluir'] == 1) {				
				//chama a função de inclusão da classe diretoria
				$resultado = $diretoria -> relacionar($_POST);
				
				if ($resultado == 1) {
					//echo foi;
				}
			}*/
			global $lista_entidade;
			
			require_once('../../classe/pmdc/entidades.php');
			//criar objeto da classe entidade

			$entidade = new entidades();
			
			$lista_entidade = $entidade -> listar_alt($_SESSION['entidade']);
			
			//chama a funcao de listagem da classe entidade
			/*if ($_POST['incluir'] == 1) {				
				//chama a função de inclusão da classe entidade
				$resultado = $entidade -> incluir($_POST);
				
				if ($resultado == 1) {
					//echo foi;
				}
			}*/
			
			if ($_POST['incluir'] == 1){
				$resultado = $diretoria -> alterar($_POST['entidadeselect'], $_POST['diretoria']);
				?> <script> alert('Entidade/Diretoria alterada com sucesso') </script><?php  
			}

		break;
	}
}
?>