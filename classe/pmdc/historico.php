<?php
require_once('../conexao.php');

class historico {

	/*------------- Função para incluir dados no banco --------------*/
	public function incluir($valores) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$conexao -> begin();
		
		//publico padrao
		
		//inserir
		//processo respondido
		if ($valores['novo_status'] == 5) {
			$sql = "insert into ouv_historico (id_ouvidoria, data, id_status, resumo, id_origem, id_destino, id_resposta_padrao, id_usuario, publico) 
					values (".$valores['id_ouvidoria'].",'".date('Y-m-d H:i:s')."','".$valores['novo_status']."',
					'".mysql_real_escape_string($valores['resumo'])."',".$_SESSION['entidade'].",".$valores['entidade'].",
					'".$valores['resposta_padrao']."','".$_SESSION['usuario']."',".$valores['publico'].")";
		}
		else {
			if ($valores['novo_status'] == 2) {
				$sql = "insert into ouv_historico (id_ouvidoria, data, id_status, resumo, id_destino, id_resposta_padrao, id_usuario, publico) 
					values (".$valores['id_ouvidoria'].",'".date('Y-m-d H:i:s')."','".$valores['novo_status']."',
					'".mysql_real_escape_string($valores['resumo'])."',".$valores['entidade'].",
					'".$valores['resposta_padrao']."','".$_SESSION['usuario']."',".$valores['publico'].")";
			}
			else {
				$sql = "insert into ouv_historico (id_ouvidoria, data, id_status, resumo, id_resposta_padrao, id_usuario, publico) 
						values (".$valores['id_ouvidoria'].",'".date('Y-m-d H:i:s')."','".$valores['novo_status']."',
						'".mysql_real_escape_string($valores['resumo'])."','".$valores['resposta_padrao']."','".$_SESSION['usuario']."',".$valores['publico'].")";
			}
		}
		
		$conexao -> query($sql);
		
		
		if ($valores['cidadao'] == 1) {
			$sql = "update ouv_ouvidoria set resposta_cidadao = 1 where id_ouvidoria = ".$valores['id_ouvidoria'];
			$resultado = $conexao -> query($sql);
		}
		else {
			$sql = "update ouv_ouvidoria set resposta_cidadao = 0 where id_ouvidoria = ".$valores['id_ouvidoria'];
			$resultado = $conexao -> query($sql);
		}
		
		$conexao -> commit();
		
		if ($resultado) {
			//retorna 1 se não der erro
			return 1;
		}
	}
	
	/*------------- historico de um registro da ouvidoria --------------*/
	public function listar($id) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//buscar dados
		$sql = "select ouv_historico.*, ouv_status.status, date_format(ouv_historico.data, '%d/%m/%Y %H:%i:%s') as hdata,
				ouv_entidade.entidade as origem, if (ouv_historico.publico=1 and ouv_historico.id_usuario='','CIDADÃO',ouv_usuario.nome) as nome,
				ent.entidade as destino,
				if (ouv_historico.publico=0,'Privado','Público') as Acesso
					from ouv_historico 
						inner join ouv_status on ouv_historico.id_status = ouv_status.id_status
						left join ouv_usuario on ouv_usuario.id_usuario = ouv_historico.id_usuario
						left join ouv_entidade on ouv_entidade.id_entidade = ouv_historico.id_origem
						left join ouv_entidade ent on ent.id_entidade = ouv_historico.id_destino
							where id_ouvidoria = ".$id."
								order by data desc";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se não der erro
			return $resultado;
		}
	}
	
	public function listar_protocolo($protocolo) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$sql = "select ouv_historico.*, ouv_status.status, date_format(ouv_historico.data, '%d/%m/%Y %H:%i:%s') as hdata,
				ouv_entidade.entidade as origem, ent.entidade as destino
					from ouv_historico 
						inner join ouv_status on ouv_historico.id_status = ouv_status.id_status
						inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_historico.id_ouvidoria
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						left join ouv_entidade on ouv_entidade.id_entidade = ouv_historico.id_origem
						left join ouv_entidade ent on ent.id_entidade = ouv_historico.id_destino
							where ouv_processo.protocolo = '".$protocolo."'
							and ouv_processo.form = 1
								order by data desc";
		$resultado = $conexao -> Query($sql);
		return $resultado;
		//caso nao encontre o protocolo, buscar nas tabelas de backup
		/*if (mysql_num_rows($resultado) < 1) {
			$res = $this -> buscar_backup($protocolo);
			if ($res) {
				return $res;
			}
			else {
				return $resultado;
			}
		}
		else {
			//retorna o resultado
			return $resultado;
		}*/
	}
	
	/*---------------------- Função para buscar historico do protocolo nas tabelas de backup-----------------------------------*/
	public function buscar_backup($protocolo) {
		$conexao = new conexao();
		
		//buscar tabelas de backup
		$sql = "show tables like '_ouvidoria%'";
		$resultado = $conexao -> query($sql);
		
		while ($r = mysql_fetch_array($resultado)) {
			$periodo = substr($r[0],10);
			
			$sql = "select _historico".$periodo.".*, ouv_status.status, date_format(_historico".$periodo.".data, '%d/%m/%Y %H:%i:%s') as hdata,
				ouv_entidade.entidade as origem,
				ent.entidade as destino
					from _historico".$periodo." 
						inner join ouv_status on _historico".$periodo.".id_status = ouv_status.id_status
						inner join _ouvidoria".$periodo." on _ouvidoria".$periodo.".id_ouvidoria = _historico".$periodo.".id_ouvidoria
						inner join _processo".$periodo." on _processo".$periodo.".id_ouvidoria = _ouvidoria".$periodo.".id_ouvidoria
						left join ouv_entidade on ouv_entidade.id_entidade = _historico".$periodo.".id_origem
						left join ouv_entidade ent on ent.id_entidade = _historico".$periodo.".id_destino
							where _processo".$periodo.".protocolo = '".$protocolo."'
							and _processo".$periodo.".form = 1
								order by data desc";
			$result = $conexao -> query($sql);
			
			if (mysql_num_rows($result) > 0) {
				return $result;
			}
		}
	}
	
	/*------------- Função para incluir dados de registro pendente --------------*/
	public function incluir_pendentes() {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//buscar registros pendentes
		$sql = "select ouv_ouvidoria.id_ouvidoria
					from ouv_ouvidoria
						inner join ouv_processo on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
							where current_date() >= ouv_processo.data_fim
							and ouv_ouvidoria.id_status_atual not in (3,4,6)
							and ouv_processo.form = 1";
		$this -> resultado = $conexao -> query($sql);
		
		while ($r = mysql_fetch_array($this -> resultado)) {
			//inserir
			$sql = "insert into ouv_historico (id_ouvidoria, data, id_status, resumo, publico)
					values (".$r['id_ouvidoria'].",'".date('Y-m-d H:i:s')."','4',
					'Data limite de atendimento excedida',0)";
			$resultado = $conexao -> query($sql);
		}
	}
	
	/*------------- Função para incluir dados de visualização --------------*/
	public function incluir_visualizacao($id,$usuario) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$sql = "insert into ouv_historico (id_ouvidoria, data, id_status, resumo, id_usuario, publico) 
					values (".$id.",'".date('Y-m-d H:i:s')."',
					(select id_status_atual from ouv_ouvidoria where id_ouvidoria = ".$id."),
					'Visualização',".$usuario.", 0)";
		$resultado = $conexao -> query($sql);
	}
	
	public function incluir_email($sql) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$conexao -> query($sql);
	}
}