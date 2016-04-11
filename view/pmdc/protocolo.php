<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>OUVIDORIA - FAETEC</title>
<link href="../../css/pmdc/style_protocolo.css" rel="stylesheet" type="text/css"/>
</head>

<body>
	<div style="border:solid; border-color:#333300; width:800px;">
		<table border="0" width="100%" cellpadding="10" cellspacing="5">
			<tr>
				<td>
					<img src="../../imagens/pmdc/logo_gov.jpg" border="0" />
				</td>
			</tr>
			<tr>
				<td>
				<b>PROTOCOLO DE ATENDIMENTO DE MANIFESTA&Ccedil;&Atilde;O</b><br>
				Exer&ccedil;a sua cidadania!<br />
				A resposta ser&aacute; encaminhada ao e-mail informado.<br>
				Caso seja um e-mail inv&aacute;lido a mesma poder&aacute; ser acompanhada em nosso site (www.faetec.rj.gov.br/ouvidoria) com o n&uacute;mero do protocolo abaixo:
				</td>
			</tr>
			<tr>
				<td>
					<p style="font-weight:bold; font-size:16px;">
						Protocolo: <?php echo base64_decode($_GET['pr']); ?>
						<br>
						data: <?php echo date('d/m/Y'); ?>
					</p>
				</td>
			</tr>
		</table>
	</div>
	<br>
	<input type='button' name='imprimir' id='imprimir' onclick='window.print()' value='Imprimir Protocolo'>
</body>
</html>