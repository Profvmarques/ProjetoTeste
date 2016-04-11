<?php 
require_once('../../controle/faetec/processos.php');
controle_processos('visualizar');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script>
	function pesquisa() {
		if (document.getElementById('tipo').value != '' && document.getElementById('busca').value != '') {
			document.getElementById('pesquisar').value=1;
			limpar_filtro();
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
	
	function limpar_filtro() {
		document.getElementById('entidade').value='';
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ouvidoria - FAETEC</title>
<link rel="stylesheet" type="text/css" href="../../css/faetec/style_historico.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style_rel.css" />
<link rel="stylesheet" type="text/css" href="../../css/datePicker.css" />
<script type="text/javascript" src="../../js/jquery.datePicker.js"></script>
<script type="text/javascript" src="../../js/date.js"></script>
<script src="../../js/jquery.maskedinput.js" type="text/javascript"></script>
<script type="text/javascript" src="../../js/jquery.tablesorter.js"></script>
<script type="text/javascript">
$().ready(function(){ 
    $("#tabela").tablesorter({
		headers: { 
            // colunas que no tem sort
            0: { 
                //protocolo 
                sorter: false 
            }, 
            // assign the third column (we start counting zero) 
            7: { 
                //Visualizar 
                sorter: false 
            } 
        } 
	});
	
	$('#data_inicial').datePicker({startDate:'01/01/2000'});
	$('#data_final').datePicker({startDate:'01/01/2000'});


	$("#data_inicial").mask("99/99/9999");
	$("#data_final").mask("99/99/9999");

}); 
</script>
</head>
<body>
<form name='form' method='post'>
	<fieldset><legend><b>Filtros</b></legend>
		<table width="100%" border="0">
			<tr>
				<td><b>Status</b></td>
				<td><b>Entidade</b></td>
			</tr>
			<tr>
				<td>
					<select name='status' id='status'>
						<?php if (mysql_num_rows($lista_status) > 1) { ?>
							<option value="">Todos os status</option>
						<?php } ?>
						<?php while ($s = mysql_fetch_array($lista_status)) {
							if ($s['id_status'] != 5) { ?>
							<option value="<?php echo $s['id_status']; ?>"><?php echo $s['status']; ?></option>
						<?php }} ?>
					</select>
				</td>
				<td>
					<select name='entidade' id='entidade'>
						<?php if (mysql_num_rows($lista_entidades) > 1) { ?>
							<option value="">Todas as entidades</option>
						<?php } ?>
						<?php while ($l = mysql_fetch_array($lista_entidades)) { ?>
							<option value="<?php echo $l['id_entidade']; ?>"><?php echo $l['entidade']; ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td><b>Data Inicial</b></td>
				<td><b>Data Final</b></td>
			</tr>
			<tr>
				<td>
					<input type='text' name='data_inicial' id='data_inicial'>
				</td>
				<td>
					<input type='text' name='data_final' id='data_final'>
				</td>
			</tr>
			<tr>
				<td colspan='2'><b>Tipo</b></td>
			</tr>
			<tr>
				<td colspan='2'>
					<select name='tipo' id='tipo'>
						<?php if (mysql_num_rows($lista_tipo) > 1) { ?>
							<option value="">Todos os tipos</option>
						<?php } ?>
						<?php while ($a = mysql_fetch_array($lista_tipo)) { ?>
							<option value="<?php echo $a['id_tipo']; ?>"><?php echo $a['tipo']; ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<input type='button' value='Filtrar' onclick="document.getElementById('filtrar').value=1;limpar_pesquisa();document.form.submit();">
				</td>
			</tr>
		</table>
	</fieldset>
	<fieldset><legend><b>Pesquisa</b></legend>
		<table width="100%" border="0">
			<tr>
				<td>
					<select name='tipo' id='tipo'>
						<option value=''>Tipo de pesquisa</option>
						<option value='1'>N&uacute;mero de protocolo</option>
						<option value='2'>Nome</option>
						<option value='3'>E-mail</option>
						<option value='4'>CPF</option>
					</select>
					<input type='text' name='busca' id='busca'>
					<input type='button' value='Pesquisar' onclick="pesquisa();">
				</td>
			</tr>
		</table>
	</fieldset>
	<table width="100%" border="0" id="tabela" class="tablesorter">
		<thead>
		  <tr>
		    <th>Protocolo</th>
		    <th>Tipo</th>
		    <th>Assunto</th>
		    <th>Entidade</th>
		    <th>Data</th>
		    <th>Data Limite</th>
		    <th>Status</th>
		    <th width="10%">Visualizar</th>
		  </tr>
		</thead>
		<tbody>
		<?php while ($r = mysql_fetch_array($resultado)) {
			switch ($r['status_atual']) {
				case 'Nova':
					$cor='#000000';
				break;
				case 'Atendida':
					$cor='#1d6302';
				break;
				case 'Encaminhada':
					$cor='#d08a03';
				break;
				case 'Pendente':
					$cor='#a30d02';
				break;
				case 'Respondida':
					$cor='#456de0';
				break;
				case 'Reiterada':
					$cor='#FF0066';
				break;
			}
		?>
		<tr style='color:<?php echo $cor; ?>;font-weight:bold'>
			<td><?php echo $r['protocolo']; ?></td>
			<td><?php echo $r['tipo']; ?></td>
			<td><?php echo $r['assunto']; ?></td>
			<td><?php echo $r['entidade']; ?></td>
			<td><?php echo $r['data']; ?></td>
			<td><?php echo $r['data_fim']; ?></td>
			<td><?php echo $r['status_atual']; ?></td>
			<td>
				<a href="?pg=2&id=<?php echo $r['id_ouvidoria']; ?>"><img src='../../imagens/faetec/lupa.png' border='0'><a>
			</td>
		</tr>
		<?php } ?>
		</tbody>		
		<tr>
			<td colspan=8>
				<?php for ($i=0;$i<$num;$i++) { ?>
					<?php if ($i == ($_GET['inicio']/10)) {
						echo $i+1;
					} 
					else { ?>
						<a href="?pg=37&inicio=<?php echo $i*10; echo $filtro; ?>"><?php echo $i+1; ?></a>
					<?php } ?>
				<?php }?>
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
	document.getElementById('tipo').value='<?php echo $filtrotipo; ?>';
	document.getElementById('entidade').value='<?php echo $filtroEntidade; ?>';
	document.getElementById('data_inicial').value='<?php echo $filtroInicial; ?>';
	document.getElementById('data_final').value='<?php echo $filtroFinal; ?>';
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