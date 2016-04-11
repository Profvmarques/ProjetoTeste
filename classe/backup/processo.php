<?php
require ('ouvidoria.php');
session_start();

class processo extends ouvidoria {
public function ListOuvidoria($entidade,$status,$ini=0) {
	$comp = '';
	if ($status != '') {
		$comp .= " and _ouvidoria".$_SESSION['periodo'].".id_status_atual = '".$status."'";
	}
	if ($entidade != '') {
		$comp .= " and _processo".$_SESSION['periodo'].".id_entidade = ".$entidade;
	}
	$sql_list="select * from _processo".$_SESSION['periodo']." 
				inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
					where _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']." 
					and _processo".$_SESSION['periodo'].".id_processo not in(select _denuncia".$_SESSION['periodo'].".id_processo from _denuncia".$_SESSION['periodo'].") 
					and _processo".$_SESSION['periodo'].".ativo = 1";

	$sql_list_p="select _ouvidoria".$_SESSION['periodo'].".*, _processo".$_SESSION['periodo'].".protocolo, ouv_assunto.assunto, 
		date_format(_processo".$_SESSION['periodo'].".data_ini, '%d/%m/%Y %H:%i:%s') as data, 
		date_format(_processo".$_SESSION['periodo'].".data_fim, '%d/%m/%Y') as data_fim, 
		if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'N√£o especificado') as entidade, 
		ouv_status.status as status_atual
			from _ouvidoria".$_SESSION['periodo']."
				inner join _processo".$_SESSION['periodo']." on _processo".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
				inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
				/*inner join ouv_usuario on (ouv_usuario.id_entidade = ouv_entidade.id_entidade or ouv_usuario.id_entidade = ouv_entidade.id_entidade_pai)
				inner join ouv_perfil on ouv_usuario.id_perfil = ouv_perfil.id_perfil
				*/inner join ouv_assunto on ouv_assunto.id_assunto = _ouvidoria".$_SESSION['periodo'].".id_assunto
				inner join _historico".$_SESSION['periodo']." on _historico".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
				inner join ouv_status on ouv_status.id_status = _ouvidoria".$_SESSION['periodo'].".id_status_atual
					where _processo".$_SESSION['periodo'].".id_processo not in(select _denuncia".$_SESSION['periodo'].".id_processo from _denuncia".$_SESSION['periodo'].")
						/*and ouv_usuario.id_usuario =".$_SESSION['usuario']."*/
						and _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
						and _processo".$_SESSION['periodo'].".ativo = 1
						".$comp."
							group by _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
								order by data_ini desc limit ".$ini.",10";
		
	$Acesso = new conexao();

	$this->Result=$Acesso->Query($sql_list_p,$Acesso->cnx_p);
	$this->Resultado=$Acesso->Query($sql_list,$Acesso->cnx_p);
}

public function ListInativos($entidade,$status,$ini=0) {
	$comp = '';
	if ($status != '') {
		$comp .= " and _ouvidoria".$_SESSION['periodo'].".id_status_atual = '".$status."'";
	}
	if ($entidade != '') {
		$comp .= " and _processo".$_SESSION['periodo'].".id_entidade = ".$entidade;
	}
	$sql_list="select * from _processo".$_SESSION['periodo']." 
				inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
					where _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']." 
					and _processo".$_SESSION['periodo'].".id_processo not in(select _denuncia".$_SESSION['periodo'].".id_processo from _denuncia".$_SESSION['periodo'].") 
					and _processo".$_SESSION['periodo'].".ativo = 0"; 
									
	$sql_list_p="select _ouvidoria".$_SESSION['periodo'].".*, _processo".$_SESSION['periodo'].".protocolo, ouv_assunto.assunto, 
		date_format(_processo".$_SESSION['periodo'].".data_ini, '%d/%m/%Y %H:%i:%s') as data, 
		date_format(_processo".$_SESSION['periodo'].".data_fim, '%d/%m/%Y') as data_fim, 
		if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'N√£o especificado') as entidade, 
		ouv_status.status as status_atual
			from _ouvidoria".$_SESSION['periodo']."
				inner join _processo".$_SESSION['periodo']." on _processo".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
				inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
				inner join ouv_usuario on (ouv_usuario.id_entidade = ouv_entidade.id_entidade or ouv_usuario.id_entidade = ouv_entidade.id_entidade_pai)
				inner join ouv_perfil on ouv_usuario.id_perfil = ouv_perfil.id_perfil
				inner join ouv_assunto on ouv_assunto.id_assunto = _ouvidoria".$_SESSION['periodo'].".id_assunto
				inner join _historico".$_SESSION['periodo']." on _historico".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
				inner join ouv_status on ouv_status.id_status = _ouvidoria".$_SESSION['periodo'].".id_status_atual
					where _processo".$_SESSION['periodo'].".id_processo not in(select _denuncia".$_SESSION['periodo'].".id_processo from _denuncia".$_SESSION['periodo'].")
						and ouv_usuario.id_usuario =".$_SESSION['usuario']."
						and _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
						and _processo".$_SESSION['periodo'].".ativo = 0
						".$comp."
							group by _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
								order by data_ini desc limit ".$ini.",10";
		
	$Acesso = new conexao();

	$this->Result=$Acesso->Query($sql_list_p,$Acesso->cnx_p);
	$this->Resultado=$Acesso->Query($sql_list,$Acesso->cnx_p);
}

