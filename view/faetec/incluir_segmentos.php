<?php 
require_once('controles/segmentos.php');
controle_segmentos('incluir');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src='funcoes/funcoes.js'></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ouvidoria - FAETEC</title>
</head>

<body>
<form name="form" method="POST">
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
		<tr>
			<td><label style="font-weight:bold; color:#666666">Nome:*</label></td>
			<td><input name="nome" type="text" id="nome" size="45" title="Preencha o campo Nome"></td>
		</tr>
		<tr>
			<td><input name="incluir" type="hidden" value="1" /></td>
			<td><input name="enviar" type="button" id="enviar" value="Enviar" onClick="validar(document.form);">
			<input name="limpar" type="reset" id="limpar" value="Limpar"></td>
		</tr>
	</table>
</form>
</body>
</html>