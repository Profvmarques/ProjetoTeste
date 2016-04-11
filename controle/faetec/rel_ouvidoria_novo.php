<?php
set_time_limit(99999999);
session_start();

if ($_POST['data_inicial'] != '' && $_POST['data_final'] != '') {
	$i = explode("/",$_POST['data_inicial']);
	$inicio = $i[2]."-".$i[1]."-".$i[0];
	$f = explode("/",$_POST['data_final']);
	$fim = $f[2]."-".$f[1]."-".$f[0];
	$datas = " and date(ouv_processo.data_ini) between '".$inicio."' and '".$fim."'";
}

require_once('../../classe/conexao.php');
require_once('../../classe/faetec/processos.php');
require_once('../../classe/entidades.php');
require_once('../../classe/faetec/tipos.php');
require_once('../../classe/canais.php');

$processos = new processos();
$entidades = new entidades();
$tipos = new tipos();
$canais = new canais();
$conexao = new conexao();

require('fpdf/fpdf.php');       			
define('FPDF_FONTPATH','fpdf/font/');

$pdf=new FPDF('P','mm','A4');				
$pdf->SetMargins(10,10);
$pdf->AddPage();							
$pdf->SetFont('Arial','B',16);				

$tot = $processos -> contar(0,1,$datas);

