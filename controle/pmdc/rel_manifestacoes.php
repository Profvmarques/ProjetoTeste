<?php
require_once('../../classe/conexao.php');
require_once('../../classe/pmdc/processos.php');
require_once('../../classe/entidades.php');
require_once('../../classe/pmdc/tipos.php');

$processos = new processos();
$entidades = new entidades();
$tipos = new tipos();
$conexao = new conexao();

require('fpdf/fpdf.php');       			
define('FPDF_FONTPATH','fpdf/font/');
$pdf=new FPDF('P','mm','A4');				

$pdf->SetMargins(10,10);
//$pdf->AddPage();							
$pdf->SetFont('Arial','B',16);				

//cores
$col1=array(173, 30, 6);
$col2=array(232, 148, 48);
$col3=array(189, 163, 242);
$col4=array(4, 121, 203);
$col5=array(32, 164, 232);
$col6=array(19, 132, 4);
$col7=array(129, 200, 97);
$col8=array(246, 122, 1);
//$col9=array(177, 163, 4);
//$col10=array(131, 131, 126);
//$col11=array(145, 3, 147);

//cores para o grafico de barras
$col[0]=array(232, 148, 48);
$col[1]=array(4, 121, 203);
$col[2]=array(32, 164, 232);
$col[3]=array(19, 132, 4);
$col[4]=array(129, 200, 97);

$comp = '';

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
	
$comp = " and date(ouv_processo.data_ini) between '".$data_inicial."' and '".$data_final."'";

if ($_POST['status'] != '') {
	require_once('../../classe/status.php');
	$status = new status();
	
	$desc_status = $status -> desc_status($_POST['status']);
}

if ($_POST['tipo_usuario'] != '') {
	require_once('../../classe/tipo_usuario.php');
	$tipo_usuario = new tipo_usuario();
	
	$desc_tipo = $tipo_usuario -> desc_tipo($_POST['tipo_usuario']);
}

if ($_POST['subitem'] != '') {
	require_once('../../classe/sub_item.php');
	$sub_item = new sub_item();
	
	$desc_sub = mysql_result($sub_item -> detalhes($_POST['subitem']),0,'subitem');
}

$id_entidade = $_POST['entidade'];

