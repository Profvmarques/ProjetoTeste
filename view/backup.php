<?php 
require_once('../../controle/backup.php');
controle_backup('criar');
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
			ano: "required",
			semestre: "required"
		},
		messages: {
			ano: " Preencha o campo ano",
			semestre: " Preencha o campo semestre"
		}
	});
});
</script>
</head>
<body>
<p>Backup</p>
<form name="form" method="post" id="form">
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
		<tr>
			<td width="15%"><span>Ano:</span><span class="asterisco">*</span></td>
			<td>
				<select name='ano' id='ano'>
					<option value=''>Selecione</option>
					<?php while ($la = mysql_fetch_array($lista_anos)) { ?>
					<option value='<?php echo $la['ano']; ?>'><?php echo $la['ano']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="15%"><span>Semestre:</span><span class="asterisco">*</span></td>
			<td>
				<select name='semestre' id='semestre'>
					<option value=''>Selecione</option>
					<option value='01'>1</option>
					<option value='02'>2</option>
				</select>
			</td>
		</tr>
		
	</table>
	</br>
	<input name="enviar" type="submit" id="enviar" value="Enviar">
	<input name="limpar" type="reset" id="limpar" value="Limpar">
</form>
</body>
</html>
<script>