<?php 
require_once('../../controle/verificacao.php'); 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>OUVIDORIA - BACKUP</title>
<link rel="stylesheet" type="text/css" href="../../css/backup/style_index.css" />
</head>

<body>
<div id="corpo">
<?php 
switch ($_SESSION['entidade']) {
	//SECT
	case 10:
		$img = 'sect/logo_gov_ouvidoria.jpg';
	break;
	//FAETEC
	case 1:
		$img = 'faetec/logo_gov.jpg';
	break;
	//CECIERJ
	case 44:
		$img = 'cecierj/logo_gov.jpg';
	break;
}
?>
<div id="header" style="background-image:url(../../imagens/<?php echo $img; ?>);"></div>

<div id="conteudo">
<div id="menu">
<center>
	<?php echo "<b>".substr($_SESSION['periodo'], -1)."º semestre de ".substr($_SESSION['periodo'], 0, -2)."</b>"; ?>
</center>
<?php include ('menu.php');?></div>
<div id="pagina">
<?php
switch ($_GET['pg']){
	case 1:
		include ('view_ouvidoria.php');
	break;
	case 7:
		include ('view_denuncia.php');
	break;
	case 15:
		include ('cons_andam.php');
	break;
	case 2:
		include ('view_all_ouvidoria.php');
	break;
	case 8:
		include ('view_all_denuncia.php');
	break;
	case 18:
		include ('view_inativos.php');
	break;
	case 19:
		include ('view_all_inativo.php');
	break;
	case 20:
		include ('view_denuncias_inativas.php');
	break;
	case 21:
		include ('view_all_denuncia_inativa.php');
	break;
	case 3:
		include ('ouvidoria_geral.php');
	break;
	case 4:
		include ('rel_entidade.php');
	break;
	case 17:
		include ('rel_entidade_comp.php');
	break;
	case 6:
		include ('../../controle/sair_backup.php');
	break;
}
?>
</div>
</div>
<div id="footer">Divis&atilde;o de Inform&aacute;tica - FAETEC</div>
</div>
</body>
</body>
</html>