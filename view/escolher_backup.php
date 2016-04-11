<?php
require_once('../../controle/backup.php');
controle_backup('escolher');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SECT</title>
<link rel="stylesheet" type="text/css" href="../../css/style_forms.css" />
<link rel="stylesheet" type="text/css" href="../../css/sect/datePicker.css" />
<script src="../../js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
$("#form").validate({
		rules: {
			periodo: "required"
		},
		messages: {
			periodo: "Escolha o Per�odo"
		}
	});
});
</script>
</head>

<body>
<p>Consultar Backup</p>
<form action="" method="post" name="form" id='form'>
	<table>
		<tr>
			<td><span>Per&iacute;odo:</span><span class="asterisco">*</span></td>
			<td>
				<select name='periodo' id='periodo' style='line-height:8px; width:550px; font-size:11px;' class='required'>
					<option value=''>Selecione</option>
					<?php foreach ($array_periodos as $a) { ?>
					<option value='<?php echo $a['periodo']; ?>'><?php echo $a['texto']; ?></option>
					<?php } ?>
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