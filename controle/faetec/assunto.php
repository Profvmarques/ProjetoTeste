<?php 
function controle_assunto($acao){
	switch ($acao){
		case 'incluir':
			if ($_POST['enviar']) {				
				require_once('../../classe/faetec/assunto.php');
				$assunto = new assunto();
				
				$resultado = $assunto -> incluir($_POST);
				
				if ($resultado == 1) {
					echo "<script>alert('assunto incluído com sucesso !')</script>";
				}
			}
		break;
		
		case 'editar':
			require_once('../../classe/faetec/assunto.php');
			$assunto = new assunto();
			
			global $lista_assunto;
			global $id_assunto;
			global $det;
			
			if ($_POST['enviar']) {			
				//chama a função de alteração da classe assunto
				$resultado = $assunto -> alterar($_POST);
				
				if ($resultado == 1) {
					//exibe mensagem e redireciona se der certo
					echo "<script>alert('Dados alterados');</script>";
				}
			}
			
			//listar assuntos
			$lista_assunto = $assunto -> listar();
			
			//assunto escolhido
			if ($_POST['id_assunto'] != '') {
				$detalhes = $assunto -> detalhes($_POST['id_assunto']);
				$det = mysql_fetch_array($detalhes);
			}
		break;
	}
}
?>