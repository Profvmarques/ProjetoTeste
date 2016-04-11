<?php
require_once('../faetec/classe/pmdc/usuarios.php');

if (count($_POST) > 0) {
	//criar objeto da classe ouvidoria
	$usuarios = new usuarios();
	//chama a funcao de login
	$login = $usuarios -> login($_POST);
	
	if ($login == 1) {
		//login deu certo
		echo "<script>window.location='?pg=view/pmdc/visualizar_ouvidoria.php';</script>";
	}
	else {
		echo "<script>alert('Usuário inexistente');</script>";
	}
}
?>