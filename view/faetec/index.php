<?php
require_once('../../controle/verificacao.php');
ini_set('default_charset', 'latin1');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>OUVIDORIA - FAETEC</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="stylesheet" type="text/css" href="../../css/faetec/style_index.css" />
        <link rel="stylesheet" type="text/css" href="../../css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../../css/faetec/style_historico.css"/>
        <link rel="stylesheet" type="text/css" href="../../css/style_rel.css" />
        <link rel="stylesheet" type="text/css" href="../../css/datePicker.css" />
		<script type="text/javascript" src="../../js/jquery-1.6.1.min.js"></script>
        <script type="text/javascript" src="../../js/jquery.nivo.slider.js"></script>
        <!--<script type="text/javascript" src="js/jquery-1.7.1.js"></script>-->
        <script src="../../js/superfish.js" type="text/javascript"></script>
	    <script src='../../js/cufon-yui.js' type='text/javascript'></script>
        <script type="text/javascript" src="../../js/jquery.datePicker.js"></script>
        <script type="text/javascript" src="../../js/date.js"></script>
        <script src="../../js/jquery.maskedinput.js" type="text/javascript"></script>
        <script type="text/javascript" src="../../js/jquery.tablesorter.js"></script>
        <script type="text/javascript">
		jQuery(function(){
			// main navigation init
			jQuery('ul.sf-menu').superfish({
				delay:       1000, 	 // one second delay on mouseout 
				animation:   {opacity:'false',height:'show'}, // fade-in and slide-down animation 
				speed:       'slow', // faster animation speed 
				autoArrows:  false,  // generation of arrow mark-up (for submenu) 
				dropShadows: false,  // drop shadows (for submenu)
				onHide		: function(){Cufon.refresh('.sf-menu > li > a')}
			}).children('li').each(function(i){jQuery(this).addClass("top_item_"+(i+=1));});
			});
		</script>
        
		<script>
        function pesquisa() {
        if (document.getElementById('tipo').value != '' && document.getElementById('busca').value != '') {
            document.getElementById('pesquisar').value=1;
            limpar_filtro();
            document.form.submit();
        }
        else {
            alert('preencha os parâmetros da pesquisa');
        }
        }
        
        function limpar_pesquisa() {
        document.getElementById('tipo').value='';
        document.getElementById('busca').value='';
        }
        
        function limpar_filtro() {
        document.getElementById('entidade').value='';
        }
        </script>
       

        
        
        <script type="text/javascript">
        $().ready(function(){ 
        $("#tabela").tablesorter({
        headers: { 
            // colunas que no tem sort
            0: { 
                //protocolo 
                sorter: false 
            }, 
            // assign the third column (we start counting zero) 
            7: { 
                //Visualizar 
                sorter: false 
            } 
        } 
        });
        
        $('#data_inicial').datePicker({startDate:'01/01/2000'});
        $('#data_final').datePicker({startDate:'01/01/2000'});
        
        
        $("#data_inicial").mask("99/99/9999");
        $("#data_final").mask("99/99/9999");
        
        }); 
        </script>
	 
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