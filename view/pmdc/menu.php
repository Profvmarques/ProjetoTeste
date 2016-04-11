<?php 
require_once ('../../controle/menu.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="../../css/pmdc/style_menu.css" />
</head>

<body>
	<table cellpadding="6" class="table">
		<?php if ($acesso['ler'] == 1) { ?>
			<tr>
				<td class="titulo">Visualizar Dados</td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=1">Formas de Contato</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=19">Den&uacute;ncias</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=37">Novos Coment&aacute;rios</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=13">Andamento de processo</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=15">Processos Inibidos</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=18">Den&uacute;ncias Inibidas</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=33">Processos em Bloco</a></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td class="titulo">Relatório geral</td>
			</tr>
			<tr >
			<td class="texto"><a href="index.php?pg=4">Formas de Contato</a></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td class="titulo">Relatórios Espec&iacute;ficos</td>
			</tr>
			<!--<tr>
				<td class="texto"><a href="index.php?pg=5">Formas de Contato</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=14">Comparativo de status</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=24">Quantitativo por Canais</a></td>
			</tr>-->
			<tr>
				<td class="texto"><a href="index.php?pg=34">Comparativos</a></td>
			</tr>
			<!--<tr>
				<td class="texto"><a href="index.php?pg=28">Relatório de Diretorias</a></td>
			</tr>-->
			<tr>
				<td></td>
			</tr>
		<?php } ?>
		<?php if ($acesso['alterar'] == 1) { ?>
			<tr>
				<td class="titulo">Formul&aacute;rio Ouvidoria</td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=9">Formas de Contato - Sistema On-line</a></td>
			</tr>
		<?php } ?>
		<?php if ($acesso['incluir'] == 1) { ?>
			<tr>
				<td class="texto"><a href="index.php?pg=17">Den&uacute;ncia - Sistema On-line</a></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td class="titulo">Cadastros</td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=6">Incluir Usuários</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=10">Editar Usuários</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=7">Incluir Entidade</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=11">Editar Entidade</a></td>
			</tr>
			<!--<tr>
				<td class="texto"><a href="index.php?pg=25">Incluir Diretoria</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=26">Designar Diretoria</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=27">Alterar Diretoria</a></td>
			</tr>-->
			<tr>
				<td class="texto"><a href="index.php?pg=8">Incluir Resposta Padrão</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=12">Editar Resposta Padrão</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=38">Incluir Assunto</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=39">Editar Assunto</a></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<!--<tr>
				<td class="titulo">Backup</td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=22">Criar Backup</a></td>
			</tr>
			<tr>
				<td class="texto"><a href="index.php?pg=23">Escolher Backup</a></td>
			</tr>
			<tr>
				<td class='titulo'>Chat</td>
			</tr>
			<tr>
				<td class='texto'><a href="index.php?pg=29">Acessar</a></td>
			</tr>
			<tr>
				<td class='texto'><a href="index.php?pg=30">Hist&oacute;rico</a></td>
			</tr>-->
		<?php } ?>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td class="texto"><a href="index.php?pg=3">Sair</a></td>
		</tr>
	</table>
</body>
</html>