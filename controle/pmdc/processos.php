<?php 
function controle_processos($acao) {
	switch ($acao) {
		case 'incluir':
			session_start();
			
			//criar objeto da classe tipos
			require_once('../../classe/pmdc/tipos.php');
			$tipos = new tipos();
			
			//criar objeto da classe entidades
			require_once('../../classe/entidades.php');
			$entidades = new entidades();
			
			//criar objeto da classe modalidades
			require_once('../../classe/pmdc/modalidades.php');
			$modalidades = new modalidades();
			
			//criar objeto da classe deficiencia
			require_once('../../classe/deficiencia.php');
			$deficiencia = new deficiencia();
			
			//criar objeto da classe tipo_usuario
			require('../../classe/tipo_usuario.php');
			$tipo_usuario = new tipo_usuario();
			
			//criar objeto da classe assunto
			require('../../classe/pmdc/assunto.php');
			$assunto = new assunto();
			
			global $lista_tipos;
			global $lista_entidades;
			global $lista_modalidades;
			global $lista_tipo;
			global $lista_deficiencias;
			global $lista_assunto;
			
			//listar os tipos
			$lista_tipos = $tipos -> listar();
			
			//listar as deficiencias
			$lista_deficiencias = $deficiencia -> listar();
			
			//listar os tipos de usuarios
			$lista_tipo = $tipo_usuario -> listar();
			
			//listar os assuntos
			$lista_assunto = $assunto -> listar(1);
			
			//listar as entidades
			$lista_entidades = $entidades -> listar(1,1);
			
			//listar as modalidades
			$lista_modalidades = $modalidades -> listar();
			
			//incluir dados do formulário no banco
			if ($_POST['incluir'] == 1) {
				//criar objeto da classe processos
				require_once('../../classe/pmdc/processos.php');
				$processos = new processos();
				
				//chama a função de inclusão da classe processos
				$resultado = $processos -> incluir($_POST);
				if ($resultado != '') {
					echo "<script>window.location='protocolo.php?pr=".base64_encode($resultado)."'</script>"; 
					die;
				}
			}
		break;
		
		case 'visualizar':
			//criar objeto da classe processos
			require_once('../../classe/pmdc/processos.php');
			$processos = new processos();

			//criar objeto da classe entidades
			require_once('../../classe/entidades.php');
			$entidades = new entidades();

			//criar objeto da classe modalidades
			require_once('../../classe/pmdc/modalidades.php');
			$modalidades = new modalidades();
			
			//criar objeto da classe status
			require_once('../../classe/status.php');
			$status = new status();
			
			//criar objeto da classe tipo
			require_once('../../classe/pmdc/tipos.php');
			$tipos = new tipos();
			
			//criar objeto da classe deficiencia
			require_once('../../classe/deficiencia.php');
			$deficiencia = new deficiencia();
			
			//criar objeto da classe assunto
			require_once('../../classe/pmdc/assunto.php');
			$assunto = new assunto();
			
			//criar objeto da classe historico
			require_once('../../classe/pmdc/historico.php');
			$historico = new historico();
			
			//atualizar registros pendentes
			$historico -> incluir_pendentes();
			$processos -> atualizar_pendencias();
			
			global $resultado;
			global $resultado_outros;
			global $num;
			global $lista_entidades;
			global $lista_modalidades;
			global $lista_deficiencias;
			global $lista_status;
			global $lista_tipo;
			global $lista_assunto;
			global $filtro;
			global $filtroStatus;
			global $filtrotipo;
			global $filtroassunto;
			global $filtroEntidade;
			global $filtroModalidade;
			global $filtroDeficiencia;
			global $filtroInicial;
			global $filtroFinal;
			
			//manter filtros quando trocar de pagina
			$filtro = '';
			$filtroStatus = $_GET['status'];
			$filtrotipo = $_GET['tipo_manifestacao'];
			$filtroassunto = $_GET['assunto'];
			$filtroEntidade = $_GET['entidade'];			
			$filtroModalidade = $_GET['modalidade'];
			$filtroDeficiencia = $_GET['deficiencia'];
			$filtroInicial = date("d/m/Y", strtotime("-5 months"));
			$filtroFinal = date('d/m/Y');
			
			//filtros informados por post ou get
			if ($_POST['status'] != '') {
				$filtro .= "&status=".$_POST['status'];
				$filtroStatus = $_POST['status'];
			}
			if ($_POST['tipo_manifestacao'] != '') {
				$filtro .= "&tipo_manifestacao=".$_POST['tipo_manifestacao'];
				$filtrotipo = $_POST['tipo_manifestacao'];
			}
			if ($_POST['assunto'] != '') {
				$filtro .= "&assunto=".$_POST['assunto'];
				$filtroassunto = $_POST['assunto'];
			}
			if ($_POST['deficiencia'] != '') {
				$filtro .= "&deficiencia=".$_POST['deficiencia'];
				$filtroDeficiencia = $_POST['deficiencia'];
			}
			if ($_POST['entidade'] != '') {
				$filtro .= "&entidade=".$_POST['entidade'];
				$filtroEntidade = $_POST['entidade'];
			}
			if ($_POST['modalidade'] != '') {
				$filtro .= "&modalidade=".$_POST['modalidade'];
				$filtroModalidade = $_POST['modalidade'];
			}
			if ($_POST['data_inicial'] != '') {
				$filtro .= "&di=".$_POST['data_inicial'];
				$filtroInicial = $_POST['data_inicial'];
			}
			if ($_POST['data_final'] != '') {
				$filtro .= "&df=".$_POST['data_final'];
				$filtroFinal = $_POST['data_final'];
			}
			
			if ($_GET['status'] != '') {
				$filtro .= "&status=".$_GET['status'];
				$filtroStatus = $_GET['status'];
			}
			if ($_GET['tipo_manifestacao'] != '') {
				$filtro .= "&tipo_manifestacao=".$_GET['tipo_manifestacao'];
				$filtrotipo = $_GET['tipo_manifestacao'];
			}
			if ($_GET['assunto'] != '') {
				$filtro .= "&assunto=".$_GET['assunto'];
				$filtroassunto = $_GET['assunto'];
			}
			if ($_GET['deficiencia'] != '') {
				$filtro .= "&deficiencia=".$_GET['deficiencia'];
				$filtroDeficiencia = $_GET['deficiencia'];
			}
			if ($_GET['entidade'] != '') {
				$filtro .= "&entidade=".$_GET['entidade'];
				$filtroEntidade = $_GET['entidade'];
			}
			if ($_GET['modalidade'] != '') {
				$filtro .= "&modalidade=".$_GET['modalidade'];
				$filtroModalidade = $_GET['modalidade'];
			}
			if ($_GET['di'] != '') {
				$filtro .= "&di=".$_GET['di'];
				$filtroInicial = $_GET['di'];
			}
			if ($_GET['df'] != '') {
				$filtro .= "&df=".$_GET['df'];
				$filtroFinal = $_GET['df'];
			}
			
			if ($_POST['filtrar'] == 1) {
				$filtro = '';
				$_GET['inicio'] = 0;
				
				if ($_POST['entidade'] != '') {
					$filtro .= "&entidade=".$_POST['entidade'];
					$filtroEntidade = $_POST['entidade'];
				}
				else {
					$filtroEntidade = '';
				}
				
				if ($_POST['modalidade'] != '') {
					$filtro .= "&modalidade=".$_POST['modalidade'];
					$filtroModalidade = $_POST['modalidade'];
				}
				else {
					$filtroModalidade = '';
				}
				
				if ($_POST['deficiencia'] != '') {
					$filtro .= "&deficiencia=".$_POST['deficiencia'];
					$filtroDeficiencia = $_POST['deficiencia'];
				}
				else {
					$filtroDeficiencia = '';
				}
				
				if ($_POST['status'] != '') {
					$filtro .= "&status=".$_POST['status'];
					$filtroStatus = $_POST['status'];
				}
				else {
					$filtroStatus = '';
				}
				if ($_POST['tipo_manifestacao'] != '') {
					$filtro .= "&tipo_manifestacao=".$_POST['tipo_manifestacao'];
					$filtrotipo = $_POST['tipo_manifestacao'];
				}
				else {
					$filtrotipo = '';
				}
				
				if ($_POST['assunto'] != '') {
					$filtro .= "&assunto=".$_POST['assunto'];
					$filtroassunto = $_POST['assunto'];
				}
				else {
					$filtroassunto = '';
				}
				
				if ($_POST['data_inicial'] != '') {
					$filtro .= "&di=".$_POST['data_inicial'];
					$filtroInicial = $_POST['data_inicial'];
				}
				else {
					$filtroInicial = '';
				}
				
				if ($_POST['data_final'] != '') {
					$filtro .= "&df=".$_POST['data_final'];
					$filtroFinal = $_POST['data_final'];
				}
				else {
					$filtroFinal = '';
				}
				
				if ($_POST['deficiencia'] == '' && $_POST['entidade'] == '' && $_POST['modalidade'] == '' && $_POST['status'] == '' && $_POST['tipo_manifestacao'] == '' && $_POST['assunto'] == '' && $_POST['data_inicial'] == '' && $_POST['data_final'] == '') {
					$filtro = "";
				}
			}

			//post ou get
			if ($_POST['tipo'] != '') {
				$tipo = $_POST['tipo'];
			}
			else {
				$tipo = $_GET['t'];
			}
			
			if ($_POST['busca'] != '') {
				$busca = $_POST['busca'];
			}
			else {
				$busca = $_GET['p'];
			}
			
			//filtros de pesquisa
			//if ($_POST['pesquisar'] == 1 && $_POST['filtrar'] != 1) {
				$filtro .= "&t=".$tipo."&p=".$busca;
			/*}
			else {
				//if ($_GET['p'] != '' && $_POST['filtrar'] != 1) {
					$filtro .= "&t=".$_GET['t']."&p=".$_GET['p'];
				/*}
				else {
					$filtro .= "&t=&p=&f=1";
				}
			}*/
			
			
			//listagem geral
			//if (($_POST['pesquisar'] != 1 && $_GET['p'] == '') || ($_POST['filtrar'] == 1 || $_GET['f'] == 1)) {
				//chama a função de listagem da classe processos
				if ($_GET['inicio'] == '') {
					$processos -> listar($filtroStatus,$filtrotipo,$filtroassunto,$filtroEntidade,$filtroModalidade,$filtroDeficiencia,$filtroInicial,$filtroFinal,$tipo,$busca,0,($_GET['pg']==37));
				}
				else {
					$processos -> listar($filtroStatus,$filtrotipo,$filtroassunto,$filtroEntidade,$filtroModalidade,$filtroDeficiencia,$filtroInicial,$filtroFinal,$tipo,$busca,$_GET['inicio'],($_GET['pg']==37));	
				}
			/*}
			//pesquisa
			else {
				//chama a função de pesquisa da classe processos
				if ($_GET['inicio'] == '') {
					$processos -> pesquisar($filtroStatus,$filtrotipo,$filtroassunto,$filtroEntidade,$filtroModalidade,$filtroDeficiencia,$tipo,$busca);
				}
				else {
					$processos -> pesquisar($filtroStatus,$filtrotipo,$filtroassunto,$filtroEntidade,$filtroModalidade,$filtroDeficiencia,$tipo,$busca,$_GET['inicio']);
				}
			}*/

			//resultado da listagem da classe processos
			$resultado = $processos -> resultado;
			
			//numero total de registros para paginação
			$num = $processos -> num;
			
			//chama a função de listagem da classe entidades
			$lista_entidades = $entidades -> listar($_SESSION['entidade']);

			//chama a função de listagem da classe status
			$lista_status = $status -> listar();
			
			//chama a função de listagem da classe tipo
			$lista_tipo = $tipos -> listar();
			
			//chama a função de listagem da classe assunto
			$lista_assunto = $assunto -> listar();
			
			//chama a função de listagem da classe deficiencia
			$lista_deficiencias = $deficiencia -> listar();
			
			//chama a função de listagem da classe modalidades
			$lista_modalidades = $modalidades -> listar();
		break;
		
		//unidades
		case 'visualizar_unidade':
			//criar objeto da classe processos
			require_once('../../classe/pmdc/processos.php');
			$processos = new processos();

			//criar objeto da classe tipo
			require_once('../../classe/pmdc/tipos.php');
			$tipos = new tipos();

			global $resultado;
			global $resultado_outros;
			global $num;
			global $lista_tipo;
			global $filtro;
			global $filtrotipo;
			global $filtroInicial;
			global $filtroFinal;

			//manter filtros quando trocar de pagina
			$filtro = '';
			$filtrotipo = $_GET['tipo'];
			$filtroInicial = date("d/m/Y", strtotime("-5 months"));
			$filtroFinal = date('d/m/Y');

			//filtros informados por post ou get
			if ($_POST['tipo'] != '') {
				$filtro .= "&tipo=".$_POST['tipo'];
				$filtrotipo = $_POST['tipo'];
			}
			if ($_POST['data_inicial'] != '') {
				$filtro .= "&di=".$_POST['data_inicial'];
				$filtroInicial = $_POST['data_inicial'];
			}
			if ($_POST['data_final'] != '') {
				$filtro .= "&df=".$_POST['data_final'];
				$filtroFinal = $_POST['data_final'];
			}
				
			if ($_GET['tipo'] != '') {
				$filtro .= "&tipo=".$_GET['tipo'];
				$filtrotipo = $_GET['tipo'];
			}
			if ($_GET['di'] != '') {
				$filtro .= "&di=".$_GET['di'];
				$filtroInicial = $_GET['di'];
			}
			if ($_GET['df'] != '') {
				$filtro .= "&df=".$_GET['df'];
				$filtroFinal = $_GET['df'];
			}
				
			if ($_POST['filtrar'] == 1) {
				$filtro = '';
				$_GET['inicio'] = 0;
		
				if ($_POST['tipo'] != '') {
					$filtro .= "&tipo=".$_POST['tipo'];
					$filtrotipo = $_POST['tipo'];
				}
				else {
					$filtrotipo = '';
				}
		
				if ($_POST['data_inicial'] != '') {
					$filtro .= "&di=".$_POST['data_inicial'];
					$filtroInicial = $_POST['data_inicial'];
				}
				else {
					$filtroInicial = '';
				}
		
				if ($_POST['data_final'] != '') {
					$filtro .= "&df=".$_POST['data_final'];
					$filtroFinal = $_POST['data_final'];
				}
				else {
					$filtroFinal = '';
				}
		
				if ($_POST['tipo'] == '' && $_POST['data_inicial'] == '' && $_POST['data_final'] == '') {
					$filtro = "";
				}
			}
				
			//filtros de pesquisa
			if ($_POST['pesquisar'] == 1 && $_POST['filtrar'] != 1) {
				$filtro .= "&t=".$_POST['tipo']."&p=".$_POST['busca'];
			}
			else {
				if ($_GET['p'] != '' && $_POST['filtrar'] != 1) {
					$filtro .= "&t=".$_GET['t']."&p=".$_GET['p'];
				}
				else {
					$filtro .= "&t=&p=&f=1";
				}
			}
				
			//listagem geral
			if (($_POST['pesquisar'] != 1 && $_GET['p'] == '') || ($_POST['filtrar'] == 1 || $_GET['f'] == 1)) {
				//chama a função de listagem da classe processos
				if ($_GET['inicio'] == '') {
					$processos -> listar_unidade($filtroStatus,$filtrotipo,$filtroEntidade,$filtroInicial,$filtroFinal);
				}
				else {
					$processos -> listar_unidade($filtroStatus,$filtrotipo,$filtroEntidade,$filtroInicial,$filtroFinal,$_GET['inicio']);
				}
			}
			//pesquisa
			else {
				//post ou get
				if ($_POST['tipo'] != '') {
					$tipo = $_POST['tipo'];
				}
				else {
					$tipo = $_GET['t'];
				}
		
				if ($_POST['busca'] != '') {
					$busca = $_POST['busca'];
				}
				else {
					$busca = $_GET['p'];
				}
		
				//chama a função de pesquisa da classe processos
				if ($_GET['inicio'] == '') {
					$processos -> pesquisar_unidade($filtroStatus,$filtrotipo,$filtroEntidade,$tipo,$busca);
				}
				else {
					$processos -> pesquisar_unidade($filtroStatus,$filtrotipo,$filtroEntidade,$tipo,$busca,$_GET['inicio']);
				}
			}
		
			//resultado da listagem da classe processos
			$resultado = $processos -> resultado;
				
			//numero total de registros para paginação
			$num = $processos -> num;
				
			//chama a função de listagem da classe tipo
			$lista_tipo = $tipos -> listar();
		break;
		
		//responder processos em bloco
		case 'bloco':
			//criar objeto da classe entidades
			require_once('../../classe/entidades.php');
			$entidades = new entidades();
			
			//criar objeto da classe modalidades
			require_once('../../classe/pmdc/modalidades.php');
			$modalidades = new modalidades();

			//criar objeto da classe deficiencia
			require_once('../../classe/deficiencia.php');
			$deficiencia = new deficiencia();

			//criar objeto da classe status
			require_once('../../classe/status.php');
			$status = new status();
			
			//criar objeto da classe resposta_padrao
			require_once('../../classe/resposta_padrao.php');
			$resposta_padrao = new resposta_padrao();
			
			//criar objeto da classe tipos
			require_once('../../classe/pmdc/tipos.php');
			$tipos = new tipos();
			
			//criar objeto da classe assunto
			require_once('../../classe/pmdc/assunto.php');
			$assunto = new assunto();
			
			global $lista_entidades;
			global $lista_modalidades;
			global $lista_deficiencias;
			global $lista_status_resposta;
			global $lista_status;
			global $lista_resposta;
			global $lista_tipo;
			global $lista_assunto;
			
			//chama a função de listagem da classe entidades
			$lista_entidades = $entidades -> listar($_SESSION['entidade']);

			//chama a função de listagem da classe modalidades (filtro)
			$lista_modalidades = $modalidades -> listar();
			
			//chama a função de listagem da classe deficiencia (filtro)
			$lista_deficiencias = $deficiencia -> listar();
			
			//chama a função de listagem da classe status (filtro)
			$lista_status = $status -> listar();
			
			//chama a função de listagem da classe status (resposta)
			$lista_status_resposta = $status -> listar();
			
			//chama a função de listagem da classe resposta_padrao
			$lista_resposta = $resposta_padrao -> listar();
			
			//chama a função de listagem da classe tipo
			$lista_tipo = $tipos -> listar();
			
			//chama a função de listagem da classe assunto
			$lista_assunto = $assunto -> listar();
		break;
		
		case 'visualizar_denuncias':
			//criar objeto da classe processos
			require_once('../../classe/pmdc/processos.php');
			$processos = new processos();

			//criar objeto da classe entidades
			require_once('../../classe/entidades.php');
			$entidades = new entidades();
			
			//criar objeto da classe modalidades
			require_once('../../classe/pmdc/modalidades.php');
			$modalidades = new modalidades();
			
			//criar objeto da classe deficiencia
			require_once('../../classe/deficiencia.php');
			$deficiencia = new deficiencia();

			//criar objeto da classe status
			require_once('../../classe/status.php');
			$status = new status();
			
			//criar objeto da classe historico
			require_once('../../classe/pmdc/historico.php');
			$historico = new historico();
			
			//atualizar registros pendentes
			$historico -> incluir_pendentes();
			$processos -> atualizar_pendencias();
			
			global $resultado;
			global $resultado_outros;
			global $num;
			global $lista_entidades;
			global $lista_modalidades;
			global $lista_deficiencias;
			global $lista_status;
			global $filtro;
			global $filtroStatus;
			global $filtroassunto;
			global $filtroEntidade;
			global $filtroModalidade;
			global $filtroDeficiencia;
			global $filtroInicial;
			global $filtroFinal;
			
			//manter filtros quando trocar de pagina
			$filtro = '';
			$filtroStatus = $_GET['status'];
			$filtrotipo = $_GET['tipo'];
			$filtroAssunto = $_GET['assunto'];			
			$filtroEntidade = $_GET['entidade'];			
			$filtroModalidade = $_GET['modalidade'];			
			$filtroDeficiencia = $_GET['deficiencia'];			
			$filtroInicial = date("d/m/Y", strtotime("-5 months"));
			$filtroFinal = date('d/m/Y');
			
			//filtros informados por post ou get
			if ($_POST['status'] != '') {
				$filtro .= "&status=".$_POST['status'];
				$filtroStatus = $_POST['status'];
			}
			if ($_POST['entidade'] != '') {
				$filtro .= "&entidade=".$_POST['entidade'];
				$filtroEntidade = $_POST['entidade'];
			}
			if ($_POST['modalidade'] != '') {
				$filtro .= "&modalidade=".$_POST['modalidade'];
				$filtroModalidade = $_POST['modalidade'];
			}
			if ($_POST['assunto'] != '') {
				$filtro .= "&assunto=".$_POST['assunto'];
				$filtroassunto = $_POST['assunto'];
			}
			if ($_POST['deficiencia'] != '') {
				$filtro .= "&deficiencia=".$_POST['deficiencia'];
				$filtroDeficiencia = $_POST['deficiencia'];
			}
			if ($_POST['data_inicial'] != '') {
				$filtro .= "&di=".$_POST['data_inicial'];
				$filtroInicial = $_POST['data_inicial'];
			}
			if ($_POST['data_final'] != '') {
				$filtro .= "&df=".$_POST['data_final'];
				$filtroFinal = $_POST['data_final'];
			}
			
			if ($_GET['status'] != '') {
				$filtro .= "&status=".$_GET['status'];
				$filtroStatus = $_GET['status'];
			}
			if ($_GET['assunto'] != '') {
				$filtro .= "&assunto=".$_GET['assunto'];
				$filtroassunto = $_GET['assunto'];
			}
			if ($_GET['deficiencia'] != '') {
				$filtro .= "&deficiencia=".$_GET['deficiencia'];
				$filtroDeficiencia = $_GET['deficiencia'];
			}
			if ($_GET['entidade'] != '') {
				$filtro .= "&entidade=".$_GET['entidade'];
				$filtroEntidade = $_GET['entidade'];
			}
			if ($_GET['modalidade'] != '') {
				$filtro .= "&modalidade=".$_GET['modalidade'];
				$filtroModalidade = $_GET['modalidade'];
			}
			if ($_GET['di'] != '') {
				$filtro .= "&di=".$_GET['di'];
				$filtroInicial = $_GET['di'];
			}
			if ($_GET['df'] != '') {
				$filtro .= "&df=".$_GET['df'];
				$filtroFinal = $_GET['df'];
			}
			
			if ($_POST['filtrar'] == 1) {
				$filtro = '';
				$_GET['inicio'] = 0;
				
				if ($_POST['entidade'] != '') {
					$filtro = "&entidade=".$_POST['entidade'];
					$filtroEntidade = $_POST['entidade'];
				}
				else {
					$filtroEntidade = '';
				}
				
				if ($_POST['modalidade'] != '') {
					$filtro = "&modalidade=".$_POST['modalidade'];
					$filtroModalidade = $_POST['modalidade'];
				}
				else {
					$filtroModalidade = '';
				}
				
				if ($_POST['deficiencia'] != '') {
					$filtro = "&deficiencia=".$_POST['deficiencia'];
					$filtroDeficiencia = $_POST['deficiencia'];
				}
				else {
					$filtroDeficiencia = '';
				}
				
				if ($_POST['status'] != '') {
					$filtro = "&status=".$_POST['status'];
					$filtroStatus = $_POST['status'];
				}
				else {
					$filtroStatus = '';
				}
				
				if ($_POST['assunto'] != '') {
					$filtro .= "&assunto=".$_POST['assunto'];
					$filtroassunto = $_POST['assunto'];
				}
				else {
					$filtroassunto = '';
				}
				
				if ($_POST['data_inicial'] != '') {
					$filtro .= "&di=".$_POST['data_inicial'];
					$filtroInicial = $_POST['data_inicial'];
				}
				else {
					$filtroInicial = '';
				}
				
				if ($_POST['data_final'] != '') {
					$filtro .= "&df=".$_POST['data_final'];
					$filtroFinal = $_POST['data_final'];
				}
				else {
					$filtroFinal = '';
				}
				
				if ($_POST['entidade'] == '' && $_POST['deficiencia'] == '' && $_POST['modalidade'] == '' && $_POST['assunto'] == '' && $_POST['status'] == '' && $_POST['data_inicial'] == '' && $_POST['data_final'] == '') {
					$filtro = "";
				}
			}
			
			//post ou get
			if ($_POST['tipo'] != '') {
				$tipo = $_POST['tipo'];
			}
			else {
				$tipo = $_GET['t'];
			}
			
			if ($_POST['busca'] != '') {
				$busca = $_POST['busca'];
			}
			else {
				$busca = $_GET['p'];
			}
			
			//filtros de pesquisa
			//if ($_POST['pesquisar'] == 1 && $_POST['filtrar'] != 1) {
				$filtro .= "&t=".$tipo."&p=".$busca;
			/*}
			else {
				if ($_GET['p'] != '' && $_POST['filtrar'] != 1) {
					$filtro .= "&t=".$_GET['t']."&p=".$_GET['p'];
				}
				else {
					$filtro .= "&t=&p=&f=1";
				}
			}*/
			
			//listagem geral
			//if (($_POST['pesquisar'] != 1 && $_GET['p'] == '') || ($_POST['filtrar'] == 1 || $_GET['f'] == 1)) {
				//chama a função de listagem da classe processos
				if ($_GET['inicio'] == '') {
					$processos -> listar_denuncias($filtroStatus,$filtroassunto,$filtroEntidade,$filtroModalidade,$filtroDeficiencia,$filtroInicial,$filtroFinal,$tipo,$busca);
				}
				else {
					$processos -> listar_denuncias($filtroStatus,$filtroassunto,$filtroEntidade,$filtroModalidade,$filtroDeficiencia,$filtroInicial,$filtroFinal,$tipo,$busca,$_GET['inicio']);	
				}
			/*}
			//pesquisa
			else {
				//chama a função de pesquisa da classe processos
				if ($_GET['inicio'] == '') {
					$processos -> pesquisar_denuncias($filtroStatus,$filtroassunto,$filtroEntidade,$filtroModalidade,$filtroDeficiencia,$tipo,$busca);
				}
				else {
					$processos -> pesquisar_denuncias($filtroStatus,$filtroassunto,$filtroEntidade,$filtroModalidade,$filtroDeficiencia,$tipo,$busca,$_GET['inicio']);
				}
			}*/

			//resultado da listagem da classe processos
			$resultado = $processos -> resultado;
			
			//numero total de registros para paginação
			$num = $processos -> num;
			
			//chama a função de listagem da classe entidades
			$lista_entidades = $entidades -> listar($_SESSION['entidade']);

			//chama a função de listagem da classe modalidades
			$lista_modalidades = $modalidades -> listar();
			
			//chama a função de listagem da classe deficiencia
			$lista_deficiencias = $deficiencia -> listar();
			
			//chama a função de listagem da classe status
			$lista_status = $status -> listar();
		break;
		
		case 'detalhes':
			global $resultado;
			global $permissoes;
			global $resultado_historico;
			global $resultado_ent;
			global $resultado_entidade;
			global $resultado_tipo_manifestacao;
			global $resultado_pri;
			global $resultado_tipo;
			global $resultado_assunto;
			global $lista_status;
			global $lista_modalidades;
			global $id_destino;
			global $id_origem;
			global $lista_resposta;
			
			//criar objeto da classe processos
			require_once('../../classe/pmdc/processos.php');
			$processos = new processos();
			
			//criar objeto da classe tipos
			require_once('../../classe/pmdc/tipos.php');
			$tipos = new tipos();
			
			//criar objeto da classe entidades
			require_once('../../classe/entidades.php');
			$entidades = new entidades();
			
			//criar objeto da classe status
			require_once('../../classe/status.php');
			$status = new status();

			//criar objeto da classe modalidade de ensino
			require_once('../../classe/pmdc/modalidades.php');
			$modalidades = new modalidades();

			//criar objeto da classe prioridade
			require_once('../../classe/prioridade.php');
			$prioridade = new prioridade();

			//criar objeto da classe tipo_usuario
			require_once('../../classe/tipo_usuario.php');
			$tipo_usuario = new tipo_usuario();
			
			//criar objeto da classe assunto
			require_once('../../classe/pmdc/assunto.php');
			$assunto = new assunto();

			//criar objeto da classe usuario
			require_once('../../classe/usuario.php');
			$usuario = new usuario();
			
			//criar objeto da classe resposta_padrao
			require_once('../../classe/resposta_padrao.php');
			$resposta_padrao = new resposta_padrao();
			
			//criar objeto da classe historico
			require_once('../../classe/pmdc/historico.php');
			$historico = new historico();
			
			//incluir visualização no historico
			if (count($_POST) < 1) {
				$historico->incluir_visualizacao($_GET['id'],$_SESSION['usuario']);
			}
			
			//excluir manifestaçao
			if ($_POST['excluir'] == 1) {
				$resultado = $processos -> excluir($_GET['id']);
				if ($resultado == 1) {	
					echo "<script>alert('Manifestação excluída');</script>";
					echo "<script>window.location='?pg=1'</script>";
					die;
				}
			}
			
			if ($_POST['inibir']) {
				$resultado = $processos -> inibir($_GET['id']);
				if ($resultado == 1) {
					echo "<script>alert('Manifestação inibida');</script>";
					echo "<script>window.location='?pg=1'</script>";
					die;
				}
			}
			
			if ($_POST['inibir_denuncia']) {
				$resultado = $processos -> inibir($_GET['id']);
				if ($resultado == 1) {
					echo "<script>alert('Denúncia inibida');</script>";
					echo "<script>window.location='?pg=19'</script>";
					die;
				}
			}
			
			if ($_POST['restaurar']) {
				$resultado = $processos -> restaurar($_GET['id']);
				if ($resultado == 1) {	
					echo "<script>alert('Manifestação restaurada');</script>";
					echo "<script>window.location='?pg=15'</script>";
					die;
				}
			}
			
			if ($_POST['restaurar_denuncia']) {
				$resultado = $processos -> restaurar($_GET['id']);
				if ($resultado == 1) {	
					echo "<script>alert('Manifestação restaurada');</script>";
					echo "<script>window.location='?pg=18'</script>";
					die;
				}
			}
			
			//alterações
			if ($_POST['alterar']) {
				$resultado = $processos -> atualizar($_POST['novo_status'], $_GET['id']);
				if ($resultado == 1) {
					$resultado = $historico -> incluir($_POST);
					if ($resultado == 1) {
						//alteração realizada com sucesso
						echo "<script>alert('alteração realizada com sucesso');</script>";
						/*echo "<script>window.location='index.php?pg=2&id=".$_POST['id_ouvidoria']."';</script>";*/
					}
				}
			}
			
			if ($_POST['btn_cidadao'] || $_POST['btn_vinculada']) {
				require_once('../../controle/mail/class.phpmailer.php');
				//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
				
				$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
				
				$mail->IsSMTP(); // telling the class to use SMTP
				
				try {
					$email = ($_POST['btn_cidadao'] != '') ? $_POST['email_cidadao'] : $_POST['email_vinculada'];
					$destino = ($_POST['btn_cidadao'] != '') ? 'Cidadão' : 'Vinculada';
					$nome = ($_POST['btn_cidadao'] != '') ? $_POST['nome_cidadao'] : $_POST['nome_vinculada'];
					$copia = ($_POST['btn_cidadao'] != '') ? $_POST['copia_cidadao'] : $_POST['copia_vinculada'];
					if ($email == '') {
						echo "<script>alert('Informe o E-mail');</script>";
					}
					else {
						$mail->Host       = "smtps.proderj.rj.gov.br"; // SMTP server
						$mail->SMTPSecure = 'ssl';
						$mail->SMTPAuth = true;
						$mail->Port = 465;
						$mail->Username = 'dinfosedes@faetec.rj.gov.br';
						$mail->Password = 'faetec2010';
						$mail->ContentType = 'text/html';
						$mail->AddReplyTo('ouvidoria@duquedecaxias.rj.gov.br', 'Ouvidoria PMDC');
						$mail->SetFrom('ouvidoria@duquedecaxias.rj.gov.br', 'Ouvidoria PMDC');
						$mail->AddAddress($email, $nome);
						
						//copias
						$n = 0;
						$copias = '; com cópia para: ';
						$cc = '';
						$cp = explode(",",$copia);
						foreach ($cp as $c) {
							if ($c != '') {
								if ($n == 0) {
									$copias .= $c;
									$n = 1;
								}
								else {
									$copias .= ", ".$c;
								}
								$mail->AddCC($c, '');
							}
						}
						
						if ($n > 0) {
							$cc = $copias;
						}
						
						$mail->Subject = 'Ouvidoria PMDC';
						$mail->AltBody = 'Para ver esta mensagem, use um visualizador de e-mail compatível com HTML'; // optional - MsgHTML will create an alternate automatically
						if ($_POST['btn_vinculada'] != '') {
							$mail->MsgHTML(nl2br($_POST['resumo'])."<br><br>".$_POST['dados_manifestacao']);
							//$mail->MsgHTML(nl2br(utf8_decode($_POST['resumo']))."<br><br>".$_POST['dados_manifestacao']);
						}
						else {
							$mail->MsgHTML(nl2br($_POST['resumo']));
							//$mail->MsgHTML(nl2br(utf8_decode($_POST['resumo'])));
						}
						//$mail->AddAttachment('images/phpmailer.gif');      // attachment
						//$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
						
						if ($mail->Send()) {
							echo "<script>alert('Mensagem enviada');</script>";
						}
						
						$sql = "insert into ouv_historico 
								(id_ouvidoria, id_status, data, resumo, id_usuario, publico) 
								values 
								(".$_GET['id'].", 
								(select id_status_atual from ouv_ouvidoria where id_ouvidoria = ".$_GET['id']."),
								'".date('Y-m-d H:i:s')."', 'E-mail enviado para ".$email." (".$destino.")".$cc."',
								".$_SESSION['usuario'].", ".$_POST['publico'].")";
						$historico->Incluir_email($sql);
					}
				}
				catch (phpmailerException $e) {
					echo $e->errorMessage(); //Pretty error messages from PHPMailer
				}
				catch (Exception $e) {
					echo $e->getMessage(); //Boring error messages from anything else!
				}
			}
			
			if ($_POST['btn_resposta_unidade']) {
				$resultado = $processos -> atualizar(7, $_GET['id']);
				if ($resultado == 1) {
					$resultado = $historico -> incluir($_POST);
					if ($resultado == 1) {
						//alteração realizada com sucesso
						echo "<script>alert('alteração realizada com sucesso');</script>";
					}
				}
			}
			
			//chama a funcao para listar as entidades
			$resultado_ent = $entidades -> listar($_SESSION['entidade']);
			$resultado_entidade = $entidades -> listar($_SESSION['entidade']);
			
			//chama a funcao para listar os tipos
			$resultado_tipo_manifestacao = $tipos -> listar($_SESSION['entidade']);
			
			//chama a funcao para listar as prioridades
			$resultado_pri = $prioridade -> listar();
			
			//chama a funcao para listar os tipos de usuario
			$resultado_tipo = $tipo_usuario -> listar();
			
			//chama a funcao para listar os assuntos
			$resultado_assunto = $assunto -> listar();
			
			//chama a função de listagem da classe status
			$lista_status = $status -> listar();
			
			//chama a função de listagem da classe modalidade de ensino
			$lista_modalidades = $modalidades -> listar();

			//chama a função de listagem da classe resposta_padrao
			$lista_resposta = $resposta_padrao -> listar();
			
			//chama a função para listar dados de um registro da classe processos
			$resultado = $processos -> detalhes($_GET['id']);
			
			//buscar permissoes do usuario
			$permissoes = $usuario -> permissoes($_SESSION['usuario']);
			
			//chama a função para listar o historico de um registro da classe processos
			$resultado_historico = $historico -> listar($_GET['id']);
			
			//guarda o id_destino do registro de historico mais recente
			$id_destino = mysql_result($resultado_historico,0,'id_destino');
			//guarda o id_origem do registro de historico mais recente
			$id_origem = mysql_result($resultado_historico,0,'id_origem');
		break;
		
		case 'inativos':
			//criar objeto da classe processos
			require_once('../../classe/pmdc/processos.php');
			$processos = new processos();

			//criar objeto da classe entidades
			require_once('../../classe/entidades.php');
			$entidades = new entidades();

			//criar objeto da classe status
			require_once('../../classe/status.php');
			$status = new status();
			
			//criar objeto da classe historico
			require_once('../../classe/pmdc/historico.php');
			$historico = new historico();
			
			//atualizar registros pendentes
			$historico -> incluir_pendentes();
			$processos -> atualizar_pendencias();
			
			global $resultado;
			global $resultado_outros;
			global $num;
			global $lista_entidades;
			global $lista_status;
			global $filtro;
			global $filtroStatus;
			global $filtroEntidade;
			
			//manter filtros quando trocar de pagina
			$filtro = '';
			$filtroStatus = $_GET['status'];
			$filtroEntidade = $_GET['entidade'];
			
			//filtros informados por post ou get
			if ($_POST['status'] != '') {
				$filtro .= "&status=".$_POST['status'];
				$filtroStatus = $_POST['status'];
			}
			if ($_POST['entidade'] != '') {
				$filtro .= "&entidade=".$_POST['entidade'];
				$filtroEntidade = $_POST['entidade'];
			}
			
			if ($_GET['status'] != '') {
				$filtro .= "&status=".$_GET['status'];
				$filtroStatus = $_GET['status'];
			}
			if ($_GET['entidade'] != '') {
				$filtro .= "&entidade=".$_GET['entidade'];
				$filtroEntidade = $_GET['entidade'];
			}
			
			if ($_POST['filtrar'] == 1) {
				$_GET['inicio'] = 0;
				
				if ($_POST['entidade'] != '') {
					$filtro = "&entidade=".$_POST['entidade'];
					$filtroEntidade = $_POST['entidade'];
				}
				else {
					$filtroEntidade = '';
				}
				
				if ($_POST['status'] != '') {
					$filtro = "&status=".$_POST['status'];
					$filtroStatus = $_POST['status'];
				}
				else {
					$filtroStatus = '';
				}
				
				if ($_POST['entidade'] == '' && $_POST['status'] == '') {
					$filtro = "";
				}
			}
			
			//filtros de pesquisa
			if ($_POST['pesquisar'] == 1) {
				$filtro .= "&t=".$_POST['tipo']."&p=".$_POST['busca'];
			}
			elseif ($_GET['p'] != '') {
				$filtro .= "&t=".$_GET['t']."&p=".$_GET['p'];
			}
			
			//listagem geral
			if ($_POST['pesquisar'] != 1) {
				//chama a função de listagem da classe processos
				if ($_GET['inicio'] == '') {
					$processos -> listar_inativos($filtroStatus,$filtroEntidade);
				}
				else {
					$processos -> listar_inativos($filtroStatus,$filtroEntidade,$_GET['inicio']);	
				}
			}
			//pesquisa
			else {
				//post ou get
				if ($_POST['tipo'] != '') {
					$tipo = $_POST['tipo'];
				}
				else {
					$tipo = $_GET['t'];
				}
				
				if ($_POST['busca'] != '') {
					$busca = $_POST['busca'];
				}
				else {
					$busca = $_GET['p'];
				}
				
				//chama a função de pesquisa da classe processos
				if ($_GET['inicio'] == '') {
					$processos -> pesquisar_inativos($filtroStatus,$filtroEntidade,$tipo,$busca);
				}
				else {
					$processos -> pesquisar_inativos($filtroStatus,$filtroEntidade,$tipo,$busca,$_GET['inicio']);
				}
			}
						
			//resultado da listagem da classe processos
			$resultado = $processos -> resultado;
			
			//numero total de registros para paginação
			$num = $processos -> num;
			
			//chama a função de listagem da classe entidades
			$lista_entidades = $entidades -> listar($_SESSION['entidade']);

			//chama a função de listagem da classe status
			$lista_status = $status -> listar();
		break;
		
		case 'denuncias_inativas':
			//criar objeto da classe processos
			require_once('../../classe/pmdc/processos.php');
			$processos = new processos();

			//criar objeto da classe entidades
			require_once('../../classe/entidades.php');
			$entidades = new entidades();

			//criar objeto da classe status
			require_once('../../classe/status.php');
			$status = new status();
			
			//criar objeto da classe historico
			require_once('../../classe/pmdc/historico.php');
			$historico = new historico();
			
			//atualizar registros pendentes
			$historico -> incluir_pendentes();
			$processos -> atualizar_pendencias();
			
			global $resultado;
			global $resultado_outros;
			global $num;
			global $lista_entidades;
			global $lista_status;
			global $filtro;
			global $filtroStatus;
			global $filtroEntidade;
			
			//manter filtros quando trocar de pagina
			$filtro = '';
			$filtroStatus = $_GET['status'];
			$filtroEntidade = $_GET['entidade'];
			
			//filtros informados por post ou get
			if ($_POST['status'] != '') {
				$filtro .= "&status=".$_POST['status'];
				$filtroStatus = $_POST['status'];
			}
			if ($_POST['entidade'] != '') {
				$filtro .= "&entidade=".$_POST['entidade'];
				$filtroEntidade = $_POST['entidade'];
			}
			
			if ($_GET['status'] != '') {
				$filtro .= "&status=".$_GET['status'];
				$filtroStatus = $_GET['status'];
			}
			if ($_GET['entidade'] != '') {
				$filtro .= "&entidade=".$_GET['entidade'];
				$filtroEntidade = $_GET['entidade'];
			}
			
			if ($_POST['filtrar'] == 1) {
				$_GET['inicio'] = 0;
				
				if ($_POST['entidade'] != '') {
					$filtro = "&entidade=".$_POST['entidade'];
					$filtroEntidade = $_POST['entidade'];
				}
				else {
					$filtroEntidade = '';
				}
				
				if ($_POST['status'] != '') {
					$filtro = "&status=".$_POST['status'];
					$filtroStatus = $_POST['status'];
				}
				else {
					$filtroStatus = '';
				}
				
				if ($_POST['entidade'] == '' && $_POST['status'] == '') {
					$filtro = "";
				}
			}
			
			//filtros de pesquisa
			if ($_POST['pesquisar'] == 1) {
				$filtro .= "&t=".$_POST['tipo']."&p=".$_POST['busca'];
			}
			elseif ($_GET['p'] != '') {
				$filtro .= "&t=".$_GET['t']."&p=".$_GET['p'];
			}
			
			//listagem geral
			if ($_POST['pesquisar'] != 1) {
				//chama a função de listagem da classe processos
				if ($_GET['inicio'] == '') {
					$processos -> listar_denuncias_inativas($filtroStatus,$filtroEntidade);
				}
				else {
					$processos -> listar_denuncias_inativas($filtroStatus,$filtroEntidade,$_GET['inicio']);	
				}
			}
			//pesquisa
			else {
				//post ou get
				if ($_POST['tipo'] != '') {
					$tipo = $_POST['tipo'];
				}
				else {
					$tipo = $_GET['t'];
				}
				
				if ($_POST['busca'] != '') {
					$busca = $_POST['busca'];
				}
				else {
					$busca = $_GET['p'];
				}
				
				//chama a função de pesquisa da classe processos
				if ($_GET['inicio'] == '') {
					$processos -> pesquisar_denuncias_inativas($filtroStatus,$filtroEntidade,$tipo,$busca);
				}
				else {
					$processos -> pesquisar_denuncias_inativas($filtroStatus,$filtroEntidade,$tipo,$busca,$_GET['inicio']);
				}
			}
						
			//resultado da listagem da classe processos
			$resultado = $processos -> resultado;
			
			//numero total de registros para paginação
			$num = $processos -> num;
			
			//chama a função de listagem da classe entidades
			$lista_entidades = $entidades -> listar($_SESSION['entidade']);

			//chama a função de listagem da classe status
			$lista_status = $status -> listar();
		break;
		
		case 'historico_publico':
			if ($_POST['enviar']) {
				require_once('../../classe/pmdc/historico.php');
				$historico = new historico();
				
				$historico -> incluir($_POST);
				echo "<script>alert('Novo comentário registrado');</script>";
				
				global $res;
				global $res2;
				
				$res = $historico -> listar_protocolo($_POST['n_prot']); 
				$res2 = $historico -> listar_protocolo($_POST['n_prot']); 
			}
			else {
				if ($_POST['n_prot']!=''){
					require_once('../../classe/pmdc/historico.php');
					$historico = new historico();
					
					global $res;
					global $res2;					
					
					$res = $historico -> listar_protocolo($_POST['n_prot']); 
					$res2 = $historico -> listar_protocolo($_POST['n_prot']); 
				}
			}
		break;
		
		case 'incluir_denuncia':
			session_start();
			
			//criar objeto da classe tipos
			require_once('../../classe/pmdc/tipos.php');
			$tipos = new tipos();
			
			//criar objeto da classe deficiencia
			require_once('../../classe/deficiencia.php');
			$deficiencia = new deficiencia();

			//criar objeto da classe entidades
			require_once('../../classe/entidades.php');
			$entidades = new entidades();
			
			//criar objeto da classe modalidades
			require_once('../../classe/pmdc/modalidades.php');
			$modalidades = new modalidades();
			
			//criar objeto da classe assunto
			require('../../classe/pmdc/assunto.php');
			$assunto = new assunto();
			
			global $lista_tipos;
			global $lista_entidades;
			global $lista_modalidades;
			global $lista_deficiencias;
			global $lista_assunto;
			
			//listar os tipos
			$lista_tipos = $tipos -> listar();

			//listar as entidades
			$lista_entidades = $entidades -> listar(1,1);
			
			//listar as modalidades
			$lista_modalidades = $modalidades -> listar();
			
			//listar as deficiencias
			$lista_deficiencias = $deficiencia -> listar();
			
			//listar os assuntos
			$lista_assunto = $assunto -> listar(1);
			
			//incluir dados do formulário no banco
			if ($_POST['incluir'] == 1) {
				//criar objeto da classe processos
				require_once('../../classe/pmdc/processos.php');
				$processos = new processos();
				
				//chama a função de inclusão da classe processos
				$resultado = $processos -> incluir_denuncia($_POST);
				
				if ($resultado != '') {
					$id_foto=explode("-",$resultado);
					
					/*foreach ($_FILES["file"]['tmp_name'] as $chave => $arq) {
						if ($arq != '') {
							$tam = ($_FILES["file"]['size'][$chave]/1048576);
							if ($tam < 1) {
								$num = $chave + 1;
								$anexo = $processos -> formatar_anexo($id_foto[1]."-".$num."-".$_FILES["file"]['name'][$chave]);
								if (!copy($arq, "../../anexos/".$anexo)) {
									echo "Erro ao enviar".$_FILES["file"]['name'][$chave];
								}
								else {
									$processos -> incluir_anexo($id_foto[1],$anexo,$num);
								}
							}
						}
					}*/
					
					echo "<script>window.location='protocolo.php?pr=".base64_encode($resultado)."'</script>"; 
					die;
				}
			}
		break;
	}
}

