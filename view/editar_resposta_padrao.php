<?php 
require_once('../../controle/resposta_padrao.php');
controle_resposta_padrao('editar');
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
<form name="form" method="POST">
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
		<tr>
			<td width=18%><span>Resposta:</span><span class="asterisco">*</span></td>
			<td>
				<select name='resposta_sel' id='resposta_sel' onchange="submit();">
					<option value=''>Selecione a resposta</option>
					<?php while ($l = mysql_fetch_array($lista)) { ?>
					<option value='<?php echo $l['id_resposta_padrao']; ?>'><?php echo $l['resposta_padrao']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<?php
		//resposta escolhida
		if ($rs != '') { ?>
		<tr>
			<td><span>Resposta Padrão:</span><span class="asterisco">*</span></td>
			<td><input type='text' name="resposta" id="resposta" value='<?php echo mysql_result($dados,0,'resposta_padrao'); ?>'></textarea></td>
		</tr>
		<tr>
			<td><span>Observação:</span><span class="asterisco">*</span></td>
			<td><textarea name="obs" id="obs" cols="70" rows="6"><?php echo mysql_result($dados,0,'observacao'); ?></textarea></td>
		</tr>
		<tr>
			<td colspan=2>
				<input name="enviar" type="submit" id="enviar" value="Enviar">
				<input name="limpar" type="reset" id="limpar" value="Limpar">
				<?php if ($excluir == 1) { ?>
					<input name="excluir" type="submit" id="excluir" value="Excluir resposta">
				<?php } ?>
			</td>
		</tr>
		<?php 
		}
		?>
	</table>
</form>
</body>
</html>
<?php if ($rs != '') { ?>
	<script>document.getElementById('resposta_sel').value='<?php echo $rs; ?>';</script>
<?php } ?>