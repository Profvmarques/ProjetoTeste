<?php
require_once('../../controle/faetec/usuarios.php');
controle_usuarios('alterar_senha_unidade');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Ouvidoria - FAETEC</title>
		<link rel="stylesheet" type="text/css" href="../../css/style_rel.css" />
		<style type='text/css'>
			input.error {
				background-color: #ffcccc;
			}
			label.error {
				color: #7563a5;
			}
		</style>
		<script src="../../js/jquery.js" type="text/javascript"></script>
		<script src="../../js/jquery.validate.js" type="text/javascript"></script>
		<script type="text/javascript">
		$().ready(function() {
			$("#form").validate({
				rules: {
					senha_atual: 'required',
					nova_senha: 'required',
					confirmar_senha: {
						equalTo: nova_senha
					}
				},
				messages: {
					senha_atual: 'Informe a senha atual',
					nova_senha: 'Informe a nova senha',
					confirmar_senha: 'Confirma&ccedil;&atilde;o de senha inv&aacute;lida'
				}
			});
			$("#alterar").click(function() {
				if ($("#form").valid()) {
					$("#form").submit();
				}
			});
		});
		</script>
	</head>
	<body>
		<p>Alterar Senha</p>
		<form method="post" id="form">
			<table>
				<tr>
					<td><span>Senha atual:</span></td>
					<td><input type='password' name='senha_atual' id='senha_atual'></td>
				</tr>
				<tr>
					<td><span>Nova senha:</span></td>
					<td><input type='password' name='nova_senha' id='nova_senha'></td>
				</tr>
				<tr>
					<td><span>Confirmar nova senha:</span></td>
					<td><input type='password' name='confirmar_senha' id='confirmar_senha'></td>
				</tr>
				<tr>
					<td>
						<input type="button" value="Alterar" id="alterar">
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>