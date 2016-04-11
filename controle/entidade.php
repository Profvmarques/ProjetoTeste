<?
require_once '../classe/entidade.php';

function consulta_entidade()
{
	global $res_entidade;
	$entidade=new entidade();
	$res_entidade=$entidade->consultar_entidade();
}
?>