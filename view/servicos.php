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
        <style type="text/css">
        #apDiv1 {
	position: absolute;
	width: 200px;
	height: 115px;
	z-index: 1;
}
        #apDiv2 {
	position: absolute;
	width: 200px;
	height: 115px;
	z-index: 1;
}
        #apDiv3 {
	position: absolute;
	left: 328px;
	top: 498px;
	width: 203px;
	height: 24px;
	z-index: 1;
}
        </style>
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
                                
                                <li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/faetec/cons_andam2.php">Consulte a sua manifesta��o</a></li>
                                 <li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/relatorio_estatistico.php">Relat�rios estat�sticos</a></li>
                                <li><a href="login.php">Acesso Restrito &agrave; ouvidoria</a></li>
                                <!--<li><a href="#">Como entrar com um recurso</a></li>-->
                            </ul>
                        </li>
                        <li><a href="http://transparencia.duquedecaxias.rj.gov.br/portal/" target="_blank">Portal da Transpar&ecirc;ncia</a></li>
                        <li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/lei_acesso_informacao.php">Lei de Acesso</a></li>
                      <li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/servicos.php" >Servi�os</a></li>
                        <li><a href="http://www.duquedecaxias.rj.gov.br/portal/index.php?option=com_content&view=article&id=816&Itemid=427" target="_blank">Perfil do Ouvidor</a></li>
                    </ul>
                </div>
				<div id="pagina">

                
                
                <div class="formulario">
               	  <div class="media">
                  		<a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/index.php" class="btn btn-success">Voltar ao portal da Ouvidoria</a>
                        
                        <div style=" background-color:#e7eff4; width:498px; border:2px solid #a4bac6; padding:10px; margin:23px auto; ">
	                        <h3 style=" background-color:#13344e; border: 1px solid #a4bac6; font-weight:bold; color: #ffffff; font-size: 13px; line-height: 37px; margin: 0; min-height: 37px; padding: 0 11px; text-transform: uppercase;  white-space: nowrap;"> SERVI�OS PARA O CIDAD�O </h3>
                        <img width="475" height="395" border="0" style="border:1px solid #acc7d8; margin-top:12px; display: block; margin-left: auto; margin-right: auto;" usemap="#Map" alt="" src="../imagens/icones.jpg">
                        <map id="Map" name="Map">
                        <area target="new" href="http://www.duquedecaxias.rj.gov.br/portal/index.php?option=com_content&view=article&id=1848&Itemid=497" shape="rect" coords="10,11,229,37">
                        <area target="new" href="http://www.duquedecaxias.rj.gov.br/portal/index.php?option=com_content&view=article&id=2235:coleta-de-lixo&catid=40:noticias-da-servicos-publicos&Itemid=265" shape="rect" coords="258,14,464,35">
                        <area target="new" href="http://webpmdc.duquedecaxias.rj.gov.br/ConsultaWeb/Paginas/ConsultaExternaProcesso/Pesquisar.aspx" shape="rect" coords="11,64,227,85">
                        <area target="new" href="http://webpmdc.duquedecaxias.rj.gov.br:8087/webrun/form.jsp?sys=WBS&action=openform&formID=8730&align=0&mode=-1&goto=-1&filter=&scrolling=no" shape="rect" coords="260,65,461,84">
                        <area target="new" href="http://ipmdc.com.br/contracheque.html" shape="rect" coords="18,116,227,132">
                        <area target="new" href="http://www.duquedecaxias.rj.gov.br/portal/index.php?option=com_content&amp;view=article&amp;id=2235:coleta-de-lixo&amp;catid=40:noticias-da-servicos-publicos&amp;Itemid=265" shape="rect" coords="260,110,465,134">
                        <area target="new" href="https://spe.duquedecaxias.rj.gov.br/iptu/informacoes.aspx" shape="rect" coords="16,212,228,234">
                        <area target="new" href="https://spe.duquedecaxias.rj.gov.br/iss/informacoes.aspx" shape="rect" coords="257,214,471,235">
                        <area target="new" href="http://www.duquedecaxias.rj.gov.br/portal/index.php?option=com_content&amp;view=article&amp;id=1860&amp;Itemid=499" shape="rect" coords="15,265,225,288">
                        <area target="new" href="http://www.mcmv.duquedecaxias.rj.gov.br/" shape="rect" coords="256,265,467,286" >
                        <area target="new" href="https://spe.duquedecaxias.rj.gov.br/nfse/capa.aspx" shape="rect" coords="17,316,228,336">
                        <area target="new" href="http://www.duquedecaxias.rj.gov.br/portal/index.php?option=com_content&view=article&id=2236:fumace&catid=39:noticias-da-saude&Itemid=264" shape="rect" coords="16,164,225,185">
                        <area target="new" href="http://www.duquedecaxias.rj.gov.br/portal/index.php?option=com_content&amp;view=article&amp;id=2237:iluminacao&amp;catid=40:noticias-da-servicos-publicos&amp;Itemid=265" shape="rect" coords="257,161,468,186">
                        <area target="new" href="index.php?option=com_wrapper&view=wrapper&Itemid=509" shape="rect" coords="257,314,467,337">
                        <area target="new" href="http://www.duquedecaxias.rj.gov.br/portal/index.php?option=com_content&amp;view=article&amp;id=2238:unidades-de-saude&amp;catid=39:noticias-da-saude&amp;Itemid=264" shape="rect" coords="17,365,225,383">
                        <area shape="rect" coords="259,366,473,385" href="https://www.webmail.duquedecaxias.rj.gov.br/" target="new">
                        </map>
                        </div>
                    
                  </div>
          
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