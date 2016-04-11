<?php
require_once('../../classe/pmdc/processos.php');
$processos = new processos();

require('fpdf/fpdf.php');       			
define('FPDF_FONTPATH','fpdf/font/');

if ($_POST['data_inicial'] == '') {
	$_POST['data_inicial'] = '01/08/2009';
}
if ($_POST['data_final'] == '') {
	$_POST['data_final'] = date('d/m/Y');
}

class ici extends FPDF {
	
	function header() {
		$this->SetFont('Arial','B',16);
		$this->Cell(0,10,'FUNDAÇÃO DE APOIO A ESCOLA TÉCNICA',0,1,'C');
		
		$this->SetFont('Arial','B',12);
		$this->Cell(0,10,'RELATÓRIOS DA OUVIDORIA',0,1,'C');
		$this->Cell(0,8,'Quantitativo de manifestações por '.$_POST['desc_tipo'],0,1,'C');
		
		if ($_POST['entidade'] != '') {
			$this->Cell(0,8,'Entidade: '.$_POST['desc_entidade'],0,1,'C');
		}
		if ($_POST['status'] != '') {
			$this->Cell(0,8,'Status: '.$_POST['desc_status'],0,1,'C');
		}
		if ($_POST['assunto'] != '') {
			$this->Cell(0,8,'Assunto: '.$_POST['desc_assunto'],0,1,'C');
		}
		if ($_POST['deficiencia'] != '') {
			$this->Cell(0,8,'Deficiência: '.$_POST['desc_deficiencia'],0,1,'C');
		}
		if ($_POST['modalidade'] != '') {
			$this->Cell(0,8,'Modalidade: '.$_POST['desc_modalidade'],0,1,'C');
		}
		if ($_POST['tipo_usuario'] != '') {
			$this->Cell(0,8,'Tipo de Usuário: '.$_POST['desc_tipo_usuario'],0,1,'C');
		}
		if ($_POST['tipo_manifestacao'] != '') {
			$this->Cell(0,8,'Tipo de Manifestação: '.$_POST['desc_tipo_manifestacao'],0,1,'C');
		}
		if ($_POST['canais'] != '') {
			$this->Cell(0,8,'Canal: '.$_POST['desc_canais'],0,1,'C');
		}
		
		if ($_POST['data_inicial'] != '' && $_POST['data_final'] != '') {
			$this->SetFont('Arial','B',10);
			$this->Cell(0,8,"Período: ".$_POST['data_inicial']." até ".$_POST['data_final'],0,1,'C');
		}
		
		if ($_POST['tipo_grafico'] == 'barras') {
			$this->SetFont('Arial','B',9);
			$this->SetX(7);
			$this->Cell(47,3,$_POST['desc_tipo'],0,0,'L');
			$this->Cell(10,3,"Quantidade",0,1,'L');
			$this->Ln(5);
		}
	}
	
}

$pdf = new ici('L','mm','A4');

$pdf->SetMargins(10,10);
$pdf->SetFont('Arial','B',16);
$pdf->AddPage();

//cores para o grafico de barras
$col[0]=array(232, 148, 48);
$col[1]=array(4, 121, 203);
$col[2]=array(32, 164, 232);
$col[3]=array(19, 132, 4);
$col[4]=array(129, 200, 97);

$datas = '';

$di = explode("/",$_POST['data_inicial']);
$df = explode("/",$_POST['data_final']);
$data_inicial = $di[2]."-".$di[1]."-".$di[0];
$data_final = $df[2]."-".$df[1]."-".$df[0];

$datas = " and date(ouv_processo.data_ini) between '".$data_inicial."' and '".$data_final."'";

$resultado = $processos -> comparativos($_POST,$datas);

