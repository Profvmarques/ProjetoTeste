<?php
require_once('../faetec/controles/segmentos.php');
controle_segmentos('relatorio')
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src='../faetec/funcoes/funcoes.js'></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ouvidoria - FAETEC</title>
</head>

<body>
<form action="../faetec/controles/rel_segmentos_pdf.php" method="post" name="form">
<table>
	<tr>
		<td>Segmento: </td>
		<td>
			<select name="segmento" id="segmento" style='line-height:8px; width:550px; font-size:11px;'>
				<option value="">Todos os segmentos</option>
				<?php while ($s = mysql_fetch_array($lista)) { ?>
				<option value="<?php echo $s['id']; ?>"><?php echo $s['nome']; ?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Data inicial: </td>
		<td><input type='text' name='data_inicial' id='data_inicial' value='' 
		onkeypress="return mascaras_format(document.form,'data_inicial','99/99/9999',event);" size="11" maxlength="10"></td>
	</tr>
	<tr>
		<td>Data final: </td>
		<td><input type='text' name='data_final' id='data_final' value='' 
		onkeypress="return mascaras_format(document.form,'data_final','99/99/9999',event);" size="11" maxlength="10"></td>
	</tr>
	<tr>
		<td><input type="button" value="Gerar" id="gerar" onclick="document.form.submit();"></td>
	</tr>
</table>

</form>
<p>&nbsp;</p><hr width="100%" size="2" /><div align="center"><h4><strong><font color="#3366ff">DESENVOLVIDO PELA DIVIS&Atilde;O DE INFORM&Aacute;TICA - FAETEC</font></strong></h4></div><p>&nbsp;</p>
</body>
</html>