<?php
require_once ('conexao.php');

class prioridade {
	//listar todos as prioridades
	public function listar() {
		$conexao = new conexao();
		
		$sql = "select * from ouv_prioridade order by prioridade";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
	
	//alterar prioridade
	public function alterar($prioridade, $id) {
		$conexao = new conexao();
		
		$sql = "update ouv_ouvidoria set id_prioridade = ".$prioridade." where id_ouvidoria = ".$id;
		$resultado = $conexao -> query($sql);
		
		return $resultado;
	}
}
?>