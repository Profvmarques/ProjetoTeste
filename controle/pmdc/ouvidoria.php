<?php 
function controle_ouvidoria($acao) {
	switch ($acao) {
		case 'incluir':
			//criar objeto da classe tipos
			require_once('../../classe/pmdc/tipos.php');
			$tipos = new tipos();

			//criar objeto da classe entidades
			require_once('../../classe/pmdc/entidades.php');
			$entidades = new entidades();
			
			global $lista_tipos;
			global $lista_entidades;

			//listar os tipos
			$lista_tipos = $tipos -> listar();

			//listar as entidades
			$lista_entidades = $entidades -> listar($_SESSION['entidade']);
			
			//incluir dados do formulário no banco
			if ($_POST['incluir'] == 1) {
				//criar objeto da classe ouvidoria
				require_once('../../classe/pmdc/ouvidoria.php');
				$ouvidoria = new ouvidoria();
				
				//chama a função de inclusão da classe ouvidoria
				$resultado = $ouvidoria -> incluir($_POST);
				if ($resultado != '') {
					//inclusão realizada com sucesso
					echo "<div align='right' style='float:right'>";
					echo "<img src='view/pmdc/printButton.png'";
					echo " onclick='window.print()' onMouseOver=\"this.style.cursor='pointer'\">";
					echo "</div>";
					echo "<strong>Formul&aacute;rio enviado com sucesso!</strong>";
					echo "<br> Seu número de protocolo é: ".$resultado;
					die;
				}
			}
		break;
		
		case 'visualizar':
			//criar objeto da classe ouvidoria
			require_once('../../classe/pmdc/ouvidoria.php');
			$ouvidoria = new ouvidoria();

			//criar objeto da classe ouvidoria
			require_once('../../classe/pmdc/segmentos.php');
			$segmentos = new segmentos();
			
			global $resultado;
			global $resultado_outros;
			global $num;
			global $lista_segmentos;
			global $filtro;
			global $filtroStatus;
			global $filtroSegmento;
			
			//manter filtros quando trocar de pagina
			$filtro = '';
			$filtroStatus = $_GET['status'];
			$filtroSegmento = $_GET['segmento'];
			
			//filtros informados por post ou get
			if ($_POST['status'] != '') {
				$filtro .= "&status=".$_POST['status'];
				$filtroStatus = $_POST['status'];
			}
			if ($_POST['segmento'] != '') {
				$filtro .= "&segmento=".$_POST['segmento'];
				$filtroSegmento = $_POST['segmento'];
			}
			
			if ($_GET['status'] != '') {
				$filtro .= "&status=".$_GET['status'];
				$filtroStatus = $_GET['status'];
			}
			if ($_GET['segmento'] != '') {
				$filtro .= "&segmento=".$_GET['segmento'];
				$filtroSegmento = $_GET['segmento'];
			}
			
			if ($_POST['filtrar'] == 1) {
				$_GET['inicio'] = 0;
				
				if ($_POST['segmento'] != '') {
					$filtro = "&segmento=".$_POST['segmento'];
					$filtroSegmento = $_POST['segmento'];
				}
				else {
					$filtro = "";
					$filtroSegmento = '';
				}
				
				if ($_POST['status'] != '') {
					$filtro = "&status=".$_POST['status'];
					$filtroStatus = $_POST['status'];
				}
				else {
					$filtro = "";
					$filtroStatus = '';
				}
			}
			
			//listagem geral
			if ($_POST['pesquisar'] != 1) {
				//chama a função de listagem da classe ouvidoria
				if ($_GET['inicio'] == '') {
					$ouvidoria -> listar($filtroStatus,$filtroSegmento);
				}
				else {
					$ouvidoria -> listar($filtroStatus,$filtroSegmento,$_GET['inicio']);	
				}
			}
			//pesquisa
			else {
				//chama a função de pesquisa da classe ouvidoria
				if ($_GET['inicio'] == '') {
					$ouvidoria -> pesquisar($filtroStatus,$filtroSegmento,$_POST['tipo'],$_POST['busca']);
				}
				else {
					$ouvidoria -> pesquisar($filtroStatus,$filtroSegmento,$_POST['tipo'],$_POST['busca'],$_GET['inicio']);
				}
			}
						
			//resultado da listagem da classe ouvidoria
			$resultado = $ouvidoria -> resultado;
			
			//numero total de registros para paginação
			$num = $ouvidoria -> num;
			
			//chama a função de listagem da classe segmentos
			$lista_segmentos = $segmentos -> listar($_SESSION['usuario']);
		break;
		
		case 'detalhes':
			global $resultado;
			global $resultado_historico;
			global $resultado_seg;
			
			//criar objeto da classe ouvidoria
			require_once('../../classe/pmdc/ouvidoria.php');
			$ouvidoria = new ouvidoria();
			
			//criar objeto da classe segmento
			require_once('../../classe/pmdc/segmentos.php');
			$segmentos = new segmentos();
			
			//chama a funcao para listar todos os segmentos
			$resultado_seg = $segmentos -> listar();
			
			//chama a função para listar dados de um registro da classe ouvidoria
			$resultado = $ouvidoria -> detalhes($_GET['id']);
			
			//criar objeto da classe historico
			require_once('classe/pmdc/historico.php');
			$historico = new historico();
			
			//chama a função para listar o historico de um registro da classe ouvidoria
			$resultado_historico = $historico -> listar($_GET['id']);
			
			//alterações
			if ($_POST['alterar'] == 1) {
				$resultado = $ouvidoria -> alterar($_POST);
				if ($resultado == 1) {
					//alteração realizada com sucesso
					echo "<script>alert('alteração realizada com sucesso');</script>";
					echo "<script>window.location='index.php?pg=view/pmdc/detalhes_ouvidoria.php&id=".$_POST['id_ouvidoria']."';</script>";
				}
			}
		break;
	}
}
?>