<?php
require_once('../../controle/pmdc/diretoria.php');
controle_diretoria('designar');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src='../faetec/funcoes/funcoes.js'></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ouvidoria - FAPERJ</title>
<link rel="stylesheet" type="text/css" href="../../css/style_forms.css" />
<script src="../../js/jquery.js" type="text/javascript"></script>
<script src="../../js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
$("#form").validate({
		rules: {
			diretoria: "required",
			entidadeselect : "required",
		},
		messages: {
			diretoria: " Selecione uma diretoria",
			entidadeselect : " Selecione uma entidade",
		}
	});
});
</script>
</head>

<body>
<form name="form" id='form' method="POST">
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
		<tr>
			<td width="15%"><span>Diretoria:</span><span class="asterisco">*</span></td>
			<td>
				<select name='diretoria' id='diretoria' >
					<option value=''>Selecione</option>
					<?php while ($e = mysql_fetch_array($lista_diretoria)) { ?>
					<option value='<?php echo $e['id_diretoria']; ?>'><?php echo $e['desc_diretoria']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<?php
	//if ($_POST['diretoria'] != ''){?>
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
		<tr>
			<td width="15%"><span>Entidade:</span><span class="asterisco">*</span></td>
			<td>
				<select name='entidadeselect' id='entidadeselect'>
					<option value=''>Selecione</option>
					<?php while ($e = mysql_fetch_array($lista_entidade)) { ?>
					<option value='<?php echo $e['id_entidade']; ?>'><?php echo $e['entidade']; ?></option>
				<?php } ?>
				</select>
			</td>
		</tr>
	</table>
	<br>
			<input name="incluir" type="hidden" value="1" />
			<input name="enviar" type="submit" id="enviar" value="Enviar">
			<input name="limpar" type="reset" id="limpar" value="Limpar">
	<?php //} ?>
</form>
</body>
</html>
