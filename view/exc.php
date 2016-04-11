<form method='post' name='excluir' action='excluir_user.php'>
<input type='hidden' name='id' value=''>
<input type='hidden' name='nome' value=''>
<h2>Clique no ícone do Usuário a ser excluido.</h2>
<table border=0 width=50%>
	<td valign='top'></td>
	<td valign='top'>Nome</td>
	<td valign='top'>Entidade</td>
	<?
	require_once '../controle/usuario.php';
	consulta_exc();
	
	while($r=mysql_fetch_array($res))
	{?>
	<tr>
		<td valign='top' align='right'><img src="imagens/excluir.gif" onclick="document.excluir.id.value=<? echo $r['id_usuario']; ?>;document.excluir.nome.value='<? echo $r['nome']; ?>';document.excluir.submit();" onMouseOver="this.style.cursor='pointer'"></td>
		<td valign='top'><? echo $r['nome']; ?></td>
		<td valign='top'><? echo $r['entidade']; ?></td>
	</tr>
	<?}
	?>
</table>
</form>
