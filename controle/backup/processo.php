<?php
require('../../classe/backup/processo.php');
session_start();

function Processo($opcao){
	$processo = new processo(); 
	
	switch ($opcao)	{
		case 'ouvidoria':
			global $res;
			global $ini;
			global $pg;
			global $res_e;
			global $res_s;
			
			if ($_GET['ini']==""){
				$ini=0;
			} else {
				$ini=$_GET['ini'];
			}
			
			//$processo->ListOuvidoria('');

			//criar objeto da classe historico
			require_once('../../classe/backup/historico.php');
			$historico = new historico();
			
			//atualizar registros pendentes
			$historico -> incluir_pendentes();
			$processo -> atualizar_pendencias();

			require('../../classe/entidades.php');

			$entidade = new entidades();

			$res_e= $entidade->listar($_SESSION['entidade']);

			require('../../classe/status.php');

			$status = new status();

			$res_s = $status->listar();

			global $filtroStatus;
			global $filtro;
			global $filtroEntidade;
				
			//manter filtros quando trocar de pagina
			$filtro = '';
			$filtroEntidade = $_GET['entidade'];
			$filtroStatus = $_GET['status'];
			
			//filtros informados por post ou get
			if ($_POST['status'] != '') {
				$filtro .= "&status=".$_POST['status'];
				$filtroStatus = $_POST['status'];
			}
			
			//filtros informados por post ou get
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
				if ($_GET['ini'] == '') {
					$processo -> ListOuvidoria($filtroEntidade,$filtroStatus);
				}
				else {
					$processo -> ListOuvidoria($filtroEntidade,$filtroStatus,$_GET['ini']);
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
				
				//chama a funÃ§Ã£o de pesquisa da classe processos
				if ($_GET['ini'] == '') {
					$processo -> pesquisar($filtroEntidade,$tipo,$busca);
				}
				else {
					$processo -> pesquisar($filtroEntidade,$tipo,$busca,$_GET['ini']);
				}
			}
			$res=$processo->Result;

			$total = mysql_num_rows($processo->Resultado);
			$pg = $total/10;	
		break;

		case 'processo':
			global $r;
			global $lista_resposta;
			$id = $_GET['p'];
			
			require('../../classe/backup/historico.php');
			$historico = new historico(); 
			require('../../classe/resposta_padrao.php');
			$resposta_padrao = new resposta_padrao();
			require_once('../../classe/entidades.php');
			$entidades = new entidades();
			require_once('../../classe/assuntos.php');
			$assuntos = new assuntos();
			require_once('../../classe/status.php');
			$status = new status();
			require_once('../../classe/sub_item.php');
			$sub_item = new sub_item();
			
			global $res_o;
			global $resultado_ent;
			global $resultado_entidades;
			global $resultado_assunto;
			global $lista_status;
			global $lista_sub;
			
			if ($_POST['excluir'] == 1) {
				$resultado = $processo -> excluir($id);
				if ($resultado == 1) {	
					echo "<script>alert('Manifestação excluída');</script>";
					echo "<script>window.location='?pg=1'</script>";
					die;
				}
			}
			
			if ($_POST['inibir']) {
				$resultado = $processo -> inibir($id);
				$sql_incluir = "insert into _historico".$_SESSION['periodo']." (id_ouvidoria, id_status, id_resposta_padrao, data, resumo, id_usuario, publico) 
									values (".$_GET['p'].", ".$_POST['status'].", ".$_POST['resposta'].", '".date('Y-m-d H:i:s')."',
									'Manifestação inibida', ".$_SESSION['usuario'].", 0)";
				$historico->Incluir($sql_incluir);
				if ($resultado == 1) {	
					echo "<script>alert('Manifestação inibida');</script>";
					echo "<script>window.location='?pg=1'</script>";
					die;
				}
			}
			
			if ($_POST['restaurar']) {
				$resultado = $processo -> restaurar($id);
				$resposta = $processo -> id_resposta($id);
				if ($resposta == 0) {
					$resposta = 'null';
				}
				$sql_incluir = "insert into _historico".$_SESSION['periodo']." (id_ouvidoria, id_status, id_resposta_padrao, data, resumo, id_usuario, publico) 
									values (".$_GET['p'].", ".$_POST['status'].", ".$resposta.", '".date('Y-m-d H:i:s')."',
									'Manifestação restaurada', ".$_SESSION['usuario'].", 0)";
				$historico->Incluir($sql_incluir);
				if ($resultado == 1) {	
					echo "<script>alert('Manifestação restaurada');</script>";
					echo "<script>window.location='?pg=18'</script>";
					die;
				}
			}
			
			if ($_POST['alterar']) {
				if ($_POST['status']=='2') {
					$sql_incluir = "insert into _historico".$_SESSION['periodo']."
									(id_ouvidoria, id_status, id_resposta_padrao, data, resumo, id_origem, id_destino, id_usuario, publico) 
									values 
									(".$_GET['p'].", ".$_POST['status'].", ".$_POST['resposta'].", '".date('Y-m-d H:i:s')."', '".$_POST['resumo']."',
									".$_SESSION['entidade'].", ".$_POST['destino'].", ".$_SESSION['usuario'].", ".$_POST['publico'].")";
				}
				else {
					$sql_incluir = "insert into _historico".$_SESSION['periodo']." (id_ouvidoria, id_status, id_resposta_padrao, data, resumo, id_usuario, publico) 
									values (".$_GET['p'].", ".$_POST['status'].", ".$_POST['resposta'].", '".date('Y-m-d H:i:s')."',
									'".$_POST['resumo']."', ".$_SESSION['usuario'].", ".$_POST['publico'].")";
				}
				$sql_update = "update _ouvidoria".$_SESSION['periodo']." set id_status_atual=".$_POST['status']." where id_ouvidoria=".$_GET['p'];
				
				$historico->Incluir($sql_incluir);
				$historico->Update($sql_update);
				
				echo "<script>alert('alteração realizada com sucesso');</script>";
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
						$mail->Host       = "relay.proderj.rj.gov.br"; // SMTP server
						//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
						$mail->AddReplyTo('ouvidoria@cienciaetecnologia.rj.gov.br', 'Ouvidoria SECT');
						$mail->SetFrom('ouvidoria@cienciaetecnologia.rj.gov.br', 'Ouvidoria SECT');
						$mail->AddAddress($email, $nome);
						//$mail->AddReplyTo('ouvidoria@cienciaetecnologia.rj.gov.br', 'First Last');
						
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
						
						$mail->Subject = 'Ouvidoria SECT';
						$mail->AltBody = 'Para ver esta mensagem, use um visualizador de e-mail compatível com HTML'; // optional - MsgHTML will create an alternate automatically
						$mail->MsgHTML(nl2br($_POST['resumo']));
						//$mail->AddAttachment('images/phpmailer.gif');      // attachment
						//$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
						
						if ($mail->Send()) {
							echo "<script>alert('Mensagem enviada');</script>";
						}
						
						$sql = "insert into _historico".$_SESSION['periodo']."
								(id_ouvidoria, id_status, data, resumo, id_usuario, publico) 
								values 
								(".$_GET['p'].", 
								(select id_status_atual from _ouvidoria".$_SESSION['periodo']." where id_ouvidoria = ".$_GET['p']."),
								'".date('Y-m-d H:i:s')."', 'E-mail enviado para ".$email." (".$destino.")".$cc."',
								".$_SESSION['usuario'].", ".$_POST['publico'].")";
						$historico->Incluir($sql);
					}
				}
				catch (phpmailerException $e) {
					echo $e->errorMessage(); //Pretty error messages from PHPMailer
				}
				catch (Exception $e) {
					echo $e->getMessage(); //Boring error messages from anything else!
				}
			}
			
			if (count($_POST) < 1) {
				$historico->incluir_visualizacao($_GET['p'],$_SESSION['usuario']);
			}
			
			$processo->ListProcesso($id);
			$r=$processo->Result;
			
			$historico->ListHistoricoO($id);
			$res_o=$historico->Result;
			
			//chama a funcao para listar as entidades
			$resultado_ent = $entidades -> listar($_SESSION['entidade']);
			$resultado_entidades = $entidades -> listar($_SESSION['entidade']);
			
			//chama a funcao para listar os assuntos
			$resultado_assunto = $assuntos -> listar();
			
			//assunto do processo
			$sub = $processo -> assunto($id);
			
			//chama a funcao para listar os subitens do assunto
			$lista_sub = $sub_item -> subitens(mysql_result($sub,0,'id_assunto'));
			
			//chama a funcao para listar os status
			$lista_status = $status -> listar();
			
			//chama a função de listagem da classe resposta_padrao
			$lista_resposta = $resposta_padrao -> listar();
		break;

		case 'processo_d':
			require('../../classe/backup/historico.php');
			$historico = new historico();
			
			require('../../classe/status.php');
			$status = new status();
			
			require('../../classe/resposta_padrao.php');
			$resposta_padrao = new resposta_padrao();
			
			require_once('../../classe/entidades.php');
			$entidades = new entidades();
			
			global $r;
			global $rh;
			global $rs;
			global $rr;
			global $resultado_entidades;
			
			$id = $_GET['p'];
			
			/*if ($_POST['excluir']) {
				require_once('../../classe/backup/denuncia.php');
				$denuncia = new denuncia();
				
				$resultado = $denuncia -> excluir($id);
				if ($resultado == 1) {	
					echo "<script>alert('Denúncia excluída');</script>";
					echo "<script>window.location='?pg=7'</script>";
					die;
				}
			}*/
			
			if ($_POST['inibir']) {
				$resultado = $processo -> inibir($id);
				if ($resultado == 1) {	
					echo "<script>alert('Denúncia inibida');</script>";
					echo "<script>window.location='?pg=7'</script>";
					die;
				}
			}
			
			if ($_POST['restaurar']) {
				$resultado = $processo -> restaurar($id);
				if ($resultado == 1) {	
					echo "<script>alert('Denúncia restaurada');</script>";
					echo "<script>window.location='?pg=20'</script>";
					die;
				}
			}
			
			if ($_POST['alterar']) {
				$sql_incluir = "insert into _historico".$_SESSION['periodo']." (id_ouvidoria, id_status, id_resposta_padrao, data, resumo, id_usuario, publico) 
								values (".$_GET['p'].", ".$_POST['status'].", ".$_POST['resposta'].",
								'".date('Y-m-d H:i:s')."', '".$_POST['resumo']."', ".$_SESSION['usuario'].", ".$_POST['publico'].")";
				$sql_update = "update _ouvidoria".$_SESSION['periodo']." set id_status_atual=".$_POST['status']." where id_ouvidoria=".$_GET['p'];
				
				$historico->Incluir($sql_incluir);
				$historico->Update($sql_update);
				
				echo "<script>alert('alteração realizada com sucesso');</script>";
			}
			
			if (count($_POST) < 1) {
				$historico->incluir_visualizacao($_GET['p'],$_SESSION['usuario']);
			}
			
			$processo->ListProcessoD($id);
			$r = $processo->Result;
			
			$historico -> ListHistoricoO($id);
			$rh = $historico->Result;
			
			$rr = $resposta_padrao -> listar();
			
			$rs = $status -> listar();
			
			$resultado_entidades = $entidades -> listar($_SESSION['entidade']);
		break;

	    case 'denuncia':
			global $res;
			global $ini;
			global $pg;
			global $res_e;
			global $res_s;
			
			if ($_GET['ini']==""){
				$ini=0;
			} else {
				$ini=$_GET['ini'];
			}

			//criar objeto da classe historico
			require_once('../../classe/backup/historico.php');
			$historico = new historico();
			
			//atualizar registros pendentes
			$historico -> incluir_pendentes();
			$processo -> atualizar_pendencias();

			require('../../classe/status.php');

			$status = new status();

			$res_s = $status->listar();

			global $filtroStatus;
			global $filtro;
				
			//manter filtros quando trocar de pagina
			$filtro = '';
			$filtroStatus = $_GET['status'];
			
			//filtros informados por post ou get
			if ($_POST['status'] != '') {
				$filtro .= "&status=".$_POST['status'];
				$filtroStatus = $_POST['status'];
			}
			
			//filtros informados por post ou get
			if ($_GET['status'] != '') {
				$filtro .= "&status=".$_GET['status'];
				$filtroStatus = $_GET['status'];
			}
						
			if ($_POST['filtrar'] == 1) {
				$_GET['inicio'] = 0;
				
				if ($_POST['status'] != '') {
					$filtro = "&status=".$_POST['status'];
					$filtroStatus = $_POST['status'];
				}
				else {
					$filtroStatus = '';
				}
			
				
				if ($_POST['status'] == '') {
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
				if ($_GET['ini'] == '') {
					$processo -> ListDenuncia($filtroStatus);
				}
				else {
					$processo -> ListDenuncia($filtroStatus,$_GET['ini']);
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
				if ($_GET['ini'] == '') {
					$processo -> pesquisar_denuncia($filtroEntidade,$tipo,$busca);
				}
				else {
					$processo -> pesquisar_denuncia($filtroEntidade,$tipo,$busca,$_GET['ini']);
				}
			}
			$res=$processo->Result;

			$total = mysql_num_rows($processo->Resultado);
			$pg = $total/10;			
		break;
		
		case 'historico_publico':
			if ($_POST['n_prot']!=''){
				require('../../classe/backup/historico.php');
				$historico = new historico();
				
				global $res;
				
				$historico -> listhistprotocolo($_POST['n_prot']); 
				$res = $historico -> Result;
			}
		break;
		
		case 'inativos':
			global $res;
			global $ini;
			global $pg;
			global $res_e;
			global $res_s;
			
			if ($_GET['ini']==""){
				$ini=0;
			} else {
				$ini=$_GET['ini'];
			}
			
			//$processo->ListOuvidoria('');

			require('../../classe/entidades.php');

			$entidade = new entidades();

			$res_e= $entidade->listar(10);

			require('../../classe/status.php');

			$status = new status();

			$res_s = $status->listar();

			global $filtroStatus;
			global $filtro;
			global $filtroEntidade;
				
			//manter filtros quando trocar de pagina
			$filtro = '';
			$filtroEntidade = $_GET['entidade'];
			$filtroStatus = $_GET['status'];
			
			//filtros informados por post ou get
			if ($_POST['status'] != '') {
				$filtro .= "&status=".$_POST['status'];
				$filtroStatus = $_POST['status'];
			}
			
			//filtros informados por post ou get
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
				if ($_GET['ini'] == '') {
					$processo -> ListInativos($filtroEntidade,$filtroStatus);
				}
				else {
					$processo -> ListInativos($filtroEntidade,$filtroStatus,$_GET['ini']);
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
				
				//chama a funÃ§Ã£o de pesquisa da classe processos
				if ($_GET['ini'] == '') {
					$processo -> pesquisar_inativos($filtroEntidade,$tipo,$busca);
				}
				else {
					$processo -> pesquisar_inativos($filtroEntidade,$tipo,$busca,$_GET['ini']);
				}
			}
			$res=$processo->Result;

			$total = mysql_num_rows($processo->Resultado);
			$pg = $total/10;	
		break;
		
		case 'denuncias_inativas':
			global $res;
			global $ini;
			global $pg;
			global $res_e;
			global $res_s;
			
			if ($_GET['ini']==""){
				$ini=0;
			} else {
				$ini=$_GET['ini'];
			}
			
			//$processo->ListOuvidoria('');

			require('../../classe/entidades.php');

			$entidade = new entidades();

			$res_e= $entidade->listar(10);

			require('../../classe/status.php');

			$status = new status();

			$res_s = $status->listar();

			global $filtroStatus;
			global $filtro;
			global $filtroEntidade;
				
			//manter filtros quando trocar de pagina
			$filtro = '';
			$filtroEntidade = $_GET['entidade'];
			$filtroStatus = $_GET['status'];
			
			//filtros informados por post ou get
			if ($_POST['status'] != '') {
				$filtro .= "&status=".$_POST['status'];
				$filtroStatus = $_POST['status'];
			}
			
			//filtros informados por post ou get
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
				if ($_GET['ini'] == '') {
					$processo -> ListInativos_d($filtroStatus);
				}
				else {
					$processo -> ListInativos_d($filtroStatus,$_GET['ini']);
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
				
				//chama a funÃ§Ã£o de pesquisa da classe processos
				if ($_GET['ini'] == '') {
					$processo -> pesquisar_denuncias_inativas($filtroEntidade,$tipo,$busca);
				}
				else {
					$processo -> pesquisar_denuncias_inativas($filtroEntidade,$tipo,$busca,$_GET['ini']);
				}
			}
			$res=$processo->Result;

			$total = mysql_num_rows($processo->Resultado);
			$pg = $total/10;	
		break;
	}
}

