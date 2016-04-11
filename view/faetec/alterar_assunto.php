<?php 
require_once('../../controle/faetec/assunto.php');
controle_assunto('editar');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src='funcoes/funcoes.js'></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ouvidoria - FAETEC</title>
<link rel="stylesheet" type="text/css" href="../../css/style_forms.css" />
<script src="../../js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
	$("#form").validate({
		rules: {
			assunto: "required",
		},
		messages: {
			assunto: " Preencha o campo Assunto",
		}
	});
});
</script>
</head>

<body>
<p>Cadastro de Assunto</p>
<form name="form" method="POST">
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
		<tr>
			<td width="15%"><label style="font-weight:bold; color:#666666">Assunto:</label></td>
			<td>
				<select name='id_assunto' id='id_assunto' onchange="document.getElementById('editar').value='';submit()">
					<option value=''>Selecione</option>
					<?php while ($a = mysql_fetch_array($lista_assunto)) { ?>
					<option value='<?php echo $a['id_assunto']; ?>'><?php echo $a['assunto']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<?php 
		//assunto escolhido
		if ($_POST['id_assunto'] != '') { ?>
		<tr>
			<td><label style="font-weight:bold; color:#666666">Nome:*</label></td>
			<td><input name="assunto" type="text" id="assunto" size="45" title="Preencha o campo Assunto" value='<?php echo $det['assunto']; ?>'></td>
		</tr>
		<tr>
			<td width="15%"><span>Ativo:</span><span class="asterisco">*</span></td>
			<td>
				<select name='ativo' id='ativo'>
					<option value='1'>Sim</option>
					<option value='0'>N&atilde;o</option>
				</select>
			</tr>
		</tr>
		<tr>
			<td></td>
			<td><input name="enviar" type="submit" id="enviar" value="Enviar">
			<input name="limpar" type="reset" id="limpar" value="Limpar"></td>
		</tr>
		<?php 
		}
		?>
		<input name="editar" id="editar" type="hidden" value="1" />
	</table>
</form>
</body>
</html>
<?php if ($_POST['id_assunto'] != '') { ?>
	<script>document.getElementById('id_assunto').value='<?php echo $_POST['id_assunto']; ?>';</script>
	<script>document.getElementById('ativo').value='<?php echo $det['ativo']; ?>';</script>
<?php } ?>