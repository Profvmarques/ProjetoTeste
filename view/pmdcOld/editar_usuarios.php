<?php 
require_once('../faetec/controles/usuarios.php');
controle_usuarios('editar');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src='../faetec/funcoes/funcoes.js'></script>
<script>
function validacao(formulario){
	if (document.getElementById('senha').value != document.getElementById('conf').value) {
		alert('senha não confere');
		document.getElementById('senha').value='';
		document.getElementById('conf').value='';
	}
	else {
		validar(formulario);
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ouvidoria - FAETEC</title>
</head>

<body>
<form name="form" method="POST">
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
		<tr>
			<td colspan=2>
				<select name='usuario' id='usuario' onchange="document.getElementById('editar').value='';submit()">
					<option value=''>Selecione o usuário</option>
					<?php while ($l = mysql_fetch_array($lista)) { ?>
					<option value='<?php echo $l['id']; ?>'><?php echo $l['login']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<?php 
		//usuario escolhido
		if ($usuario != '') {?>
		<tr>
			<td><label style="font-weight:bold; color:#666666">Login:*</label></td>
			<td><input name="nome" type="text" id="nome" size="45" title="Preencha o campo Nome" value='<?php echo $detalhes['login']; ?>'></td>
		</tr>
		<tr>
			<td><label style="font-weight:bold; color:#666666">Nova Senha:</label></td>
			<td><input name="senha" type="password" id="senha" size="45"></td>
		</tr>
		<tr>
			<td><label style="font-weight:bold; color:#666666">Confirmar Senha:</label></td>
			<td><input name="conf" type="password" id="conf" size="45"></td>
		</tr>
		<tr>
			<td colspan=2>
				<input name="enviar" type="button" id="enviar" value="Enviar" onClick="document.getElementById('editar').value=1;validacao(document.form);">
				<input name="limpar" type="reset" id="limpar" value="Limpar">
			</td>
		</tr>
		<tr>
			<td align='center' colspan='2'>Permissões</td>
		</tr>
		<tr>
			<td colspan='2'>
				<select name='segmento' id='segmento'>
					<option value=''>Selecione o segmento</option>
					<option value='0'>Não encaminhado</option>
					<?php while ($s = mysql_fetch_array($lista_segmentos)) { ?>
					<option value='<?php echo $s['id']; ?>'><?php echo $s['nome']; ?></option>
					<?php } ?>
				</select>
				<select name='permissao' id='permissao'>
					<option value=''>Selecione a permissão</option>
					<option value='1'>Visualizar Tudo</option>
					<option value='2'>Visualizar Status</option>
				</select>
				<input type='button' value='Adicionar' onclick="document.getElementById('editar').value=2;document.form.submit();">
			</td>
		</tr>
	</table>
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
		<?php if (mysql_num_rows($lista_permissoes) > 0) { ?>
			<?php while ($p = mysql_fetch_array($lista_permissoes)) { ?>
				<tr>
					<td width='10%'><?php echo ($p['nome'] != '') ? $p['nome'] : 'Não encaminhado'; ?></td>
					<td width='10%'><?php echo $p['permissao']; ?></td>
					<td><input type='button' value='Remover' 
					onclick="document.getElementById('editar').value=3;document.getElementById('remover').value=<?php echo $p['id']; ?>;document.form.submit();"></td>
				</tr>
			<?php } ?>
		<?php } ?>
		</tr>
	<?php } ?>	
	</table>
	<input name="editar" id="editar" type="hidden" value="" />
	<input name="remover" id="remover" type="hidden" value="" />
</form>
</body>
</html>
<?php if ($usuario != '') { ?>
	<script>document.getElementById('usuario').value='<?php echo $usuario; ?>';</script>
<?php } ?>