public function ListProcesso($id) {
	$sql_p="select _ouvidoria".$_SESSION['periodo'].".*, _processo".$_SESSION['periodo'].".*, ouv_assunto.*, ouv_status.*, ouv_perfil.alterar, 
				ouv_perfil.excluir, date_format(data_ini, '%d/%m/%Y %H:%i:%s') as data,
				date_format(data_nasc, '%d/%m/%Y') as data_nasc,
				date_format(data_fim,'%d/%m/%Y') as data_fim,
				if(ouv_entidade.id_entidade = 0,'N„o especificado',ouv_entidade.id_entidade) as ent,
				ouv_entidade.entidade as entidade, ouv_perfil.alterar as alt,
				ouv_tipo_usuario.descricao as tipo_usuario,
				(select ouv_status.status from ouv_status 
				inner join _historico".$_SESSION['periodo']." on _historico".$_SESSION['periodo'].".id_status = ouv_status.id_status 
				where _historico".$_SESSION['periodo'].".id_historico = 
				(select max(id_historico) from _ouvidoria".$_SESSION['periodo']." where _historico".$_SESSION['periodo'].".id_ouvidoria = ".$id." ) 
				order by id_historico desc limit 1) as status_atual,
				(select _historico".$_SESSION['periodo'].".resumo from _historico".$_SESSION['periodo']." where _historico".$_SESSION['periodo'].".id_historico = 
				(select max(id_historico) from _ouvidoria".$_SESSION['periodo']." where _historico".$_SESSION['periodo'].".id_ouvidoria = ".$id."  ) 
				order by id_historico desc limit 1) as resumo_atual,
				(select ouv_status.id_status from ouv_status 
				inner join _historico".$_SESSION['periodo']." on _historico".$_SESSION['periodo'].".id_status = ouv_status.id_status 
				where _historico".$_SESSION['periodo'].".id_historico = 
				(select max(id_historico) from _ouvidoria".$_SESSION['periodo']." where _historico".$_SESSION['periodo'].".id_ouvidoria = ".$id." ) 
				order by id_historico desc limit 1) as id_status_atual,
				ouv_prioridade.prioridade,
				ouv_subitem.id_subitem
					from _ouvidoria".$_SESSION['periodo']." 
						inner join _processo".$_SESSION['periodo']." on _processo".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
						left join ouv_tipo_usuario on ouv_tipo_usuario.id_tipo_usuario = _ouvidoria".$_SESSION['periodo'].".id_tipo_usuario
						inner join ouv_prioridade on ouv_prioridade.id_prioridade = _ouvidoria".$_SESSION['periodo'].".id_prioridade
						inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
						inner join ouv_usuario on (ouv_usuario.id_entidade = ouv_entidade.id_entidade or ouv_usuario.id_entidade = ouv_entidade.id_entidade_pai)
						inner join ouv_perfil on ouv_perfil.id_perfil = ouv_usuario.id_perfil
						inner join ouv_assunto on ouv_assunto.id_assunto = _ouvidoria".$_SESSION['periodo'].".id_assunto
						inner join _historico".$_SESSION['periodo']." on _historico".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
						inner join ouv_status on ouv_status.id_status = _historico".$_SESSION['periodo'].".id_status
						left join ouv_subitem on ouv_subitem.id_subitem = _ouvidoria".$_SESSION['periodo'].".id_subitem
							where _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = ".$id."
								and ouv_usuario.id_usuario = ".$_SESSION['usuario']."
									group by _ouvidoria".$_SESSION['periodo'].".id_ouvidoria";

	$Acesso = new conexao();
	$this->Result=$Acesso->Query($sql_p,$Acesso->cnx_p);
}

public function ListDenuncia($status,$ini=0) {
	$comp = '';
	if ($status != '') {
		$comp = " where _ouvidoria".$_SESSION['periodo'].".id_status_atual = '".$status."'";
	}

	$sql_list="select _ouvidoria".$_SESSION['periodo'].".*, _processo".$_SESSION['periodo'].".protocolo, ouv_assunto.*, 
				date_format(_processo".$_SESSION['periodo'].".data_ini, '%d/%m/%Y %H:%i:%s') as data, 
				date_format(_processo".$_SESSION['periodo'].".data_fim, '%d/%m/%Y') as data_fim, 
				if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'N„o especificado') as entidade, 
				ouv_status.status as status_atual
					from _ouvidoria".$_SESSION['periodo']."
						inner join _processo".$_SESSION['periodo']." on _processo".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
						inner join _denuncia".$_SESSION['periodo']." on _processo".$_SESSION['periodo'].".id_processo = _denuncia".$_SESSION['periodo'].".id_processo
						inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
						inner join ouv_assunto on ouv_assunto.id_assunto = _ouvidoria".$_SESSION['periodo'].".id_assunto
						inner join _historico".$_SESSION['periodo']." on _historico".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
						inner join ouv_status on ouv_status.id_status = _ouvidoria".$_SESSION['periodo'].".id_status_atual
							".$comp."
							and (ouv_entidade.id_entidade = ".$_SESSION['entidade']." or ouv_entidade.id_entidade_pai = ".$_SESSION['entidade'].")
							and _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
							and _processo".$_SESSION['periodo'].".ativo = 1
								group by _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
									order by data_ini desc
										limit ".$ini.",10";

	$sql_total="select * from _processo".$_SESSION['periodo']." 
					inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
						where _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
						and _processo".$_SESSION['periodo'].".id_processo in(select _denuncia".$_SESSION['periodo'].".id_processo from _denuncia".$_SESSION['periodo'].") 
						and _processo".$_SESSION['periodo'].".ativo = 1";
	$Acesso = new conexao();
	$this->Result=$Acesso->Query($sql_list,$Acesso->cnx_p);
	$this->Resultado=$Acesso->Query($sql_total,$Acesso->cnx_p);
}

