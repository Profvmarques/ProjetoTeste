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
		
        
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
  
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../css/pmdc/style_historico.css"/>
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
                                
                                <li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/pmdc/cons_andam2.php">Consulte a sua manifestação</a></li>
                                 <li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/relatorio_estatistico.php">Relatórios estatísticos</a></li>
                                <li><a href="login.php">Acesso Restrito &agrave; ouvidoria</a></li>
                                <!--<li><a href="#">Como entrar com um recurso</a></li>-->
                            </ul>
                        </li>
                        <li><a href="http://transparencia.duquedecaxias.rj.gov.br/portal/" target="_blank">Portal da Transpar&ecirc;ncia</a></li>
                        <li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/lei_acesso_informacao.php">Lei de Acesso</a></li>
                          <li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/servicos.php">Serviços</a></li>
                        <li><a href="http://www.duquedecaxias.rj.gov.br/portal/index.php?option=com_content&view=article&id=816&Itemid=427" target="_blank">Perfil do Ouvidor</a></li>
                    </ul>
                </div>
				<div id="pagina">

                
                
                <div class="formulario">
               	  <div class="media">
                            <a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/index.php" class="btn btn-success">Voltar ao portal da Ouvidoria</a>
                  <br />
                  <br />
                  
                  <div class="panel-group" id="accordion" style="margin-right: 20px !important;">
                    <div class="panel panel-default" style="background-color: #5bc0de !important; border-color: #46b8da !important; color: #fff !important;">
                        <div class="panel-heading" style="background-color: #5bc0de !important; border-color: #46b8da !important; color: #fff !important;">
                            <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">RELATÓRIO ESTATÍSTICO DE JANEIRO A FEVEREIRO DE 2016</a>
                            </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse" style="background-color: #fff !important; color: #000 !important;">
                            <div class="panel-body"> Vimos pelo presente apresentar as demandas encaminhadas &agrave; Ouvidoria Geral do Munic&iacute;pio de Duque de Caxias, nos meses de janeiro e fevereiro de 2016. Ao todo, foram registradas <strong>2.944</strong> manifesta&ccedil;&otilde;es, que apresentam-se abaixo em ordem decrescente.<br /><br />

                            <img src="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/imagens/demanda2016.jpg" width="500" height="391" /><br />
                            <br />
                            <img src="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/imagens/demanda_grafico2016.jpg" width="582" height="644" /><br />
                        	</div>
                        </div>
                    </div>
                    
                    <div class="panel panel-default" style="background-color: #5bc0de !important; border-color: #46b8da !important; color: #fff !important;">
                        <div class="panel-heading" style="background-color: #5bc0de !important; border-color: #46b8da !important; color: #fff !important;">
                            <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">RELATÓRIO ESTATÍSTICO DE JANEIRO A ABRIL DE 2015</a>
                            </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse" style="background-color: #fff !important; color: #000 !important;">
                            <div class="panel-body"><br>
                            Gráfico 1 – Visando facilitar o diálogo com o cidadão, disponibilizamos seis canais de comunicação, que, entre janeiro e abril de 2015, receberam 805 demandas descritas da seguinte forma: 616 por telefone (76%); 65 das mídias sociais (8%); 63 via e-mail (8%); 38 no ônibus itinerante / Fundec (5%); 16 na sede da Ouvidoria (2%); e 7 de participação em eventos (1%).
                            
                            <br />                    
                            <br />
                            <img src="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/imagens/grafico_01.jpg" width="500" height="248" /><br /><br />
                            Gráfico 2 – Neste gráfico, apresentamos as demandas por Secretaria, totalizando 805 manifestações. Destacando as secretarias de Serviço Público (44%), de Obras (16%), de Saúde (15%) e de Trabalho e Renda (9%).
                            <br />                    
                            <br />
                            <img src="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/imagens/grafico_02.jpg" width="500" height="391" /><br /><br />
                            
                            Gráfico 3 - Referente a 805 demandas recebidas, sendo 60% resolvidas. Com relação aos 40% de demandas não atendidas, classificamos como: irrazoáveis, indeferidas, pendentes de projetos, pendentes de recursos financeiros e processos administrativos em andamento.
                            <br />                    
                            <br />
                            <img src="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/imagens/grafico_03.jpg" width="500" height="263" /><br />
                            </div>
                        </div>
                    </div>
                    
                    <div class="panel panel-default" style="background-color: #5bc0de !important; border-color: #46b8da !important; color: #fff !important;">
                        <div class="panel-heading" style="background-color: #5bc0de !important; border-color: #46b8da !important; color: #fff !important;">
                            <h4 class="panel-title ">
                            <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapse3">RELATÓRIO ESTATÍSTICO DE JANEIRO A ABRIL DE 2014</a>
                            </h4>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse" style="background-color: #fff !important; color: #000 !important;">
                            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                            </div>
                        </div>
                    </div>
 				  </div> 

               <!--<strong><center>RELATÓRIO ESTATÍSTICO DE JANEIRO A FEVEREIRO DE 2016</center>
               </strong>
               <p><strong>               </strong></p>
                  
                 Vimos pelo presente apresentar as demandas encaminhadas &agrave; Ouvidoria Geral do Munic&iacute;pio de Duque de Caxias, nos meses de janeiro e fevereiro de 2016. Ao todo, foram registradas <strong>2.944</strong> manifesta&ccedil;&otilde;es, que apresentam-se abaixo em ordem decrescente.<br />
                 <img src="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/imagens/demanda2016.jpg" width="500" height="391" /><br />
                 <br />
                 <img src="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/imagens/demanda_grafico2016.jpg" width="582" height="644" /><br />
               </p>
                 <br />                    
                 <br />
                 <br /><br />
               <strong><center>RELATÓRIO ESTATÍSTICO DE JANEIRO A ABRIL DE 2015</center>
               </strong>
               <p><strong>               </strong><br /></p> 
  <br /> 
                 
                 Gráfico 1 – Visando facilitar o diálogo com o cidadão, disponibilizamos seis canais de comunicação, que, entre janeiro e abril de 2015, receberam 805 demandas descritas da seguinte forma: 616 por telefone (76%); 65 das mídias sociais (8%); 63 via e-mail (8%); 38 no ônibus itinerante / Fundec (5%); 16 na sede da Ouvidoria (2%); e 7 de participação em eventos (1%).
                 
                 <br />                    
                 <br />
                 <img src="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/imagens/grafico_01.jpg" width="500" height="248" /><br /><br />
                 Gráfico 2 – Neste gráfico, apresentamos as demandas por Secretaria, totalizando 805 manifestações. Destacando as secretarias de Serviço Público (44%), de Obras (16%), de Saúde (15%) e de Trabalho e Renda (9%).
                 <br />                    
                 <br />
                 <img src="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/imagens/grafico_02.jpg" width="500" height="391" /><br /><br />
                 
                 Gráfico 3 - Referente a 805 demandas recebidas, sendo 60% resolvidas. Com relação aos 40% de demandas não atendidas, classificamos como: irrazoáveis, indeferidas, pendentes de projetos, pendentes de recursos financeiros e processos administrativos em andamento.
                 <br />                    
                 <br />
                 <img src="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/imagens/grafico_03.jpg" width="500" height="263" /><br />
               </p>
               <p><br />
               </p>-->
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