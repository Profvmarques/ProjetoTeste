<?php
require_once('../../classe/pmdc/processos.php');

$processos = new processos();

require('fpdf/fpdf.php');       			
define('FPDF_FONTPATH','fpdf/font/');
$pdf=new FPDF('L','mm','A4');

$pdf->SetMargins(10,10);
//$pdf->AddPage();							
$pdf->SetFont('Arial','B',16);

//cores para o grafico de barras
$col[0]=array(232, 148, 48);
$col[1]=array(4, 121, 203);
$col[2]=array(32, 164, 232);
$col[3]=array(19, 132, 4);
$col[4]=array(129, 200, 97);

$datas = '';

if ($_POST['data_inicial'] == '') {
	$_POST['data_inicial'] = '01/08/2009';
}
if ($_POST['data_final'] == '') {
	$_POST['data_final'] = date('d/m/Y');
}

$di = explode("/",$_POST['data_inicial']);
$df = explode("/",$_POST['data_final']);
$data_inicial = $di[2]."-".$di[1]."-".$di[0];
$data_final = $df[2]."-".$df[1]."-".$df[0];

$datas = " and date(ouv_processo.data_ini) between '".$data_inicial."' and '".$data_final."'";

$pdf->AddPage();

$resultado = $processos -> processos_por_canal($datas);

if (mysql_num_rows($resultado)==0) {
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(0,10,'FUNDAÇÃO DE APOIO A ESCOLA TÉCNICA',0,1,'C');

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA',0,1,'C');
	$pdf->Cell(0,10,'NÃO HÁ RESULTADOS',0,1,'C');
}
else {
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(0,10,'FUNDAÇÃO DE APOIO A ESCOLA TÉCNICA',0,1,'C');
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA - FAETEC',0,1,'C');
	$pdf->Cell(0,8,'Quantitativo de manifestações por canal',0,1,'C');
	
	if ($_POST['data_inicial'] != '' && $_POST['data_final'] != '') {
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(0,8,"Período: ".$_POST['data_inicial']." até ".$_POST['data_final'],0,1,'C');
	}
	
	$porcanal = array();
	$canal = array();
	while ($p = mysql_fetch_array($resultado)) {
		$porcanal[$p['canal']] = $p['qtd'];
		$canal[$p['canal']] = $p['canal'];
	}
	
	$pdf->SetFont('Arial','B',9);
	$pdf->SetX(7);
	$pdf->Cell(20,3,"Canal",0,0,'L');
	$pdf->Cell(10,3,"Quantidade",0,1,'L');
	$pdf->Ln(5);
	$pdf->BarDiagram(90, 20, $porcanal, '%l : %v (%p)', $canal, $col, $pdf->gety()+5, 2);
}

$pdf->Output();
?>