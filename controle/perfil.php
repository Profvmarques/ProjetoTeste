<?
require_once '../classe/perfil.php';

function cadastra_perfil()
{
	global $res;
	$perfil=new perfil();
	$res=$perfil->cadastrar($_POST);
}

function consulta()
{
	global $res;
	$perfil=new perfil();
	$res=$perfil->consultar();
}
?>