public function ListInativos_d($status,$ini=0) {
	$comp = '';
	if ($status != '') {
		$comp = " where _ouvidoria".$_SESSION['periodo'].".id_status_atual = '".$status."'";
	}

	$sql_list="select _ouvidoria".$_SESSION['periodo'].".*, _processo".$_SESSION['periodo'].".protocolo, ouv_assunto.assunto, 
				date_format(_processo".$_SESSION['periodo'].".data_ini, '%d/%m/%Y %H:%i:%s') as data, 
				date_format(_processo".$_SESSION['periodo'].".data_fim, '%d/%m/%Y') as data_fim, 
				if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'N„o especificado') as entidade, 
				ouv_status.status as status_atual
					from _ouvidoria".$_SESSION['periodo']."
						inner join _processo".$_SESSION['periodo']." on _processo".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
						inner join _denuncia".$_SESSION['periodo']." on _processo".$_SESSION['periodo'].".id_processo = _denuncia".$_SESSION['periodo'].".id_processo
						inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
						inner join ouv_assunto on ouv_assunto.id_assunto = _ouvidoria".$_SESSION['periodo'].".id_assunto
						inner join _historico".$_SESSION['periodo']." on _historico".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
						inner join ouv_status on ouv_status.id_status = _ouvidoria".$_SESSION['periodo'].".id_status_atual
							".$comp."
							and (ouv_entidade.id_entidade = ".$_SESSION['entidade']." or ouv_entidade.id_entidade_pai = ".$_SESSION['entidade'].")
							and _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
							and _processo".$_SESSION['periodo'].".ativo = 0
								group by _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
									order by data_ini desc
										limit ".$ini.",10";
										
	$sql_total="select * from _processo".$_SESSION['periodo']." 
					inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
						where _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
						and _processo".$_SESSION['periodo'].".id_processo in(select _denuncia".$_SESSION['periodo'].".id_processo from _denuncia".$_SESSION['periodo'].") 
						and _processo".$_SESSION['periodo'].".ativo = 0";
	$Acesso = new conexao();
	$this->Result=$Acesso->Query($sql_list,$Acesso->cnx_p);
	$this->Resultado=$Acesso->Query($sql_total,$Acesso->cnx_p);
}

public function ListProcessoD($id)

{

$sql_p="select *, date_format(data_ini, '%d/%m/%Y %H:%i:%s') as data,
				date_format(data_nasc, '%d/%m/%Y') as data_nasc,
				date_format(data_fim,'%d/%m/%Y') as data_fim,
				if(ouv_entidade.id_entidade = 0,'N„o especificado',ouv_entidade.id_entidade) as ent,
				ouv_entidade.entidade as entidade, ouv_perfil.alterar as alt,
				ouv_perfil.excluir,
				(select ouv_status.status from ouv_status 
				inner join _historico".$_SESSION['periodo']." on _historico".$_SESSION['periodo'].".id_status = ouv_status.id_status 
				where _historico".$_SESSION['periodo'].".id_historico = 
				(select max(id_historico) from _ouvidoria".$_SESSION['periodo']." where _historico".$_SESSION['periodo'].".id_ouvidoria = ".$id." ) 
				order by id_historico desc limit 1) as status_atual,
				(select _historico".$_SESSION['periodo'].".resumo from _historico".$_SESSION['periodo']." where _historico".$_SESSION['periodo'].".id_historico = 
				(select max(id_historico) from _ouvidoria".$_SESSION['periodo']." where _historico".$_SESSION['periodo'].".id_ouvidoria = ".$id."  ) 
				order by id_historico desc limit 1) as resumo_atual,
				(select ouv_status.id_status from ouv_status 
				inner join _historico".$_SESSION['periodo']." on _historico".$_SESSION['periodo'].".id_status = ouv_status.id_status 
				where _historico".$_SESSION['periodo'].".id_historico = 
				(select max(id_historico) from _ouvidoria".$_SESSION['periodo']." where _historico".$_SESSION['periodo'].".id_ouvidoria = ".$id." ) 
				order by id_historico desc limit 1) as id_status_atual,
				_ouvidoria".$_SESSION['periodo'].".nome as nome_ouvidoria
					from _ouvidoria".$_SESSION['periodo']." 
						inner join _processo".$_SESSION['periodo']." on _processo".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
						inner join _denuncia".$_SESSION['periodo']." on _denuncia".$_SESSION['periodo'].".id_processo = _processo".$_SESSION['periodo'].".id_processo
						inner join ouv_prioridade on ouv_prioridade.id_prioridade = _ouvidoria".$_SESSION['periodo'].".id_prioridade
						inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
						inner join ouv_usuario on (ouv_usuario.id_entidade = ouv_entidade.id_entidade or ouv_usuario.id_entidade = ouv_entidade.id_entidade_pai)
						inner join ouv_perfil on ouv_perfil.id_perfil = ouv_usuario.id_perfil
						inner join ouv_assunto on ouv_assunto.id_assunto = _ouvidoria".$_SESSION['periodo'].".id_assunto
						inner join _historico".$_SESSION['periodo']." on _historico".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
						inner join ouv_status on ouv_status.id_status = _historico".$_SESSION['periodo'].".id_status
							where _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = ".$id."
							and ouv_usuario.id_usuario = ".$_SESSION['usuario']."
								group by _ouvidoria".$_SESSION['periodo'].".id_ouvidoria";



$Acesso = new conexao();
$this->Result=$Acesso->Query($sql_p,$Acesso->cnx_p);

}

