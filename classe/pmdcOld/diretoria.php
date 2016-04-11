<?php
require_once('../conexao.php');

class diretoria {

	/*------------- Funчуo para incluir dados no banco --------------*/
	public function incluir($valores) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		//inserir
		$sql = "insert into ouv_diretoria (desc_diretoria) 
				values ('".strtoupper($valores['nome'])."')";
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna 1 se nуo der erro
			return 1;
		}
	}
	
	/*------------- Funчуo para listar todas as diretorias --------------*/
	public function listar($diretoria) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		$comp = '';
		
		if ($diretoria != '') {
			$comp = " where id_diretoria = ".$diretoria;
		}
		
		$sql = "select * from ouv_diretoria order by desc_diretoria";
		$resultado = $conexao -> query($sql);
		
		return $resultado;
		
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return $resultado;
		}
	}
	
	
	
	/*---------------- Funчуo para relacionar entidade-diretoria ------------- */
	public function relacionar($ent, $dir){
		$conexao = new conexao ();
	
		if ($dir != '' && $ent != ''){
			$sql = "insert into ouv_entidade_diretoria (id_entidade, id_diretoria) values (".$ent.",".$dir.")";
			$resultado = $conexao -> query($sql);  
		} 
			
			
		if ($resultado){
			return $resultado;
		}
		}
   
    	/*---------------- Funчуo para alterar entidade-diretoria ------------- */
	public function alterar($ent, $dir){
		$conexao = new conexao ();
	
		if ($dir != '' && $ent != ''){
			$sql = "update ouv_entidade_diretoria set id_entidade=".$ent.",id_diretoria=".$dir." where id_entidade=".$ent.";";
			$resultado = $conexao -> query($sql);
		} 
			
			
		if ($resultado){
			return $resultado;
		}
		}

	public function contar($diretoria,$datas='',$status='',$tipo='',$subitem='') {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		session_start();
		
		if ($diretoria == '')
			$comp = " WHERE ouv_diretoria.id_diretoria > 0";
		else
			$comp = " WHERE ouv_diretoria.id_diretoria = ".$diretoria;
			
		if ($status != '') {
			$comp .= " and ouv_ouvidoria.id_status_atual = ".$status;
		}
		
		if ($tipo != '') {
			$comp .= " and ouv_ouvidoria.id_tipo_usuario = ".$tipo;
		}
		
		if ($subitem != '') {
			$comp .= " and ouv_ouvidoria.id_subitem = ".$subitem;
		}
		
		//limitar data inicial e final
		if ($datas != '') {
			$comp .= $datas;
		}
	
		//faz a busca 
		
		$sql = "select id_processo from ouv_processo
				INNER join ouv_ouvidoria ON ouv_ouvidoria.id_ouvidoria = ouv_processo.id_ouvidoria
				INNER join ouv_entidade_diretoria ON ouv_processo.id_entidade = ouv_entidade_diretoria.id_entidade 
				INNER join ouv_diretoria ON ouv_diretoria.id_diretoria = ouv_entidade_diretoria.id_diretoria"
				.$comp;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return mysql_num_rows($resultado);
		}
		
		}
	
	/*------------- Funчуo para buscar os dados de uma entidade --------------*/
	public function detalhes($id) {
		//criar objeto da classe conexуo
		$conexao = new conexao();
		
		if ($id != '')
			$comp = " where id_diretoria = ".$id;
		else
			$comp = " where id_diretoria > 0";
		
		//faz a busca
		$sql = "select * from ouv_diretoria".$comp ;
		$resultado = $conexao -> query($sql);
		
		if ($resultado) {
			//retorna o resultado se nуo der erro
			return $resultado;
		}
	}
		
	
	
}
	
	

?>