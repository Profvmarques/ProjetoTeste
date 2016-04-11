<?php
require_once '../../controle/usuario.php';
cadastra();
if ($_POST['ok']) {
	if ($res_cadastra) {
		echo "<script>alert('Usuário cadastrado !');</script>";
	}
	else {
		echo "<script>alert('Usuário não cadastrado !');</script>";
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
				senha:"required",
				csenha:"required",
				ativo:"required",
				perfil: "required"
			},
			messages: {
				nome: "Preencha o campo Nome",
				login: "Preencha o campo Login",
				senha:"Preencha o campo Senha",
				csenha:"Digite novamente a senha",
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
</head>
<body>
<p>Cadastro de Usu&aacute;rios</p>
<form method='post' name='novo' id='novo'>
<table width="326">
<tr>
	<td><span>Nome:</span><span class="asterisco">*</span></td>
	<td><input type='text' name='nome' id='nome'></td>
</tr>
<tr>
	<td><span>Login:</span><span class="asterisco">*</span></td>
	<td><input type='text' name='login' id='login'></td>
</tr>
<tr>
	<td><span>Senha:</span><span class="asterisco">*</span></td>
	<td><input type='password' name='senha' id='senha'></td>
</tr>
<tr>
	<td><span>Confirmar Senha:</span><span class="asterisco">*</span></td>
	<td><input type='password' name='csenha' id='csenha'></td>
</tr>
<tr>
	<td><span>Perfil:</span><span class="asterisco">*</span></td>
	<td>
	<select name='perfil' id='perfil'>
		<option value=''>Selecione o perfil</option>
		<?php while($r=mysql_fetch_array($res_perfil)) { ?>
			<option value='<?php echo $r['id_perfil']; ?>'><?php echo $r['perfil']; ?></option>
		<?php } ?>
	</select>	</td>
</tr>
<tr style='display:none' id='linha_entidade'>
	<td><span>Entidade:</span><span class="asterisco">*</span></td>
	<td>
	<select name='entidade' id='entidade'>
		<option value=''>Selecione a Entidade</option>
		<?php while($r=mysql_fetch_array($res_entidade)) { ?>
			<option value='<?php echo $r['id_entidade']; ?>'><?php echo $r['entidade']; ?></option>
		<?php }	?>
	</select></td>
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
</table></br>
<input type='hidden' name='ok'>
	<input type='submit' name='cadastrar' value='Cadastrar'>
       <input type='reset' value='Limpar'>   
</form>
</body>
</html>