public function id_resposta($id) {
	$Acesso = new conexao();
	$sql = "select id_resposta_padrao from _historico".$_SESSION['periodo']." where id_ouvidoria = ".$id." order by data desc limit 1";
	$r = $Acesso->Query($sql);
	
	return mysql_result($r,0,'id_resposta_padrao');
}

public function AlterarPrioridade($sql_u)
{

$Acesso = new conexao();
$this->Result=$Acesso->Query($sql_u,$Acesso->cnx_p);


}

public function alterar_entidade($entidade,$ouvidoria) {
	$Acesso = new conexao();
	
	$sql = "update _processo".$_SESSION['periodo']."
				inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
					set id_entidade = ".$entidade."
						where _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = ".$ouvidoria;
	$Acesso->Query($sql,$Acesso->cnx_p);
}

public function alterar_assunto($assunto,$ouvidoria) {
	$Acesso = new conexao();
	
	$sql = "update _ouvidoria".$_SESSION['periodo']."
				set id_assunto = ".$assunto.", id_subitem = null
					where _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = ".$ouvidoria;
	$Acesso->Query($sql,$Acesso->cnx_p);
}

public function alterar_subitem($subitem,$ouvidoria) {
	$Acesso = new conexao();
	
	$sql = "update _ouvidoria".$_SESSION['periodo']."
				set id_subitem = ".$subitem."
					where _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = ".$ouvidoria;
	$Acesso->Query($sql,$Acesso->cnx_p);
}