if (isset($_POST['id'])) {
	//criar objeto da classe resposta_padrao
	require_once('../../classe/resposta_padrao.php');
	$resposta_padrao = new resposta_padrao();
	$res = $resposta_padrao -> detalhes($_POST['id']);
	echo utf8_encode(mysql_result($res,0,'observacao'));
}

if (isset($_POST['prioridade'])) {
	//criar objeto da classe prioridade
	require_once('../../classe/prioridade.php');
	$prioridade = new prioridade();
	$res = $prioridade -> alterar($_POST['prioridade'],$_POST['id_ouvidoria']);
}

if ($_POST['id_tipo_usuario']) {
	//criar objeto da classe tipo_usuario
	require_once('../../classe/pmdc/processos.php');
	$processos = new processos();
	$processos -> alterar_tipo_usuario($_POST['tipo_usuario'],$_POST['id_ouvidoria']);
}

if ($_POST['entidade_nova']) {
	require_once('../../classe/pmdc/processos.php');
	$processos = new processos();
	$processos -> alterar_entidade($_POST['entidade_nova'],$_POST['id_ouvidoria']);
}

if ($_POST['modalidade_nova']) {
	require_once('../../classe/pmdc/processos.php');
	$processos = new processos();
	$processos -> alterar_modalidade($_POST['modalidade_nova'],$_POST['id_ouvidoria']);
}

