<?php
session_start();
	if($_SESSION['login']!='')
	{
		$login = $_SESSION['login'];
	}
	
	if($_SESSION['senha']!='')
	{
		$senha = $_SESSION['senha'];
	}

	if(!empty($login) && !empty($senha))
	{
		include "usuario.php";
		consulta_dados();
		
			if((mysql_num_rows($res_consulta)) == 1)
			{
				
				if(md5($senha) != (mysql_result($res_consulta,0,"senha")))
				{
					unset($_SESSION['login']);
					unset($_SESSION['senha']);
					echo "<script>alert('Senha Inválida');</script>";
					echo "<script> window.location='../view'</script>";
				}
			}
			else
			{
				unset($_SESSION['login']);
				unset($_SESSION['senha']);
				echo "<script>alert('Usuário Inválido');</script>";
				echo "<script> window.location='../view'</script>";
			}
	}
	else
	{
		unset($_SESSION['login']);
		unset($_SESSION['senha']);
		echo "<script>alert('Usuário ou Senha Inválidos');</script>";
		echo "<script> window.location='../view'</script>";
	}
$_SESSION['usuario']=mysql_result($res_consulta,0,'id_usuario');
$_SESSION['entidade']=mysql_result($res_consulta,0,'id_entidade');

?>
