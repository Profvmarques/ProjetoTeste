<?php 
require_once('../../controle/entidades.php');
controle_entidades('incluir');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ouvidoria - FAETEC</title>
<link rel="stylesheet" type="text/css" href="../../css/style_forms.css" />
<script src="../../js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
$("#form").validate({
		rules: {
			nome: "required",
		},
		messages: {
			nome: "Preencha o campo Nome",
		}
	});
});
</script>
</head>

<body>
<p>Cadastro de Entidades</p>
<form name="form" method="post" id="form">
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
		<tr>
			<td width="15%"><span>Nome:</span><span class="asterisco">*</span></td>
			<td><input name="nome" type="text" id="nome"></td>
		</tr>
		<tr>
			<td valign="top"><span>Descri��o:</span></td>
			<td><textarea name='descricao' id='descricao' cols="24" rows="5"></textarea></td>
		</tr></table></br>
	
			<input name="incluir" type="hidden" value="1" />
			<input name="enviar" type="submit" id="enviar" value="Enviar">
			<input name="limpar" type="reset" id="limpar" value="Limpar">
		
	
</form>
</body>
</html>