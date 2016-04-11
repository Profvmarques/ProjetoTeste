<?php
set_time_limit(99999999);
require_once('../../classe/conexao.php');
require_once('../../classe/backup/processo.php');
require_once('../../classe/entidades.php');
require_once('../../classe/assuntos.php');
require_once('../../classe/canais.php');

$processo = new processo();
$entidades = new entidades();
$assuntos = new assuntos();
$canais = new canais();
$conexao = new conexao();
session_start();

require('fpdf/fpdf.php');       			
define('FPDF_FONTPATH','fpdf/font/');

$pdf=new FPDF('P','mm','A4');				
$pdf->SetMargins(10,10);
$pdf->AddPage();							
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


$pdf->Cell(0,10,'SECRETARIA DE CIÊNCIA E TECNOLOGIA',0,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA',0,1,'C');
$pdf->Cell(0,10,'Tipologia das manifestações recebidas',0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50,5,'TIPO',1,0,'C');
$pdf->Cell(50,5,'Quantidade',1,0,'C');
$pdf->Cell(50,5,'Percentual (%)',1,1,'C');
$pdf->SetFont('Arial','B',8);

$lista_assuntos = $assuntos -> listar();

$tot = $processo -> contar(0,$_SESSION['entidade']);

$total_tipo=0;
$total_percent=0;


while ($l = mysql_fetch_array($lista_assuntos)) {
	$tipo = $assuntos -> nome_assunto($l['id_assunto']);
	$quantidade = $processo -> contar($l['id_assunto']);
	$percent = ($quantidade/$tot)*100;

	$total_tipo += $quantidade;
	$total_percent += $percent;

	$pdf->Cell(50,5,$tipo,1,0,'C');
	$pdf->Cell(50,5,$quantidade,1,0,'C');
	$pdf->Cell(50,5,number_format($percent,2),1,1,'C');
}
$pdf->Cell(50,5,'Total',1,0,'C');
$pdf->Cell(50,5,$total_tipo,1,0,'C');
$pdf->Cell(50,5,$total_percent,1,1,'C');

//inicializar os arrays de resposta e descricao
$assuntos -> inicializar();
//buscar assuntos de cada registro da tabela ouvidoria
$resultado = $processo -> buscar_assuntos();

//percorre as mensagens e incrementa a soma de cada assunto
while ($r = mysql_fetch_array($resultado)) {
	$assuntos -> respostas[$r['id_assunto']] ++;
}

$pdf->Ln(8);
	
$valY = $pdf->GetY();				
$pdf->SetXY(25, $valY + 10);

//pizza
$pdf->PieChart(140, 140, $assuntos -> respostas, $assuntos -> descricao, '%l (%p)',array($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8));


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



$pdf->Cell(0,10,'SECRETARIA DE CIÊNCIA E TECNOLOGIA',0,1,'C');

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

$tot = $processo -> contar(0,$_SESSION['entidade']);

$total_tipo=0;
$total_percent=0;

while ($l = mysql_fetch_array($lista_canais)) {
	$tipo = $canais -> nome_canal($l['id_canal']);
	$quantidade = $processo -> contar_canal($l['id_canal']);
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
$canais -> inicializar();
//buscar canais de cada registro da tabela ouvidoria
$resultado = $processo -> buscar_canais();

//percorre as mensagens e incrementa a soma de cada canal
while ($r = mysql_fetch_array($resultado)) {
	$canais -> respostas[$r['id_canal']] ++;
}

$pdf->Ln(8);
	
$valY = $pdf->GetY();				
$pdf->SetXY(25, $valY + 10);

//barras
$pdf->SetFont('Arial','B',9);
$pdf ->Ln(8);
$pdf->SetX(7);
$pdf->Cell(32,3,"Canais",0,0,'L');
$pdf->Cell(10,3,"Quantidade",0,1,'L');
$pdf->Ln(1);
$pdf->BarDiagram(90, 20, $canais -> respostas, '%l : %v (%p)', $canais -> descricao, $col, $pdf->gety()+10, 3);

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
$pdf->Cell(0,10,'SECRETARIA DE CIÊNCIA E TECNOLOGIA',0,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA',0,1,'C');
$pdf->Cell(0,10,'COMPORTAMENTO DAS DEMANDAS POR ENTIDADE VINCULADA',0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(75,5,'Fluxo das manifestações recebidas',1,0,'C');
$pdf->Cell(50,5,'Quantidade',1,0,'C');
$pdf->Cell(50,5,'Percentual (%)',1,1,'C');
$pdf->SetFont('Arial','B',8);

$lista_entidades = $entidades -> listar($_SESSION['entidade']);

$tot = $processo -> contar_entidades($_SESSION['entidade']);

$total_entidade=0;
$total_percent=0;

while ($l = mysql_fetch_array($lista_entidades)) {
	$quantidade = $processo -> contar_demanda($l['id_entidade']);
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

//inicializar os arrays de resposta e descricao
$entidades -> inicializar_backup();
//buscar assuntos de cada registro da tabela ouvidoria
$resultado = $processo -> buscar_entidades($_SESSION['entidade']);

//percorre as mensagens e incrementa a soma de cada entidade
while ($r = mysql_fetch_array($resultado)) {
	$entidades -> respostas[$r['id_entidade']] ++;
}
$pdf->Ln(8);
	
$valY = $pdf->GetY();				
$pdf->SetXY(25, $valY + 10);

//pizza
$pdf->PieChart(140, 140, $entidades -> respostas, $entidades -> descricao, '%l (%p)',array($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10,$col11));

$pdf->Output();
?>