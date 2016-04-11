<?php 
require_once('controles/segmentos.php');
controle_segmentos('editar');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src='funcoes/funcoes.js'></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ouvidoria - FAETEC</title>
</head>

<body>
<form name="form" method="POST">
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
		<tr>
			<td colspan=2>
				<select name='segmento' id='segmento' onchange="document.getElementById('editar').value='';submit()">
					<option value=''>Selecione o segmento</option>
					<?php while ($l = mysql_fetch_array($lista)) { ?>
					<option value='<?php echo $l['id']; ?>'><?php echo $l['nome']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<?php 
		//segmento escolhido
		if ($segmento != '') {?>
		<tr>
			<td><label style="font-weight:bold; color:#666666">Nome:*</label></td>
			<td><input name="nome" type="text" id="nome" size="45" title="Preencha o campo Nome" value='<?php echo $nome; ?>'></td>
		</tr>

		</tr>
	<?php } ?>	
	</table>
	<input name="enviar" type="button" id="enviar" value="Enviar" onClick="document.getElementById('editar').value=1;validar(document.form);">
	<input name="limpar" type="reset" id="limpar" value="Limpar">
	<input name="editar" id="editar" type="hidden" value="" />
	<input name="id" id="id" type="hidden" value="<?php echo $segmento; ?>" />
</form>
</body>
</html>
<?php if ($segmento != '') { ?>
	<script>document.getElementById('segmento').value='<?php echo $segmento; ?>';</script>
<?php } ?>