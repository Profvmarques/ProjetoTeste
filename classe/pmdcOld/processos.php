<?php 
require_once('../ouvidoria.php');

class processos extends ouvidoria{
	
	/*------------- Função para incluir dados no banco --------------*/
	public function incluir($valores) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//data de nascimento
		$d = explode("/",$valores['data_nasc']);
		$data_nasc = $d[2]."-".$d[1]."-".$d[0];
		
		//calcular data limite
		$data_limite = $this -> add_data(1);
		
		if ($valores['canal'] == '') {
			$canal = 5;
		}
		else {
			$canal = $valores['canal'];
		}
		
		$valores['nome'] = str_replace("'","\'",$valores['nome']);
		$valores['endereco'] = str_replace("'","\'",$valores['endereco']);
		$valores['bairro'] = str_replace("'","\'",$valores['bairro']);
		$valores['cidade'] = str_replace("'","\'",$valores['cidade']);
		
		//inserir
		$conexao -> begin();
		
		$sql = "insert into ouv_ouvidoria  (id_tipo,id_canal,id_prioridade,nome,cpf,sexo,data_nasc,escolaridade,email,endereco,bairro,
				cidade,telefone,celular,prim_rec,protocolo_anterior,comentario,id_status_atual, id_tipo_usuario, id_deficiencia, id_assunto, id_modalidade) values 
				(".$valores['tipo'].",".$canal.",1,'".$valores['nome']."','".$valores['cpf']."','".$valores['sexo']."','".$data_nasc."',
				'".$valores['escolaridade']."','".$valores['email']."','".$valores['endereco']."','".$valores['bairro']."','".$valores['cidade']."',
				'".$valores['telefone']."','".$valores['celular']."','".$valores['question']."','".mysql_real_escape_string($valores['protocolo_anterior'])."',
				'".mysql_real_escape_string($valores['comentario'])."', 1, '".$valores['tipo_usuario']."', '".$valores['deficiencia']."', '".$valores['assunto']."', '".$valores['modalidade']."')";
		$conexao -> query($sql);

		$id_ouvidoria = mysql_insert_id();
		$semestre = (date('m') > 6) ? 2 : 1;
		$protocolo = "OF-".$id_ouvidoria."-".$semestre."SEM-".date('Y');

		$sql = "insert into ouv_processo (id_entidade, protocolo, data_ini, data_fim, id_ouvidoria, form, inibir_dados) values 
		('".$valores['entidade']."', '".$protocolo."', '".date('Y-m-d H:i:s')."', '".$data_limite."', ".$id_ouvidoria.", 1, '".$valores['inibir_dados']."')";
		$conexao -> query($sql);

		$sql = "insert into ouv_historico (id_ouvidoria, id_status, data) values (".$id_ouvidoria.", 1, '".date('Y-m-d')."')";
		$conexao -> query($sql);
		
		$conexao -> commit();
		
		/*$sql = "call ins_faetec(
			,
			'".$canal."',
			'1',
			'".$valores['nome']."',
			'".$valores['sexo']."',
			'".$data_nasc."',
			'".$valores['escolaridade']."',
			'".$valores['email']."',
			'".$valores['endereco']."',
			'".$valores['bairro']."',
			'".$valores['cidade']."',
			'".$valores['telefone']."', 
			'".$valores['celular']."',
			'".$valores['question']."', 
			'".$valores['comentario']."',
			'".$valores['entidade']."', 
			'".date('Y-m-d H:i:s')."',
			'".$data_limite."',
			1,
			'".$valores['tipo_usuario']."', 
			'".$valores['deficiencia']."', 
			@retorno);";
		
		$sql .= "select @retorno";
	
		$cnx = $conexao -> Conecta_Procedure();
		$resultado = $conexao -> Query_Procedure_M($sql, $conexao -> cnx_p);
		
		if ($resultado) {
			return $resultado;
		}*/
		return $protocolo;
	}
	
	public function incluir_denuncia($valores) {
		$conexao = new conexao();
		$data_fim= $this->add_data(1);
		
		if ($valores['canal'] == '') {
			$canal = 5;
		}
		else {
			$canal = $valores['canal'];
		}
		
		//data de nascimento
		$d = explode("/",$valores['data_nasc']);
		$data_nasc = $d[2]."-".$d[1]."-".$d[0];
		
		$conexao -> begin();
		
		$sql = "insert into ouv_ouvidoria  (id_tipo,id_canal,id_prioridade,nome,data_nasc,escolaridade,email,endereco,bairro,
				cidade,telefone,celular,prim_rec,protocolo_anterior,comentario,id_deficiencia, id_assunto, id_modalidade) values 
				(8,".$canal.",1,'".$valores['nome']."','".$data_nasc."','".$valores['escolaridade']."','".$valores['email']."','".$valores['endereco']."',
				'".$valores['bairro']."','".$valores['cidade']."','".$valores['telefone']."','".$valores['celular']."','".$valores['question']."',
				'".mysql_real_escape_string($valores['protocolo_anterior'])."','".mysql_real_escape_string($valores['comentario'])."',
				'".$valores['deficiencia']."', '".$valores['assunto']."', '".$valores['modalidade']."')";
		$conexao -> query($sql);

		$id_ouvidoria = mysql_insert_id();
		$semestre = (date('m') > 6) ? 2 : 1;
		$protocolo = "DF-".$id_ouvidoria."-".$semestre."SEM-".date('Y');

		$sql = "insert into ouv_processo (id_entidade, protocolo, data_ini, data_fim, id_ouvidoria, form, inibir_dados) values 
				('".$valores['entidade']."', '".$protocolo."', '".date('Y-m-d H:i:s')."', '".$data_fim."', ".$id_ouvidoria.", 1, '".$valores['inibir_dados']."')";
		$conexao -> query($sql);
		
		$id_denuncia = mysql_insert_id();
		
		$sql = "insert into ouv_denuncia (id_processo) values (".$id_denuncia.")";
		$conexao -> query($sql);
		
		$sql = "insert into ouv_historico (id_ouvidoria, id_status, data) values (".$id_ouvidoria.", 1, '".date('Y-m-d')."')";
		$conexao -> query($sql);
		
		$conexao -> commit();
		
		/*$sql_insert="call ins_denuncia_faetec(8,".$canal.",1,".$valores['entidade'].",'".$valores['nome']."',
		'".$data_nasc."','".$valores['email']."','".$valores['endereco']."','".$valores['bairro']."',
		'".$valores['cidade']."', '".$valores['telefone']."', '".$valores['celular']."', '".$valores['question']."',
		'".$valores['comentario']."', '".date('Y-m-d H:i:s')."', '".$data_fim."', '".$valores['escolaridade']."',
		'1', '".$valores['deficiencia']."', @retorno);";  
  		
		$sql_insert.="select @retorno";
		
		$conexao = new conexao();
		
		$cnx = $conexao -> Conecta_Procedure();
		$resultado = $conexao -> Query_Procedure_M($sql_insert, $conexao -> cnx_p);
		
		if ($resultado) {
			return $resultado;
		}*/
		return $protocolo;
	}
	
	/*------------- Função para listar dados para visualização geral --------------*/
	//$inicio => parametro opcional, recebe 0 se não for informado
	public function listar($status,$tipo,$assunto,$entidade,$modalidade,$deficiencia,$data_inicial,$data_final,$tipo_pesquisa,$busca,$inicio,$novos=0) {
		//criar objeto da classe conexão
		$conexao = new conexao();

		//filtros
		$comp = '';
		$group = '';
		if ($status != '') {
			$comp .= " and ouv_ouvidoria.id_status_atual = '".$status."'";
		}
		if ($tipo != '') {
			$comp .= " and ouv_ouvidoria.id_tipo = '".$tipo."'";
		}
		if ($assunto != '') {
			$comp .= " and ouv_ouvidoria.id_assunto = '".$assunto."'";
		}
		if ($entidade != '') {
			$comp .= " and ouv_processo.id_entidade = ".$entidade;
		}
		if ($modalidade != '') {
			$comp .= " and ouv_ouvidoria.id_modalidade = ".$modalidade;
		}
		if ($deficiencia != '') {
			$comp .= " and ouv_ouvidoria.id_deficiencia = ".$deficiencia;
		}
		if ($novos == 1) {
			$comp .= " and resposta_cidadao = 1";
		}
		
		if ($data_inicial != '' && $data_final != '') {
			$di = explode("/",$data_inicial);
			$df = explode("/",$data_final);
			$comp .= " and date(ouv_processo.data_ini) between '".$di[2]."-".$di[1]."-".$di[0]."' and '".$df[2]."-".$df[1]."-".$df[0]."'";
			$group = "group by ouv_ouvidoria.id_ouvidoria";
		}
		
		if ($tipo_pesquisa != '') {
			switch ($tipo_pesquisa) {
				case 1:
					$comp .= " and ouv_processo.protocolo = '".$busca."'";
				break;
				case 2:
					$comp .= " and ouv_ouvidoria.nome like '%".$busca."%'";
				break;
				case 3:
					$comp .= " and ouv_ouvidoria.email = '".$busca."'";
				break;
				case 4:
					$comp .= " and ouv_ouvidoria.cpf = '".$busca."'";
				break;
			}
			$inicio = 0;
		}
		
		session_start();
		
		//faz a busca de acordo com as permissoes do usuario
		$sql = "select ouv_ouvidoria.*, ouv_processo.protocolo, ouv_tipo.tipo, 
				date_format(ouv_processo.data_ini, '%d/%m/%Y %H:%i:%s') as data, 
				date_format(ouv_processo.data_fim, '%d/%m/%Y') as data_fim, 
				if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'Não especificado') as entidade, 
				ouv_status.status as status_atual, if(ouv_assunto.assunto is null,'Não Informado',ouv_assunto.assunto) as assunto
					from ouv_ouvidoria
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo
						left join ouv_assunto on ouv_assunto.id_assunto = ouv_ouvidoria.id_assunto
						left join ouv_modalidade on ouv_modalidade.id_modalidade = ouv_ouvidoria.id_modalidade
						inner join ouv_status on ouv_status.id_status = ouv_ouvidoria.id_status_atual
							where ouv_processo.id_processo not in(select ouv_denuncia.id_processo from ouv_denuncia)
							and ouv_processo.form = 1
							and ouv_processo.ativo = 1
							".$comp."
								".$group."
									order by data_ini desc
										limit ".$inicio.",10";
		$resultado = $conexao -> query($sql);

		if ($resultado) {
			//retorna o resultado se não der erro
			$this -> resultado = $resultado;
		}			
		
		//faz a busca do total de registros
		$sql = "select * from ouv_processo 
					inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
					inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
						where ouv_processo.form = 1
						and ouv_processo.id_processo not in(select ouv_denuncia.id_processo from ouv_denuncia) 
						and ouv_processo.ativo = 1".$comp."
							".$group;

		$resultado_total = $conexao -> query($sql);
		
		if ($resultado_total) {
			//retorna o numero de resultados se não der erro
			$num = mysql_num_rows($resultado_total) / 10;
			$this -> num = $num;
		}			
		
	}
	
	/*------------- Função para listar dados para visualização das unidades --------------*/
	//$inicio => parametro opcional, recebe 0 se não for informado
	public function listar_unidade($status,$tipo,$entidade,$data_inicial,$data_final,$inicio=0) {
		//criar objeto da classe conexão
		$conexao = new conexao();
	
		//filtros
		$comp = '';
		if ($tipo != '') {
			$comp .= " and ouv_ouvidoria.id_tipo = '".$tipo."'";
		}
		
		if ($data_inicial != '' && $data_final != '') {
			$di = explode("/",$data_inicial);
			$df = explode("/",$data_final);
			$comp .= " and date(ouv_processo.data_ini) between '".$di[2]."-".$di[1]."-".$di[0]."' and '".$df[2]."-".$df[1]."-".$df[0]."'";
		}
	
	
		session_start();
	
		//faz a busca de acordo com as permissoes do usuario
		$sql = "select ouv_ouvidoria.*, ouv_processo.protocolo, ouv_tipo.tipo,
				date_format(ouv_processo.data_ini, '%d/%m/%Y %H:%i:%s') as data,
				date_format(ouv_processo.data_fim, '%d/%m/%Y') as data_fim,
				if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'Não especificado') as entidade,
				ouv_status.status as status_atual, if(ouv_assunto.assunto is null,'Não Informado',ouv_assunto.assunto) as assunto
					from ouv_ouvidoria
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo
						inner join ouv_status on ouv_status.id_status = ouv_ouvidoria.id_status_atual
						left join ouv_assunto on ouv_assunto.id_assunto = ouv_ouvidoria.id_assunto
						inner join ouv_historico on ouv_ouvidoria.id_ouvidoria = ouv_historico.id_ouvidoria
							where ouv_historico.id_destino = ".$_SESSION['entidade']."
							and ouv_processo.ativo = 1
							".$comp."
								group by ouv_ouvidoria.id_ouvidoria
									order by data_ini desc
										limit ".$inicio.",10";
		$resultado = $conexao -> query($sql);
	
		if ($resultado) {
			//retorna o resultado se não der erro
			$this -> resultado = $resultado;
		}
	
		//faz a busca do total de registros
		$sql = "select * from ouv_processo
					inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
					inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
						where ouv_ouvidoria.id_status_atual = 2
						and ouv_processo.id_entidade = ".$_SESSION['entidade']."
						and ouv_processo.ativo = 1
						".$comp;
	
		$resultado_total = $conexao -> query($sql);
	
		if ($resultado_total) {
			//retorna o numero de resultados se não der erro
			$num = mysql_num_rows($resultado_total) / 10;
			$this -> num = $num;
		}
	
	}
	
	/*------------- Função para listar dados para resposta em bloco --------------*/
	//$inicio => parametro opcional, recebe 0 se não for informado
	public function listar_bloco($status,$entidade,$modalidade,$deficiencia,$data_inicial,$data_final,$tipo,$assunto) {
		//criar objeto da classe conexão
		$conexao = new conexao();

		//filtros
		$comp = '';
		if ($status != '') {
			$comp .= " and ouv_ouvidoria.id_status_atual = '".$status."'";
		}
		if ($entidade != '') {
			$comp .= " and ouv_processo.id_entidade = ".$entidade;
		}
		if ($modalidade != '') {
			$comp .= " and ouv_ouvidoria.id_modalidade = ".$modalidade;
		}
		if ($deficiencia != '') {
			$comp .= " and ouv_ouvidoria.id_deficiencia = ".$deficiencia;
		}
		if ($tipo != '') {
			$comp .= " and ouv_ouvidoria.id_tipo = ".$tipo;
		}
		if ($assunto != '') {
			$comp .= " and ouv_ouvidoria.id_assunto = ".$assunto;
		}
		
		if ($data_inicial != '' && $data_final != '') {
			$di = explode("/",$data_inicial);
			$df = explode("/",$data_final);
			$comp .= " and date(ouv_processo.data_ini) between '".$di[2]."-".$di[1]."-".$di[0]."' and '".$df[2]."-".$df[1]."-".$df[0]."'";
		}
		
		
		session_start();
		
		//faz a busca de acordo com as permissoes do usuario
		$sql = "select ouv_ouvidoria.*, ouv_processo.protocolo, ouv_tipo.tipo, 
				date_format(ouv_processo.data_ini, '%d/%m/%Y %H:%i:%s') as data, 
				date_format(ouv_processo.data_fim, '%d/%m/%Y') as data_fim, 
				if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'Não especificado') as entidade, 
				ouv_status.status as status_atual, if(ouv_assunto.assunto is null,'Não Informado',ouv_assunto.assunto) as assunto
					from ouv_ouvidoria
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo
						inner join ouv_status on ouv_status.id_status = ouv_ouvidoria.id_status_atual
						left join ouv_assunto on ouv_assunto.id_assunto = ouv_ouvidoria.id_assunto
						left join ouv_modalidade on ouv_modalidade.id_modalidade = ouv_ouvidoria.id_modalidade
							where ouv_processo.id_processo not in(select ouv_denuncia.id_processo from ouv_denuncia)
							and ouv_processo.form = 1
								".$comp."
								and ouv_processo.ativo = 1
									order by data_ini desc";
		$resultado = $conexao -> query($sql);

		if ($resultado) {
			//retorna o resultado se não der erro
			$this -> resultado = $resultado;
		}
		
	}
	
	/*------------- Função para listar dados para visualização geral --------------*/
	//$inicio => parametro opcional, recebe 0 se não for informado
	public function listar_denuncias($status,$assunto,$entidade,$modalidade,$deficiencia,$data_inicial,$data_final,$tipo_pesquisa,$busca,$inicio=0) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//filtros
		$comp = '';
		$group = '';
		if ($status != '') {
			$comp .= " and ouv_ouvidoria.id_status_atual = '".$status."'";
		}
		if ($assunto != '') {
			$comp .= " and ouv_ouvidoria.id_assunto = '".$assunto."'";
		}
		if ($entidade != '') {
			$comp .= " and ouv_processo.id_entidade = ".$entidade;
		}
		if ($modalidade != '') {
			$comp .= " and ouv_ouvidoria.id_modalidade = ".$modalidade;
		}
		if ($deficiencia != '') {
			$comp .= " and ouv_ouvidoria.id_deficiencia = ".$deficiencia;
		}
		
		if ($data_inicial != '' && $data_final != '') {
			$di = explode("/",$data_inicial);
			$df = explode("/",$data_final);
			$comp .= " and date(ouv_processo.data_ini) between '".$di[2]."-".$di[1]."-".$di[0]."' and '".$df[2]."-".$df[1]."-".$df[0]."'";
			$group = "group by ouv_ouvidoria.id_ouvidoria";
		}
		
		if ($tipo_pesquisa != '') {
			switch ($tipo_pesquisa) {
				case 1:
					$comp .= " and ouv_processo.protocolo = '".$busca."'";
				break;
				case 2:
					$comp .= " and ouv_ouvidoria.nome like '%".$busca."%'";
				break;
				case 3:
					$comp .= " and ouv_ouvidoria.email = '".$busca."'";
				break;
				case 4:
					$comp .= " and ouv_ouvidoria.cpf = '".$busca."'";
				break;
			}
			$inicio = 0;
		}
		
		session_start();
		
		//faz a busca de acordo com as permissoes do usuario
		$sql = "select ouv_ouvidoria.*, ouv_processo.protocolo, ouv_tipo.tipo, 
				date_format(ouv_processo.data_ini, '%d/%m/%Y %H:%i:%s') as data, 
				date_format(ouv_processo.data_fim, '%d/%m/%Y') as data_fim, 
				if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'Não especificado') as entidade, 
				ouv_status.status as status_atual, ouv_assunto.assunto
					from ouv_ouvidoria
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						left join ouv_assunto on ouv_assunto.id_assunto = ouv_ouvidoria.id_assunto
						left join ouv_modalidade on ouv_modalidade.id_modalidade = ouv_ouvidoria.id_modalidade
						inner join ouv_denuncia on ouv_processo.id_processo = ouv_denuncia.id_processo
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo
						inner join ouv_status on ouv_status.id_status = ouv_ouvidoria.id_status_atual
							where (ouv_entidade.id_entidade = 1 or ouv_entidade.id_entidade_pai = 1)
							and ouv_processo.form = 1
							".$comp."
							and ouv_processo.ativo = 1
								order by data_ini desc
									limit ".$inicio.",10";
		$resultado = $conexao -> query($sql);

		if ($resultado) {
			//retorna o resultado se não der erro
			$this -> resultado = $resultado;
		}
		
		//faz a busca do total de registros
		$sql = "select * from ouv_processo 
					inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
					inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
						where ouv_processo.form = 1
						and ouv_processo.id_processo in(select ouv_denuncia.id_processo from ouv_denuncia) 
						and ouv_processo.ativo = 1".$comp;

		$resultado_total = $conexao -> query($sql);
		
		if ($resultado_total) {
			//retorna o numero de resultados se não der erro
			$num = mysql_num_rows($resultado_total) / 10;
			$this -> num = $num;
		}			
		
	}
	
	/*------------- Função para listar dados de processos inativos para visualização geral --------------*/
	//$inicio => parametro opcional, recebe 0 se não for informado
	public function listar_inativos($status,$entidade,$inicio=0) {
		//criar objeto da classe conexão
		$conexao = new conexao();

		//filtros
		$comp = '';
		if ($status != '') {
			$comp .= " and ouv_ouvidoria.id_status_atual = '".$status."'";
		}
		if ($entidade != '') {
			$comp .= " and ouv_processo.id_entidade = ".$entidade;
		}
		
		session_start();
		
		//faz a busca de acordo com as permissoes do usuario
		$sql = "select ouv_ouvidoria.*, ouv_processo.protocolo, ouv_tipo.tipo, 
				date_format(ouv_processo.data_ini, '%d/%m/%Y %H:%i:%s') as data, 
				date_format(ouv_processo.data_fim, '%d/%m/%Y') as data_fim, 
				if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'Não especificado') as entidade, 
				ouv_status.status as status_atual, if(ouv_assunto.assunto is null,'Não Informado',ouv_assunto.assunto) as assunto
					from ouv_ouvidoria
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo
						inner join ouv_status on ouv_status.id_status = ouv_ouvidoria.id_status_atual
						left join ouv_assunto on ouv_assunto.id_assunto = ouv_ouvidoria.id_assunto
							where ouv_processo.id_processo not in(select ouv_denuncia.id_processo from ouv_denuncia)
							and ouv_processo.form = 1
							".$comp."
							and ouv_processo.ativo = 0
								order by data_ini desc
									limit ".$inicio.",10";
		$resultado = $conexao -> query($sql);

		if ($resultado) {
			//retorna o resultado se não der erro
			$this -> resultado = $resultado;
		}			
		
		//faz a busca do total de registros
		$sql = "select * from ouv_processo 
					inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						where ouv_processo.form = 1
						and ouv_processo.id_processo not in(select ouv_denuncia.id_processo from ouv_denuncia) 
						and ouv_processo.ativo = 0".$comp;;

		$resultado_total = $conexao -> query($sql);
		
		if ($resultado_total) {
			//retorna o numero de resultados se não der erro
			$num = mysql_num_rows($resultado_total) / 10;
			$this -> num = $num;
		}			
		
	}
	
	/*------------- Função para listar dados para visualização geral --------------*/
	//$inicio => parametro opcional, recebe 0 se não for informado
	public function listar_denuncias_inativas($status,$entidade,$inicio=0) {
		//criar objeto da classe conexão
		$conexao = new conexao();

		//filtros
		$comp = '';
		if ($status != '') {
			$comp .= " and ouv_ouvidoria.id_status_atual = '".$status."'";
		}
		if ($entidade != '') {
			$comp .= " and ouv_processo.id_entidade = ".$entidade;
		}
		
		session_start();
		
		//faz a busca de acordo com as permissoes do usuario
		$sql = "select ouv_ouvidoria.*, ouv_processo.protocolo, ouv_tipo.tipo, 
				date_format(ouv_processo.data_ini, '%d/%m/%Y %H:%i:%s') as data, 
				date_format(ouv_processo.data_fim, '%d/%m/%Y') as data_fim, 
				if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'Não especificado') as entidade, 
				ouv_status.status as status_atual
					from ouv_ouvidoria
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_denuncia on ouv_processo.id_processo = ouv_denuncia.id_processo
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo
						inner join ouv_historico on ouv_historico.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_status on ouv_status.id_status = ouv_ouvidoria.id_status_atual
							where ouv_processo.form = 1
							".$comp."
							and ouv_processo.ativo = 0
								order by data_ini desc
									limit ".$inicio.",10";
		$resultado = $conexao -> query($sql);

		if ($resultado) {
			//retorna o resultado se não der erro
			$this -> resultado = $resultado;
		}			
		
		//faz a busca do total de registros
		$sql = "select * from ouv_processo 
					inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						where ouv_processo.form = 1
						and ouv_processo.id_processo in(select ouv_denuncia.id_processo from ouv_denuncia) 
						and ouv_processo.ativo = 0".$comp;

		$resultado_total = $conexao -> query($sql);
		
		if ($resultado_total) {
			//retorna o numero de resultados se não der erro
			$num = mysql_num_rows($resultado_total) / 10;
			$this -> num = $num;
		}			
		
	}
	
	/*------------- Função para pesquisar registros --------------*/
	public function pesquisar($status,$tipo_manifestacao,$assunto,$entidade,$modalidade,$deficiencia,$tipo,$busca,$inicio=0) {	
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//filtros
		$comp = '';
		$group = '';
		if ($status != '') {
			$comp .= " and ouv_ouvidoria.id_status_atual = '".$status."'";
		}
		if ($tipo_manifestacao != '') {
			$comp .= " and ouv_ouvidoria.id_tipo = '".$tipo_manifestacao."'";
		}
		if ($assunto != '') {
			$comp .= " and ouv_ouvidoria.id_assunto = '".$assunto."'";
		}
		if ($entidade != '') {
			$comp .= " and ouv_processo.id_entidade = ".$entidade;
		}
		if ($modalidade != '') {
			$comp .= " and ouv_ouvidoria.id_modalidade = ".$modalidade;
		}
		if ($deficiencia != '') {
			$comp .= " and ouv_ouvidoria.id_deficiencia = ".$deficiencia;
		}
		
		if ($data_inicial != '' && $data_final != '') {
			$di = explode("/",$data_inicial);
			$df = explode("/",$data_final);
			$comp .= " and date(ouv_processo.data_ini) between '".$di[2]."-".$di[1]."-".$di[0]."' and '".$df[2]."-".$df[1]."-".$df[0]."'";
			$group = "group by ouv_ouvidoria.id_ouvidoria";
		}
		
		switch ($tipo) {
			case 1:
				$comp .= " and ouv_processo.protocolo = '".$busca."'";
			break;
			case 2:
				$comp .= " and ouv_ouvidoria.nome like '%".$busca."%'";
			break;
			case 3:
				$comp .= " and ouv_ouvidoria.email = '".$busca."'";
			break;
			case 4:
				$comp .= " and ouv_ouvidoria.cpf = '".$busca."'";
			break;
		}
		
		session_start();
		
		//faz a busca de acordo com as permissoes do usuario
		$sql = "select ouv_ouvidoria.*, ouv_processo.protocolo, ouv_tipo.tipo, 
				date_format(ouv_processo.data_ini, '%d/%m/%Y %H:%i:%s') as data, 
				date_format(ouv_processo.data_fim, '%d/%m/%Y') as data_fim, 
				if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'Não especificado') as entidade, 
				ouv_status.status as status_atual, ouv_prioridade.prioridade,
				if(ouv_assunto.assunto is null,'Não Informado',ouv_assunto.assunto) as assunto
					from ouv_ouvidoria
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_prioridade on ouv_prioridade.id_prioridade = ouv_ouvidoria.id_prioridade
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						inner join ouv_usuario on ouv_usuario.id_entidade = ouv_usuario.id_entidade
						inner join ouv_perfil on ouv_usuario.id_perfil = ouv_perfil.id_perfil
						inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo
						inner join ouv_historico on ouv_historico.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_status on ouv_status.id_status = ouv_ouvidoria.id_status_atual
						left join ouv_assunto on ouv_assunto.id_assunto = ouv_ouvidoria.id_assunto
							where ouv_usuario.id_usuario = ".$_SESSION['usuario']."
							and ouv_processo.id_processo not in(select ouv_denuncia.id_processo from ouv_denuncia)
							and ouv_processo.form = 1
							".$comp."
							and ouv_processo.ativo = 1
								group by ouv_ouvidoria.id_ouvidoria
									order by data_ini desc
										limit ".$inicio.",10";

		$resultado = $conexao -> query($sql);

		if ($resultado) {
			//retorna o resultado se não der erro
			$this -> resultado = $resultado;
		}			
		
		//faz a busca do total de registros
		$sql = "select * from ouv_processo 
					inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
					inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
					inner join ouv_historico on ouv_historico.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						where ouv_processo.form = 1
						and ouv_processo.id_processo not in(select ouv_denuncia.id_processo from ouv_denuncia) 
						and ouv_processo.ativo = 1
						".$comp."
							group by ouv_ouvidoria.id_ouvidoria";
		$resultado_total = $conexao -> query($sql);

		if ($resultado_total) {
			//retorna o numero de resultados se não der erro
			$num = mysql_num_rows($resultado_total) / 10;
			$this -> num = $num;
		}				
	}
	
	/*------------- Função para pesquisar registros --------------*/
	public function pesquisar_denuncias($status,$assunto,$entidade,$modalidade,$deficiencia,$tipo,$busca,$inicio=0) {	
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//filtros
		$comp = '';
		$group = '';
		if ($status != '') {
			$comp .= " and ouv_ouvidoria.id_status_atual = '".$status."'";
		}
		if ($assunto != '') {
			$comp .= " and ouv_ouvidoria.id_assunto = '".$assunto."'";
		}
		if ($entidade != '') {
			$comp .= " and ouv_processo.id_entidade = ".$entidade;
		}
		if ($modalidade != '') {
			$comp .= " and ouv_ouvidoria.id_modalidade = ".$modalidade;
		}
		if ($deficiencia != '') {
			$comp .= " and ouv_ouvidoria.id_deficiencia = ".$deficiencia;
		}
		
		switch ($tipo) {
			case 1:
				$comp .= " and ouv_processo.protocolo = '".$busca."'";
			break;
			case 2:
				$comp .= " and ouv_ouvidoria.nome like '%".$busca."%'";
			break;
			case 3:
				$comp .= " and ouv_ouvidoria.email = '".$busca."'";
			break;
			case 4:
				$comp .= " and ouv_ouvidoria.cpf = '".$busca."'";
			break;
		}
		
		session_start();
		
		//faz a busca de acordo com as permissoes do usuario
		$sql = "select ouv_ouvidoria.*, ouv_processo.protocolo, ouv_tipo.tipo, 
				date_format(ouv_processo.data_ini, '%d/%m/%Y %H:%i:%s') as data, 
				date_format(ouv_processo.data_fim, '%d/%m/%Y') as data_fim, 
				if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'Não especificado') as entidade, 
				ouv_status.status as status_atual, ouv_prioridade.prioridade, ouv_assunto.assunto
					from ouv_ouvidoria
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						left join ouv_assunto on ouv_assunto.id_assunto = ouv_ouvidoria.id_assunto
						inner join ouv_denuncia on ouv_denuncia.id_processo = ouv_processo.id_processo
						inner join ouv_prioridade on ouv_prioridade.id_prioridade = ouv_ouvidoria.id_prioridade
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						inner join ouv_usuario on ouv_usuario.id_entidade = ouv_usuario.id_entidade
						inner join ouv_perfil on ouv_usuario.id_perfil = ouv_perfil.id_perfil
						inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo
						inner join ouv_historico on ouv_historico.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_status on ouv_status.id_status = ouv_ouvidoria.id_status_atual
							where ouv_usuario.id_usuario = ".$_SESSION['usuario']."
							and ouv_processo.form = 1
							".$comp."
							and ouv_processo.id_processo in(select ouv_denuncia.id_processo from ouv_denuncia)
							and ouv_processo.ativo = 1
								group by ouv_ouvidoria.id_ouvidoria
									order by data_ini desc
										limit ".$inicio.",10";

		$resultado = $conexao -> query($sql);

		if ($resultado) {
			//retorna o resultado se não der erro
			$this -> resultado = $resultado;
		}			
		
		//faz a busca do total de registros
		$sql = "select * from ouv_processo 
					inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
					inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
						where ouv_processo.form = 1
						and ouv_processo.id_processo in(select ouv_denuncia.id_processo from ouv_denuncia) 
						and ouv_processo.ativo = 1
						".$comp;
		$resultado_total = $conexao -> query($sql);

		if ($resultado_total) {
			//retorna o numero de resultados se não der erro
			$num = mysql_num_rows($resultado_total) / 10;
			$this -> num = $num;
		}				
	}
	
	/*------------- Função para pesquisar registros --------------*/
	public function pesquisar_denuncias_inativas($status,$entidade,$tipo,$busca,$inicio=0) {	
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//filtros
		$comp = '';
		if ($status != '') {
			$comp .= " and ouv_historico.id_status = '".$status."'";
		}
		if ($segmento != '') {
			$comp .= " and ouv_processo.id_entidade = ".$entidade;
		}
		if ($tipo == 1) {
			$comp .= " and ouv_processo.protocolo = '".$busca."'";
		}
		if ($tipo == 2) {
			$comp .= " and ouv_ouvidoria.nome like '%".$busca."%'";
		}
		
		session_start();
		
		//faz a busca de acordo com as permissoes do usuario
		$sql = "select ouv_ouvidoria.*, ouv_processo.protocolo, ouv_tipo.tipo, 
				date_format(ouv_processo.data_ini, '%d/%m/%Y %H:%i:%s') as data, 
				date_format(ouv_processo.data_fim, '%d/%m/%Y') as data_fim, 
				if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'Não especificado') as entidade, 
				ouv_status.status as status_atual,
				ouv_prioridade.prioridade
					from ouv_ouvidoria
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_denuncia on ouv_denuncia.id_processo = ouv_processo.id_processo
						inner join ouv_prioridade on ouv_prioridade.id_prioridade = ouv_ouvidoria.id_prioridade
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						inner join ouv_usuario on ouv_usuario.id_entidade = ouv_usuario.id_entidade
						inner join ouv_perfil on ouv_usuario.id_perfil = ouv_perfil.id_perfil
						inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo
						inner join ouv_historico on ouv_historico.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_status on ouv_status.id_status = ouv_ouvidoria.id_status_atual
							where ouv_usuario.id_usuario = ".$_SESSION['usuario']."
							and (ouv_processo.id_entidade = ".$_SESSION['entidade']." 
								or ouv_historico.id_destino = ".$_SESSION['entidade']."
								 or ouv_entidade.id_entidade_pai = ".$_SESSION['entidade'].")
							".$comp."
							and ouv_processo.ativo = 0
								group by ouv_ouvidoria.id_ouvidoria
									order by data_ini desc
										limit ".$inicio.",10";

		$resultado = $conexao -> query($sql);

		if ($resultado) {
			//retorna o resultado se não der erro
			$this -> resultado = $resultado;
		}			
		
		//faz a busca do total de registros
		$sql = "select * from ouv_processo 
					inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
					inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
						where ouv_processo.form = 1
						and ouv_processo.id_processo in(select ouv_denuncia.id_processo from ouv_denuncia) 
						and ouv_processo.ativo = 0
						".$comp;
		$resultado_total = $conexao -> query($sql);

		if ($resultado_total) {
			//retorna o numero de resultados se não der erro
			$num = mysql_num_rows($resultado_total) / 10;
			$this -> num = $num;
		}				
	}
	
	/*------------- Função para pesquisar registros inativos --------------*/
	public function pesquisar_inativos($status,$entidade,$tipo,$busca,$inicio=0) {	
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//filtros
		$comp = '';
		if ($status != '') {
			$comp .= " and ouv_historico.id_status = '".$status."'";
		}
		if ($segmento != '') {
			$comp .= " and ouv_processo.id_entidade = ".$entidade;
		}
		if ($tipo == 1) {
			$comp .= " and ouv_processo.protocolo = '".$busca."'";
		}
		if ($tipo == 2) {
			$comp .= " and ouv_ouvidoria.nome like '%".$busca."%'";
		}
		
		session_start();
		
		//faz a busca de acordo com as permissoes do usuario
		$sql = "select ouv_ouvidoria.*, ouv_processo.protocolo, ouv_tipo.tipo, 
				date_format(ouv_processo.data_ini, '%d/%m/%Y %H:%i:%s') as data, 
				date_format(ouv_processo.data_fim, '%d/%m/%Y') as data_fim, 
				if (ouv_entidade.entidade <> '',ouv_entidade.entidade,'Não especificado') as entidade, 
				ouv_status.status as status_atual, if(ouv_assunto.assunto is null,'Não Informado',ouv_assunto.assunto) as assunto
				ouv_prioridade.prioridade
					from ouv_ouvidoria
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_prioridade on ouv_prioridade.id_prioridade = ouv_ouvidoria.id_prioridade
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						inner join ouv_usuario on ouv_usuario.id_entidade = ouv_usuario.id_entidade
						inner join ouv_perfil on ouv_usuario.id_perfil = ouv_perfil.id_perfil
						inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo
						inner join ouv_historico on ouv_historico.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_status on ouv_status.id_status = ouv_ouvidoria.id_status_atual
						left join ouv_assunto on ouv_assunto.id_assunto = ouv_ouvidoria.id_assunto
							where ouv_usuario.id_usuario = ".$_SESSION['usuario']."
							and ouv_processo.id_processo not in(select ouv_denuncia.id_processo from ouv_denuncia)
							and (ouv_processo.id_entidade = ".$_SESSION['entidade']." 
								or ouv_historico.id_destino = ".$_SESSION['entidade']."
								 or ouv_entidade.id_entidade_pai = ".$_SESSION['entidade'].")
							".$comp."
							and ouv_processo.ativo = 0
								group by ouv_ouvidoria.id_ouvidoria
									order by data_ini desc
										limit ".$inicio.",10";

		$resultado = $conexao -> query($sql);

		if ($resultado) {
			//retorna o resultado se não der erro
			$this -> resultado = $resultado;
		}			
		
		//faz a busca do total de registros
		$sql = "select * from ouv_processo 
					inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
					inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
						where ouv_processo.form = 1
						and ouv_processo.id_processo not in(select ouv_denuncia.id_processo from ouv_denuncia) 
						and ouv_processo.ativo = 0
						".$comp;
		$resultado_total = $conexao -> query($sql);

		if ($resultado_total) {
			//retorna o numero de resultados se não der erro
			$num = mysql_num_rows($resultado_total) / 10;
			$this -> num = $num;
		}				
	}
	
	/*------------- Função para listar dados de um registro da ouvidoria --------------*/
	public function detalhes($id) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//listar detalhes
		$sql = "select ouv_ouvidoria.*, ouv_processo.*, ouv_tipo.*, ouv_status.*, date_format(data_ini, '%d/%m/%Y %H:%i:%s') as data,
				ouv_perfil.alterar, date_format(data_nasc, '%d/%m/%Y') as data_nasc,
				date_format(data_fim,'%d/%m/%Y') as data_fim,
				if(ouv_entidade.id_entidade = 0,'Não especificado',ouv_entidade.id_entidade) as ent,
				ouv_entidade.entidade as entidade, ouv_perfil.alterar as alt,
				ouv_status.status as status_atual,
				ouv_prioridade.id_prioridade as prioridade, ouv_prioridade.prioridade as desc_prioridade,
				ouv_tipo_usuario.descricao as tipo_usuario,
				ouv_tipo_usuario.id_tipo_usuario as id_tipo_usuario,
				ouv_deficiencia.deficiencia, if(ouv_assunto.assunto is null,'Não Informado',ouv_assunto.assunto) as assunto,
				ouv_modalidade.modalidade, ouv_processo.inibir_dados
					from ouv_ouvidoria 
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						left join ouv_tipo_usuario on ouv_tipo_usuario.id_tipo_usuario = ouv_ouvidoria.id_tipo_usuario
						inner join ouv_prioridade on ouv_prioridade.id_prioridade = ouv_ouvidoria.id_prioridade
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
						inner join ouv_usuario on (ouv_usuario.id_entidade = ouv_entidade.id_entidade or ouv_usuario.id_entidade = ouv_entidade.id_entidade_pai)
						inner join ouv_perfil on ouv_perfil.id_perfil = ouv_usuario.id_perfil
						inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo
						inner join ouv_historico on ouv_historico.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						inner join ouv_status on ouv_status.id_status = ouv_ouvidoria.id_status_atual
						left join ouv_deficiencia on ouv_deficiencia.id = ouv_ouvidoria.id_deficiencia
						left join ouv_assunto on ouv_assunto.id_assunto = ouv_ouvidoria.id_assunto
						left join ouv_modalidade on ouv_modalidade.id_modalidade = ouv_ouvidoria.id_modalidade
							where ouv_ouvidoria.id_ouvidoria = ".$id."
								group by ouv_ouvidoria.id_ouvidoria";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se não der erro
			return $resultado;
		}
	}
	
	/*------------- Função para alterar dados de um registro da ouvidoria --------------*/
	/*public function alterar($valores) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$data = date('Y-m-d H:i:s');
		
		//atualizar segmento somente se ele foi escolhido
		if ($valores['segmento'] != '') {
			$comp = ", segmento_id = '".$valores['segmento']."'";
		}
		
		//alterar
		$sql = "update ouvidoria set 
						status = '".$valores['novo_status']."', 
						resumo = '".$valores['resumo']."',
						data = '".$data."'
						".$comp."
							where id = ".$valores['id'];
		$resultado = $conexao -> query($sql);
		if ($resultado) {
			//incluir registro no historico
			require_once('../faetec/classes/historico.php');
			$historico = new historico();
			
			$resultado = $historico -> incluir($valores['id'],$data,$valores['novo_status'],$valores['resumo']);
			
			//retorna 1 se não der erro
			if ($resultado) {
				return 1;
			}
		}
	}*/
	
	/*------------- Função para contar o numero de mensagens para um tipo e uma entidade --------------*/
	//$datas => complemento para o sql limitar a data inicial e final
	public function contar($datas='',$tipo=0) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//complemento para o sql se apenas o tipo foi informado
		if ($tipo != 0) {
			$comp = " and id_tipo = ".$tipo;
		}
		
		//limitar data inicial e final
		if ($datas != '') {
			$di = explode("/", $datas['inicial']);
			$df = explode("/", $datas['final']);
			$comp .= " and ouv_processo.data_ini between '".$di[2]."-".$di[1]."-".$di[0]."' and '".$df[2]."-".$df[1]."-".$df[0]."'";
		}
		
		//faz a busca
		$sql = "select id_processo
					from ouv_processo
						inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
							where ouv_processo.form = 1
							and ouv_processo.ativo = 1
							".$comp;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o numero de resultados se não der erro
			return mysql_num_rows($resultado);
		}
	}
	
	/*------------- Função para buscar os tipos de cada registro para cada segmento (opcional) na tabela ouvidoria --------------*/
	//$datas => complemento para o sql limitar a data inicial e final
	public function buscar_tipos($datas='') {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//limitar a data inicial e final
		if ($datas != '') {
			$di = explode("/", $datas['inicial']);
			$df = explode("/", $datas['final']);
			$comp = " and ouv_processo.data_ini between '".$di[2]."-".$di[1]."-".$di[0]."' and '".$df[2]."-".$df[1]."-".$df[0]."'";
		}
		
		//faz a busca
		$sql = "select ouv_tipo.id_tipo
					from ouv_processo
						inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
							inner join ouv_tipo on ouv_ouvidoria.id_tipo = ouv_tipo.id_tipo
								where ouv_processo.form = 1
								and ouv_processo.ativo = 1"
								.$comp;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se não der erro
			return $resultado;
		}
	}
	