public function assunto($ouvidoria) {
	$Acesso = new conexao();
	
	$sql = "select id_assunto from _ouvidoria".$_SESSION['periodo']." where id_ouvidoria = ".$ouvidoria;
	$r = $Acesso->Query($sql,$Acesso->cnx_p);
	
	return $r;
}

	/*------------- FunÁ„o para contar o numero de mensagens para um assunto e uma entidade --------------*/
	//$datas => complemento para o sql limitar a data inicial e final
	public function contar($assunto=0,$entidade=0,$datas='',$status='',$tipo='') {
		//criar objeto da classe conex„o
		$conexao = new conexao();
		
		//complemento para o sql se apenas o assunto foi informado
		if ($assunto != 0 && $entidade == 0) {
			$comp = "where id_assunto = ".$assunto." and form = ".$_SESSION['entidade'];
		}
		
		//complemento para o sql se assunto e entidade foram informados
		if ($assunto != 0 && $entidade != 0) {
			$comp = "where (id_assunto = ".$assunto.") 
						and (_processo".$_SESSION['periodo'].".id_entidade = ".$entidade."
						and form = ".$_SESSION['entidade'].")";
		}
		
		//complemento para o sql se apenas a entidade foi informada
		if ($assunto == 0 && $entidade != 0) {
			$comp = "where form = ".$_SESSION['entidade'];
			
		}
		
		//limitar data inicial e final
		if ($datas != '') {
			$comp .= $datas;
		}
		
		//filtrar status
		if ($status != '') {
			$comp .= " and _ouvidoria".$_SESSION['periodo'].".id_status_atual = ".$status;
		}
		
		//filtrar tipo de usuario
		if ($tipo != '') {
			$comp .= " and _ouvidoria".$_SESSION['periodo'].".id_tipo_usuario = ".$tipo;
		}
		
		//faz a busca
		$sql = "select id_processo
					from _processo".$_SESSION['periodo']."
						inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
						inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
							".$comp."
							and _processo".$_SESSION['periodo'].".ativo = 1";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o numero de resultados se n„o der erro
			return mysql_num_rows($resultado);
		}
	}
	
	/*------------- FunÁ„o para buscar os assuntos de cada registro para cada segmento (opcional) na tabela ouvidoria --------------*/
	//$datas => complemento para o sql limitar a data inicial e final
	public function buscar_assuntos($entidade=0,$datas='',$status='',$tipo='') {
		//criar objeto da classe conex„o
		$conexao = new conexao();
		
		//complemento caso o segmento seja informado
		if ($entidade != 0) {
			$comp = " and _processo".$_SESSION['periodo'].".id_entidade = ".$entidade;
		}
		
		//limitar a data inicial e final
		if ($datas != '') {
			$comp .= $datas;
		}
		
		//filtrar status
		if ($status != '') {
			$comp .= " and _ouvidoria".$_SESSION['periodo'].".id_status_atual = ".$status;
		}
		
		//filtrar tipo de usuario
		if ($tipo != '') {
			$comp .= " and _ouvidoria".$_SESSION['periodo'].".id_tipo_usuario = ".$tipo;
		}
		
		//faz a busca
		$sql = "select ouv_assunto.id_assunto
					from _processo".$_SESSION['periodo']."
						inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
						inner join ouv_assunto on _ouvidoria".$_SESSION['periodo'].".id_assunto = ouv_assunto.id_assunto
						inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
							where _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
							".$comp."
							and _processo".$_SESSION['periodo'].".ativo = 1";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se n„o der erro
			return $resultado;
		}
	}
	
	/*------------- FunÁ„o para contar o numero de mensagens para um canal--------------*/
	//$datas => complemento para o sql limitar a data inicial e final
	public function contar_canal($canal) {
		//criar objeto da classe conex„o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select id_processo
					from _processo".$_SESSION['periodo']."
						inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
						inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
							where id_canal = ".$canal."
							and _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
							and _processo".$_SESSION['periodo'].".ativo = 1";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o numero de resultados se n„o der erro
			return mysql_num_rows($resultado);
		}
	}	
	
	/*------------- FunÁ„o para buscar os canais de cada registro na tabela ouvidoria --------------*/
	public function buscar_canais() {
		//criar objeto da classe conex„o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select ouv_canal.id_canal
					from _processo".$_SESSION['periodo']."
						inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
						inner join ouv_canal on _ouvidoria".$_SESSION['periodo'].".id_canal = ouv_canal.id_canal
						inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
							where _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
							and _processo".$_SESSION['periodo'].".ativo = 1";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se n„o der erro
			return $resultado;
		}
	}
	
	/*------------- FunÁ„o para buscar as entidades de cada registro na tabela processos --------------*/
	public function buscar_entidades() {
		//criar objeto da classe conex„o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select ouv_entidade.id_entidade
					from _processo".$_SESSION['periodo']."
						inner join ouv_entidade on _processo".$_SESSION['periodo'].".id_entidade = ouv_entidade.id_entidade
							where _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
							and _processo".$_SESSION['periodo'].".ativo = 1";

		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se n„o der erro
			return $resultado;
		}
	}
	
	/*------------- FunÁ„o para buscar os entidades de cada registro na tabela ouvidoria --------------*/
	public function contar_entidades($entidade) {
		//criar objeto da classe conex„o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select id_processo
					from _processo".$_SESSION['periodo']."
						inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
						inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
							where _processo".$_SESSION['periodo'].".form = ".$entidade."
							and _processo".$_SESSION['periodo'].".ativo = 1";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se n„o der erro
			return mysql_num_rows($resultado);
		}
	}
	/*------------- FunÁ„o para contar os registros de cada entidade para o relatorio geral de demandas --------------*/
	public function contar_demanda($entidade) {
		//criar objeto da classe conex„o
		$conexao = new conexao();
		
		//faz a busca
		$sql = "select id_processo 
				from _processo".$_SESSION['periodo']." 
					inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria 
						where _processo".$_SESSION['periodo'].".id_entidade = ".$entidade." 
						and form = ".$_SESSION['entidade']."
						and _processo".$_SESSION['periodo'].".ativo = 1";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se n„o der erro
			return mysql_num_rows($resultado);
		}
	}

