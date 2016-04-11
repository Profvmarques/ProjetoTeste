<?
if($_POST['cadastrar'])
{
	require_once '../controle/perfil.php';
	cadastra_perfil();
	if($res)
	{
		echo "<script>alert('Perfil cadastrado !');</script>";
	}
	else
	{
		echo "<script>alert('Perfil não cadastrado !');</script>";
	}
}
?>
<form method='post'>
<table>
<tr>
	<td>Perfil:</td>
	<td><input type='text' name='perfil'></td>
<tr>
<tr>
	<td>Acesso:</td>
	<td>
		<input type='checkbox' name='incluir'>Incluir
		<input type='checkbox' name='ler'>Ler
	</td>
</tr>
<tr>
	<td></td>
	<td>
		<input type='checkbox' name='alterar'>Alterar
		<input type='checkbox' name='excluir'>Excluir
	</td>
</tr>
<tr>
	<td><input type='submit' name='cadastrar' value='Cadastrar'></td>
	<td><input type='reset' value='Limpar'></td>
</tr>
</table>
</form>