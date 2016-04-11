<?php
require ('../../classe/ouvidoria.php');



class processo extends ouvidoria{
		
	
	
	
	 public function InsertProcesso($id_tipo,$id_canal,$id_prioridade,$nome,$sexo,$data_nasc,$escolaridade,$email,$endereco,$bairro,$cidade,$telefone,$celular,$prim_rec,$comentario, $id_entidade, $data_ini)
	{

		$data_fim= $this->add_data();

		$sql_insert="call ins_ouvidoria(".$id_tipo.",".$id_canal.",".$id_prioridade.",'".$nome."','".$sexo."','".$data_nasc."','".$escolaridade."','".$email."','".$endereco."','".$bairro."','".$cidade."', '".$telefone."', 
							'".$celular."', '".$prim_rec."', '".$comentario."', ".$id_entidade.", '".$data_ini."', '".$data_fim."')";  
  
		
		$Acesso = new conexao();
		
		

		$this->Result=$Acesso->Query($sql_insert,$Acesso->cnx_p);

		
	}


public function ListOuvidoria()
{

		$sql_list="

select @ouv:=ouv_ouvidoria.id_ouvidoria as a, 
			(select ouv_status.status from ouv_status 
			inner join ouv_historico on ouv_historico.id_status = ouv_status.id_status where ouv_historico.id_historico = 
			(select max(id_historico) from ouv_ouvidoria where ouv_historico.id_ouvidoria = @ouv ) 
			order by id_historico desc limit 1) as status_atual,
			ouv_ouvidoria.*, ouv_processo.protocolo, ouv_tipo.tipo, date_format(ouv_processo.data_ini, '%d/%m/%Y %H:%i:%s') as data, 
				date_format(ouv_processo.data_fim, '%d/%m/%Y') as data_fim, 
				if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'Não especificado') as entidade, ouv_status.status,
				ouv_prioridade.prioridade
					from ouv_ouvidoria
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_prioridade on ouv_prioridade.id_prioridade = ouv_ouvidoria.id_prioridade
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo
						inner join ouv_historico on ouv_historico.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_status on ouv_status.id_status = ouv_historico.id_status
							group by ouv_ouvidoria.id_ouvidoria
									order by data desc
										limit 10";  
  
		
		$Acesso = new conexao();

		$this->Result=$Acesso->Query($sql_list,$Acesso->cnx_p);

}



public function Listdenuncia()
{

		$sql_list="

select @ouv:=ouv_ouvidoria.id_ouvidoria as a, 
			(select ouv_status.status from ouv_status 
			inner join ouv_historico on ouv_historico.id_status = ouv_status.id_status where ouv_historico.id_historico = 
			(select max(id_historico) from ouv_ouvidoria where ouv_historico.id_ouvidoria = @ouv ) 
			order by id_historico desc limit 1) as status_atual,
			ouv_ouvidoria.*, ouv_processo.protocolo, ouv_tipo.tipo, date_format(ouv_processo.data_ini, '%d/%m/%Y %H:%i:%s') as data, 
				date_format(ouv_processo.data_fim, '%d/%m/%Y') as data_fim, 
				if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'Não especificado') as entidade, ouv_status.status,
				ouv_prioridade.prioridade
					from ouv_ouvidoria
					    
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_denuncia on ouv_processo.id_processo=ouv_denuncia.id_processo
						inner join ouv_prioridade on ouv_prioridade.id_prioridade = ouv_ouvidoria.id_prioridade
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo
						inner join ouv_historico on ouv_historico.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_status on ouv_status.id_status = ouv_historico.id_status
							group by ouv_ouvidoria.id_ouvidoria
									order by data desc
										limit 10";  
  
		
		$Acesso = new conexao();

		$this->Result=$Acesso->Query($sql_list,$Acesso->cnx_p);

}


public function ListProcesso($id)