public function pesquisar($entidade,$tipo,$busca,$inicio=0) {	
	//criar objeto da classe conex√£o
	$conexao = new conexao();
	
	//filtros
	$comp = '';
	if ($entidade != '') {
		$comp .= " and _processo".$_SESSION['periodo'].".id_entidade = ".$entidade;
	}
	if ($tipo == 1) {
		$comp .= " and _processo".$_SESSION['periodo'].".protocolo = '".$busca."'";
	}
	if ($tipo == 2) {
		$comp .= " and _ouvidoria".$_SESSION['periodo'].".nome like '%".$busca."%'";
	}
	
	session_start();
	
	//faz a busca de acordo com as permissoes do usuario
	$sql = "select _ouvidoria".$_SESSION['periodo'].".*, _processo".$_SESSION['periodo'].".protocolo, ouv_assunto.assunto, 
			date_format(_processo".$_SESSION['periodo'].".data_ini, '%d/%m/%Y %H:%i:%s') as data, 
			date_format(_processo".$_SESSION['periodo'].".data_fim, '%d/%m/%Y') as data_fim, 
			if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'N√£o especificado') as entidade, 
			ouv_status.status as status_atual,
			ouv_prioridade.prioridade
				from _ouvidoria".$_SESSION['periodo']."
					inner join _processo".$_SESSION['periodo']." on _processo".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
					inner join ouv_prioridade on ouv_prioridade.id_prioridade = _ouvidoria".$_SESSION['periodo'].".id_prioridade
					inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
					/*inner join ouv_usuario on (ouv_usuario.id_entidade = ouv_entidade.id_entidade or ouv_usuario.id_entidade = ouv_entidade.id_entidade_pai)
					inner join ouv_perfil on ouv_usuario.id_perfil = ouv_perfil.id_perfil*/
					inner join ouv_assunto on ouv_assunto.id_assunto = _ouvidoria".$_SESSION['periodo'].".id_assunto
					inner join _historico".$_SESSION['periodo']." on _historico".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
					inner join ouv_status on ouv_status.id_status = _ouvidoria".$_SESSION['periodo'].".id_status_atual
						/*where ouv_usuario.id_usuario = ".$_SESSION['usuario']."*/
						and _processo".$_SESSION['periodo'].".id_processo not in(select _denuncia".$_SESSION['periodo'].".id_processo from _denuncia".$_SESSION['periodo'].")
						/*and (_processo".$_SESSION['periodo'].".id_entidade = ".$_SESSION['entidade']." 
							or _historico".$_SESSION['periodo'].".id_destino = ".$_SESSION['entidade']."
							 or ouv_entidade.id_entidade_pai = ".$_SESSION['entidade'].")*/
						and _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
						".$comp."
						and _processo".$_SESSION['periodo'].".ativo = 1
							group by _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
								order by data desc
									limit ".$inicio.",10";

	$resultado = $conexao -> query($sql);

	if ($resultado) {
		//retorna o resultado se n√£o der erro
		$this -> Result = $resultado;
	}			
	
	//faz a busca do total de registros
	$sql = "select * from _processo".$_SESSION['periodo']." 
				inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
				inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
					where _processo".$_SESSION['periodo'].".form = 10
					and _processo".$_SESSION['periodo'].".id_processo not in(select _denuncia".$_SESSION['periodo'].".id_processo from _denuncia".$_SESSION['periodo'].") 
					and _processo".$_SESSION['periodo'].".ativo = 1
					".$comp;
	$resultado_total = $conexao -> query($sql);

	if ($resultado_total) {
		//retorna o numero de resultados se n„o der erro
		$this -> Resultado = $resultado_total;
	}				
}

public function pesquisar_denuncia($entidade,$tipo,$busca,$inicio=0) {	
	//criar objeto da classe conex√£o
	$conexao = new conexao();
	
	//filtros
	$comp = '';
	if ($entidade != '') {
		$comp .= " and _processo".$_SESSION['periodo'].".id_entidade = ".$entidade;
	}
	if ($tipo == 1) {
		$comp .= " and _processo".$_SESSION['periodo'].".protocolo = '".$busca."'";
	}
	if ($tipo == 2) {
		$comp .= " and _ouvidoria".$_SESSION['periodo'].".nome like '%".$busca."%'";
	}
	
	session_start();
	
	//faz a busca de acordo com as permissoes do usuario
	$sql = "select _ouvidoria".$_SESSION['periodo'].".*, _processo".$_SESSION['periodo'].".protocolo, ouv_assunto.assunto, 
			date_format(_processo".$_SESSION['periodo'].".data_ini, '%d/%m/%Y %H:%i:%s') as data, 
			date_format(_processo".$_SESSION['periodo'].".data_fim, '%d/%m/%Y') as data_fim, 
			if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'N√£o especificado') as entidade, 
			ouv_status.status as status_atual,
			ouv_prioridade.prioridade
				from _ouvidoria".$_SESSION['periodo']."
					inner join _processo".$_SESSION['periodo']." on _processo".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
					inner join ouv_prioridade on ouv_prioridade.id_prioridade = _ouvidoria".$_SESSION['periodo'].".id_prioridade
					inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
					inner join ouv_usuario on (ouv_usuario.id_entidade = ouv_entidade.id_entidade or ouv_usuario.id_entidade = ouv_entidade.id_entidade_pai)
					inner join ouv_perfil on ouv_usuario.id_perfil = ouv_perfil.id_perfil
					inner join ouv_assunto on ouv_assunto.id_assunto = _ouvidoria".$_SESSION['periodo'].".id_assunto
					inner join _historico".$_SESSION['periodo']." on _historico".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
					inner join ouv_status on ouv_status.id_status = _ouvidoria".$_SESSION['periodo'].".id_status_atual
						where ouv_usuario.id_usuario = ".$_SESSION['usuario']."
						and _processo".$_SESSION['periodo'].".id_processo in(select _denuncia".$_SESSION['periodo'].".id_processo from _denuncia".$_SESSION['periodo'].")
						and (_processo".$_SESSION['periodo'].".id_entidade = ".$_SESSION['entidade']." 
							or _historico".$_SESSION['periodo'].".id_destino = ".$_SESSION['entidade']."
							 or ouv_entidade.id_entidade_pai = ".$_SESSION['entidade'].")
						".$comp."
						and _processo".$_SESSION['periodo'].".ativo = 1
							group by _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
								order by data desc
									limit ".$inicio.",10";

	$resultado = $conexao -> query($sql);

	if ($resultado) {
		//retorna o resultado se n√£o der erro
		$this -> Result = $resultado;
	}			
	
	//faz a busca do total de registros
	$sql = "select * from _processo".$_SESSION['periodo']." 
				inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
				inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
					where _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
					and _processo".$_SESSION['periodo'].".id_processo not in(select _denuncia".$_SESSION['periodo'].".id_processo from _denuncia".$_SESSION['periodo'].") 
					and _processo".$_SESSION['periodo'].".ativo = 1
					".$comp;
	$resultado_total = $conexao -> query($sql);

	if ($resultado_total) {
		//retorna o numero de resultados se n„o der erro
		$this -> Resultado = $resultado_total;
	}				
}

