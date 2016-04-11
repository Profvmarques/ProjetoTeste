<?php 
require_once('../../classe/conexao.php');

class historico{
	
	public function listhistprotocolo($protocolo) {
		$sql = "select _historico".$_SESSION['periodo'].".*, ouv_status.status, date_format(_historico".$_SESSION['periodo'].".data, '%d/%m/%Y %H:%i:%s') as hdata,
				ouv_entidade.entidade as origem,
				ent.entidade as destino
					from _historico".$_SESSION['periodo']." 
						inner join ouv_status on _historico".$_SESSION['periodo'].".id_status = ouv_status.id_status
						inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _historico".$_SESSION['periodo'].".id_ouvidoria
						inner join _processo".$_SESSION['periodo']." on _processo".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
						left join ouv_entidade on ouv_entidade.id_entidade = _historico".$_SESSION['periodo'].".id_origem
						left join ouv_entidade ent on ent.id_entidade = _historico".$_SESSION['periodo'].".id_destino
							where _processo".$_SESSION['periodo'].".protocolo = '".$protocolo."'
							and _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
								order by data desc";
		$Acesso = new conexao();
		$this->Result=$Acesso->Query($sql,$Acesso->cnx_p);
	}
	
	public function ListHistoricoO($id)	{
		$sql = "select _historico".$_SESSION['periodo'].".*, ouv_status.status, date_format(_historico".$_SESSION['periodo'].".data, '%d/%m/%Y %H:%i:%s') as hdata,
					if (publico=1,'Pъblico','Privado') as acesso,
					ouv_entidade.entidade as origem,ouv_usuario.nome,
					ent.entidade as destino
						from _historico".$_SESSION['periodo']." 
							inner join ouv_status on _historico".$_SESSION['periodo'].".id_status = ouv_status.id_status
							left join ouv_usuario on ouv_usuario.id_usuario = _historico".$_SESSION['periodo'].".id_usuario
							left join ouv_entidade on ouv_entidade.id_entidade = _historico".$_SESSION['periodo'].".id_origem
							left join ouv_entidade ent on ent.id_entidade = _historico".$_SESSION['periodo'].".id_destino
								where id_ouvidoria = ".$id."
									order by data desc";
		$Acesso = new conexao();
		$this->Result=$Acesso->Query($sql,$Acesso->cnx_p);
	}
	
	public function Incluir($sql) {
		$Acesso = new conexao();
		$this->Result=$Acesso->Query($sql,$Acesso->cnx_p);
	}

	public function Update($sql) {
		$Acesso = new conexao();
		$this->Result=$Acesso->Query($sql,$Acesso->cnx_p);
	}

	/*------------- Funзгo para incluir dados de registro pendente --------------*/
	public function incluir_pendentes() {
		//criar objeto da classe conexгo
		$conexao = new conexao();
		
		//buscar registros pendentes
		$sql = "select _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
					from _ouvidoria".$_SESSION['periodo']."
						inner join _processo".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
							where current_date() >= _processo".$_SESSION['periodo'].".data_fim
							and _ouvidoria".$_SESSION['periodo'].".id_status_atual not in (3,4,6)
							and _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade'];
		$this -> resultado = $conexao -> query($sql);
		
		while ($r = mysql_fetch_array($this -> resultado)) {
			//inserir
			$sql = "insert into _historico".$_SESSION['periodo']." (id_ouvidoria, data, id_status, resumo) 
					values (".$r['id_ouvidoria'].",'".date('Y-m-d H:i:s')."','4',
					'Data limite de atendimento excedida')";
			$resultado = $conexao -> query($sql);
		}
	}
	
	/*------------- Funзгo para incluir dados de visualizaзгo --------------*/
	public function incluir_visualizacao($id,$usuario) {
		//criar objeto da classe conexгo
		$conexao = new conexao();
		
		$sql = "insert into _historico".$_SESSION['periodo']." (id_ouvidoria, data, id_status, resumo, id_usuario, publico) 
					values (".$id.",'".date('Y-m-d H:i:s')."',
					(select id_status_atual from _ouvidoria".$_SESSION['periodo']." where id_ouvidoria = ".$id."),
					'Visualizaзгo',".$usuario.", 0)";
		$resultado = $conexao -> query($sql);
	}
	
}
?>