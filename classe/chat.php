<?php
class chat {
	
	//adicionar uma mensagem no chat
	public function adicionar($texto) {
		require_once('conexao.php');
		$conexao = new conexao();
		session_start();
		
		//inserir mensagem apenas se a sessao nao estiver encerrada
		if ($this -> verificar_sessao() < 3) {
			$sql = "insert into ouv_mensagens (nome, mensagem, id_sessao)
					values ('".$_SESSION['nome']."','".$texto."',".$_SESSION['sessao'].")";
			$conexao -> query($sql);
		}
	}
	
	//listar mensagens ainda nao visualizadas
	public function listar($ultimo,$sessao) {
		require_once('conexao.php');
		$conexao = new conexao();
		
		//ultimo id nao informado, começar do zero
		if ($ultimo == '') {
			$ultimo = 0;
		}
		
		$sql = "select ouv_mensagens.id, nome, mensagem, 
				date_format(data_hora,'%d/%m/%Y %H:%i:%s') as data_hora 
					from ouv_mensagens
						inner join ouv_sessoes on ouv_sessoes.id = ouv_mensagens.id_sessao
							where ouv_mensagens.id > ".$ultimo." 
							and ouv_sessoes.id = ".$sessao;
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//adicionar um usuario na fila de espera
	public function adicionar_fila($id,$nome) {
		require_once('conexao.php');
		$conexao = new conexao();
		
		//verificar se o usuario ja esta na fila ou sendo atendido pelo id da sessao do php
		$sql = "select id 
					from ouv_sessoes 
						where sessao_usuario = '".$id."' 
						and id_status in (1,2)";
		$resultado = $conexao -> query($sql);
		
		//usuario nao esta na fila
		if (mysql_num_rows($resultado) < 1) {
			//guardar dados do usuario
			$sql = "insert into ouv_usuario_chat (nome) values ('".$nome."')";
			$conexao -> query($sql);
			
			//iniciar sessao de atendimento
			$sql = "insert into ouv_sessoes (sessao_usuario,inicio,id_usuario,id_status)
					values ('".$id."','".date('Y-m-d H:i:s')."','".mysql_insert_id()."',1)";
			$conexao -> query($sql);
			
			session_start();
			$_SESSION['sessao'] = mysql_insert_id();
		}
		//usuario ja esta na fila ou sendo atendido
		else {
			$_SESSION['sessao'] = mysql_result($resultado,0,'id');
		}
	}
	
	//listar usuarios na fila de espera
	public function listar_fila() {
		require_once('conexao.php');
		$conexao = new conexao();
		
		$sql = "select * from ouv_sessoes where id_administrador is null";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//atualizar fila de espera com o id do administrador que fara o atendimento
	public function iniciar_atendimento($sessao) {
		require_once('conexao.php');
		$conexao = new conexao();
		
		$sql = "update ouv_sessoes set 
					id_administrador = ".$_SESSION['usuario'].", 
					id_status = 2,
					inicio_atendimento = '".date('Y-m-d H:i:s')."'
						where id = '".$sessao."'";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//verificar se o usuario foi atendido pelo id da sessao do php
	public function verificar($sessao) {
		require_once('conexao.php');
		$conexao = new conexao();
		
		$sql = "select * 
					from ouv_sessoes 
						where sessao_usuario = '".$sessao."'
						and id_status = 2";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//verificar se o usuario foi atendido pelo id da tabela ouv_sessoes
	public function verificar_atendido($sessao) {
		require_once('conexao.php');
		$conexao = new conexao();
		
		$sql = "select id_status 
					from ouv_sessoes 
						where id = ".$sessao;
		$resultado = $conexao -> query($sql);
		
		return mysql_result($resultado,0,'id_status');
	}
	
	//buscar usuarios na fila de atendimento
	public function verificar_fila() {
		require_once('conexao.php');
		$conexao = new conexao();
		
		$sql = "select ouv_sessoes.*, ouv_usuario_chat.nome
					from ouv_sessoes 
						inner join ouv_usuario_chat on ouv_sessoes.id_usuario = ouv_usuario_chat.id
							where id_status = 1";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//guardar hora de encerramento
	public function hora_encerramento() {
		require_once('conexao.php');
		$conexao = new conexao();
		session_start();
		
		$sql = "update ouv_sessoes set fim = '".date('Y-m-d H:i:s')."'
					where id = ".$_SESSION['sessao'];
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//guardar mensagens no historico
	public function guardar_historico() {
		require_once('conexao.php');
		$conexao = new conexao();
		session_start();
		
		$sql = "insert into ouv_historico_chat (nome, mensagem, data_hora, id_sessao)
				select nome, mensagem, data_hora, id_sessao from ouv_mensagens where id_sessao = ".$_SESSION['sessao'];
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//apagar mensagens na tabela original
	public function apagar_mensagens() {
		require_once('conexao.php');
		$conexao = new conexao();
		session_start();
		
		$sql = "delete from ouv_mensagens where id_sessao = ".$_SESSION['sessao'];
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//atualizar status da sessao (encerrar)
	public function atualizar_status($inatividade=0) {
		require_once('conexao.php');
		$conexao = new conexao();
		session_start();
		
		if ($inatividade == 0) {
			//encerrada
			$status = 3;
		}
		else {
			//encerrada por inatividade
			$status = 4;
		}
		
		$sql = "update ouv_sessoes set id_status = ".$status."
					where id = ".$_SESSION['sessao'];
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//buscar status da sessao
	public function verificar_sessao() {
		require_once('conexao.php');
		$conexao = new conexao();
		session_start();
		
		$sql = "select id_status 
					from ouv_sessoes 
						where id = ".$_SESSION['sessao'];
		$resultado = $conexao -> query($sql);
		
		return mysql_result($resultado,0,'id_status');
	}
	
	//encerrar sessao por inatividade
	public function timeout() {
		require_once('conexao.php');
		$conexao = new conexao();
		session_start();
		
		$sql = "select time_to_sec(timediff(time(now()),time(data_hora))) as tempo
					from ouv_mensagens 
						where id_sessao = ".$_SESSION['sessao'];
		$resultado = $conexao -> query($sql);
		
		//encerrar sessao se houver XX segundos de inatividade
		if (mysql_num_rows($resultado) > 0) {
			if (mysql_result($resultado,0,'tempo') > 1000) {
				//guardar hora de encerramento
				$this -> hora_encerramento();
				//salvar mensagens no historico
				$this -> guardar_historico();
				//apagar mensagens da tabela original
				$this -> apagar_mensagens();
				//atualizar status da sessao para encerrada por inatividade
				$this -> atualizar_status(1);
			}
		}
	}
	
	//listar sessoes (apenas encerradas)
	public function listar_sessoes($adm=0,$inicio='') {
		require_once('conexao.php');
		$conexao = new conexao();
		
		//filtrar por administrador
		if ($adm != 0) {
			$comp = " and ouv_sessoes.id_administrador = ".$adm;
		}
	
		//inicio da listagem
		if ($inicio == '') {
			$inicio = 0;
		}
		
		$sql = "select ouv_sessoes.id, date_format(inicio,'%d/%m/%Y %H:%i:%s') as inicio, 
				date_format(inicio_atendimento,'%d/%m/%Y %H:%i:%s') as inicio_atendimento, 
				date_format(fim,'%d/%m/%Y %H:%i:%s') as fim, ouv_usuario_chat.nome as 'cidadão', 
				ouv_usuario.nome as 'usuário'
					from ouv_sessoes
						inner join ouv_usuario_chat on ouv_usuario_chat.id = ouv_sessoes.id_usuario
						inner join ouv_usuario on ouv_usuario.id_usuario = ouv_sessoes.id_administrador
							where id_status in (3,4)
							".$comp."
								order by fim desc
									limit ".$inicio.",10";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//total de sessoes
	public function total_sessoes() {
		require_once('conexao.php');
		$conexao = new conexao();
		session_start();
		
		$sql = "select ouv_sessoes.id 
				from ouv_sessoes
					inner join ouv_usuario on ouv_usuario.id_usuario = ouv_sessoes.id_administrador
						where ouv_usuario.id_entidade = ".$_SESSION['entidade'];
		$resultado = $conexao -> query($sql);
		
		return mysql_num_rows($resultado);
	}
	
	//listar historico de uma sessao
	public function listar_historico($sessao) {
		require_once('conexao.php');
		$conexao = new conexao();
		
		$sql = "select ouv_historico_chat.id, nome, mensagem, 
				date_format(data_hora,'%d/%m/%Y %H:%i:%s') as data_hora 
					from ouv_historico_chat
						inner join ouv_sessoes on ouv_sessoes.id = ouv_historico_chat.id_sessao
							where ouv_sessoes.id = ".$sessao;
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
}
?>