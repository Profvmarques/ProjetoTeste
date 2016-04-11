<?php
require_once('../../controle/verificacao.php');
ini_set('default_charset', 'latin1');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>OUVIDORIA - FAETEC</title>
		<link rel="stylesheet" type="text/css" href="../../css/faetec/style_index.css" />
	</head>
	<body>
		<div id="corpo">
			<div id="header"></div>
			<div id="conteudo">
				<div id="menu"><?php include ('menu.php');?></div>
				<div id="pagina">
					<?php
					switch ($_GET['pg']){
						case 1:
							include ('visualizar_ouvidoria.php');
						break;
						case 2:
							include ('detalhes_ouvidoria.php');
						break;
						case 3:
							include ('../../controle/sair.php');
						break;
						case 4:
							include ('alterar_senha.php');
						break;
					}
					?>
				</div>
			</div>
			<div id="footer">DGI - Diretoria de Gest&atilde;o da Informa&ccedil;&atilde;o - FAETEC</div>
		</div>
	</body>
</html>