if ($_POST['assunto_novo']) {
	require_once('../../classe/pmdc/processos.php');
	$processos = new processos();
	$processos -> alterar_assunto($_POST['assunto_novo'],$_POST['id_ouvidoria']);
}

if ($_POST['tipo_novo']) {
	require_once('../../classe/pmdc/processos.php');
	$processos = new processos();
	$processos -> alterar_tipo($_POST['tipo_novo'],$_POST['id_ouvidoria'],$_POST['denuncia']);
}

if ($_POST['filtrar_bloco']) {
	require_once('../../classe/pmdc/processos.php');
	$processos = new processos();
	
	$processos -> listar_bloco($_POST['status'],$_POST['entidade'],$_POST['modalidade'],$_POST['deficiencia'],$_POST['data_inicial'],$_POST['data_final'],$_POST['tipo'],$_POST['assunto']);
	$resultado = $processos -> resultado;
	
	echo "<table width='100%' border='0' id='tabela' class='tablesorter'>";
	echo "	<thead>";
	echo "		<tr>";
	echo "	    	<th>Protocolo</th>";
	echo "	    	<th>Tipo</th>";
	echo "	    	<th>Assunto</th>";
	echo "	    	<th>Entidade</th>";
	echo "	    	<th>Data</th>";
	echo "	    	<th>Data Limite</th>";
	echo "	    	<th>Status</th>";
	echo "	    	<th><input type='checkbox' id='selecionar_todos'> Selecionar</th>";
	echo "	  	</tr>";
	echo "	</thead>";
	echo "	<tbody>";
	while ($r = mysql_fetch_array($resultado)) {
		switch ($r['status_atual']) {
			case 'Nova':
				$cor='#000000';
			break;
			case 'Atendida':
				$cor='#1d6302';
			break;
			case 'Encaminhada':
				$cor='#d08a03';
			break;
			case 'Pendente':
				$cor='#a30d02';
			break;
			case 'Respondida':
				$cor='#456de0';
			break;
			case 'Reiterada':
				$cor='#FF0066';
			break;
		}
		echo "<tr style='color:".$cor.";font-weight:bold'>";
		echo "	<td>".$r['protocolo']."</td>";
		echo "	<td>".utf8_encode($r['tipo'])."</td>";
		echo "	<td>".utf8_encode($r['assunto'])."</td>";
		echo "	<td>".utf8_encode($r['entidade'])."</td>";
		echo "	<td>".$r['data']."</td>";
		echo "	<td>".$r['data_fim']."</td>";
		echo "	<td>".$r['status_atual']."</td>";
		echo "	<td><input type='checkbox' name='processos_escolhidos' value='".$r['id_ouvidoria']."'></td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
}

if ($_POST['escolhido']) {
	require_once('../../classe/pmdc/processos.php');
	$processos = new processos();
	
	require_once('../../classe/pmdc/historico.php');
	$historico = new historico();
	
	session_start();
	
	//alterações
	$ids = explode("|",$_POST['ids']);
	foreach ($ids as $id) {
		$_POST['id_ouvidoria'] = $id;
		$resultado = $processos -> atualizar($_POST['novo_status'], $id);
		if ($resultado == 1) {
			$resultado = $historico -> incluir($_POST);
		}
	}
}

if ($_POST['inibir_blobo']) {
	require_once('../../classe/pmdc/processos.php');
	$processos = new processos();
	
	//alterações
	$ids = explode("|",$_POST['ids']);
	foreach ($ids as $id) {
		$resultado = $processos -> inibir($id);
	}
}

if ($_POST['email_bloco']) {
	require_once('../../controle/mail/class.phpmailer.php');
	//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
	
	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
	
	$mail->IsSMTP(); // telling the class to use SMTP
	
	try {
		$email = $_POST['email'];
		$destino = $_POST['destino'];
		$nome = $_POST['nome'];
		$copia = $_POST['copia'];
		if ($email == '') {
			echo "<script>alert('Informe o E-mail');</script>";
		}
		else {
			$mail->Host       = "smtps.proderj.rj.gov.br"; // SMTP server
			$mail->SMTPSecure = 'ssl';
			$mail->SMTPAuth = true;
			$mail->Port = 465;
			$mail->Username = 'dinfosedes@faetec.rj.gov.br';
			$mail->Password = 'faetec2010';
			$mail->ContentType = 'text/html';
			$mail->AddReplyTo('ouvidoria@duquedecaxias.rj.gov.br', 'Ouvidoria PMDC');
			$mail->SetFrom('ouvidoria@duquedecaxias.rj.gov.br', 'Ouvidoria PMDC');
			$mail->AddAddress($email, $nome);
			
			//copias
			if ($destino == 'Vinculada') {
				$cp = explode(",",$copia);
				foreach ($cp as $c) {
					if ($c != '') {
						$mail->AddCC($c, '');
					}
				}
			}
			//copias ocultas
			else {
				$cp = explode(",",$copia_oculta);
				foreach ($cp as $c) {
					if ($c != '') {
						$mail->AddBCC($c, '');
					}
				}
			}
			
			$mail->Subject = 'Ouvidoria PMDC';
			$mail->AltBody = 'Para ver esta mensagem, use um visualizador de e-mail compatível com HTML'; // optional - MsgHTML will create an alternate automatically
			if ($destino == 'Vinculada') {
				session_start();
				$ids = explode("|",$_POST['ids']);
				$manifestacoes = '';
				foreach ($ids as $id) {
					require_once('../../classe/pmdc/processos.php');
					$processos = new processos();
					
					$detalhes = mysql_fetch_array($processos -> detalhes($id));
					if ($detalhes['inibir_dados'] == '0') {
						$html = "<br><br>";
						$html .= "<table width='100%' border='0'>";
						$html .= "	<tr class='odd'>";
						$html .= "		<td width='15%' class='td'>Protocolo:</td><td width='25%' class='textol'>".$detalhes['protocolo']."</td>";
						$html .= "		<td width='10%' class='td'>Data:</td><td width='20%' class='textol'>".$detalhes['data']."</td>";
						$html .= "		<td width='10%' class='td'>Data Limite:</td><td width='20%' class='textol' colspan=2>".$detalhes['data_fim']."</td>";
						$html .= "	</tr>";
						$html .= "	<tr class='column1'>";
						$html .= "		<td class='td'>tipo:</td>";
						$html .= "		<td class='textol'>".$l['tipo']."</td>";
						$html .= "		<td class='td'>Status:</td><td class='textol'>".$detalhes['status_atual']."</td>";
						$html .= "		<td class='td'>Prioridade:</td>";
						$html .= "		<td colspan=2>".$detalhes['desc_prioridade']."</td>";
						$html .= "	</tr>";
						$html .= "	<tr class='odd'>";
						$html .= "		<td class='td'>Nome:</td><td colspan='3' class='textol'>".$detalhes['nome']."</td>";
						$html .= "		<td class='td'>CPF:</td><td class='textol'>".$detalhes['cpf']."</td>";
						$html .= "	</tr>";
						$html .= "	<tr class='column1'>";
						$html .= "		<td class='td'>Sexo:</td>";
						$html .= "		<td class='textol'>".$detalhes['sexo']."</td>";
						$html .= "		<td class='td'>Data Nascimento:</td>";
						$html .= "		<td class='textol'>".$detalhes['data_nasc']."</td>";
						$html .= "		<td class='td'>Tipo de usu&aacute;rio:</td>";
						$html .= "		<td class='textol'>".$detalhes['tipo_usuario']."</td>";
						$html .= "	</tr>";
						$html .= "	<tr class='odd'>";
						$html .= "		<td class='td'>Escolaridade:</td>";
						$html .= "		<td class='textol'>".$detalhes['escolaridade']."</td>";
						$html .= "		<td class='td'>Defici&ecirc;ncia:</td>";
						$def = ($detalhes['deficiencia'] == '') ? 'Nenhuma' : $detalhes['deficiencia'];
						$html .= "		<td class='textol' colspan='3'>".$def."</td>";
						$html .= "	</tr>";
						$html .= "	<tr  class='column1'>";
						$html .= "		<td class='td'>E-mail:</td>";
						$html .= "		<td colspan='7' class='textol'>".$detalhes['email']."</td>";
						$html .= "	</tr>";
						$html .= "	<tr class='odd'>";
						$html .= "		<td class='td'>Endere&ccedil;o:</td>";
						$html .= "		<td colspan='7' class='textol'>".$detalhes['endereco']."</td>";
						$html .= "	</tr>";
						$html .= "	<tr class='column1'>";
						$html .= "		<td class='td'>Bairro:</td>";
						$html .= "		<td class='textol'>".$detalhes['bairro']."</td>";
						$html .= "		<td class='td'>Cidade:</td>";
						$html .= "		<td colspan='5' class='textol'>".$detalhes['cidade']."</td>";
						$html .= "	</tr>";
						$html .= "	<tr class='odd'>";
						$html .= "		<td class='td'>Telefone:</td>";
						$html .= "		<td class='textol'>".$detalhes['telefone']."</td>";
						$html .= "		<td class='td'>Celular:</td>";
						$html .= "		<td colspan='5' class='textol'>".$detalhes['celular']."</td>";
						$html .= "	</tr>";
						$html .= "	<tr class='column1'>";
						$html .= "		<td class='td'>Entidade:</td>";
						$html .= "		<td class='textol'>".$detalhes['entidade']."</td>";
						$html .= "		<td class='td'>Primeira Manifesta&ccedil;&atilde;o:</td>";
						$html .= "		<td colspan='5' class='textol'>".$detalhes['prim_rec']."</td>";
						$html .= "	</tr>";
						$html .= "	<tr class='odd'>";
						$html .= "		<td class='td'>Protocolo(s) Anteriore(s):</td>";
						$html .= "		<td colspan='5' class='textol'>".$detalhes['protocolo_anterior']."</td>";
						$html .= "	</tr>";
						$html .= "	<tr class='column1'>";
						$html .= "		<td class='td'>Coment&aacute;rio:</td><td colspan='7' class='textol'>".nl2br($detalhes['comentario'])."</td>";
						$html .= "		<input type='hidden' name='coment' id='coment' value='".$detalhes['comentario']."'>";
						$html .= "	</tr>";
						$html .= "</table>";
					}
					else {
						$html .= "	<tr class='column1'>";
						$html .= "		<td class='td'>Coment&aacute;rio:</td><td width='20px' class='textol'>".nl2br($detalhes['comentario'])."</td>";
						$html .= "		<input type='hidden' name='coment' id='coment' value='".$detalhes['comentario']."'>";
						$html .= "	</tr>";
					}
					$manifestacoes .= $html;
				}
				$mail->MsgHTML(nl2br(utf8_decode($_POST['resumo']))."<br><br>".$manifestacoes);
			}
			else {
				$mail->MsgHTML(nl2br(utf8_decode($_POST['resumo'])));
			}
			if ($mail->Send()) {
				echo 1;
			}
		}
	}
	catch (phpmailerException $e) {
		echo $e->errorMessage(); //Pretty error messages from PHPMailer
	}
	catch (Exception $e) {
		echo $e->getMessage(); //Boring error messages from anything else!
	}
}

if ($_POST['inibir_dados_novo'] != '') {
	require_once('../../classe/pmdc/processos.php');
	$processos = new processos();
	
	session_start();
	
	$processos -> atualizar_inibicao($_POST['inibir_dados_novo'],$_POST['id_ouvidoria']);
}


if ($_POST['historico_bloco']) {
	require_once('../../classe/pmdc/historico.php');
	$historico = new historico();
	session_start();
	
	$ids = explode("|",$_POST['ids']);
	foreach ($ids as $id) {
		$sql = "insert into ouv_historico 
						(id_ouvidoria, id_status, data, resumo, id_usuario, publico) 
						values 
						(".$id.", 
						(select id_status_atual from ouv_ouvidoria where id_ouvidoria = ".$id."),
						'".date('Y-m-d H:i:s')."', 'E-mail enviado para ".$_POST['email']." (".utf8_decode($_POST['destino']).") com cópia para: ".$_POST['copia']."',
						".$_SESSION['usuario'].", ".$_POST['publico'].")";
		$historico -> Incluir_email($sql);
	}
}
?>