public function pesquisar_inativos($entidade,$tipo,$busca,$inicio=0) {	
	//criar objeto da classe conex√£o
	$conexao = new conexao();
	
	//filtros
	$comp = '';
	if ($entidade != '') {
		$comp .= " and _processo".$_SESSION['periodo'].".id_entidade = ".$entidade;
	}
	if ($tipo == 1) {
		$comp .= " and _processo".$_SESSION['periodo'].".protocolo = '".$busca."'";
	}
	if ($tipo == 2) {
		$comp .= " and _ouvidoria".$_SESSION['periodo'].".nome like '%".$busca."%'";
	}
	
	session_start();
	
	//faz a busca de acordo com as permissoes do usuario
	$sql = "select _ouvidoria".$_SESSION['periodo'].".*, _processo".$_SESSION['periodo'].".protocolo, ouv_assunto.assunto, 
			date_format(_processo".$_SESSION['periodo'].".data_ini, '%d/%m/%Y %H:%i:%s') as data, 
			date_format(_processo".$_SESSION['periodo'].".data_fim, '%d/%m/%Y') as data_fim, 
			if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'N√£o especificado') as entidade, 
			ouv_status.status as status_atual,
			ouv_prioridade.prioridade
				from _ouvidoria".$_SESSION['periodo']."
					inner join _processo".$_SESSION['periodo']." on _processo".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
					inner join ouv_prioridade on ouv_prioridade.id_prioridade = _ouvidoria".$_SESSION['periodo'].".id_prioridade
					inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
					inner join ouv_usuario on (ouv_usuario.id_entidade = ouv_entidade.id_entidade or ouv_usuario.id_entidade = ouv_entidade.id_entidade_pai)
					inner join ouv_perfil on ouv_usuario.id_perfil = ouv_perfil.id_perfil
					inner join ouv_assunto on ouv_assunto.id_assunto = _ouvidoria".$_SESSION['periodo'].".id_assunto
					inner join _historico".$_SESSION['periodo']." on _historico".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
					inner join ouv_status on ouv_status.id_status = _ouvidoria".$_SESSION['periodo'].".id_status_atual
						where ouv_usuario.id_usuario = ".$_SESSION['usuario']."
						and (_processo".$_SESSION['periodo'].".id_entidade = ".$_SESSION['entidade']." 
						and _processo".$_SESSION['periodo'].".id_processo not in(select _denuncia".$_SESSION['periodo'].".id_processo from _denuncia".$_SESSION['periodo'].")
							or _historico".$_SESSION['periodo'].".id_destino = ".$_SESSION['entidade']."
							 or ouv_entidade.id_entidade_pai = ".$_SESSION['entidade'].")
						".$comp."
						and _processo".$_SESSION['periodo'].".ativo = 0
							group by _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
								order by data desc
									limit ".$inicio.",10";

	$resultado = $conexao -> query($sql);

	if ($resultado) {
		//retorna o resultado se n√£o der erro
		$this -> Result = $resultado;
	}			
	
	//faz a busca do total de registros
	$sql = "select * from _processo".$_SESSION['periodo']." 
				inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
				inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
					where _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
					and _processo".$_SESSION['periodo'].".id_processo in(select _denuncia".$_SESSION['periodo'].".id_processo from _denuncia".$_SESSION['periodo'].") 
					and _processo".$_SESSION['periodo'].".ativo = 0
					".$comp;
	$resultado_total = $conexao -> query($sql);

	if ($resultado_total) {
		//retorna o numero de resultados se n„o der erro
		$this -> Resultado = $resultado_total;
	}				
}

