<?php
require_once '../../controle/usuario.php';
altera();

if($_POST['ok'])
{
	require_once '../../controle/usuario.php';
	
	if($res_altera)
	{
		echo "<script>alert('Usuário Alterado !');</script>";
		//echo "<script> window.location='index.php?pg=view/usuario.php'</script>";
		
	}
	else
	{
		echo "<script>alert('Usuário Não Alterado !');</script>";
		//echo "<script> window.location='index.php?pg=view/usuario.php'</script>";
	}
}
?>
<html>
<head>
<script src="../../js/jquery.validate.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../../css/style_forms.css" />

<script type="text/javascript">
$().ready(function() {
	$("#novo").validate({
		rules: {
			nome: "required",
			login: "required",
			entidade:"required",
			ativo:"required",
			perfil: "required"
		},
		messages: {
			nome: "Preencha o campo Nome",
			login: "Preencha o campo Login",
			entidade: "Escolha uma entidade",
			ativo: "Escolha um status",
			perfil: "Escolha um perfil"
		}
	});

	$("#perfil").change(function() {
		if ($(this).val() == 5) {
			$("#linha_entidade").fadeIn();
		}
		else {
			$("#linha_entidade").fadeOut();
			$("#entidade").val('');
		}
	});
});
</script>
<script>
function verifica_senha() {
	var senha = document.getElementById('senha').value;
	var csenha = document.getElementById('csenha').value;
	
	if (senha != '' && csenha != '') {
		if (senha != csenha) {
			alert('Senha e confirmação de senha não conferem');
			document.getElementById('senha').value = '';
			document.getElementById('csenha').value = '';
		}
	}
}
</script>
</head>
<body>
<p>Altera&ccedil;&atilde;o de Usu&aacute;rios</p>
<form method='post' name='novo' id='novo'>
<input type='hidden' name='id' value='<?php echo mysql_result($res_consulta,0,'id_usuario'); ?>'>
<table>
<tr>
	<td><span>Usu&aacute;rio:</span></td>
	<td>
		<select name='usuario' id='usuario' onChange="document.getElementById('editar').value='';submit()">
			<option value=''>Selecione o usuário</option>
			<?php while ($l = mysql_fetch_array($lista)) { ?>
			<option value='<?php echo $l['id_usuario']; ?>'><?php echo $l['nome']; ?></option>
			<?php } ?>
		</select>
	</td>
</tr>
<tr>
	<td colspan=2></td>
</tr>
<?php 
//usuario escolhido
if ($_POST['usuario'] != '') {?>
<tr>
	<td><span>Nome:</span><span class="asterisco">*</span></td>
	<td><input type='text' name='nome' id='nome' title='Preencha o Nome !' value='<?php echo $detalhes['nome']; ?>'></td>
</tr>
<tr>
	<td><span>Login:</span><span class="asterisco">*</span></td>
	<td><input type='text' name='login' id='login' title='Preencha o Login !' value='<?php echo $detalhes['login']; ?>'></td>
</tr>
<tr>
	<td><span>Senha:</span></td>
	<td><input type='password' name='senha' id='senha' onblur='verifica_senha();'></td>
</tr>
<tr>
	<td><span>Confirmar Senha:</span></td>
	<td><input type='password' name='csenha' id='csenha' onblur='verifica_senha();'></td>
</tr>
<tr>
	<td><span>Perfil:</span><span class="asterisco">*</span></td>
	<td>
	<select name='perfil' title='Selecione o Perfil !'>
		<option value=''>Selecione o perfil</option>
		<?php while($r=mysql_fetch_array($res_perfil)) { ?>
			<option value='<?php echo $r['id_perfil']; ?>' <?php if($r['id_perfil'] == $detalhes['id_perfil'])echo "selected";?>><?php echo $r['perfil']; ?></option>
		<?php } ?>
	</select>
	</td>
</tr>
<tr>
	<td><span>Entidade:</span><span class="asterisco">*</span></td>
	<td>
	<select name='entidade' title='Selecione a Entidade !'>
		<option value=''>Selecione a Entidade</option>
		<?php	while($r=mysql_fetch_array($res_entidade)) { ?>
			<option value='<?php echo $r['id_entidade']; ?>' <?php if($r['id_entidade'] == $detalhes['id_entidade'])echo "selected";?>><?php echo $r['entidade']; ?></option>
		<?php } ?>
	</select>
	</td>
</tr>
<tr>
	<td><span>Ativo:</span><span class="asterisco">*</span></td>
	<td>
	<select name='ativo' id='ativo' title='Selecione o status'>
		<option value='1'>Sim</option>
		<option value='0'>N&atilde;o</option>
	</select>
	</td>
</tr>
<tr>
	<td colspan=2>
		<input type='submit' name='alterar' id='alterar' value='Alterar'>
		<input type='reset' value='Limpar'>
		<?php /*if ($excluir == 1) { ?>
			<input type='submit' name='inativar' id='inativar' value='Inativar Usuário'>
		<?php } */?>
	</td>
	
</tr>
<?php
}
?>
</table>
<input type='hidden' name='editar' id='editar'>
<input type='hidden' name='ok'>
</form>
</body>
<?php if ($_POST['usuario'] != '') { ?>
	<script>document.getElementById('usuario').value='<?php echo $_POST['usuario']; ?>'</script>
	<script>document.getElementById('ativo').value='<?php echo $detalhes['ativo']; ?>'</script>
<?php } ?>