<?php 
require_once('../../controle/sub_item.php');
controle_sub_item('incluir');
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
						descricao: "required",
					},
					messages: {
						descricao: " Preencha o campo Descricao",
					}
				});
			});
		</script>
	</head>
	<body>
		<p>Cadastro de Subitens</p>
		<form name="form" method="post" id="form">
			<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
				<tr>
					<td>
						<span>Assunto</span>
					</td>
					<td>
						<select name='assunto' id='assunto'>
							<option value=''>Selecione</option>
							<?php while ($la = mysql_fetch_array($lista_assuntos)) { ?>
								<option value='<?php echo $la['id_assunto']; ?>'><?php echo $la['assunto']; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td width="15%"><span>Descricao:</span><span class="asterisco">*</span></td>
					<td><input name="descricao" type="text" id="descricao"></td>
				</tr>
			</table>
			</br>
			<input name="enviar" type="submit" id="enviar" value="Enviar">
			<input name="limpar" type="reset" id="limpar" value="Limpar">
		</form>
	</body>
</html>