/*------------- Função para buscar os tipos de cada registro para cada segmento (opcional) na tabela ouvidoria --------------*/
	//$datas => complemento para o sql limitar a data inicial e final
	public function buscar_tipos_dir($diretoria=0,$datas='',$status='',$tipo='',$subitem='') {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
			
		
		//complemento caso o segmento seja informado
		if ($diretoria != 0){
			$comp = "where ouv_diretoria.id_diretoria = ".$diretoria;
		}
		
		if($diretoria == ""){
			$comp = "where ouv_diretoria.id_diretoria > 0";
		}	
		
		//limitar a data inicial e final
		if ($datas != '') {
			$comp .= $datas;
		}
		
		//filtrar status
		if ($status != '') {
			$comp .= " and ouv_ouvidoria.id_status_atual = ".$status;
		}
		
		//filtrar tipo de usuario
		if ($tipo != '') {
			$comp .= " and ouv_ouvidoria.id_tipo_usuario = ".$tipo;
		}
		
		//filtrar subitem
		if ($subitem != '') {
			$comp .= " and ouv_ouvidoria.id_subitem = ".$subitem;
		}
		
		//faz a busca
		$sql = "select ouv_tipo.id_tipo
					from ouv_processo
						inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
							inner join ouv_tipo on ouv_ouvidoria.id_tipo = ouv_tipo.id_tipo
							inner join ouv_entidade on ouv_processo.id_entidade = ouv_entidade.id_entidade
							inner join ouv_entidade_diretoria on ouv_entidade_diretoria.id_entidade = ouv_entidade.id_entidade
							inner join ouv_diretoria on ouv_entidade_diretoria.id_diretoria = ouv_diretoria.id_diretoria
								".$comp;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se não der erro
			return $resultado;
		}
	}
	
	/*------------- Função para contar o numero de mensagens para um canal--------------*/
	//$datas => complemento para o sql limitar a data inicial e final
	public function contar_canal($datas='',$canal) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$comp = '';
		if ($datas != '') {
			$di = explode("/", $datas['inicial']);
			$df = explode("/", $datas['final']);
			$comp = " and ouv_processo.data_ini between '".$di[2]."-".$di[1]."-".$di[0]."' and '".$df[2]."-".$df[1]."-".$df[0]."'";
		}
		
		//faz a busca
		$sql = "select id_processo
					from ouv_processo
						inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
							where id_canal = ".$canal."
							and ouv_processo.form = 1
							and ouv_processo.ativo = 1".$comp;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o numero de resultados se não der erro
			return mysql_num_rows($resultado);
		}
	}	
	
	/*------------- Função para contar o numero de mensagens para os canais de uma entidade --------------*/
	//$datas => complemento para o sql limitar a data inicial e final
	public function contar_total_canais($datas='') {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$comp = '';
		if ($datas != '') {
			$di = explode("/", $datas['inicial']);
			$df = explode("/", $datas['final']);
			$comp .= " and ouv_processo.data_ini between '".$di[2]."-".$di[1]."-".$di[0]."' and '".$df[2]."-".$df[1]."-".$df[0]."'";
		}
		
		//faz a busca
		$sql = "select id_processo
					from ouv_processo
						inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
							where ouv_processo.form = 1
							and ouv_processo.ativo = 1".$comp;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o numero de resultados se não der erro
			return mysql_num_rows($resultado);
		}
	}	
	
	/*------------- Função para buscar os canais de cada registro na tabela ouvidoria --------------*/
	public function buscar_canais($datas='') {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$comp = '';
		if ($datas != '') {
			$di = explode("/", $datas['inicial']);
			$df = explode("/", $datas['final']);
			$comp .= " and ouv_processo.data_ini between '".$di[2]."-".$di[1]."-".$di[0]."' and '".$df[2]."-".$df[1]."-".$df[0]."'";
		}
		
		//faz a busca
		$sql = "select ouv_canal.id_canal
					from ouv_processo
						inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
						inner join ouv_canal on ouv_ouvidoria.id_canal = ouv_canal.id_canal
						inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade
							where ouv_processo.form = 1
							and ouv_processo.ativo = 1".$comp;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se não der erro
			return $resultado;
		}
	}
	
	/*------------- Função para buscar as entidades de cada registro na tabela processos --------------*/
	public function buscar_entidades($datas='') {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$comp = '';
		if ($datas != '') {
			$comp = $datas;
		}
		
		//faz a busca
		$sql = "select ouv_entidade.id_entidade
					from ouv_processo
						inner join ouv_entidade on ouv_processo.id_entidade = ouv_entidade.id_entidade
							where ouv_processo.form = 1
							and ouv_processo.ativo = 1
									order by ouv_entidade.entidade".$comp;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se não der erro
			return $resultado;
		}
	}	
	
	/*------------- Função para buscar os entidades de cada registro na tabela ouvidoria --------------*/
	public function contar_entidades($datas='',$entidade) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$comp = '';
		if ($datas != '') {
			$di = explode("/", $datas['inicial']);
			$df = explode("/", $datas['final']);
			$comp .= " and ouv_processo.data_ini between '".$di[2]."-".$di[1]."-".$di[0]."' and '".$df[2]."-".$df[1]."-".$df[0]."'";
		}
		
		//faz a busca
		$sql = "select id_processo
					from ouv_processo
						inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
							where ouv_processo.form = ".$entidade."
							and ouv_processo.ativo = 1".$comp;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se não der erro
			return mysql_num_rows($resultado);
		}
	}
	
	/*------------- Função para buscar os entidades de cada registro na tabela ouvidoria --------------*/
	public function contar_entidades_geral($datas='',$entidade) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$comp = '';
		if ($datas != '') {
			$di = explode("/", $datas['inicial']);
			$df = explode("/", $datas['final']);
			$comp .= " and ouv_processo.data_ini between '".$di[2]."-".$di[1]."-".$di[0]."' and '".$df[2]."-".$df[1]."-".$df[0]."'";
		}
		
		$sql = "select id_processo
					from ouv_processo
						inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
							where ouv_processo.id_entidade = ".$entidade."
							and ouv_processo.form = 1
							and ouv_processo.ativo = 1".$comp;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se não der erro
			return mysql_num_rows($resultado);
		}
	}

	function comportamento_demandas($datas='') {
		$conexao = new conexao();

		$comp = '';
		if ($datas != '') {
			$di = explode("/", $datas['inicial']);
			$df = explode("/", $datas['final']);
			$comp .= " and ouv_processo.data_ini between '".$di[2]."-".$di[1]."-".$di[0]."' and '".$df[2]."-".$df[1]."-".$df[0]."'";
		}

		$sql = "select ouv_entidade.entidade, sum(ouv_ouvidoria.id_tipo=1) as informacao,
				sum(ouv_ouvidoria.id_tipo=2) as sugestao, sum(ouv_ouvidoria.id_tipo=3) as reclamacao, sum(ouv_ouvidoria.id_tipo=4) as elogio,
				sum(ouv_ouvidoria.id_tipo=5) as agradecimento, sum(ouv_ouvidoria.id_tipo=6) as outros, sum(ouv_ouvidoria.id_tipo=7) as solicitacao,
				sum(ouv_ouvidoria.id_tipo=8) as denuncia, count(ouv_processo.id_processo) as total
  					from ouv_entidade
    					left join ouv_processo on ouv_processo.id_entidade = ouv_entidade.id_entidade and ouv_processo.form = 1 and ouv_processo.ativo = 1
    					".$comp."
    					left join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
      						where ouv_entidade.id_entidade_pai = 1
      						or ouv_entidade.id_entidade = 1
        						group by ouv_entidade.id_entidade
          							order by ouv_entidade.entidade";
        $resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se não der erro
			return $resultado;
		}
	}

	function comportamento_assuntos($datas='') {
		$conexao = new conexao();

		$comp = '';
		if ($datas != '') {
			$di = explode("/", $datas['inicial']);
			$df = explode("/", $datas['final']);
			$comp .= " and ouv_processo.data_ini between '".$di[2]."-".$di[1]."-".$di[0]."' and '".$df[2]."-".$df[1]."-".$df[0]."'";
		}

		$sql = "select ouv_assunto.id_assunto, sum(ouv_ouvidoria.id_tipo=1) as informacao,
				sum(ouv_ouvidoria.id_tipo=2) as sugestao, sum(ouv_ouvidoria.id_tipo=3) as reclamacao, sum(ouv_ouvidoria.id_tipo=4) as elogio,
				sum(ouv_ouvidoria.id_tipo=5) as agradecimento, sum(ouv_ouvidoria.id_tipo=6) as outros, sum(ouv_ouvidoria.id_tipo=7) as solicitacao,
				sum(ouv_ouvidoria.id_tipo=8) as denuncia, count(ouv_ouvidoria.id_ouvidoria) as total
 					from ouv_ouvidoria
					    inner join ouv_assunto on ouv_ouvidoria.id_assunto = ouv_assunto.id_assunto
					    inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria 
					    and ouv_processo.form = 1 and ouv_processo.ativo = 1
					    ".$comp."
      						group by ouv_assunto.id_assunto
      							order by ouv_assunto.assunto";
        $resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se não der erro
			return $resultado;
		}
	}

	/*------------- Função para atualizar o status_atual de um registro da ouvidoria --------------*/
	public function atualizar($status,$ouvidoria) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//atualizacao
		$sql = "update ouv_ouvidoria 
					set id_status_atual = ".$status." 
						where id_ouvidoria = ".$ouvidoria;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se não der erro
			return 1;
		}
	}

	/*------------- Função para atualizar a inibição de dados do manifestante --------------------------*/
	public function atualizar_inibicao($inibicao,$ouvidoria) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//atualizacao
		$sql = "update ouv_processo
					set inibir_dados = ".$inibicao." 
						where id_ouvidoria = ".$ouvidoria;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se não der erro
			return 1;
		}	
	}
	
	/*------------- Função para atualizar o status_atual de um registro da ouvidoria para pendente quando a data limite for alcançada --------------*/
	public function atualizar_pendencias() {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//atualizacao
		$sql = "update ouv_ouvidoria
					inner join ouv_processo on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
						set ouv_ouvidoria.id_status_atual = 4
							where current_date() >= ouv_processo.data_fim
							and ouv_ouvidoria.id_status_atual not in (3,4,6,7)
							and ouv_processo.form = 1";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se não der erro
			return 1;
		}
	}
	
	//numero de processos por dia em um determinado periodo para o relatorio por entidades
	public function processos_por_dia($inicio, $fim, $entidade = '', $status = '', $tipo = '', $subitem = '') {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$comp = '';
		if($entidade != ''){
			$comp = " and ouv_processo.id_entidade = ".$entidade;
		}
		else{
			$comp = " and ouv_processo.id_entidade >= 0";
		}
		
		
		//filtrar status
		if ($status != '') {
			$comp .= " and ouv_ouvidoria.id_status_atual = ".$status;
		}
		
		//filtrar tipo de usuario
		if ($tipo != '') {
			$comp .= " and ouv_ouvidoria.id_tipo_usuario = ".$tipo;
		}
		
		//filtrar subitem
		if ($subitem != '') {
			$comp .= " and ouv_ouvidoria.id_subitem = ".$subitem;
		}
		
		//busca
		$sql = "select count(id_processo)as total, date_format(date(data_ini),'%d/%m/%Y') as data
					from ouv_processo
						inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
							where date(data_ini) between '".$inicio."' and '".$fim."'
							".$comp."
								group by date(data_ini)";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
//numero de processos por dia em um determinado periodo para o relatorio por entidades
	public function processos_por_dia_dir($inicio, $fim, $diretoria, $status = '', $tipo = '', $subitem = '') {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		if ($diretoria != ''){
			$comp = "ouv_diretoria.id_diretoria = ".$diretoria;
		}
		else{
			$comp = "ouv_diretoria.id_diretoria > 0";
		}
		
		//filtrar status
		if ($status != '') {
			$comp .= "and ouv_ouvidoria.id_status_atual = ".$status;
		}
		
		//filtrar tipo de usuario
		if ($tipo != '') {
			$comp .= "and ouv_ouvidoria.id_tipo_usuario = ".$tipo;
		}
		
		//filtrar subitem
		if ($subitem != '') {
			$comp .= " and ouv_ouvidoria.id_subitem = ".$subitem;
		}
		
		//busca
		$sql = "select count(id_processo)as total, date_format(date(data_ini),'%d/%m/%Y') as data
					from ouv_processo
					inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
                    inner join ouv_entidade on ouv_processo.id_entidade = ouv_entidade.id_entidade
					inner join ouv_entidade_diretoria on ouv_entidade_diretoria.id_entidade = ouv_entidade.id_entidade
					inner join ouv_diretoria on ouv_entidade_diretoria.id_diretoria = ouv_diretoria.id_diretoria
					where date(data_ini) between '".$inicio."' and '".$fim."'
                    and ".$comp." group by date(data_ini)";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	
	//numero de processos para cada status em um determinado periodo para o relatorio comparativo
	public function processos_por_status($inicio,$fim,$entidade='') {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		if ($entidade != '') {
			$comp = "and ouv_processo.id_entidade = ".$entidade;
		}
		
		$sql = "select count(ouv_processo.id_processo) as total, ouv_status.status
					from ouv_processo
						inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
						inner join ouv_status on ouv_status.id_status = ouv_ouvidoria.id_status_atual
							where date(data_ini) between '".$inicio."' and '".$fim."'
							and ouv_processo.form = 1
							and ouv_processo.ativo = 1
							".$comp."
								group by ouv_status.id_status";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//numero de processos para cada canal em um determinado periodo
	public function processos_por_canal($datas) {
		$conexao = new conexao();
		
		$sql = "select canais.canal, count(ouv_ouvidoria.id_canal) as qtd
					from ouv_ouvidoria
						inner join canais on canais.id_canal = ouv_ouvidoria.id_canal
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
							where ouv_processo.form = 1
							".$datas."
								group by canais.id_canal";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	public function comparativos($valores,$datas) {
		$conexao = new conexao();
		
		switch ($valores['tipo']) {
			case 'entidade':
				$tabela = "ouv_entidade";
				$id = "id_entidade";
				$descricao = "entidade";
				$join = "inner join ouv_entidade on ouv_entidade.id_entidade = ouv_processo.id_entidade";
				$group = "ouv_entidade.id_entidade";
			break;
			case 'modalidade':
				$tabela = "ouv_modalidade";
				$id = "id_modalidade";
				$descricao = "modalidade";
				$join = "inner join ouv_modalidade on ouv_modalidade.id_modalidade = ouv_ouvidoria.id_modalidade";
				$group = "ouv_modalidade.id_modalidade";
			break;
			case 'status':
				$tabela = "ouv_status";
				$id = "id_status";
				$descricao = "status";
				$join = "inner join ouv_status on ouv_status.id_status = ouv_ouvidoria.id_status_atual";
				$group = "ouv_status.id_status";
			break;
			case 'assunto':
				$tabela = "ouv_assunto";
				$id = "id_assunto";
				$descricao = "assunto";
				$join = "inner join ouv_assunto on ouv_assunto.id_assunto = ouv_ouvidoria.id_assunto";
				$group = "ouv_assunto.id_assunto";
			break;
			case 'deficiencia':
				$tabela = "ouv_deficiencia";
				$id = "id";
				$descricao = "deficiencia";
				$join = "inner join ouv_deficiencia on ouv_deficiencia.id = ouv_ouvidoria.id_deficiencia";
				$group = "ouv_deficiencia.id";
			break;
			case 'tipo_usuario':
				$tabela = "ouv_tipo_usuario";
				$id = "id_tipo_usuario";
				$descricao = "descricao";
				$join = "inner join ouv_tipo_usuario on ouv_tipo_usuario.id_tipo_usuario = ouv_ouvidoria.id_tipo_usuario";
				$group = "ouv_tipo_usuario.id_tipo_usuario";
			break;
			case 'tipo_manifestacao':
				$tabela = "ouv_tipo";
				$id = "id_tipo";
				$descricao = "tipo";
				$join = "inner join ouv_tipo on ouv_tipo.id_tipo = ouv_ouvidoria.id_tipo";
				$group = "ouv_tipo.id_tipo";
			break;
			case 'canais':
				$tabela = "ouv_canal";
				$id = "id_canal";
				$descricao = "canal";
				$join = "inner join ouv_canal on ouv_canal.id_canal = ouv_ouvidoria.id_canal";
				$group = "ouv_canal.id_canal";
			break;
		}
		
		$comp = '';
		if ($valores['entidade'] != '') {
			$comp = " and ouv_processo.id_entidade = ".$valores['entidade'];
		}
		if ($valores['modalidade'] != '') {
			$comp = " and ouv_ouvidoria.id_modalidade = ".$valores['modalidade'];
		}
		if ($valores['status'] != '') {
			$comp .= " and ouv_ouvidoria.id_status_atual = ".$valores['status'];
		}
		if ($valores['tipo_usuario'] != '') {
			$comp .= " and ouv_ouvidoria.id_tipo_usuario = ".$valores['tipo_usuario'];
		}
		if ($valores['assunto'] != '') {
			$comp .= " and ouv_ouvidoria.id_assunto = ".$valores['assunto'];
		}
		if ($valores['deficiencia'] != '') {
			$comp .= " and ouv_ouvidoria.id_deficiencia = ".$valores['deficiencia'];
		}
		if ($valores['tipo_manifestacao'] != '') {
			$comp .= " and ouv_ouvidoria.id_tipo = ".$valores['tipo_manifestacao'];
		}
		if ($valores['canais'] != '') {
			$comp .= " and ouv_ouvidoria.id_canal = ".$valores['canais'];
		}
		
		$sql = "select ".$tabela.".".$descricao." as tipo, count(".$tabela.".".$id.") as qtd
					from ouv_ouvidoria						
						inner join ouv_processo on ouv_processo.id_ouvidoria = ouv_ouvidoria.id_ouvidoria
						".$join."
							where ouv_processo.form = 1
							and ouv_processo.ativo = 1
							".$comp."
							".$datas."
								group by ".$group;
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	public function alterar_tipo_usuario($tipo,$ouvidoria) {
		$conexao = new conexao();
		
		$sql = "update ouv_processo
					inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
						set id_tipo_usuario = ".$tipo."
							where ouv_ouvidoria.id_ouvidoria = ".$ouvidoria;
		$conexao -> query($sql);
	}
	
	public function alterar_entidade($entidade,$ouvidoria) {
		$conexao = new conexao();
		
		$sql = "update ouv_processo
					inner join ouv_ouvidoria on ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
						set id_entidade = ".$entidade."
							where ouv_ouvidoria.id_ouvidoria = ".$ouvidoria;
		$conexao -> query($sql);
	}

	public function alterar_modalidade($modalidade,$ouvidoria) {
		$conexao = new conexao();
		
		$sql = "update ouv_ouvidoria
					set id_modalidade = ".$modalidade."
						where ouv_ouvidoria.id_ouvidoria = ".$ouvidoria;
		$conexao -> query($sql);
	}
	
	public function alterar_tipo($tipo,$ouvidoria,$denuncia=0) {
		$conexao = new conexao();
		
		$conexao -> begin();
		
		$sql = "update ouv_ouvidoria
					set id_tipo = ".$tipo."
						where ouv_ouvidoria.id_ouvidoria = ".$ouvidoria;
		$conexao -> query($sql);
		
		if ($denuncia == 1 && $tipo != 8) {
			$sql = "delete ouv_denuncia 
						from ouv_denuncia
							inner join ouv_processo on ouv_denuncia.id_processo = ouv_processo.id_processo
								where ouv_processo.id_ouvidoria = ".$ouvidoria;
			$conexao -> query($sql);
		}
		
		$conexao -> commit();
	}
	
	public function alterar_assunto($assunto,$ouvidoria) {
		$conexao = new conexao();
		
		$sql = "update ouv_ouvidoria
					set id_assunto = ".$assunto."
						where ouv_ouvidoria.id_ouvidoria = ".$ouvidoria;
		$conexao -> query($sql);
	}
	
	/*------------- Função para contar o numero de mensagens para um tipo e uma dir --------------*/
	//$datas => complemento para o sql limitar a data inicial e final
	public function contar_dir($tipo=0,$diretoria=0,$datas='',$status='',$tipo='',$subitem='') {
	//criar objeto da classe conexão
		$conexao = new conexao();
		
		//complemento para o sql se apenas o tipo foi informado
		if ($tipo != 0 && $diretoria == '') {
			$comp = " WHERE id_tipo = ".$tipo." AND ouv_diretoria.id_diretoria > 0";
		}
		
		//complemento para o sql se tipo e dir foram informados
		if ($tipo != 0 && $diretoria != '') {
			$comp = " where (id_tipo = ".$tipo.")AND ouv_diretoria.id_diretoria = ".$diretoria;
		
		}
		
		//complemento para o sql se apenas a entidade foi informada
		if ($tipo == 0 && $diretoria != '') {
			$comp = " WHERE ouv_diretoria.id_diretoria = ".$diretoria;
			
		}
		
		if ($tipo == 0 && $diretoria == '') {
			$comp = " WHERE ouv_diretoria.id_diretoria > 0 ";
			
		}
		
		//limitar data inicial e final
		if ($datas != '') {
			$comp .= $datas;
		}
		
		//filtrar status
		if ($status != '') {
			$comp .= " and ouv_ouvidoria.id_status_atual = ".$status;
		}
		
		//filtrar tipo de usuario
		if ($tipo != '') {
			$comp .= " and ouv_ouvidoria.id_tipo_usuario = ".$tipo;
		}
		
		//filtrar subitem
		if ($subitem != '') {
			$comp .= " and ouv_ouvidoria.id_subitem = ".$subitem;
		}
		
		//faz a busca
		$sql = "select id_processo from ouv_processo
				INNER join ouv_ouvidoria ON ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
				INNER join ouv_entidade_diretoria ON ouv_processo.id_entidade = ouv_entidade_diretoria.id_entidade 
				INNER join ouv_diretoria ON ouv_diretoria.id_diretoria = ouv_entidade_diretoria.id_diretoria
				".$comp;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o numero de resultados se não der erro
			return mysql_num_rows($resultado);
		}
	}
	
}
?>