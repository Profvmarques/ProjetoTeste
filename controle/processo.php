<?php
require('../../classe/sect/processo.php');
function Processo($opcao){
	$processo = new processo(); 
	switch ($opcao)	{
		case 'incluir':
			if ($_POST['enviar']) {
				$data_n = explode("/", $_POST['data_nasc']);
				$data_nasc = $data_n[2]."-".$data_n[1]."-".$data_n[0];

				$hoje=date("Y-m-d H:i:s");
				$processo->InsertProcesso($_POST['tipo'],$_POST['canal'],$_POST['id_prioridade'],$_POST['nome'], $_POST['sexo'], $data_nasc, $_POST['escolaridade'], $_POST['email'],
				$_POST['endereco'], $_POST['bairro'], $_POST['cidade'], $_POST['telefone'], $_POST['celular'], $_POST['question'], $_POST['coments'], $_POST['entidade'], $hoje);
			}
		break;
	
		case 'ouvidoria':
			global $res;
			
			$processo->ListOuvidoria();
			$res = $processo->Result;
		break;
		
		case 'denuncia':
			global $res;
			$processo->Listdenuncia();

			$res = $processo->Result;
		break;

		case 'processo':
			global $r;
			$id = $_GET['p'];	
			$processo->ListProcesso($id);
			
			$r = $processo->Result;
		break;
		
		case 'viewdenuncia':
			global $r;
			$id = $_GET['p'];	
			$processo->viewdenuncia($id);

			$r = $processo->Result;
		break;
	}
}
?>