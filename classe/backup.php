<?php
class backup {
	
	//listar anos disponiveis para backup
	public function listar_anos() {
		require_once('conexao.php');
		$conexao = new conexao();
		session_start();
		
		$sql = "select distinct year(ouv_processo.data_ini) as ano
					from ouv_processo
						where ouv_processo.form = ".$_SESSION['entidade'];
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//criar
	public function criar($valores) {
		require_once('conexao.php');
		$conexao = new conexao();
		$conexao -> conexao_backup();
		session_start();
		
		//data inicial e final de acordo com o semestre escolhido
		switch ($valores['semestre']) {
			case '01';
				$inicio = $valores['ano'].'-01-01';
				$fim = $valores['ano'].'-06-30';
			break;
			case '02';
				$inicio = $valores['ano'].'-08-01';
				$fim = $valores['ano'].'-12-31';
			break;
		}
		
		//iniciar transaction
		$conexao -> begin();
		
		//criar tabelas caso nao existam
		$sql = "create table if not exists sect_backup._processo".$valores['ano'].$valores['semestre']." like sect.ouv_processo";
		$res = $conexao -> query_transaction($sql);
		if (!$res) {
			$erro = 'Erro ao criar tabela de processos, aзгo cancelada';
			$conexao -> rollback();
			return $erro;
		}
		
		$sql = "create table if not exists sect_backup._ouvidoria".$valores['ano'].$valores['semestre']." like sect.ouv_ouvidoria";
		$res = $conexao -> query_transaction($sql);
		if (!$res) {
			$erro = 'Erro ao criar tabela de ouvidoria, aзгo cancelada';
			$conexao -> rollback();
			return $erro;
		}
		
		$sql = "create table if not exists sect_backup._historico".$valores['ano'].$valores['semestre']." like sect.ouv_historico";
		$res = $conexao -> query_transaction($sql);
		if (!$res) {
			$erro = 'Erro ao criar tabela de histуrico, aзгo cancelada';
			$conexao -> rollback();
			return $erro;
		}
		
		$sql = "create table if not exists sect_backup._denuncia".$valores['ano'].$valores['semestre']." like sect.ouv_denuncia";
		$res = $conexao -> query_transaction($sql);
		if (!$res) {
			$erro = 'Erro ao criar tabela de denъncias, aзгo cancelada';
			$conexao -> rollback();
			return $erro;
		}
		
		//inserir dados
		$sql = "insert into sect_backup._processo".$valores['ano'].$valores['semestre']." 
				select * from sect.ouv_processo
					where sect.ouv_processo.data_ini between '".$inicio."' and '".$fim."'
					and sect.ouv_processo.form = ".$_SESSION['entidade']."
						on duplicate key update 
						sect_backup._processo".$valores['ano'].$valores['semestre'].".id_processo = sect_backup._processo".$valores['ano'].$valores['semestre'].".id_processo";
		$res = $conexao -> query_transaction($sql);
		if (!$res) {
			$erro = 'Erro ao copiar dados de processos, aзгo cancelada';
			$conexao -> rollback();
			return $erro;
		}
		
		/*$sql = "insert into _ouvidoria".$valores['ano'].$valores['semestre']."
				select * from ouv_ouvidoria 
					where ouv_ouvidoria.id_ouvidoria 
					in (select id_ouvidoria
							from _processo".$valores['ano'].$valores['semestre']."
								where _processo".$valores['ano'].$valores['semestre'].".data_ini between '".$inicio."' and '".$fim."'
								and _processo".$valores['ano'].$valores['semestre'].".form = ".$_SESSION['entidade'].")
					on duplicate key update 
					_ouvidoria".$valores['ano'].$valores['semestre'].".id_ouvidoria = _ouvidoria".$valores['ano'].$valores['semestre'].".id_ouvidoria";
		$res = $conexao -> query_transaction($sql);
		if (!$res) {
			$erro = 'Erro ao copiar dados de ouvidoria, aзгo cancelada';
			$conexao -> rollback();
			return $erro;
		}
		
		$sql = "insert into _historico".$valores['ano'].$valores['semestre']."
				select * from ouv_historico
					where ouv_historico.id_ouvidoria 
					in (select id_ouvidoria
							from _processo".$valores['ano'].$valores['semestre']."
								where _processo".$valores['ano'].$valores['semestre'].".data_ini between '".$inicio."' and '".$fim."'
								and _processo".$valores['ano'].$valores['semestre'].".form = ".$_SESSION['entidade'].")
					on duplicate key update 
					_historico".$valores['ano'].$valores['semestre'].".id_historico = _historico".$valores['ano'].$valores['semestre'].".id_historico";
		$res = $conexao -> query_transaction($sql);
		if (!$res) {
			$erro = 'Erro ao copiar dados de histуrico, aзгo cancelada';
			$conexao -> rollback();
			return $erro;
		}
		
		$sql = "insert into _denuncia".$valores['ano'].$valores['semestre']."
				select ouv_denuncia.* from ouv_denuncia
					inner join ouv_processo on ouv_processo.id_processo = ouv_denuncia.id_processo
						where ouv_processo.data_ini between '".$inicio."' and '".$fim."'
						and ouv_processo.form = ".$_SESSION['entidade']."
				on duplicate key update 
				_denuncia".$valores['ano'].$valores['semestre'].".id_denuncia = _denuncia".$valores['ano'].$valores['semestre'].".id_denuncia";
		$res = $conexao -> query_transaction($sql);
		if (!$res) {
			$erro = 'Erro ao copiar dados de denъncia, aзгo cancelada';
			$conexao -> rollback();
			return $erro;
		}
		
		//deletar dados das tabelas atuais
		$sql = "delete ouv_ouvidoria, ouv_historico, ouv_denuncia, ouv_processo from ouv_processo 
					inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
					inner join ouv_historico on ouv_historico.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
					left join ouv_denuncia on ouv_denuncia.id_processo = ouv_processo.id_processo
						where ouv_processo.id_processo in
						(select id_processo from _processo".$valores['ano'].$valores['semestre']." 
							where _processo".$valores['ano'].$valores['semestre'].".form = ".$_SESSION['entidade'].")";
		$res = $conexao -> query_transaction($sql);
		if (!$res) {
			$erro = 'Erro ao excluir registros, aзгo cancelada';
			$conexao -> rollback();
			return $erro;
		}*/		
		
		$conexao -> commit();
		return 1;
	}
	
	public function listar_periodos() {
		require_once('conexao.php');
		$conexao = new conexao();
		session_start();
		
		$sql = "show tables like '_ouvidoria%'";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	public function escolher($periodo) {
		session_start();
		$_SESSION['periodo'] = $periodo;
	}
	
}
?>