<?php
set_time_limit(99999999);
session_start();

require_once('../../classe/conexao.php');
require_once('../../classe/pmdc/processos.php');
require_once('../../classe/entidades.php');
require_once('../../classe/pmdc/tipos.php');
require_once('../../classe/canais.php');
require_once('../../classe/pmdc/assuntos.php');

$processos = new processos();
$entidades = new entidades();
$tipos = new tipos();
$canais = new canais();
$assuntos = new assuntos();
$conexao = new conexao();

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

//cores para o grafico de barras
$col[0]=array(232, 148, 48);
$col[1]=array(4, 121, 203);
$col[2]=array(32, 164, 232);
$col[3]=array(19, 132, 4);
$col[4]=array(129, 200, 97);

$datas = '';
if ($_POST['data_inicial'] != '' && $_POST['data_final'] != '') {
	$datas['inicial'] = $_POST['data_inicial'];
	$datas['final'] = $_POST['data_final'];
}

$pdf->Cell(0,10,'SECRETARIA DE CIÊNCIA E TECNOLOGIA',0,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA',0,1,'C');
$pdf->Cell(0,10,'Tipologia das manifestações recebidas',0,1,'C');
if ($datas != '') {
	$pdf->Cell(0,10,"Período: de ".$datas['inicial']." até ".$datas['final'],0,1,'C');
}
$pdf->Ln(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50,5,'TIPO',1,0,'C');
$pdf->Cell(50,5,'Quantidade',1,0,'C');
$pdf->Cell(50,5,'Percentual (%)',1,1,'C');
$pdf->SetFont('Arial','B',8);

$lista_tipos = $tipos -> listar();

$datas = '';
if ($_POST['data_inicial'] != '' && $_POST['data_final'] != '') {
	$datas['inicial'] = $_POST['data_inicial'];
	$datas['final'] = $_POST['data_final'];
}

$tot = $processos -> contar($datas);

$total_tipo=0;
$total_percent=0;


while ($l = mysql_fetch_array($lista_tipos)) {
	$tipo = $tipos -> nome_tipo($l['id_tipo']);
	$quantidade = $processos -> contar($datas,$l['id_tipo']);
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
$resultado = $processos -> buscar_tipos($datas);

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

$pdf->AddPage('L');							
$pdf->SetFont('Arial','B',16);				


//cores
$col1=array(173, 30, 6);
$col2=array(232, 148, 48);
$col3=array(189, 163, 242);
$col4=array(4, 121, 203);
$col5=array(32, 164, 232);

$pdf->Cell(0,10,'SECRETARIA DE CIÊNCIA E TECNOLOGIA',0,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA',0,1,'C');
$pdf->Cell(0,10,'Comportamento segundo os canais de acesso',0,1,'C');
if ($datas != '') {
	$pdf->Cell(0,10,"Período: de ".$datas['inicial']." até ".$datas['final'],0,1,'C');
}
$pdf->Ln(5);
$pdf->SetFont('Arial','B',10);
$pdf->setx(70);
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
	$quantidade = $processos -> contar_canal($datas,$l['id_canal']);
	$percent=($quantidade/$tot)*100;

	$total_tipo+=$quantidade;
	$total_percent+=$percent;

	$pdf->setx(70);
	$pdf->Cell(50,5,$tipo,1,0,'C');
	$pdf->Cell(50,5,$quantidade,1,0,'C');
	$pdf->Cell(50,5,number_format($percent,2),1,1,'C');
}

$pdf->setx(70);
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

$valY = $pdf->GetY();				
$pdf->SetXY(25, $valY + 10);
//print_r($canais -> descricao);
//print_r($canais -> respostas);
//barras
$pdf->SetFont('Arial','B',9);
$pdf->Ln(8);
$pdf->SetX(7);
$pdf->Cell(32,3,"Canais",0,0,'L');
$pdf->Cell(15,3,"Quantidade",0,1,'L');
$pdf->Ln(5);
$pdf->BarDiagram(90, 20, $canais -> respostas, '%l : %v (%p)', $canais -> descricao, $col, $pdf->gety()+6, 3);

//************************Comportamento das Demandas por Entidade Vinculada

$pdf->AddPage('L');

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
if ($datas != '') {
	$pdf->Cell(0,10,"Período: de ".$datas['inicial']." até ".$datas['final'],0,1,'C');
}
$pdf->Ln(5);
$coluna_descricao = 90;
$coluna_informacao = 21;
$coluna_sugestao = 20;
$coluna_reclamacao = 22;
$coluna_elogio = 17;
$coluna_agradecimento = 25;
$coluna_outros = 19;
$coluna_solicitacao = 22;
$coluna_denuncia = 22;
$coluna_total = 25;
$pdf->SetFont('Arial','B',8);
$pdf->Cell($coluna_descricao,5,'Fluxo das manifestações recebidas',1,0,'C');
$pdf->Cell($coluna_informacao,5,'Informação',1,0,'C');
$pdf->Cell($coluna_sugestao,5,'Sugestão',1,0,'C');
$pdf->Cell($coluna_reclamacao,5,'Reclamação',1,0,'C');
$pdf->Cell($coluna_elogio,5,'Elogio',1,0,'C');
$pdf->Cell($coluna_agradecimento,5,'Agradecimento',1,0,'C');
$pdf->Cell($coluna_outros,5,'Outros',1,0,'C');
$pdf->Cell($coluna_solicitacao,5,'Solicitação',1,0,'C');
$pdf->Cell($coluna_denuncia,5,'Denúncia',1,0,'C');
$pdf->Cell($coluna_valores,5,'Total',1,1,'C');
$pdf->SetFont('Arial','',8);

$lista_entidades = $processos -> comportamento_demandas($datas);

$total_informacao = 0;
$total_sugestao = 0;
$total_reclamacao = 0;
$total_elogio = 0;
$total_agradecimento = 0;
$total_outros = 0;
$total_solicitacao = 0;
$total_denuncia = 0;
$total_geral = 0;

while ($l = mysql_fetch_array($lista_entidades)) {
	$pdf->Cell($coluna_descricao,5,$l['entidade'],1,0,'L');
	$pdf->Cell($coluna_informacao,5,intval($l['informacao']),1,0,'C');
	$pdf->Cell($coluna_sugestao,5,intval($l['sugestao']),1,0,'C');
	$pdf->Cell($coluna_reclamacao,5,intval($l['reclamacao']),1,0,'C');
	$pdf->Cell($coluna_elogio,5,intval($l['elogio']),1,0,'C');
	$pdf->Cell($coluna_agradecimento,5,intval($l['agradecimento']),1,0,'C');
	$pdf->Cell($coluna_outros,5,intval($l['outros']),1,0,'C');
	$pdf->Cell($coluna_solicitacao,5,intval($l['solicitacao']),1,0,'C');
	$pdf->Cell($coluna_denuncia,5,intval($l['denuncia']),1,0,'C');
	$pdf->Cell($coluna_valores,5,intval($l['total']),1,1,'C');

	$total_informacao += $l['informacao'];
	$total_sugestao += $l['sugestao'];
	$total_reclamacao += $l['reclamacao'];
	$total_elogio += $l['elogio'];
	$total_agradecimento += $l['agradecimento'];
	$total_outros += $l['outros'];
	$total_solicitacao += $l['solicitacao'];
	$total_denuncia += $l['denuncia'];
	$total_geral += $l['total'];
}

$pdf->SetFont('Arial','B',8);
$pdf->Cell($coluna_descricao,5,'Total',1,0,'C');
$pdf->Cell($coluna_informacao,5,$total_informacao,1,0,'C');
$pdf->Cell($coluna_sugestao,5,$total_sugestao,1,0,'C');
$pdf->Cell($coluna_reclamacao,5,$total_reclamacao,1,0,'C');
$pdf->Cell($coluna_elogio,5,$total_elogio,1,0,'C');
$pdf->Cell($coluna_agradecimento,5,$total_agradecimento,1,0,'C');
$pdf->Cell($coluna_outros,5,$total_outros,1,0,'C');
$pdf->Cell($coluna_solicitacao,5,$total_solicitacao,1,0,'C');
$pdf->Cell($coluna_denuncia,5,$total_denuncia,1,0,'C');
$pdf->Cell($coluna_valores,5,$total_geral,1,1,'C');


//************************Comportamento das Demandas por Assunto

$pdf->AddPage('L');

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
$pdf->Cell(0,10,'COMPORTAMENTO DAS DEMANDAS POR ASSUNTO',0,1,'C');
if ($datas != '') {
	$pdf->Cell(0,10,"Período: de ".$datas['inicial']." até ".$datas['final'],0,1,'C');
}
$pdf->Ln(5);
$pdf->SetFont('Arial','B',8);
$pdf->Cell($coluna_descricao,5,'Fluxo das manifestações recebidas',1,0,'C');
$pdf->Cell($coluna_informacao,5,'Informação',1,0,'C');
$pdf->Cell($coluna_sugestao,5,'Sugestão',1,0,'C');
$pdf->Cell($coluna_reclamacao,5,'Reclamação',1,0,'C');
$pdf->Cell($coluna_elogio,5,'Elogio',1,0,'C');
$pdf->Cell($coluna_agradecimento,5,'Agradecimento',1,0,'C');
$pdf->Cell($coluna_outros,5,'Outros',1,0,'C');
$pdf->Cell($coluna_solicitacao,5,'Solicitação',1,0,'C');
$pdf->Cell($coluna_denuncia,5,'Denúncia',1,0,'C');
$pdf->Cell($coluna_valores,5,'Total',1,1,'C');
$pdf->SetFont('Arial','',8);

$lista_assunto = $assuntos -> listar(1);
$array_assuntos = array();
while ($l = mysql_fetch_array($lista_assunto)) {
	$array_assuntos[$l['id_assunto']]['assunto'] = $l['assunto'];
}

$resultado_assunto = $processos -> comportamento_assuntos($datas);
while ($l = mysql_fetch_array($resultado_assunto)) {
	$array_assuntos[$l['id_assunto']]['informacao'] = $l['informacao'];
	$array_assuntos[$l['id_assunto']]['sugestao'] = $l['sugestao'];
	$array_assuntos[$l['id_assunto']]['reclamacao'] = $l['reclamacao'];
	$array_assuntos[$l['id_assunto']]['elogio'] = $l['elogio'];
	$array_assuntos[$l['id_assunto']]['agradecimento'] = $l['agradecimento'];
	$array_assuntos[$l['id_assunto']]['outros'] = $l['outros'];
	$array_assuntos[$l['id_assunto']]['solicitacao'] = $l['solicitacao'];
	$array_assuntos[$l['id_assunto']]['denuncia'] = $l['denuncia'];
	$array_assuntos[$l['id_assunto']]['total'] = $l['total'];
}

$total_informacao = 0;
$total_sugestao = 0;
$total_reclamacao = 0;
$total_elogio = 0;
$total_agradecimento = 0;
$total_outros = 0;
$total_solicitacao = 0;
$total_denuncia = 0;
$total_geral = 0;

foreach ($array_assuntos as $id => $ass) {
	$pdf->Cell($coluna_descricao,5,$ass['assunto'],1,0,'L');
	$pdf->Cell($coluna_informacao,5,intval($ass['informacao']),1,0,'C');
	$pdf->Cell($coluna_sugestao,5,intval($ass['sugestao']),1,0,'C');
	$pdf->Cell($coluna_reclamacao,5,intval($ass['reclamacao']),1,0,'C');
	$pdf->Cell($coluna_elogio,5,intval($ass['elogio']),1,0,'C');
	$pdf->Cell($coluna_agradecimento,5,intval($ass['agradecimento']),1,0,'C');
	$pdf->Cell($coluna_outros,5,intval($ass['outros']),1,0,'C');
	$pdf->Cell($coluna_solicitacao,5,intval($ass['solicitacao']),1,0,'C');
	$pdf->Cell($coluna_denuncia,5,intval($ass['denuncia']),1,0,'C');
	$pdf->Cell($coluna_valores,5,intval($ass['total']),1,1,'C');

	$total_informacao += $ass['informacao'];
	$total_sugestao += $ass['sugestao'];
	$total_reclamacao += $ass['reclamacao'];
	$total_elogio += $ass['elogio'];
	$total_agradecimento += $ass['agradecimento'];
	$total_outros += $ass['outros'];
	$total_solicitacao += $ass['solicitacao'];
	$total_denuncia += $ass['denuncia'];
	$total_geral += $ass['total'];
}

$pdf->SetFont('Arial','B',8);
$pdf->Cell($coluna_descricao,5,'Total',1,0,'C');
$pdf->Cell($coluna_informacao,5,$total_informacao,1,0,'C');
$pdf->Cell($coluna_sugestao,5,$total_sugestao,1,0,'C');
$pdf->Cell($coluna_reclamacao,5,$total_reclamacao,1,0,'C');
$pdf->Cell($coluna_elogio,5,$total_elogio,1,0,'C');
$pdf->Cell($coluna_agradecimento,5,$total_agradecimento,1,0,'C');
$pdf->Cell($coluna_outros,5,$total_outros,1,0,'C');
$pdf->Cell($coluna_solicitacao,5,$total_solicitacao,1,0,'C');
$pdf->Cell($coluna_denuncia,5,$total_denuncia,1,0,'C');
$pdf->Cell($coluna_valores,5,$total_geral,1,1,'C');

$pdf->Output();
?>