<?php 
require_once('../../controle/entidades.php');
controle_entidades('editar');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src='funcoes/funcoes.js'></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ouvidoria - FAPERJ</title>
<link rel="stylesheet" type="text/css" href="../../css/style_forms.css" />
<script src="../../js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
$("#form").validate({
		rules: {
			nome: "required",
		},
		messages: {
			nome: "Preencha o campo Nome",
		}
	});
});
</script>
</head>

<body>
<form name="form" id='form' method="POST">
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
		<tr>
			<td width="15%"><span>Entidade:</span><span class="asterisco">*</span></td>
			<td>
				<select name='entidade' id='entidade' onchange="submit();">
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
			<td><span>Nome:</span><span class="asterisco">*</span></td>
			<td><input name="nome" type="text" id="nome" size="45" title="Preencha o campo Nome" value='<?php echo $det['entidade']; ?>'></td>
		</tr>
		<tr>
			<td><span>Ativo:</span><span class="asterisco">*</span></td>
			<td>
				<select name='ativo' id='ativo'>
					<option value='1'>Sim</option>
					<option value='0'>N&atilde;o</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span>Descrição:</span></td>
			<td><textarea name='descricao' id='descricao'><?php echo $det['descricao']; ?></textarea></td>
		</tr>
		<tr>
			<td colspan=2>
				<input name="enviar" type="submit" id="enviar" value="Enviar">
				<input name="limpar" type="reset" id="limpar" value="Limpar">
				<?php if ($excluir == 1) { ?>
					<!--<input name="deletar" type="submit" id="deletar" value="Excluir Entidade">-->
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
<script>document.getElementById('entidade').value='<?php echo $_POST['entidade']; ?>';</script>
<?php if ($entidade != '') { ?>
	<script>document.getElementById('ativo').value='<?php echo $det['ativo']; ?>';</script>
<?php } ?>