if ($_POST['prioridade']) {
	$processo = new processo();
	$sql_u="update _ouvidoria".$_SESSION['periodo']." 
			set id_prioridade = ".$_POST['prioridade']." where id_ouvidoria = ".$_POST['id_ouvidoria'];

	$processo->AlterarPrioridade($sql_u);
}

if ($_POST['entidade_nova']) {
	$processo = new processo();
	$processo->alterar_entidade($_POST['entidade_nova'],$_POST['id_ouvidoria']);
}

if ($_POST['assunto_novo']) {
	$processo = new processo();
	$processo->alterar_assunto($_POST['assunto_novo'],$_POST['id_ouvidoria']);
	
	require_once('../../classe/sub_item.php');
	$sub_item = new sub_item();
	
	$lista_sub = $sub_item -> subitens($_POST['assunto_novo']);
	
	if (mysql_num_rows($lista_sub) > 0) {
		echo "<script>document.getElementById('tr_sub').style.visibility='visible'</script>";
		echo "<script>document.getElementById('tr_sub').style.position='relative'</script>";
		echo "<select name='subitem' id='subitem'>";
		echo "<option value=''>Selecione</option>";
		while ($l = mysql_fetch_array($lista_sub)) {
			echo "<option value=".$l['id_subitem'].">".$l['subitem']."</option>";
		}
		echo "</select>";
	}
	else {
		echo "<script>document.getElementById('tr_sub').style.visibility='hidden'</script>";
		echo "<script>document.getElementById('tr_sub').style.position='absolute'</script>";
	}
}

