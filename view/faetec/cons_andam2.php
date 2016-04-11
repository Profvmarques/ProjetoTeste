<?php
require_once('../../controle/faetec/processos.php');
controle_processos('historico_publico');
ini_set('default_charset', 'latin1');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>OUVIDORIA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        
        <link rel="stylesheet" type="text/css" href="../../css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../../css/faetec/style_historico.css"/>
        <link rel="stylesheet" type="text/css" href="../../css/style_rel.css" />
        <link rel="stylesheet" type="text/css" href="../../css/datePicker.css" />
        <link rel="stylesheet" type="text/css" href="../../css/css-index.css" />
		<script type="text/javascript" src="../../js/jquery-1.6.1.min.js"></script>
        <script type="text/javascript" src="../../js/jquery.nivo.slider.js"></script>
        <!--<script type="text/javascript" src="js/jquery-1.7.1.js"></script>-->
        <script src="../../js/superfish.js" type="text/javascript"></script>
	    <script src='../../js/cufon-yui.js' type='text/javascript'></script>
       
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
		
       
      
<script src="../../js/jquery.validate.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../../css/style_forms.css" />
<script type="text/javascript" src="../../js/jquery.tablesorter.js"></script>
<script>
$().ready(function() {
	$("#form").validate({
		rules: {
			n_prot: "required"
		},
		messages: {
			n_prot: "Preencha o campo protocolo"
		}
	});
});

function remover() {
	var str = document.getElementById('resumo').value;
	var limite = 500;
	if (str.length > limite) {
		while (str.length > limite) {
			var newStr = str.substring(0, str.length-1);
			document.getElementById('resumo').value = newStr;
			str = document.getElementById('resumo').value;
		}
	}
	document.getElementById('tamanho').innerHTML = limite - str.length;
}
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
                                <li><a href="../login.php">Acesso Restrito &agrave; ouvidoria</a></li>
                                <!--<li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/faetec/cons_andam2.php">Consulte a sua manifestação</a></li>
                                <li><a href="../login.php">Acesso Restrito &agrave; ouvidoria</a></li>-->
                                <!--<li><a href="#">Como entrar com um recurso</a></li>-->
                            </ul>
                        </li>
                        <li><a href="http://transparencia.duquedecaxias.rj.gov.br/portal/" target="_blank">Portal da Transpar&ecirc;ncia</a></li>
                         <li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/lei_acesso_informacao.php">Lei de Acesso</a></li>
                         <li><a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/servicos.php">Serviços</a></li>
                          <!--<li><a href="http://www.duquedecaxias.rj.gov.br/portal/index.php?option=com_content&view=article&id=40&Itemid=175" target="_blank">Serviços</a></li>-->
                        <li><a href="http://www.duquedecaxias.rj.gov.br/portal/index.php?option=com_content&view=article&id=816&Itemid=427" target="_blank">Perfil do Ouvidor</a></li>
                    </ul>
                </div>
				<div id="pagina">

                
                
                <div class="formulario">
                	
  <p>Consulta de Andamento</p>
  <form id="form" name="form" method="post" action="">
    <span class="texto">N&uacute;mero do Protocolo:
      <input name="n_prot" type="text" id="n_prot" size="30" />
    </span>
    <p>
      <label>
      <input type="submit" class="btn btn-success" name="Consultar" id="Consultar" value="Consultar" />
    </label></p>
      <a href="http://www.duquedecaxias.rj.gov.br/portal/ouvidoria/view/index.php" class="btn btn-success">Voltar ao portal da Ouvidoria</a>
   <br />
  </div>
  <?php 
  if ($_POST['n_prot'] != ''){
	if (mysql_num_rows($res) > 0) {
	  if (in_array(mysql_result($res2,0,'id_status'),array(3,4))) { ?>
		<label style="font-weight:bold; color:#666666">Novo Coment&aacute;rio:*</label>
		<br>
		<textarea name="resumo" cols="45" rows="6"  id="resumo" title="Preencha o campo Comentario" onkeyup='remover()'></textarea>
		<span id='tamanho' style="font-family:Arial; font-size:12px; color:#666666; font-weight:bold;">500</span><span style="font-family:Arial; font-size:12px; color:#666666; font-weight:bold;"> caractere(s)</span>
		<br>
		<input name="enviar" type="submit" id="enviar" value="Enviar">
		<input name="id_ouvidoria" type="hidden" id="id_ouvidoria" value="<?php echo mysql_result($res2,0,'id_ouvidoria'); ?>">
		<input name="novo_status" type="hidden" id="novo_status" value="<?php echo mysql_result($res2,0,'id_status'); ?>">
		<input name="cidadao" type="hidden" id="cidadao" value="1">
		<input name="publico" type="hidden" id="publico" value="1">
		<br>
	<?php } ?>
  <p>Hist&oacute;rico</p>
 
<table width="75" border="0" class="tablesorter" id="historico">
<thead>
<tr>
<th width="29%">Data e hora</th>
<th width="27%">Status</th>
<th width="44%">Resumo</th>
</tr>
</thead>
<tbody>
<?php
while ($l=mysql_fetch_array($res)) {
	if ($l['publico'] == 1) {
		$cor='#000000';
  
		if ($l['status']=='Atendida')
		$cor='#1d6302';

		if ($l['status']=='Encaminhada')
		$cor='#d08a03';

		if ($l['status']=='Pendente')
		$cor='#a30d02';

		if ($l['status']=='Reiterada')
		$cor='#FF0066';
	
		echo "<tr style='color:$cor;font-weight:bold'>
		    <td>".$l['hdata']."</td>
		    <td>".$l['status']."</td>
		    <td>".nl2br($l['resumo'])."</td>
		    </tr>";
	} 
}


?>
</tbody>
</table>
</form>
<?php
}
else {
	echo "<span style='color:#a30d02'>Processo N&atilde;o encontrado</span>";
}
}
?>
    
                </div>
                
                <div class="content_right">
            
                    <!--<div class="login">
                    <form method='post' action='../controle/login.php'>
                        <fieldset>
                          <p><b>Acesso Restrito</b><br />Servi&ccedil;o de informa&ccedil;&atilde;o ao Mun&iacute;cipe (SIM)</p>
                          <span>Preencha o Nome do Usu&aacute;rio e senha para acessar o Sistema de informa&ccedil;&otilde;tes.</span>	
                          <div class="form-group">
                          	  <label class="campof">Usu&aacute;rio: </label>
                              <input class="form-control input-xlarge" id="login" placeholder="Login" name="login" type="text" autofocus>
                          </div>
                          <div class="form-group">
                          	  <label class="campof">Senha: </label>
                              <input class="form-control input-xlarge" id="senha" placeholder="Senha" name="senha" type="password" value="">
                          </div>
                        
                          <button type="submit" class="btn btn-lg btn-success btn-block" id="btnLogin">Login</button>
                        </fieldset>
                    </form>
                    </div>-->
                    
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
    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- SB Admin Scripts - Include with every page -->

</div>
			</div>
			<div id="footer"></div>
		</div>
	</body>
</html>