public function pesquisar_denuncias_inativas($entidade,$tipo,$busca,$inicio=0) {	
	//criar objeto da classe conex√£o
	$conexao = new conexao();
	
	//filtros
	$comp = '';
	if ($entidade != '') {
		$comp .= " and _processo".$_SESSION['periodo'].".id_entidade = ".$entidade;
	}
	if ($tipo == 1) {
		$comp .= " and _processo".$_SESSION['periodo'].".protocolo = '".$busca."'";
	}
	if ($tipo == 2) {
		$comp .= " and _ouvidoria".$_SESSION['periodo'].".nome like '%".$busca."%'";
	}
	
	session_start();
	
	//faz a busca de acordo com as permissoes do usuario
	$sql = "select _ouvidoria".$_SESSION['periodo'].".*, _processo".$_SESSION['periodo'].".protocolo, ouv_assunto.assunto, 
			date_format(_processo".$_SESSION['periodo'].".data_ini, '%d/%m/%Y %H:%i:%s') as data, 
			date_format(_processo".$_SESSION['periodo'].".data_fim, '%d/%m/%Y') as data_fim, 
			if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'N√£o especificado') as entidade, 
			ouv_status.status as status_atual,
			ouv_prioridade.prioridade
				from _ouvidoria".$_SESSION['periodo']."
					inner join _processo".$_SESSION['periodo']." on _processo".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
					inner join ouv_prioridade on ouv_prioridade.id_prioridade = _ouvidoria".$_SESSION['periodo'].".id_prioridade
					inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
					inner join ouv_usuario on (ouv_usuario.id_entidade = ouv_entidade.id_entidade or ouv_usuario.id_entidade = ouv_entidade.id_entidade_pai)
					inner join ouv_perfil on ouv_usuario.id_perfil = ouv_perfil.id_perfil
					inner join ouv_assunto on ouv_assunto.id_assunto = _ouvidoria".$_SESSION['periodo'].".id_assunto
					inner join _historico".$_SESSION['periodo']." on _historico".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
					inner join ouv_status on ouv_status.id_status = _ouvidoria".$_SESSION['periodo'].".id_status_atual
						where ouv_usuario.id_usuario = ".$_SESSION['usuario']."
						and (_processo".$_SESSION['periodo'].".id_entidade = ".$_SESSION['entidade']." 
						and _processo".$_SESSION['periodo'].".id_processo in(select _denuncia".$_SESSION['periodo'].".id_processo from _denuncia".$_SESSION['periodo'].")
							or _historico".$_SESSION['periodo'].".id_destino = ".$_SESSION['entidade']."
							 or ouv_entidade.id_entidade_pai = ".$_SESSION['entidade'].")
						".$comp."
						and _processo".$_SESSION['periodo'].".ativo = 0
							group by _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
								order by data desc
									limit ".$inicio.",10";

	$resultado = $conexao -> query($sql);

	if ($resultado) {
		//retorna o resultado se n√£o der erro
		$this -> Result = $resultado;
	}			
	
	//faz a busca do total de registros
	$sql = "select * from _processo".$_SESSION['periodo']." 
				inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
				inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
					where _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
					and _processo".$_SESSION['periodo'].".id_processo in(select _denuncia".$_SESSION['periodo'].".id_processo from _denuncia".$_SESSION['periodo'].") 
					and _processo".$_SESSION['periodo'].".ativo = 0
					".$comp;
	$resultado_total = $conexao -> query($sql);

	if ($resultado_total) {
		//retorna o numero de resultados se n„o der erro
		$this -> Resultado = $resultado_total;
	}				
}

	/*------------- FunÁ„o para atualizar o status_atual de um registro da ouvidoria para pendente quando a data limite for alcanÁada --------------*/
	public function atualizar_pendencias() {
		//criar objeto da classe conex„o
		$conexao = new conexao();
		
		//atualizacao
		$sql = "update _ouvidoria".$_SESSION['periodo']."
					inner join _processo".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
						set _ouvidoria".$_SESSION['periodo'].".id_status_atual = 4
							where current_date() >= _processo".$_SESSION['periodo'].".data_fim
							and _ouvidoria".$_SESSION['periodo'].".id_status_atual not in (3,4,6)
							and _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade'];
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se n„o der erro
			return 1;
		}
	}
	
	//numero de processos por dia em um determinado periodo para o relatorio por entidades
	public function processos_por_dia($inicio, $fim, $entidade, $status = '', $tipo = '') {
		//criar objeto da classe conex„o
		$conexao = new conexao();
		
		//filtrar status
		if ($status != '') {
			$comp = "and _ouvidoria".$_SESSION['periodo'].".id_status_atual = ".$status;
		}
		
		//filtrar tipo de usuario
		if ($tipo != '') {
			$comp = "and _ouvidoria".$_SESSION['periodo'].".id_tipo_usuario = ".$tipo;
		}
		
		//busca
		$sql = "select count(id_processo)as total, date_format(date(data_ini),'%d/%m/%Y') as data
					from _processo".$_SESSION['periodo']."
						inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
							where date(data_ini) between '".$inicio."' and '".$fim."'
							and _processo".$_SESSION['periodo'].".id_entidade = ".$entidade."
							and _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
							and _processo".$_SESSION['periodo'].".ativo = 1
							".$comp."
								group by date(data_ini)";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//numero de processos para cada status em um determinado periodo para o relatorio comparativo
	public function processos_por_status($inicio,$fim,$entidade='') {
		//criar objeto da classe conex„o
		$conexao = new conexao();
		
		if ($entidade != '') {
			$comp = "and _processo".$_SESSION['periodo'].".id_entidade = ".$entidade;
		}
		
		$sql = "select count(_processo".$_SESSION['periodo'].".id_processo) as total, ouv_status.status
					from _processo".$_SESSION['periodo']."
						inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
						inner join ouv_status on ouv_status.id_status = _ouvidoria".$_SESSION['periodo'].".id_status_atual
							where date(data_ini) between '".$inicio."' and '".$fim."'
							and _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
							and _processo".$_SESSION['periodo'].".ativo = 1
							".$comp."
								group by ouv_status.id_status";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
}
?>