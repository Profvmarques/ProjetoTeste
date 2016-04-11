<?php
require_once('../../controle/faetec/processos.php');
controle_processos('historico_publico');
ini_set('default_charset', 'latin1');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../../js/jquery.validate.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../../css/style_forms.css" />
<link rel="stylesheet" type="text/css" href="../../css/faetec/style_historico.css"/>
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
<title>Untitled Document</title>
</head>

<body>
<div id="site">
  <p>Consulta de Andamento</p>
  <form id="form" name="form" method="post" action="">
    <span class="texto">N&uacute;mero do Protocolo:
      <input name="n_prot" type="text" id="n_prot" size="30" />
    </span>
    <p>
      <label>
      <input type="submit" name="Consultar" id="Consultar" value="Consultar" />
    </label></p>
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
</body>
</html>
<?php if ($_POST['n_prot'] != '') { ?>
	<script>document.getElementById('n_prot').value='<?php echo $_POST['n_prot']; ?>';</script>
<?php }?>