if ($_POST['subitem']) {
	require_once('../../classe/sub_item.php');
	$sub_item = new sub_item();
	$processo = new processo();
	
	$processo -> alterar_subitem($_POST['subitem'],$_POST['id_ouvidoria']);
	
	$lista_sub = $sub_item -> subitens($_POST['assunto']);
	
	if (mysql_num_rows($lista_sub) > 0) {
		echo "<script>document.getElementById('tr_sub').style.visibility='visible'</script>";
		echo "<script>document.getElementById('tr_sub').style.position='relative'</script>";
		echo "<select name='subitem' id='subitem'>";
		echo "<option value=''>Nenhum</option>";
		while ($l = mysql_fetch_array($lista_sub)) {
			$sel = ($l['id_subitem'] == $_POST['subitem']) ? "selected='selected'" : '';
			echo "<option value=".$l['id_subitem']." ".$sel.">".$l['subitem']."</option>";
		}
		echo "</select>";
	}
	else {
		echo "<script>document.getElementById('tr_sub').style.visibility='hidden'</script>";
		echo "<script>document.getElementById('tr_sub').style.position='absolute'</script>";
	}
}

if (isset($_POST['id'])) {
	//criar objeto da classe resposta_padrao
	require_once('../../classe/resposta_padrao.php');
	$resposta_padrao = new resposta_padrao();
	$res = $resposta_padrao -> detalhes($_POST['id']);
	echo utf8_encode(mysql_result($res,0,'observacao'));
}
?>