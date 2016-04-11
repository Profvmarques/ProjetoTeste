<?php
require_once('../faetec/classe/pmdc/entidades.php');

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
					//echo foi;
				}
			}
		break;
		
		//incluir dados do formulário no banco
		case 'editar':
			//criar objeto da classe entidades
			$entidades = new entidades();
			
			global $lista_entidades;
			global $entidade;
			global $det;

			//segmento informado por post ou get
			if ($_POST['entidade'] != '') {
				$entidade = $_POST['entidade'];
			}
			else {
				$entidade = $_GET['entidade'];
			}
			
			//listar entidades
			$lista_entidades = $entidades -> listar($_SESSION['entidade']);
			
			//entidade escolhida
			if ($entidade != '') {
				$detalhes = $entidades -> detalhes($entidade);
				$det = mysql_fetch_array($detalhes);
			}
			
			if ($_POST['editar'] == 1) {			
				//chama a função de alteração da classe entidades
				$resultado = $entidades -> alterar($_POST);
				
				if ($resultado == 1) {
					//exibe mensagem e redireciona se der certo
					echo "<script>alert('Dados alterados');</script>";
					echo "<script>window.location='?pg=view/pmdc/editar_entidade.php&entidade=".$entidade."';</script>";
				}
			}
		break;
	}
}