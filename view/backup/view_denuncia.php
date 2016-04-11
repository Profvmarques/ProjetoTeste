<?php
require('../../controle/backup/processo.php');
Processo('denuncia');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<title>OUVIDORIA - BACKUP</title>

<link rel="stylesheet" type="text/css" href="../../css/backup/style_historico.css"/>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery.tablesorter.js"></script>
<script type="text/javascript">
	function pesquisa() {
		if (document.getElementById('tipo').value != '' && document.getElementById('busca').value != '') {
			document.getElementById('pesquisar').value=1;
			document.form.submit();
		}
		else {
			alert('preencha os parâmetros da pesquisa');
		}
	}

	function limpar_pesquisa() {
		document.getElementById('tipo').value='';
		document.getElementById('busca').value='';
	}
	
$(document).ready(function() { 
    $("#tabela").tablesorter({
		headers: { 
			// colunas que não estão com sort
			0: { 
				//protocolo 
				sorter: false 
			}, 
			 
			7: { 
				//Visualizar 
				sorter: false 
			} 
		} 
	}); 
}); 

</script>

</head>
<body>
<form name="form" method="post">
<table>
<tr>
<td>
<select name="status" id="status">
<option value="">Todos os status</option>
<?php while ($ln = mysql_fetch_array($res_s)) { ?>
<option value="<?php echo $ln['id_status']; ?>"><?php echo $ln['status']; ?></option>
<?php } ?>
</select>
</td>
<td>
<input type="button" value="Filtrar" onclick="document.getElementById('filtrar').value=1;limpar_pesquisa();document.form.submit();" />
</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>
<select name="tipo" id="tipo">
<option value="">Tipo de pesquisa</option>
<option value="1">N&uacute;mero de protocolo</option>
<option value="2">Nome</option>
</select>
<input type="text" name="busca" id="busca">
<input type="button" value="Pesquisar" onclick="pesquisa();">
</td>
</tr>
</table>
<table border="0" id="tabela" class="tablesorter">
<thead>
  <tr>
    <th>Protocolo</th>
    <th>Primeira manifestação</th>
    <th>Entidade</th>
    <th>Data</th>
    <th>Data Limite</th>
    <th>Status</th>
    <th width="10%">Visualizar</th>
  </tr>
</thead>
<tbody>

<?php 

while ($linha=mysql_fetch_array($res))
{

$cor='#000000';
  
if ($linha['status_atual']=='Atendida')
$cor='#1d6302';

if ($linha['status_atual']=='Encaminhada')
$cor='#d08a03';

if ($linha['status_atual']=='Pendente')
$cor='#a30d02';

if ($linha['status_atual']=='Reiterada')
$cor='#FF0066';

echo "<tr style='color:$cor;font-weight:bold'><td>".$linha['protocolo']."</td>
    <td>".$linha['prim_rec']."</td>
    <td>".$linha['entidade']."</td>
     <td>".$linha['data']."</td>
    <td>".$linha['data_fim']."</td>
    <td>".$linha['status_atual']."</td>

    <td><a href='index.php?pg=8&p=".$linha['id_ouvidoria']."'><img src='../../imagens/lupa.png' border='0'><a></td>
 </tr>";
 
 }
 
 ?>

</tbody></table>
<table width="100%" border=0>
<tr>
<td colspan="8">
<?php
  $in = 0;
  
for ($i=0;$i<$pg;$i++)
{
 $j=$i+1;
 
echo "<a href='index.php?pg=7&ini=$in'>".$j."</a>&nbsp;";
$in+=10;
}
?>
</td>
</tr>
</table>
<input type='hidden' name='pesquisar' id='pesquisar' value=''>
<input type='hidden' name='filtrar' id='filtrar' value=''>
</form>
</body>
</html>
<script>
	document.getElementById('status').value='<?php echo $filtroStatus; ?>';
	<?php if ($_POST['tipo'] != '') { ?>
		document.getElementById('tipo').value='<?php echo $_POST['tipo']; ?>';
	<?php } elseif ($_GET['t'] != '') { ?>
				document.getElementById('tipo').value='<?php echo $_GET['t']; ?>';
		<?php } ?>
	
	<?php if ($_POST['busca'] != '') { ?>
		document.getElementById('busca').value='<?php echo $_POST['busca']; ?>';
	<?php } elseif ($_GET['p'] != '') { ?>
				document.getElementById('busca').value='<?php echo $_GET['p']; ?>';
		<?php } ?>
</script>