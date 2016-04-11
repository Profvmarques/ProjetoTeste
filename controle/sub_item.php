<?php
function controle_sub_item($acao) {
	switch ($acao) {
		case 'incluir':
			require_once('../../classe/assuntos.php');
			$assuntos = new assuntos();
			
			global $lista_assuntos;
			
			//listar assuntos
			$lista_assuntos = $assuntos -> listar();
			
			if ($_POST['enviar']) {
				require_once('../../classe/sub_item.php');
				$sub_item = new sub_item();
				
				//incluir novo subitem
				$sub_item -> incluir($_POST);
				
				echo "<script>alert('Subitem cadastrado com sucesso');</script>";
			}
		break;
		case 'editar':
			require_once('../../classe/sub_item.php');
			$sub_item = new sub_item();
			require_once('../../classe/assuntos.php');
			$assuntos = new assuntos();
			
			session_start();
			
			global $lista_assuntos;
			global $lista_sub;
			global $detalhes;
			global $assuntos_sub;
			
			$assuntos_sub = array();
			
			//listar assuntos
			$lista_assuntos = $assuntos -> listar();
			
			//alterar dados
			if ($_POST['enviar']) {
				$sub_item -> editar($_POST['descricao'],$_POST['sub'],$_POST['ativo'],$_POST['assunto']);
				echo "<script>alert('Subitem alterado com sucesso');</script>";
			}
			
			//subitem escolhido
			if ($_POST['sub'] != '') {
				//detalhes do subitem escolhido
				$det = $sub_item -> detalhes($_POST['sub']);
				$detalhes = mysql_fetch_array($det);
				
				//assuntos do subitem escolhido
				/*$res_assuntos = $sub_item -> assuntos($_POST['sub']);
				while ($a = mysql_fetch_array($res_assuntos)) {
					$assuntos_sub[] = $a['id_assunto'];
				}*/
			}
			
			//listar subitens
			$lista_sub = $sub_item -> listar_subitens($_SESSION['entidade']);
		break;
	}
}
?>