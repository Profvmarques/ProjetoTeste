<?php
function controle_chat($acao) {
	switch ($acao) {
		//adicionar usuario na fila de espera
		case 'fila':
			require_once('../../classe/chat.php');
			session_start();
			//id da sessao do php
			$id = session_id();
			
			$chat = new chat();
			$chat -> adicionar_fila($id,$_POST['nome']);
		break;
		//iniciar atendimento
		case 'iniciar_atendimento':
			require_once('../../classe/chat.php');
			$chat = new chat();
			//iniciar atendimento caso o usuario nao esteja sendo atendido
			if ($chat -> verificar_atendido($_POST['sessao']) == 1) {
				$chat -> iniciar_atendimento($_POST['sessao']);
			}
			else {
				echo "<script>alert('usuário já está sendo atendido');</script>";
				echo "<script>window.location='index.php?pg=29'</script>";
			}
		break;
		//historico (sessoes)
		case 'historico':
			require_once('../../classe/chat.php');
			$chat = new chat();
			require_once('../../classe/usuario.php');
			$usuario = new usuario();
			
			global $lista_sessoes;
			global $lista_adm;
			global $total_sessoes;
			
			//listar sessoes
			$lista_sessoes = $chat -> listar_sessoes($_POST['adm'],$_GET['inicio']);
			//total de sessoes
			$total_sessoes = $chat -> total_sessoes();
			//listar administradores
			$lista_adm = $usuario -> listar();
		break;
		//historico de uma sessao
		case 'historico_sessao':
			require_once('../../classe/chat.php');
			$chat = new chat();
			
			global $lista_historico;
			
			$lista_historico = $chat -> listar_historico($_GET['id']);
		break;
	break;
	}
}

/*-------------------------------------------- para o jquery ------------------------------------------------------*/
switch ($_POST['acao']) {
	//mensagem enviada
	case 'add':
		require_once('../classe/chat.php');
		$chat = new chat();
		session_start();
		
		//adicionar mensagem no banco
		$chat -> adicionar($_POST['texto']);
		
		//listar mensagens ainda nao visualizadas
		$msg = $chat -> listar($_SESSION['ultimo'],$_SESSION['sessao']);
		$html = '';
		while ($m = mysql_fetch_array($msg)) {
			$html .= "<b>".$m['nome']." (".$m['data_hora'].")</b><br>";
			$html .= $m['mensagem']."<br>";
		}
		
		//se mensagens ainda nao visualizadas foram encontradas, atualiza a variavel que guarda o id da ultima mensagem exibida
		if (mysql_num_rows($msg) > 0) {
			$_SESSION['ultimo'] = mysql_result($msg,mysql_num_rows($msg)-1,'id');
		}
		
		echo $html;
	break;
	//listar mensagens ainda nao visualizadas
	case 'listar':
		require_once('../classe/chat.php');
		$chat = new chat();
		session_start();
		$msg = $chat -> listar($_SESSION['ultimo'],$_SESSION['sessao']);
		while ($m = mysql_fetch_array($msg)) {
			
			echo "<b>".$m['nome']." (".$m['data_hora'].")</b><br>";
			echo $m['mensagem']."<br>";
		}
		
		//se mensagens ainda nao visualizadas foram encontradas, atualiza a variavel que guarda o id da ultima mensagem exibida
		if (mysql_num_rows($msg) > 0) {
			$_SESSION['ultimo'] = mysql_result($msg,mysql_num_rows($msg)-1,'id');
		}
		//se nenhuma mensagem foi encontrada
		else {
			//encerrar sessao por inatividade
			$chat -> timeout();

			//status da sessao
			$status_sessao = $chat -> verificar_sessao();
			
			//verifica se a sessao foi encerrada
			if ($status_sessao == 3 || $status_sessao == 4) {
				//redirecionar administrador
				if ($_SESSION['nome'] == 'Ouvidoria') {
					echo "<script>alert('Atendimento encerrado');</script>";
					echo "<script>window.location='index.php?pg=29'</script>";
				}
				//redirecionar manifestante
				else {
					echo "<script>alert('Atendimento encerrado');</script>";
					echo "<script>window.location='index.php'</script>";
				}
			}
		}
	break;
	//verificar se o usuario foi atendido
	case 'verificar':
		require_once('../classe/chat.php');
		$chat = new chat();
		session_start();
		$atendimento = $chat -> verificar(session_id());
		
		//nao foi atendido
		if (mysql_num_rows($atendimento) < 1) {
			echo "Aguarde...";
		}
		//foi atendido
		else {
			echo "<script>window.location='chat.php'</script>";
		}
	break;
	//buscar lista de usuarios nao atendidos
	case 'verificar_fila':
		require_once('../classe/chat.php');
		$chat = new chat();
		session_start();
		$lista_fila = $chat -> verificar_fila();
		
		//exibe usuarios aguardando atendimento
		if (mysql_num_rows($lista_fila) > 0) {
			echo "<form method='post' action='index.php?pg=31'>";
			echo "<input type='hidden' name='sessao' id='sessao' value=''>";
			$i = 0;
			while ($l = mysql_fetch_array($lista_fila)) {
				echo $l['nome']." ";
				//botao de atender apenas para o primeiro da fila
				if ($i == 0) {
					echo "<input type='button' value='Atender' ";
					echo "onclick=\"document.getElementById('sessao').value='".$l['id']."';submit();\">";
					$i++;
				}
				echo "<br>";
			}
			echo "</form>";
		}
		//nenhum usuario aguardando atendimento
		else {
			echo 0;
		}
	break;
	//encerrar atendimento
	case 'encerrar':
		require_once('../classe/chat.php');
		$chat = new chat();
		
		//guardar hora de encerramento
		$chat -> hora_encerramento();
		//guardar mensagens no historico
		$chat -> guardar_historico();
		//apagar mensagens na tabela original
		$chat -> apagar_mensagens();
		//atualizar status da sessao
		$chat -> atualizar_status();
		//redirecionar
		echo "<script>window.location='index.php?pg=29'</script>";
	break;
}
?>