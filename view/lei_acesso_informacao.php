<?php
session_start();
$_SESSION = array();
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>OUVIDORIA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../css/faetec/style_historico.css"/>
        <link rel="stylesheet" type="text/css" href="../css/style_rel.css" />
        <link rel="stylesheet" type="text/css" href="../css/datePicker.css" />
        <link rel="stylesheet" type="text/css" href="../css/css-index.css" />
		<script type="text/javascript" src="../js/jquery-1.6.1.min.js"></script>
        <script type="text/javascript" src="../js/jquery.nivo.slider.js"></script>
        <!--<script type="text/javascript" src="js/jquery-1.7.1.js"></script>-->
        <script src="../js/superfish.js" type="text/javascript"></script>
	    <script src='../js/cufon-yui.js' type='text/javascript'></script>
       
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
        
	</head>
	<body>
		<div id="corpo">
			<div id="header"></div>
			<div id="conteudo">
				<div id="menu">
                    <ul id="nav" class="sf-menu">
                        <li><a href="#">Servi&ccedil;o de Informa&ccedil;&atilde;o ao Mun&iacute;cipe</a>
                            <ul>
                                
                                <li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/faetec/cons_andam2.php">Consulte a sua manifestação</a></li>
                                 <li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/relatorio_estatistico.php">Relatórios estatísticos</a></li>
                                <li><a href="login.php">Acesso Restrito &agrave; ouvidoria</a></li>
                                <!--<li><a href="#">Como entrar com um recurso</a></li>-->
                            </ul>
                        </li>
                        <li><a href="http://transparencia.duquedecaxias.rj.gov.br/portal/" target="_blank">Portal da Transpar&ecirc;ncia</a></li>
                        <li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/lei_acesso_informacao.php">Lei de Acesso</a></li>
       <li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/servicos.php" >Serviços</a></li>
                        <li><a href="http://www.duquedecaxias.rj.gov.br/portal/index.php?option=com_content&view=article&id=816&Itemid=427" target="_blank">Perfil do Ouvidor</a></li>
                    </ul>
                </div>
				<div id="pagina">

                
                
                <div class="formulario">
               	  <div class="media">
                  <a href="http://www.acessoainformacao.gov.br/assuntos/conheca-seu-direito/a-lei-de-acesso-a-informacao" target="_blank">
                    A LEI Nº 12.527/2011, CONHECIDA COMO LEI DE ACESSO À INFORMAÇÃO — LAI —, REGULAMENTA O DIREITO, PREVISTO NA CONSTITUIÇÃO, DE QUALQUER PESSOA SOLICITAR E RECEBER DOS ÓRGÃOS E ENTIDADES PÚBLICOS, DE TODOS OS ENTES E PODERES, INFORMAÇÕES PÚBLICAS POR ELES PRODUZIDAS OU CUSTODIADAS.</a>
                    
                    <br />
                    <br />
                    </div>
                    <a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/index.php" class="btn btn-success">Voltar ao portal da Ouvidoria</a>
                </div>
                
                <div class="content_right">
            
                    
                    
                 <div class="info">
                    
                   	<h2>Perguntas Frequentes</h2>
                      <ul>
                       	  <li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/lei_acesso_informacao.php"><p>O que &eacute; a Lei de Acesso &agrave; Informa&ccedil;&atilde;o?</p></a></li>
                          <li><a href="http://www.duquedecaxias.rj.gov.br/portal/index.php?option=com_content&view=article&id=1860&Itemid=499" target="_blank"><p>Perguntas e Respostas</p></a></li>
                      </ul>
                      
                    </div>
                    
                    <div class="info">
                    	<h2>Canais de Informa&ccedil;&atilde;o</h2>
                        <p>Formul&aacute;rio de Contato online</p>
                        <p>Telefone de Contato: (21) 2773-6337</p>
                        <p>E-mail: ouvidoria@duquedecaxias.rj.gov.br</p>
                        <p>&nbsp;</p>
                        <p>Atendimento presencial: </p>
                        <p>Alameda Dona Esmeralda, 206 </p>
                        <p>Jd. Primavera - Duque de Caxias / RJ</p>
                        <p>Cep: 25215-260</p>
                        <p>Hor&aacute;rio: 9h &agrave;s 17h, de segunda &agrave; sexta.</p>
                    </div>
                    
                </div>
                
                
            
            
    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- SB Admin Scripts - Include with every page -->

</div>
			</div>
			<div id="footer"></div>
		</div>
	</body>
</html>