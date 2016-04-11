<?php
require_once('../../controle/backup/processo.php');
Processo('historico_publico');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../../js/jquery.js" type="text/javascript"></script>
<script src="../../js/jquery.validate.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../../css/style_forms.css" />
<link rel="stylesheet" type="text/css" href="../../css/backup/style_historico.css"/>
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
</script>
<title>Untitled Document</title>
</head>

<body>
<div id="site">
  <p>Consulta de Andamento</p>
  <h4>Atrav&eacute;s deste link o Cidad&atilde;o poder&aacute; acompanhar o andamento da manifesta&ccedil;&atilde;o 
  registrada na Ouvidoria Geral da Ci&ecirc;ncia e Tecnologia.</h4>
  <form id="form" name="form" method="post" action="">
    <span>N&uacute;mero do Protocolo:
      <input name="n_prot" type="text" id="n_prot" size="30" />
    </span>
    <p>
      <label>
      <input type="submit" name="Consultar" id="Consultar" value="Consultar" />
    </label></p>
  </form>
  </div>
  <?php 
  if ($_POST['n_prot']!=''){
	if (mysql_num_rows($res) > 0) {
  ?>
  <p>Hist&oacute;rico</p>
<table width="100%" border="0" class="tablesorter" id="historico">
<thead>
<tr>
<th>Data e hora</th>
<th>Status</th>
<th>Resumo</th>
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
		    <td>".nl2br(utf8_encode($l['resumo']))."</td>
		    </tr>";
	}
}
?>
</tbody>
</table>
<?php
}
else {
	echo "<span style='color:#a30d02'>Processo N&atilde;o encontrado</span>";
}
}
?>
</body>
</html>
<?php if ($_POST['n_prot'] != '') { ?>
	<script>document.getElementById('n_prot').value='<?php echo $_POST['n_prot']; ?>';</script>
<?php }?>