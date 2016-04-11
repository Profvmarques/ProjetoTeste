<?php
require_once('../../controle/backup/relatorios.php');
controle_relatorios('entidades');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BACKUP</title>
<link rel="stylesheet" type="text/css" href="../../css/style_rel.css" />
<link rel="stylesheet" type="text/css" href="../../css/backup/datePicker.css" />
<script src="../../js/jquery.js" type="text/javascript"></script>
<script src="../../js/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery.maskedinput.js" type="text/javascript"></script>
<script type="text/javascript" src="../../js/jquery.datePicker.js"></script>
<script type="text/javascript" src="../../js/date.js"></script>
<script type="text/javascript">
$().ready(function() {
	
	$('#data_inicial').datePicker({startDate:'<?php echo $inicio; ?>',endDate:'<?php echo $fim; ?>'});
	$('#data_final').datePicker({startDate:'<?php echo $inicio; ?>',endDate:'<?php echo $fim; ?>'});


	$("#data_inicial").mask("99/99/9999");
	$("#data_final").mask("99/99/9999");

});
</script>
<style type='text/css'>
/* located in demo.css and creates a little calendar icon
 * instead of a text link for "Choose date"
 */
a.dp-choose-date {
	float: left;
	width: 16px;
	height: 16px;
	padding: 0;
	margin: 5px 3px 0;
	display: block;
	text-indent: -2000px;
	overflow: hidden;
	background: url(../../imagens/calendar.png) no-repeat; 
}
a.dp-choose-date.dp-disabled {
	background-position: 0 -20px;
	cursor: default;
}
/* makes the input field shorter once the date picker code
 * has run (to allow space for the calendar icon
 */
input.dp-applied {
	width: 140px;
	float: left;
}
</style>
</head>

<body>
<p>Relat&oacute;rio por Entidades</p>
<form action="../../controle/backup/rel_manifestacoes.php" method="post" name="form">
<table>
	<tr>
		<td><span>Entidade: </span></td>
		<td><select name="entidade" id="entidade" style='line-height:8px; width:550px; font-size:11px;'>
				<option value="">Todas as entidades</option>
				<?php while ($u = mysql_fetch_array($lista_entidades)) { ?>
				<option value="<?php echo $u['id_entidade']; ?>"><?php echo $u['entidade']; ?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td><span>Status:</span></td>
		<td><select name="status" id="status" style='line-height:8px; width:550px; font-size:11px;'>
				<option value="">Todos os status</option>
				<?php while ($s = mysql_fetch_array($lista_status)) { ?>
				<option value="<?php echo $s['id_status']; ?>"><?php echo $s['status']; ?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td><span>Tipo de usu&aacute;rio:</span></td>
		<td><select name="tipo_usuario" id="tipo_usuario" style='line-height:8px; width:550px; font-size:11px;'>
				<option value="">Todos os tipos</option>
				<?php while ($t = mysql_fetch_array($lista_tipos)) { ?>
				<option value="<?php echo $t['id_tipo_usuario']; ?>"><?php echo $t['descricao']; ?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td><span>Assunto</span></td>
		<td><select name='assunto' id='assunto' style='line-height:8px; width:550px; font-size:11px;'>
				<option value=''>Todos os assuntos</option>
				<?php while ($a = mysql_fetch_array($lista_assuntos)) { ?>
				<option value='<?php echo $a['id_assunto']; ?>'><?php echo $a['assunto']; ?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td><span>Data inicial: </span></td>
		<td><input type='text' name='data_inicial' id='data_inicial' value='' 
		size="11" maxlength="10"></td>
	</tr>
	<tr>
		<td><span>Data final: </span></td>
		<td><input type='text' name='data_final' id='data_final' value='' 
		size="11" maxlength="10"></td>
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
