<link href="../faetec/ouvidoria_1/phprptcss/project1.css" rel="stylesheet" type="text/css">
<script src="../faetec/ouvidoria_1/FusionChartsFree/JSClass/FusionCharts.js"></script>
<link href="../faetec/ouvidoria_1/FusionChartsFree/Contents/Style.css" rel="stylesheet" type="text/css">
<?php
error_reporting(0);

/*include "../faetec/ouvidoria_1/phprptinc/ewrcfg2.php"; 
include "../faetec/ouvidoria_1/phprptinc/ewmysql.php"; 
include "../faetec/ouvidoria_1/phprptinc/ewrsecu2.php"; 
include "../faetec/ouvidoria_1/phprptinc/ewrfn2.php"; 


include ('../faetec/ouvidoria_1/ouvidoria_resrpt.php');
include ('../faetec/ouvidoria_2/ouvidoria_res2rpt.php');
include ('../faetec/ouvidoria_3/ouvidoria_res_3rpt.php');*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Ouvidoria - FAETEC</title>
		<link rel="stylesheet" type="text/css" href="../../css/style_rel.css" />
		<link rel="stylesheet" type="text/css" href="../../css/datePicker.css" />
		<script src="../../js/jquery.js" type="text/javascript"></script>
		<script type="text/javascript" src="../../js/jquery.datePicker.js"></script>
		<script type="text/javascript" src="../../js/date.js"></script>
		<script type="text/javascript" src="../../js/jquery.maskedinput.js"></script>
		<script type="text/javascript">
			$().ready(function() {
				$('#data_inicial').datePicker({startDate:'01/01/2000'});
				$('#data_final').datePicker({startDate:'01/01/2000'});

				$("#data_inicial").mask("99/99/9999");
				$("#data_final").mask("99/99/9999");
			});
		</script>
	</head>
	<body>
		<p>Relat&oacute;rio Geral</p>
		<form action="../../controle/pmdc/rel_ouvidoria.php" method="post" name="form" target='_blank'>
			<table>
				<tr>
					<td><span>Data inicial:</span> </td>
					<td><input type='text' name='data_inicial' id='data_inicial' value='' size="11" maxlength="10"></td>
				</tr>
				<tr>
					<td><span>Data final:</span> </td>
					<td><input type='text' name='data_final' id='data_final' value='' size="11" maxlength="10"></td>
				</tr>
				<tr>
					<td>
						<input type="button" value="Gerar" id="gerar" onClick="document.form.submit();">
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>
<?php  ?>