<?
if($_POST['id']!='')
{
	$id=$_POST['id'];
	if(isset ($_POST['aceitar']))
	{
		require_once '../controle/usuario.php';
		excluir_usuario($id);
		
		if($res)
		{
			echo "<script>alert('Usu�rio Excluido !');</script>";
		}
		else
		{
			echo "<script>alert('Usu�rio N�o Excluido !');</script>";
		}
	}
	else
	{
		?>
		<form method="post">
		Tem certeza que deseja excluir <? echo $_POST['nome'];?>?
		<br>
		<BR>
		<input name="id" type="hidden" value="<? echo $id; ?>">
		<input type="submit" value="Sim" name="aceitar">
		<br>
		<BR>
		<?
		echo "<br><a href='javascript:history.go(-1)'>Voltar</a>";
		?>
		</form>
		<?
	}
	
}
else
{
	echo "Voc� precisa selecionar o Usu�rio.";
	echo "<br><a href='javascript:history.go(-1)'>Voltar</a>";
}
?>