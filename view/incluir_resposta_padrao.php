<?php 
require_once('../../controle/resposta_padrao.php');
controle_resposta_padrao('incluir');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../../css/style_forms.css" />
<script src="../../js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
	
$("#form").validate({
		rules: {
			resposta: "required",
			obs: "required"
		},
		messages: {
			resposta: "Preencha o Título da Resposta Padrão",
			obs: "Preencha a Resposta"

		}
	});

});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ouvidoria PMDC</title>
</head>

<body>
<p>Cadastro de Respostas</p>
<form name="form" method="post" id="form">
<table border=0><tr>
	<td><span>Título da Resposta Padrão:</span><span class="asterisco">*</span></td>
	<td><input type='text' name="resposta" id="resposta"></td>
	</tr><tr>
	<td valign="top"><span>Resposta:</span><span class="asterisco">*</span></td>
	<td><textarea name="obs" id="obs" cols="50" rows="6"></textarea></td>
</tr>
</table>
	<input name="incluir" type="hidden" value="1" />
	<input name="enviar" type="submit" id="enviar" value="Enviar">
	<input name="limpar" type="reset" id="limpar" value="Limpar">
</form>
</body>
</html>