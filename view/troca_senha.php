<?
require_once '../controle/usuario.php';
consulta_dados();

if($_POST['ok'])
{
	require_once '../controle/usuario.php';
	troca_senha();
	
	if($res_senha)
	{
		echo "<script>alert('Senha Alterada !!!');</script>";
	}
	else
	{
		echo "<script>alert('Senha não Alterada !!!');</script>";
	}
}
//senha 123456 
?>
<form name='senha' id='senha' method='post'>
Nome:<? echo mysql_result($res_consulta,0,'nome'); ?>
<!-- Senha Atual do Usuário -->
<input type='hidden' name='senhaAtual' value='e10adc3949ba59abbe56e057f20f883e'>
<br>
Senha Atual:<input type='password' name='senhaa' title='Preencha a Senha Atual !'>
<br>
Senha Nova:<input type='password' name='senhan' title='Preencha a Nova Senha !'>
<br>
Confirmar Senha:<input type='password' name='csenha' title='Confirme a Nova Senha !'>
<br>
<input type='hidden' name='ok'>
<input type='button' value='Salvar' onclick="validar(document.senha);">
<input type='reset' value='Limpar'>
</form>
<script src="../funcao/validacao.js"></script>