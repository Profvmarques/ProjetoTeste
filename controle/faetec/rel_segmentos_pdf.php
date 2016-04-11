<?php
require('fpdf/fpdf.php');       			
define('FPDF_FONTPATH','fpdf/font/');
$pdf=new FPDF('P','mm','A4');
$pdf->SetMargins(10,10);
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

//limitar data
$comp = '';
if ($_POST['data_inicial'] != '' && $_POST['data_final'] != '') {
	$di = explode("/",$_POST['data_inicial']);
	$df = explode("/",$_POST['data_final']);
	$data_inicial = $di[2]."-".$di[1]."-".$di[0];
	$data_final = $df[2]."-".$df[1]."-".$df[0];
	
	$comp = " and data between '".$data_inicial."' and '".$data_final."'";
}

//segmento escolhido
if ($_POST['segmento'] != "") {
	//numero de mensagens para o segmento escolhido
	$numero = $segmentos -> contar($_POST['segmento'],$comp);
	//nome do segmento escolhido
	$nome = $segmentos -> nome_segmento($_POST['segmento']);
	
    $pdf->AddPage();
	
	//nenhuma mensagem encontrada
	if ($numero == 0) {
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'FAETEC',0,1,'C');
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'RELATгRIOS DA OUVIDORIA',0,1,'C');
		$pdf->Cell(0,10,'NУO HС RESULTADOS PARA O SEGMENTO: '.$nome,0,1,'C');
	}
	//mensagem(ns) encontrada(s)
	else {
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'FAETEC',0,1,'C');
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'RELATгRIOS DA OUVIDORIA - '.$nome,0,1,'C');
		$pdf->Cell(0,10,'Tipologia das manifestaчѕes recebidas',0,1,'C');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50,5,'TIPO',1,0,'C');
		$pdf->Cell(50,5,'Quantidade',1,0,'C');
		$pdf->Cell(50,5,'Percentual (%)',1,1,'C');
		$pdf->SetFont('Arial','B',8);

		//listar os tipos
		$resultado = $tipos -> listar();
		//total de cada tipo
		$total_tipo = 0;
		//total das porcentagem
		$total_percent = 0;
		
		//percorre os tipos
		while ($a = mysql_fetch_array($resultado)) {
			//descriчуo do tipo atual
			$tipo = $tipos -> nome_tipo($a['id']);
			
			//buscar o numero de mensagens para o tipo atual para o segmento escolhido
			$quantidade = $ouvidoria -> contar($a['id'],$_POST['segmento'],$comp);

			//percentual do tipo atual para o segmento escolhido
			$percent = ($quantidade/$numero)*100;
			
			//atualiza o total de mensagens
			$total_tipo += $quantidade;
			//atualiza o total de percentual (tem que dar 100% :P)
			$total_percent += $percent;
			
			//exibe parciais
			$pdf->Cell(50,5,$tipo,1,0,'C');
			$pdf->Cell(50,5,$quantidade,1,0,'C');
			$pdf->Cell(50,5,number_format($percent,2),1,1,'C');
		}
		
		//exibe totais
		$pdf->Cell(50,5,'Total',1,0,'C');
		$pdf->Cell(50,5,$total_tipo,1,0,'C');
		$pdf->Cell(50,5,$total_percent,1,1,'C');

		//inicializar os arrays de resposta e descricao
		$tipos -> inicializar();
		//buscar tipos de cada registro de um segmento da tabela ouvidoria
		$resultado = $ouvidoria -> buscar_tipos($_POST['segmento'],$comp);
		
		//percorre as mensagens e incrementa a soma de cada tipo
		while ($r = mysql_fetch_array($resultado)) {
			$tipos -> respostas[$r['tipo_id']] ++;
		}
		
		$pdf->Ln(8);
		
		$valY = $pdf->GetY();				
		$pdf->SetXY(25, $valY + 10);

		//pizza
		$pdf->PieChart(140, 140, $tipos -> respostas, $tipos -> descricao, '%l (%p)',array($col1,$col2,$col3,$col4));
	}
}
//Relatѓrio para todos os segmentos
else {
	//buscar todos os segmentos
	$resultado_segmentos = $segmentos -> listar();
	
	//percorrer segmentos encontrados
	while ($seg = mysql_fetch_array($resultado_segmentos)) {
		//numero de mensagens para o segmento atual
		$numero = $segmentos -> contar($seg['id'],$comp);
		//nome do segmento escolhido
		$nome = $segmentos -> nome_segmento($seg['id']);
		
	    $pdf->AddPage();
		
		//nenhuma mensagem encontrada
		if ($numero == 0) {
			$pdf->SetFont('Arial','B',16);
			$pdf->Cell(0,10,'FAETEC',0,1,'C');
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,'RELATгRIOS DA OUVIDORIA',0,1,'C');
			$pdf->Cell(0,10,'NУO HС RESULTADOS PARA O SEGMENTO: '.$nome,0,1,'C');
		}
		//mensagem(ns) encontrada(s)
		else {
			$pdf->SetFont('Arial','B',16);
			$pdf->Cell(0,10,'FAETEC',0,1,'C');
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,'RELATгRIOS DA OUVIDORIA - '.$nome,0,1,'C');
			$pdf->Cell(0,10,'Tipologia das manifestaчѕes recebidas',0,1,'C');
			$pdf->Ln(5);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(50,5,'TIPO',1,0,'C');
			$pdf->Cell(50,5,'Quantidade',1,0,'C');
			$pdf->Cell(50,5,'Percentual (%)',1,1,'C');
			$pdf->SetFont('Arial','B',8);

			//listar os tipos
			$resultado = $tipos -> listar();
			//total de cada tipo
			$total_tipo = 0;
			//total das porcentagem
			$total_percent = 0;
			
			//percorre os tipos
			while ($a = mysql_fetch_array($resultado)) {
				//descriчуo do tipo atual
				$tipo = $tipos -> nome_tipo($a['id']);
				
				//buscar o numero de mensagens para o tipo atual para o segmento atual
				$quantidade = $ouvidoria -> contar($a['id'],$seg['id'],$comp);

				//percentual do tipo atual para o segmento atual
				$percent = ($quantidade/$numero)*100;
				
				//atualiza o total de mensagens
				$total_tipo += $quantidade;
				//atualiza o total de percentual (tem que dar 100% :P)
				$total_percent += $percent;
				
				//exibe parciais
				$pdf->Cell(50,5,$tipo,1,0,'C');
				$pdf->Cell(50,5,$quantidade,1,0,'C');
				$pdf->Cell(50,5,number_format($percent,2),1,1,'C');
			}
			
			//exibe totais
			$pdf->Cell(50,5,'Total',1,0,'C');
			$pdf->Cell(50,5,$total_tipo,1,0,'C');
			$pdf->Cell(50,5,$total_percent,1,1,'C');

			//inicializar os arrays de resposta e descricao
			$tipos -> inicializar();
			//buscar tipos de um segmento na tabela ouvidoria
			$resultado = $ouvidoria -> buscar_tipos($seg['id'],$comp);
			
			//percorre as mensagens e incrementa a soma de cada tipo
			while ($r = mysql_fetch_array($resultado)) {
				$tipos -> respostas[$r['tipo_id']] ++;
			}
			
			$pdf->Ln(8);
			
			$valY = $pdf->GetY();				
			$pdf->SetXY(25, $valY + 10);

			//pizza
			$pdf->PieChart(140, 140, $tipos -> respostas, $tipos -> descricao, '%l (%p)',array($col1,$col2,$col3,$col4));
		}
	}
}
	
$pdf->Output();
?>