{

$sql_p="select *, date_format(data_ini, '%d/%m/%Y %H:%i:%s') as data,
				date_format(data_nasc, '%d/%m/%Y') as data_nasc,
				date_format(data_fim,'%d/%m/%Y') as data_fim,
				if(ouv_entidade.id_entidade = 0,'Não especificado',ouv_entidade.id_entidade) as ent,
				ouv_entidade.entidade as entidade, ouv_perfil.alterar as alt,
				(select ouv_status.status from ouv_status 
				inner join ouv_historico on ouv_historico.id_status = ouv_status.id_status where ouv_historico.id_historico = 
				(select max(id_historico) from ouv_ouvidoria where ouv_historico.id_ouvidoria = ".$id." ) 
				order by id_historico desc limit 1) as status_atual,
				(select ouv_historico.resumo from ouv_historico where ouv_historico.id_historico = 
				(select max(id_historico) from ouv_ouvidoria where ouv_historico.id_ouvidoria = ".$id."  ) 
				order by id_historico desc limit 1) as resumo_atual,
				(select ouv_status.id_status from ouv_status 
				inner join ouv_historico on ouv_historico.id_status = ouv_status.id_status where ouv_historico.id_historico = 
				(select max(id_historico) from ouv_ouvidoria where ouv_historico.id_ouvidoria = ".$id." ) 
				order by id_historico desc limit 1) as id_status_atual
					from ouv_ouvidoria 
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_prioridade on ouv_prioridade.id_prioridade = ouv_ouvidoria.id_prioridade
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						inner join ouv_usuario on ouv_usuario.id_entidade = ouv_entidade.id_entidade
						inner join ouv_perfil on ouv_perfil.id_perfil = ouv_usuario.id_perfil
						inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo
						inner join ouv_historico on ouv_historico.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_status on ouv_status.id_status = ouv_historico.id_status
							where ouv_ouvidoria.id_ouvidoria = ".$id."
								group by ouv_ouvidoria.id_ouvidoria";
								
								


$Acesso = new conexao();
$this->Result=$Acesso->Query($sql_p,$Acesso->cnx_p);

}

public function viewdenuncia($id)

{

$sql_p="select *, date_format(data_ini, '%d/%m/%Y %H:%i:%s') as data,ouv_denuncia.profissao,
				date_format(data_nasc, '%d/%m/%Y') as data_nasc,
				date_format(data_fim,'%d/%m/%Y') as data_fim,
				if(ouv_entidade.id_entidade = 0,'Não especificado',ouv_entidade.id_entidade) as ent,
				ouv_entidade.entidade as entidade, ouv_perfil.alterar as alt,
				(select ouv_status.status from ouv_status 
				inner join ouv_historico on ouv_historico.id_status = ouv_status.id_status where ouv_historico.id_historico = 
				(select max(id_historico) from ouv_ouvidoria where ouv_historico.id_ouvidoria = ".$id." ) 
				order by id_historico desc limit 1) as status_atual,
				(select ouv_historico.resumo from ouv_historico where ouv_historico.id_historico = 
				(select max(id_historico) from ouv_ouvidoria where ouv_historico.id_ouvidoria = ".$id."  ) 
				order by id_historico desc limit 1) as resumo_atual,
				(select ouv_status.id_status from ouv_status 
				inner join ouv_historico on ouv_historico.id_status = ouv_status.id_status where ouv_historico.id_historico = 
				(select max(id_historico) from ouv_ouvidoria where ouv_historico.id_ouvidoria = ".$id." ) 
				order by id_historico desc limit 1) as id_status_atual
					from ouv_ouvidoria 
					    
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_denuncia on ouv_denuncia.id_processo = ouv_processo.id_processo
						inner join ouv_prioridade on ouv_prioridade.id_prioridade = ouv_ouvidoria.id_prioridade
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						inner join ouv_usuario on ouv_usuario.id_entidade = ouv_entidade.id_entidade
						inner join ouv_perfil on ouv_perfil.id_perfil = ouv_usuario.id_perfil
						inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo
						inner join ouv_historico on ouv_historico.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_status on ouv_status.id_status = ouv_historico.id_status
							where ouv_ouvidoria.id_ouvidoria = ".$id."
								group by ouv_ouvidoria.id_ouvidoria";
								
								


$Acesso = new conexao();
$this->Result=$Acesso->Query($sql_p,$Acesso->cnx_p);

}

}
?>
