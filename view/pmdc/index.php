<?php
require_once('../../controle/verificacao.php');
ini_set('default_charset', 'latin1');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>OUVIDORIA - FAETEC</title>
		<link rel="stylesheet" type="text/css" href="../../css/pmdc/style_index.css" />
	</head>
	<body>
		<div id="corpo">
			<div id="header"></div>
			<div id="conteudo">
				<div id="menu"><?php include ('menu.php');?></div>
				<div id="pagina">
					<?php
					//nao mostrar manifestacoes na pagina inicial do sac
					if ($acesso['ler'] != 1 && $_GET['pg'] == 1) {
						$_GET['pg'] = '';
					}

					switch ($_GET['pg']){
						case 1:
							include ('visualizar_ouvidoria.php');
						break;
						case 2:
							include ('detalhes_ouvidoria.php');
						break;
						case 3:
							include ('../../controle/sair.php');
						break;
						case 4:
							include ('ouvidoria_geral.php');
						break;
						case 5:
							include ('rel_entidade.php');
						break;
						case 6:
							include ('../usuario.php');
						break;
						case 7:
							include ('../incluir_entidade.php');
						break;
						case 8:
							include ('../incluir_resposta_padrao.php');
						break;
						case 9:
							include ('form_ouvidoria_faetec.php');
						break;
						case 10:
							include ('../altera_usuario.php');
						break;
						case 11:
							include ('../editar_entidade.php');
						break;
						case 12:
							include ('../editar_resposta_padrao.php');
						break;
						case 13:
							include ('cons_andam.php');
						break;
						case 14:
							include ('rel_entidade_comp.php');
						break;
						case 15:
							include ('visualizar_ouvidoria_inativos.php');
						break;
						case 16:
							include ('detalhes_inativos.php');
						break;
						case 17:
							include ('form_denuncia_faetec.php');
						break;
						case 18:
							include ('visualizar_denuncias_inativas.php');
						break;
						case 19:
							include ('visualizar_denuncias.php');
						break;
						case 20:
							include ('detalhes_denuncia.php');
						break;
						case 21:
							include ('detalhes_denuncias_inativas.php');
						break;
						case 22:
							include ('../backup.php');
						break;
						case 23:
							include ('../escolher_backup.php');
						break;
						case 24:
							include ('rel_canais.php');
						break;
						case 25:
							include ('incluir_diretoria.php');
						break;
						case 26:
							include ('designar_diretoria.php');
						break;
						case 27:
							include ('alterar_diretoria.php');
						break;
						case 28:
							include ('relat_diretoria.php');
						break;
						case 29:
							include ('../chat/adm.php');
						break;
						case 30:
							include ('../chat/historico.php');
						break;
						case 31:
							include ('../chat/chat.php');
						break;
						case 32:
							include ('../chat/detalhes_historico.php');
						break;
						case 33:
							include ('processos_bloco.php');
						break;
						case 34:
							include ('rel_comparativos.php');
						break;
						case 35:
							include ('../incluir_subitem.php');
						break;
						case 36:
							include ('../editar_subitem.php');
						break;
						case 37:
							include ('visualizar_novos_comentarios.php');
						break;
						case 38:
							include ('incluir_assunto.php');
						break;
						case 39:
							include ('alterar_assunto.php');
						break;
					}
					?>
				</div>
			</div>
			<div id="footer"></div>
		</div>
	</body>
</html>