if (mysql_num_rows($resultado) == 0) {
	$pdf->Cell(0,10,'NÃO HÁ RESULTADOS',0,1,'C');
}
else {
	if ($_POST['tipo_grafico'] == 'pizza') {
		//cores
		$col1=array(173, 30, 6);
		$col2=array(232, 148, 48);
		$col3=array(189, 163, 242);
		$col4=array(4, 121, 203);
		$col5=array(32, 164, 232);
		$col6=array(19, 132, 4);
		$col7=array(129, 200, 97);
		$col8=array(237, 220, 0);
		$col9=array(160, 66, 0);
		$col10=array(141, 62, 175);
		$col11=array(141, 128, 62);
		
		switch ($_POST['tipo']) {
			case 'modalidade':
				require_once('../../classe/pmdc/modalidades.php');
				$modalidades = new modalidades();
				
				$modalidades -> inicializar();
				
				while ($p = mysql_fetch_array($resultado)) {
					$modalidades -> respostas[$p['tipo']]  = $p['qtd'];
				}
				
				$pdf->Ln(8);

				$valY = $pdf->GetY();				
				$pdf->SetXY(25, $valY + 10);
				
				$pdf->PieChart(140, 140, $modalidades -> respostas, $modalidades -> descricao, '%l (%p)',array($col1,$col2,$col3,$col4,$col5,$col6,$col7));
			break;
			case 'status':
				require_once('../../classe/status.php');
				$status = new status();
				
				$status -> inicializar();
				
				while ($p = mysql_fetch_array($resultado)) {
					$status -> respostas[$p['tipo']]  = $p['qtd'];
				}
				
				$pdf->Ln(8);

				$valY = $pdf->GetY();				
				$pdf->SetXY(25, $valY + 10);
				
				$pdf->PieChart(140, 140, $status -> respostas, $status -> descricao, '%l (%p)',array($col1,$col2,$col3,$col4,$col5,$col6));
			break;
			case 'deficiencia':
				require_once('../../classe/deficiencia.php');
				$deficiencia = new deficiencia();
				
				$deficiencia -> inicializar();
				
				while ($p = mysql_fetch_array($resultado)) {
					$deficiencia -> respostas[$p['tipo']]  = $p['qtd'];
				}
				
				$pdf->Ln(8);

				$valY = $pdf->GetY();				
				$pdf->SetXY(25, $valY + 10);
				
				$pdf->PieChart(140, 140, $deficiencia -> respostas, $deficiencia -> descricao, '%l (%p)',array($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10,$col11));
			break;
			case 'tipo_usuario':
				require_once('../../classe/tipo_usuario.php');
				$tipo_usuario = new tipo_usuario();
				
				$tipo_usuario -> inicializar();
				
				while ($p = mysql_fetch_array($resultado)) {
					$tipo_usuario -> respostas[$p['tipo']]  = $p['qtd'];
				}
				
				$pdf->Ln(8);

				$valY = $pdf->GetY();				
				$pdf->SetXY(25, $valY + 10);
				
				$pdf->PieChart(140, 140, $tipo_usuario -> respostas, $tipo_usuario -> descricao, '%l (%p)',array($col1,$col2,$col3,$col4,$col5));
			break;
			case 'tipo_manifestacao':
				require_once('../../classe/pmdc/tipos.php');
				$tipos = new tipos();
				
				$tipos -> inicializar();
				
				while ($p = mysql_fetch_array($resultado)) {
					$tipos -> respostas[$p['tipo']]  = $p['qtd'];
				}
				
				$pdf->Ln(8);

				$valY = $pdf->GetY();				
				$pdf->SetXY(25, $valY + 10);
				
				$pdf->PieChart(140, 140, $tipos -> respostas, $tipos -> descricao, '%l (%p)',array($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8));
			break;
			case 'canais':
				require_once('../../classe/canais.php');
				$canais = new canais();
				
				$canais -> inicializar();
				
				while ($p = mysql_fetch_array($resultado)) {
					$canais -> respostas[$p['tipo']]  = $p['qtd'];
				}
				
				$pdf->Ln(8);

				$valY = $pdf->GetY();				
				$pdf->SetXY(25, $valY + 10);
				
				$pdf->PieChart(140, 140, $canais -> respostas, $canais -> descricao, '%l (%p)',array($col1,$col2,$col3,$col4,$col5));
			break;
		}
	}
	//grafico de barras
	else {
		$comparativo = array();
		$quant = array();
		$total = 0;
		while ($p = mysql_fetch_array($resultado)) {
			$comparativo[$p['tipo']] = $p['qtd'];
			$quant[$p['tipo']] = $p['tipo'];
			$total += $p['qtd'];
		}
		$comparativo['total'] = $total;
		$quant['total'] = 'Total consolidado';
		
		$pdf->BarDiagram(90, 20, $comparativo, '%l : %v (%p)', $quant, $col, $pdf->gety()+5, 2);
	}
}

$pdf->Output();
?>