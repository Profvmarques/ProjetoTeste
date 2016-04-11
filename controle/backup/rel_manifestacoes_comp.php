<?php
require_once('../../classe/conexao.php');
require_once('../../classe/backup/processo.php');
require_once('../../classe/entidades.php');
require_once('../../classe/assuntos.php');

$processo = new processo();
$entidades = new entidades();
$assuntos = new assuntos();
$conexao = new conexao();

require('fpdf/fpdf.php');       			
define('FPDF_FONTPATH','fpdf/font/');
$pdf=new FPDF('P','mm','A4');				

$pdf->SetMargins(10,10);
//$pdf->AddPage();							
$pdf->SetFont('Arial','B',16);

//cores para o grafico de barras
$col[0]=array(232, 148, 48);
$col[1]=array(4, 121, 203);
$col[2]=array(32, 164, 232);
$col[3]=array(19, 132, 4);
$col[4]=array(129, 200, 97);

$comp = '';

switch (substr($_SESSION['periodo'], -2)) {
	case '01':
		$inicio = '01/01/'.substr($_SESSION['periodo'], -2);
		$fim = '30/06/'.substr($_SESSION['periodo'], -2);
	break;
	case '02':
		$inicio = '01/07/'.substr($_SESSION['periodo'], 0, 4);
		$fim = '31/12/'.substr($_SESSION['periodo'], 0, 4);
	break;
}

if ($_POST['data_inicial'] == '') {
	$_POST['data_inicial'] = $inicio;
}
if ($_POST['data_final'] == '') {
	$_POST['data_final'] = $fim;
}

$di = explode("/",$_POST['data_inicial']);
$df = explode("/",$_POST['data_final']);
$data_inicial = $di[2]."-".$di[1]."-".$di[0];
$data_final = $df[2]."-".$df[1]."-".$df[0];

$comp = " and date(_processo".$_SESSION['periodo'].".data_ini) between '".$data_inicial."' and '".$data_final."'";

$id_entidade=$_POST['entidade'];

if ($id_entidade!="") {
	$tot = $entidades -> contar_backup($id_entidade,$comp);

	$res = $entidades -> detalhes($id_entidade);
	$nome_entidade = mysql_result($res,0,'entidade');

    $pdf->AddPage();
	
	if ($tot==0) {
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'SECRETARIA DE CIÊNCIA E TECNOLOGIA',0,1,'C');

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA',0,1,'C');
		$pdf->Cell(0,10,'NÃO HÁ RESULTADOS PARA A ENTIDADE: '.$nome_entidade,0,1,'C');
	}
	else {
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'SECRETARIA DE CIÊNCIA E TECNOLOGIA',0,1,'C');

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA - '.$nome_entidade,0,1,'C');
		$pdf->Cell(0,8,'Comparativo de status das manifestações',0,1,'C');
		
		if ($_POST['data_inicial'] != '' && $_POST['data_final'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,8,"Período: ".$_POST['data_inicial']." até ".$_POST['data_final'],0,1,'C');
		}
		
		$resultado = $processo -> processos_por_status($data_inicial, $data_final, $_POST['entidade']);
		$porstatus = array();
		while ($p = mysql_fetch_array($resultado)) {
			$porstatus[$p['status']] = $p['total'];
			$status[$p['status']] = $p['status'];
		}
		
		$pdf->SetFont('Arial','B',9);
		$pdf -> Ln(8);
		$pdf->SetX(6.6);
		$pdf->Cell(20,3,"Status",0,0,'L');
		$pdf->Cell(10,3,"Quantidade",0,1,'L');
		$pdf -> Ln(1);
		$pdf->BarDiagram(90, 20, $porstatus, '%l : %v (%p)', $status, $col, $pdf->gety()+10, 2);
	}
}
else {
	//Relatório para todas as entidades
	$lista_entidades = $entidades -> listar($_SESSION['entidade']);

	while ($l = mysql_fetch_array($lista_entidades)) {
		$tot = $entidades -> contar_backup($l['id_entidade'],$comp);
		$res = $entidades -> detalhes($l['id_entidade']);
		$nome_entidade = mysql_result($res,0,'entidade');

	    $pdf->AddPage();
		 
		if ($tot==0) {
			$pdf->SetFont('Arial','B',16);
			$pdf->Cell(0,10,'SECRETARIA DE CIÊNCIA E TECNOLOGIA',0,1,'C');

			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA',0,1,'C');
			$pdf->Cell(0,10,'NÃO HÁ RESULTADOS PARA A ENTIDADE: '.$nome_entidade,0,1,'C');
		}
		else {
			$pdf->SetFont('Arial','B',16);
			$pdf->Cell(0,10,'SECRETARIA DE CIÊNCIA E TECNOLOGIA',0,1,'C');

			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA - '.$nome_entidade,0,1,'C');
			$pdf->Cell(0,8,'Comparativo de status das manifestações',0,1,'C');
			
			if ($_POST['data_inicial'] != '' && $_POST['data_final'] != '') {
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(0,8,"Período: ".$_POST['data_inicial']." até ".$_POST['data_final'],0,1,'C');
			}
			
			$resultado = $processo -> processos_por_status($data_inicial, $data_final, $l['id_entidade']);
			$porstatus = array();
			while ($p = mysql_fetch_array($resultado)) {
				$porstatus[$p['status']] = $p['total'];
				$status[$p['status']] = $p['status'];
			}
			
			$pdf->SetFont('Arial','B',9);
			$pdf -> Ln(8);
			$pdf->SetX(6.6);
			$pdf->Cell(20,3,"Status",0,0,'L');
			$pdf->Cell(10,3,"Quantidade",0,1,'L');
			$pdf -> Ln(1);
			$pdf->BarDiagram(90, 20, $porstatus, '%l : %v (%p)', $status, $col, $pdf->gety()+10, 2);
		}
	}
}

$pdf->Output();
?>