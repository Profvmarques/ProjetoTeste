<?php 
require_once('../../controle/sub_item.php');
controle_sub_item('editar');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Ouvidoria - FAETEC</title>
		<link rel="stylesheet" type="text/css" href="../../css/style_forms.css" />
		<script src="../../js/jquery.js" type="text/javascript"></script>
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
		<p>Editar Subitens</p>
		<form name="form" method="post" id="form">
			<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
				<tr>
					<td><span>Subitem</span><span class="asterisco">*</span></td>
					<td>
						<select name='sub' id='sub' onchange='submit()'>
							<option value=''>Selecione</option>
							<?php while ($ls = mysql_fetch_array($lista_sub)) { ?>
							<option value='<?php echo $ls['id_subitem']; ?>'><?php echo $ls['subitem']; ?></option>	
							<?php } ?>
						</select>
					</td>
				</tr>
				<?php if ($_POST['sub'] != '') { ?>
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
					<td><input name="descricao" type="text" id="descricao" value=<?php echo $detalhes['subitem']; ?>></td>
				</tr>
				<tr>
					<td width="15%"><span>Ativo:</span><span class="asterisco">*</span></td>
					<td>
						<select name='ativo' id='ativo'>
							<option value=1>Sim</option>
							<option value=0>N&atilde;o</option>
						</select>
					</td>
				</tr>
				<?php } ?>
			</table>
			</br>
			<input name="enviar" type="submit" id="enviar" value="Enviar">
			<input name="limpar" type="reset" id="limpar" value="Limpar">
		</form>
	</body>
</html>
<script>
	document.getElementById('sub').value='<?php echo $_POST['sub']; ?>';
	<?php if($_POST['sub']!=''){ ?>
	document.getElementById('assunto').value='<?php echo $detalhes['id_assunto']; ?>';
	document.getElementById('ativo').value='<?php echo $detalhes['ativo']; ?>';
	<?php } ?>
</script>