//Relatório para uma entidade
if ($id_entidade!="") {
	$tot = $entidades -> contar($id_entidade,$comp,$_POST['status'],$_POST['tipo_usuario'],$_POST['subitem']);

	$res = $entidades -> detalhes($id_entidade);
	$nome_entidade = mysql_result($res,0,'entidade');

    $pdf->AddPage();
	if ($tot==0) {
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'FUNDAÇÃO DE APOIO A ESCOLA TÉCNICA',0,1,'C');

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA',0,1,'C');
		$pdf->Cell(0,10,'NÃO HÁ RESULTADOS PARA A ENTIDADE: '.$nome_entidade,0,1,'C');
		
		if ($_POST['status'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Status: ".$desc_status,0,1,'C');
		}
		
		if ($_POST['tipo_usuario'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Tipo de Usuário: ".$desc_tipo,0,1,'C');
		}
		
		if ($_POST['subitem'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Subitem: ".$desc_sub,0,1,'C');
		}
	}
	else {
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'FUNDAÇÃO DE APOIO A ESCOLA TÉCNICA',0,1,'C');

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA - '.$nome_entidade,0,1,'C');
		$pdf->Cell(0,10,'Tipologia das manifestações recebidas',0,1,'C');
		
		if ($_POST['data_inicial'] != '' && $_POST['data_final'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Período: ".$_POST['data_inicial']." até ".$_POST['data_final'],0,1,'C');
		}
		
		if ($_POST['status'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Status: ".$desc_status,0,1,'C');
		}
		
		if ($_POST['tipo_usuario'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Tipo de Usuário: ".$desc_tipo,0,1,'C');
		}
		
		if ($_POST['subitem'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Subitem: ".$desc_sub,0,1,'C');
		}
		
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50,5,'TIPO',1,0,'C');
		$pdf->Cell(50,5,'Quantidade',1,0,'C');
		$pdf->Cell(50,5,'Percentual (%)',1,1,'C');
		$pdf->SetFont('Arial','B',8);

		$r = $tipos -> listar();
		$total = mysql_num_rows($r);
		

		$total_tipo=0;
		$total_percent=0;

		for ($i=1;$i<=$total;$i++) {
			$tipo = $tipos -> nome_tipo($i);
			
			$quantidade = $processos -> contar($i,$id_entidade,$comp,$_POST['status'],$_POST['tipo_usuario'],$_POST['subitem']);

			$percent=($quantidade/$tot)*100;

			$total_tipo+=$quantidade;
			$total_percent+=$percent;

			$pdf->Cell(50,5,$tipo,1,0,'C');
			$pdf->Cell(50,5,$quantidade,1,0,'C');
			$pdf->Cell(50,5,number_format($percent,2),1,1,'C');
		}
		$pdf->Cell(50,5,'Total',1,0,'C');
		$pdf->Cell(50,5,$total_tipo,1,0,'C');
		$pdf->Cell(50,5,number_format($total_percent,2),1,1,'C');
		
		//inicializar os arrays de resposta e descricao
		$tipos -> inicializar();
		//buscar tipos de cada registro de um segmento da tabela ouvidoria
		$resultado = $processos -> buscar_tipos($_POST['entidade'],$comp,$_POST['status'],$_POST['tipo_usuario'],$_POST['subitem']);
		
		//percorre as mensagens e incrementa a soma de cada tipo
		while ($r = mysql_fetch_array($resultado)) {
			$tipos -> respostas[$r['id_tipo']] ++;
		}
		
		$pdf->Ln(8);
		
		$valY = $pdf->GetY();				
		$pdf->SetXY(25, $valY + 10);

		//pizza
		$pdf->PieChart(140, 140, $tipos -> respostas, $tipos -> descricao, '%l (%p)',array($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8));
		
		//barras
		$pdf->AddPage();
		
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'FUNDAÇÃO DE APOIO A ESCOLA TÉCNICA',0,1,'C');

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA - '.$nome_entidade,0,1,'C');
		$pdf->Cell(0,10,'Número de manifestações diárias',0,1,'C');
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(0,10,"Período: ".$_POST['data_inicial']." até ".$_POST['data_final'],0,1,'C');

		if ($_POST['status'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Status: ".$desc_status,0,1,'C');
		}
		
		if ($_POST['tipo_usuario'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Tipo de Usuário: ".$desc_tipo,0,1,'C');
		}
		
		if ($_POST['subitem'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Subitem: ".$desc_sub,0,1,'C');
		}
		
		$resultado = $processos -> processos_por_dia($data_inicial, $data_final, $_POST['entidade'], $_POST['status'], $_POST['tipo_usuario'],$_POST['subitem']);
		$pordia = array();
		while ($p = mysql_fetch_array($resultado)) {
			$pordia[$p['data']] = $p['total'];
			$datas[$p['data']] = $p['data'];
		}
		$pdf->SetFont('Arial','B',9);
		$pdf->SetX(7);
		$pdf->Cell(20,3,"Dia",0,0,'L');
		$pdf->Cell(10,3,"Quantidade",0,1,'L');
		$pdf->Ln(5);
		$pdf->BarDiagram(90, 20, $pordia, '%l : %v (%p)', $datas, $col, $pdf->gety()+6, 1);
	}
}
//Relatório para todas as entidades
else {
	$lista_entidades = $entidades -> listar(0);
	$tot = $entidades -> contar('',$comp,$_POST['status'],$_POST['tipo_usuario'],$_POST['subitem']);
	$res = $entidades -> detalhes($id_entidade);
	$nome_entidades = mysql_result($res,0,'entidade');

	$pdf->AddPage();
	if ($tot==0) {
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'FUNDAÇÃO DE APOIO A ESCOLA TÉCNICA',0,1,'C');

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA',0,1,'C');
		$pdf->Cell(0,10,'NÃO HÁ RESULTADOS PARA A DIRETORIA: TODAS AS DIRETORIAS',0,1,'C');
		
		if ($_POST['status'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Status: ".$desc_status,0,1,'C');
		}
		
		if ($_POST['tipo_usuario'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Tipo de Usuário: ".$desc_tipo,0,1,'C');
		}
		
		if ($_POST['subitem'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Subitem: ".$desc_sub,0,1,'C');
		}
	}
	else {
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'FUNDAÇÃO DE APOIO A ESCOLA TÉCNICA',0,1,'C');

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA - TODAS AS DIRETORIAS',0,1,'C');
		$pdf->Cell(0,10,'Tipologia das manifestações recebidas',0,1,'C');
		
		if ($_POST['data_inicial'] != '' && $_POST['data_final'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Período: ".$_POST['data_inicial']." até ".$_POST['data_final'],0,1,'C');
		}
		
		if ($_POST['status'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Status: ".$desc_status,0,1,'C');
		}
		
		if ($_POST['tipo_usuario'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Tipo de Usuário: ".$desc_tipo,0,1,'C');
		}
		
		if ($_POST['subitem'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Subitem: ".$desc_sub,0,1,'C');
		}
		
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50,5,'TIPO',1,0,'C');
		$pdf->Cell(50,5,'Quantidade',1,0,'C');
		$pdf->Cell(50,5,'Percentual (%)',1,1,'C');
		$pdf->SetFont('Arial','B',8);

		$r = $tipos -> listar();
		$total = mysql_num_rows($r);
		

		$total_tipo=0;
		$total_percent=0;

		for ($i=1;$i<=$total;$i++) {
			$tipo = $tipos -> nome_tipo($i);
			
			$quantidade = $processos -> contar($i,'',$comp,$_POST['status'],$_POST['tipo_usuario'],$_POST['subitem']);

			$percent=($quantidade/$tot)*100;

			$total_tipo+=$quantidade;
			$total_percent+=$percent;

			$pdf->Cell(50,5,$tipo,1,0,'C');
			$pdf->Cell(50,5,$quantidade,1,0,'C');
			$pdf->Cell(50,5,number_format($percent,2),1,1,'C');
		}
		$pdf->Cell(50,5,'Total',1,0,'C');
		$pdf->Cell(50,5,$total_tipo,1,0,'C');
		$pdf->Cell(50,5,number_format($total_percent,2),1,1,'C');
		
		//inicializar os arrays de resposta e descricao
		$tipos -> inicializar();
		//buscar tipos de cada registro de um segmento da tabela ouvidoria
		$resultado = $processos -> buscar_tipos('',$comp,$_POST['status'],$_POST['tipo_usuario'],$_POST['subitem']);
		
		//percorre as mensagens e incrementa a soma de cada tipo
		while ($r = mysql_fetch_array($resultado)) {
			$tipos -> respostas[$r['id_tipo']] ++;
		}
		
		$pdf->Ln(8);
		
		$valY = $pdf->GetY();				
		$pdf->SetXY(25, $valY + 10);

		//pizza
		$pdf->PieChart(140, 140, $tipos -> respostas, $tipos -> descricao, '%l (%p)',array($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8));
		
		//barras
		$pdf->AddPage();
		
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'FUNDAÇÃO DE APOIO A ESCOLA TÉCNICA',0,1,'C');

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA - TODAS AS DIRETORIAS',0,1,'C');
		$pdf->Cell(0,10,'Número de manifestações diárias',0,1,'C');
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(0,10,"Período: ".$_POST['data_inicial']." até ".$_POST['data_final'],0,1,'C');

		if ($_POST['status'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Status: ".$desc_status,0,1,'C');
		}
		
		if ($_POST['tipo_usuario'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Tipo de Usuário: ".$desc_tipo,0,1,'C');
		}
		
		if ($_POST['subitem'] != '') {
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(0,10,"Subitem: ".$desc_sub,0,1,'C');
		}
		
		$resultado = $processos -> processos_por_dia($data_inicial, $data_final, '', $_POST['status'], $_POST['tipo_usuario'],$_POST['subitem']);
		$pordia = array();
		while ($p = mysql_fetch_array($resultado)) {
			$pordia[$p['data']] = $p['total'];
			$datas[$p['data']] = $p['data'];
		}
		$pdf->SetFont('Arial','B',9);
		$pdf->SetX(7);
		$pdf->Cell(20,3,"Dia",0,0,'L');
		$pdf->Cell(10,3,"Quantidade",0,1,'L');
		$pdf->Ln(5);
		$pdf->BarDiagram(90, 20, $pordia, '%l : %v (%p)', $datas, $col, $pdf->gety()+6, 1);
	}
}

$pdf->Output();
?>