if ($tot > 0) {
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

	$pdf->Cell(0,10,'FUNDAÇÃO DE APOIO A ESCOLA TÉCNICA',0,1,'C');

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA',0,1,'C');
	$pdf->Cell(0,10,'Tipologia das manifestações recebidas',0,1,'C');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(50,5,'TIPO',1,0,'C');
	$pdf->Cell(50,5,'Quantidade',1,0,'C');
	$pdf->Cell(50,5,'Percentual (%)',1,1,'C');
	$pdf->SetFont('Arial','B',8);

	$lista_tipos = $tipos -> listar();

	$total_tipo=0;
	$total_percent=0;

	while ($l = mysql_fetch_array($lista_tipos)) {
		$tipo = $tipos -> nome_tipo($l['id_tipo']);
		$quantidade = $processos -> contar($l['id_tipo'],0,$datas);
		$percent=($quantidade/$tot)*100;
		
		$total_tipo+=$quantidade;
		$total_percent+=$percent;

		$pdf->Cell(50,5,$tipo,1,0,'C');
		$pdf->Cell(50,5,$quantidade,1,0,'C');
		$pdf->Cell(50,5,number_format($percent,2),1,1,'C');
	}

	$pdf->Cell(50,5,'Total',1,0,'C');
	$pdf->Cell(50,5,$total_tipo,1,0,'C');
	$pdf->Cell(50,5,$total_percent,1,1,'C');

	//inicializar os arrays de resposta e descricao
	$tipos -> inicializar();
	//buscar tipos de cada registro da tabela ouvidoria
	$resultado = $processos -> buscar_tipos(0,$datas);

	//percorre as mensagens e incrementa a soma de cada tipo
	while ($r = mysql_fetch_array($resultado)) {
		$tipos -> respostas[$r['id_tipo']] ++;
	}

	$pdf->Ln(8);
		
	$valY = $pdf->GetY();				
	$pdf->SetXY(25, $valY + 10);

	//pizza
	$pdf->PieChart(140, 140, $tipos -> respostas, $tipos -> descricao, '%l (%p)',array($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8));


	//************************Comportamento segundo os canais de acesso

	$pdf->AddPage();							
	$pdf->SetFont('Arial','B',16);				


	//cores
	$col1=array(173, 30, 6);
	$col2=array(232, 148, 48);
	$col3=array(189, 163, 242);
	$col4=array(4, 121, 203);
	$col5=array(32, 164, 232);
	//$col6=array(19, 132, 4);
	//$col7=array(129, 200, 97);
	//$col8=array(246, 122, 1);
	//$col9=array(177, 163, 4);
	//$col10=array(131, 131, 126);
	//$col11=array(145, 3, 147);



	$pdf->Cell(0,10,'FUNDAÇÃO DE APOIO A ESCOLA TÉCNICA',0,1,'C');

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA',0,1,'C');
	$pdf->Cell(0,10,'Comportamento segundo os canais de acesso',0,1,'C');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(50,5,'Canais',1,0,'C');
	$pdf->Cell(50,5,'Quantidade',1,0,'C');
	$pdf->Cell(50,5,'Percentual (%)',1,1,'C');
	$pdf->SetFont('Arial','B',8);


	$lista_canais = $canais -> listar();

	$tot = $processos -> contar_total_canais($datas);

	$total_tipo=0;
	$total_percent=0;

	while ($l = mysql_fetch_array($lista_canais)) {
		$tipo = $canais -> nome_canal($l['id_canal']);
		$quantidade = $processos -> contar_canal($l['id_canal'],$datas);
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
	$canais -> inicializar();
	//buscar canais de cada registro da tabela ouvidoria
	$resultado = $processos -> buscar_canais($datas);

	//percorre as mensagens e incrementa a soma de cada canal
	while ($r = mysql_fetch_array($resultado)) {
		$canais -> respostas[$r['id_canal']] ++;
	}

	$pdf->Ln(8);
		
	$valY = $pdf->GetY();				
	$pdf->SetXY(25, $valY + 10);

	//barras
	$pdf->SetFont('Arial','B',9);
	$pdf->Ln(8);
	$pdf->SetX(7);
	$pdf->Cell(32,3,"Canais",0,0,'L');
	$pdf->Cell(15,3,"Quantidade",0,1,'L');
	$pdf->Ln(5);
	$pdf->BarDiagram(90, 20, $canais -> respostas, '%l : %v (%p)', $canais -> descricao, $col, $pdf->gety()+6, 3);

	//************************Comportamento das Demandas por Entidade Vinculada

	$pdf->AddPage();

	//cores
	$col1=array(173, 30, 6);
	$col2=array(232, 148, 48);
	$col3=array(189, 163, 242);
	$col4=array(4, 121, 203);
	$col5=array(32, 164, 232);
	$col6=array(19, 132, 4);
	$col7=array(129, 200, 97);
	$col8=array(246, 122, 1);
	$col9=array(177, 163, 4);
	$col10=array(131, 131, 126);
	$col11=array(145, 3, 147);

	$pdf->SetFont('Arial','B',16);	
	$pdf->Cell(0,10,'FUNDAÇÃO DE APOIO A ESCOLA TÉCNICA',0,1,'C');

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA',0,1,'C');
	$pdf->Cell(0,10,'COMPORTAMENTO DAS DEMANDAS POR ENTIDADE VINCULADA',0,1,'C');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(75,5,'Fluxo das manifestações recebidas',1,0,'C');
	$pdf->Cell(50,5,'Quantidade',1,0,'C');
	$pdf->Cell(50,5,'Percentual (%)',1,1,'C');
	$pdf->SetFont('Arial','B',8);

	$lista_entidades = $entidades -> listar(1);

	$tot = $processos -> contar_entidades(1,$datas);

	$total_entidade=0;
	$total_percent=0;

	while ($l = mysql_fetch_array($lista_entidades)) {
		$quantidade = $processos -> contar_entidades_geral($l['id_entidade'],$datas);
		$percent=($quantidade/$tot)*100;

		$total_entidade+=$quantidade;
		$total_percent+=$percent;

		$pdf->Cell(75,5,$l['entidade'],1,0,'L');
		$pdf->Cell(50,5,$quantidade,1,0,'C');
		$pdf->Cell(50,5,number_format($percent,2),1,1,'C');
	}

	$pdf->Cell(75,5,'Total',1,0,'C');
	$pdf->Cell(50,5,$total_entidade,1,0,'C');
	$pdf->Cell(50,5,$total_percent,1,1,'C');

	/*
	//inicializar os arrays de resposta e descricao
	$entidades -> inicializar();
	//buscar tipos de cada registro da tabela ouvidoria
	$resultado = $processos -> buscar_entidades($datas);

	//percorre as mensagens e incrementa a soma de cada entidade
	while ($r = mysql_fetch_array($resultado)) {
		$entidades -> respostas[$r['id_entidade']] ++;
	}
	$pdf->Ln(8);
		
	$valY = $pdf->GetY();				
	$pdf->SetXY(25, $valY + 10);

	//pizza
	$pdf->PieChart(140, 140, $entidades -> respostas, $entidades -> descricao, '%l (%p)',array($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10,$col11));*/
}
else {
	$pdf->Cell(0,5,'Nenhuma manifestação encontrada',0,0,'C');
}
$pdf->Output();
?>