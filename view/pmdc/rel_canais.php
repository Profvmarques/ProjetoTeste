<?php
require_once('../../controle/pmdc/relatorios.php');
controle_relatorios('canais');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Ouvidoria - FAETEC</title>
		<link rel="stylesheet" type="text/css" href="../../css/style_rel.css" />
		<link rel="stylesheet" type="text/css" href="../../css/datePicker.css" />
		<script src="../../js/jquery.js" type="text/javascript"></script>
		<script src="../../js/jquery.validate.js" type="text/javascript"></script>
		<script src="../../js/jquery.maskedinput.js" type="text/javascript"></script>
		<script type="text/javascript" src="../../js/jquery.datePicker.js"></script>
		<script type="text/javascript" src="../../js/date.js"></script>
		<script type="text/javascript">
			$().ready(function() {
				$('#data_inicial').datePicker({startDate:'01/01/2000'});
				$("#data_inicial").mask("99/99/9999");
				$("#data_inicial").val('01/08/2009');
				
				$('#data_final').datePicker({startDate:'01/01/2000'});
				$("#data_final").mask("99/99/9999");
				$("#data_final").val('<?php echo date('d/m/Y'); ?>');
			});
		</script>
	</head>
	<body>
		<p>Quantitativo por Canais</p>
		<form action="../../controle/pmdc/rel_canais_pdf.php" method="post" name="form" id='form'>
			<table>
				<tr>
					<td><span>Data inicial:</span> </td>
					<td>
						<input type='text' name='data_inicial' id='data_inicial' value='' 
						size="11" maxlength="10">
					</td>
				</tr>
				<tr>
					<td><span>Data final:</span> </td>
					<td>
						<input type='text' name='data_final' id='data_final' value='' 
						size="11" maxlength="10">
					</td>
				</tr>
				<tr>
					<td>
						<input type="button" value="Gerar" id="gerar" onclick="document.form.submit();">
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>