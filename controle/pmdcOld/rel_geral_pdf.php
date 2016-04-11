<?php
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

//criar objeto da classe segmentos
require_once('../classe/faetec/segmentos.php');
$segmentos = new segmentos();
//criar objeto da classe tipos
require_once('../classe/faetec/tipos.php');
$tipos = new tipos();
//criar objeto da classe ouvidoria
require_once('../classe/faetec/ouvidoria.php');
$ouvidoria = new ouvidoria();

//total de registros na tabela ouvidoria
$tot = $ouvidoria -> contar();

/*-------------------------------------- Tipologia das manifestações recebidas --------------------------------------*/

$pdf->Cell(0,10,'FAETEC',0,1,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA',0,1,'C');
$pdf->Cell(0,10,'Tipologia das manifestações recebidas',0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50,5,'TIPO',1,0,'C');
$pdf->Cell(50,5,'Quantidade',1,0,'C');
$pdf->Cell(50,5,'Percentual (%)',1,1,'C');
$pdf->SetFont('Arial','B',8);

//listar os tipos
$lista_tipos = $tipos -> listar();

//total de cada tipo
$total_tipo = 0;
//total das porcentagem
$total_percent = 0;

while ($a = mysql_fetch_array($lista_tipos)) {
	//buscar o numero de mensagens para o tipo atual
	$quantidade = $ouvidoria -> contar($a['id']);
	//percentual do tipo atual
	$percent=($quantidade/$tot)*100;

	//atualiza o total de mensagens
	$total_tipo += $quantidade;
	//atualiza o total de percentual (tem que dar 100% :P)
	$total_percent += $percent;
	
	//exibe parciais
	$pdf->Cell(50,5,$a['tipo'],1,0,'C');
	$pdf->Cell(50,5,$quantidade,1,0,'C');
	$pdf->Cell(50,5,number_format($percent,2),1,1,'C');
}
//exibe totais
$pdf->Cell(50,5,'Total',1,0,'C');
$pdf->Cell(50,5,$total_tipo,1,0,'C');
$pdf->Cell(50,5,$total_percent,1,1,'C');

//inicializar os arrays de resposta e descricao
$tipos -> inicializar();
//buscar tipos de cada registro da tabela ouvidoria
$resultado = $ouvidoria -> buscar_tipos();

//percorre as mensagens e incrementa a soma de cada tipo
while ($r = mysql_fetch_array($resultado)) {
	$tipos -> respostas[$r['tipo_id']] ++;
}

$pdf->Ln(8);
	
$valY = $pdf->GetY();				
$pdf->SetXY(25, $valY + 10);

//pizza
$pdf->PieChart(140, 140, $tipos -> respostas, $tipos -> descricao, '%l (%p)',array($col1,$col2,$col3,$col4));


/*-------------------------------------- demandas por segmento --------------------------------------*/

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);	
$pdf->Cell(0,10,'FAETEC',0,1,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'RELATÓRIOS DA OUVIDORIA',0,1,'C');
$pdf->Cell(0,10,'COMPORTAMENTO DAS DEMANDAS POR ENTIDADE VINCULADA',0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(75,5,'Fluxo das manifestações recebidas',1,0,'C');
$pdf->Cell(50,5,'Quantidade',1,0,'C');
$pdf->Cell(50,5,'Percentual (%)',1,1,'C');
$pdf->SetFont('Arial','B',8);

//listar segmentos
$lista_segmentos = $segmentos -> listar();
//total de cada segmento
$total_segmento = 0;
//total das porcentagens
$total_percent = 0;

while ($s = mysql_fetch_array($lista_segmentos)) {
	//numero de mensagens para um segmento
	$quantidade = $segmentos -> contar($s['id']);
	
	//percentual do tipo atual
	$percent=($quantidade/$tot)*100;

	//atualiza o total de mensagens
	$total_segmento += $quantidade;
	//atualiza o total de percentual (tem que dar 100% :P)
	$total_percent += $percent;
	
	//exibe parciais
	$pdf->Cell(75,5,$s['nome'],1,0,'L');
	$pdf->Cell(50,5,$quantidade,1,0,'C');
	$pdf->Cell(50,5,number_format($percent,2),1,1,'C');
}

//exibe totais
$pdf->Cell(75,5,'Total',1,0,'C');
$pdf->Cell(50,5,$total_segmento,1,0,'C');
$pdf->Cell(50,5,number_format($total_percent,2),1,1,'C');

/*
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

$respostas = array();
$descricao = array();

$sql_op = "select entidade from entidade order by id_entidade";
$opc = mysql_query($sql_op) or die(mysql_error());


$sql = "select ouvidoria.id_entidade, entidade.id_entidade
				from ouvidoria 
				inner join entidade on ouvidoria.id_entidade = entidade.id_entidade";
				
		$res = mysql_query($sql) or die(mysql_error());
		
		//inicializa os dados de cada resposta
			for ($i=1;$i<=$total;$i++) {
				$respostas[$i] = 0;
				$descricao[$i] = mysql_result($opc,$i-1,'entidade');
			}

		//percorre as respostas e incrementa a soma
			while ($r = mysql_fetch_array($res)) {
				$respostas[$r['id_entidade']] ++;
			}

		$pdf->Ln(8);
			
			//$pdf->SetFont('Arial', '', 10);
			$valY = $pdf->GetY();				
			$pdf->SetXY(25, $valY + 10);
			
		//pizza
			$pdf->PieChart(140, 140, $respostas, $descricao, '%l (%p)',array($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10,$col11));
			
			
			
*/			
$pdf->Output();
?>
