<?php
require_once('../../classe/resposta_padrao.php');

function controle_resposta_padrao($acao) {
	switch ($acao) {
		//incluir dados do formulário no banco
		case 'incluir':
			if ($_POST['incluir'] == 1) {
				//criar objeto da classe resposta_padrao
				$resposta_padrao = new resposta_padrao();
				
				//chama a função de inclusão da classe resposta_padrao
				$resultado = $resposta_padrao -> incluir($_POST);
				
				if ($resultado == 1) {
					echo "<script>alert('Resposta padrão cadastrada com sucesso')</script>";
				}
			}
		break;
		
		//incluir dados do formulário no banco
		case 'editar':
			//criar objeto da classe resposta_padrao
			$resposta_padrao = new resposta_padrao();
			
			require_once('../../classe/usuario.php');
			$usuario = new usuario();
			
			global $lista;
			global $rs;
			global $dados;
			global $excluir;
			
			//resposta informada por post ou get
			if ($_POST['resposta_sel'] != '') {
				$rs = $_POST['resposta_sel'];
			}
			else {
				$rs = $_GET['resposta_sel'];
			}
			
			if ($_POST['enviar']) {			
				//chama a função de alteração da classe segmentos
				$resultado = $resposta_padrao -> alterar($_POST);
				
				if ($resultado == 1) {
					//exibe mensagem se der certo
					echo "<script>alert('Dados alterados');</script>";
				}
			}
			
			if ($_POST['excluir']) {			
				//chama a função de alteração da classe segmentos
				$resultado = $resposta_padrao -> excluir($_POST['resposta_sel']);
				
				if ($resultado == 1) {
					//exibe mensagem e redireciona se der certo
					echo "<script>alert('resposta excluída');</script>";
					$rs = '';
				}
			}
			
			//listar respostas
			$lista = $resposta_padrao -> listar();
			
			//resposta escolhida
			if ($rs != '') {
				$dados = $resposta_padrao -> detalhes($rs);
			}
			//permissoes
			$permissoes = $usuario -> permissoes($_SESSION['usuario']);
			$excluir = $permissoes['excluir'];
		break;
	}
}