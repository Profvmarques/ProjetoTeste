<?php 
require_once('controles/entidades.php');
controle_entidades('editar');
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
			<td><label style="font-weight:bold; color:#666666">Entidade:</label></td>
			<td>
				<select name='entidade' id='entidade' onchange="document.getElementById('editar').value='';submit()">
					<option value=''>Selecione</option>
					<?php while ($e = mysql_fetch_array($lista_entidades)) { ?>
					<option value='<?php echo $e['id_entidade']; ?>'><?php echo $e['entidade']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<?php 
		//entidade escolhida
		if ($entidade != '') { ?>
		<tr>
			<td><label style="font-weight:bold; color:#666666">Nome:*</label></td>
			<td><input name="nome" type="text" id="nome" size="45" title="Preencha o campo Nome" value='<?php echo $det['entidade']; ?>'></td>
		</tr>
		<tr>
			<td><label style="font-weight:bold; color:#666666">Entidade pai:*</label></td>
			<td>
				<select name='pai' id='pai'>
					<option value=''>Selecione</option>
					<?php for ($i=0;$i<mysql_num_rows($lista_entidades);$i++) {
					?>
					<option value='<?php echo mysql_result($lista_entidades,$i,'id_entidade'); ?>'><?php echo mysql_result($lista_entidades,$i,'entidade'); ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td><label style="font-weight:bold; color:#666666">Descrição</label></td>
			<td><textarea name='descricao' id='descricao'><?php echo $det['descricao']; ?></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input name="enviar" type="button" id="enviar" value="Enviar" onClick="validar(document.form);">
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
<script>document.getElementById('entidade').value='<?php echo $entidade; ?>';</script>
<?php if ($entidade != '') { ?>
	<script>document.getElementById('pai').value='<?php echo $det['id_entidade_pai']; ?>';</script>
<?php } ?>