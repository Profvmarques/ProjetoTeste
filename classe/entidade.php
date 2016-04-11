<?
require_once 'conexao.php';

class entidade
{

	public function consultar_entidade()
	{
		$sql="select * from ouv_entidade order by entidade";
		$conecta=new conecta();
		return $conecta->query($sql);
	}
}

?>