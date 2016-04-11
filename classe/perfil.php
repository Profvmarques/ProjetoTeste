<?php
require_once 'conexao.php';
class perfil
{
	public function cadastrar($i)
	{
		$excluir=($i['excluir']=='on')?1:0;
		$ler=($i['ler']=='on')?1:0;
		$incluir=($i['incluir']=='on')?1:0;
		$alterar=($i['alterar']=='on')?1:0;
		
		//se o usuario não marcar pelo menos um tipo de acesso, o perfil recebe permissão só para leitura
		$ler=($excluir==0 && $ler==0 && $incluir==0 && $alterar==0)?1:$ler;
		
		$sql="insert into ouv_perfil (perfil,excluir,ler,incluir,alterar)
				values ('".$i['perfil']."',".$excluir.",".$ler.",".$incluir.",".$alterar.")";
		$conecta=new conecta();
		return $conecta->query($sql);
	}
	
	public function consultar()
	{
		$sql="select * from ouv_perfil order by perfil";
		$conexao = new conexao();
		return $conexao -> query($sql);
	}
}
?>