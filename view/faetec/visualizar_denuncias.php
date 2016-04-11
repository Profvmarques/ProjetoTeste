<?php 
require_once('../../controle/faetec/processos.php');
controle_processos('visualizar_denuncias');
?>

<form name='form' method='post'>
	<fieldset>
    <legend><b>Filtros</b></legend>
		<div class="form-group campof campowx  ">
            <label><b>Status</b></label>
            <select name='status' id='status'>
						<?php if (mysql_num_rows($lista_status) > 1) { ?>
							<option value="">Todos os status</option>
						<?php } ?>
						<?php while ($s = mysql_fetch_array($lista_status)) {
							if ($s['id_status'] != 5) { ?>
							<option value="<?php echo $s['id_status']; ?>"><?php echo $s['status']; ?></option>
						<?php }} ?>
					</select>
        </div>
            
            
			<div class="form-group ">
            <label><b>Entidade</b></label>
					<select name='entidade' id='entidade'>
						<?php if (mysql_num_rows($lista_entidades) > 1) { ?>
							<option value="">Todas as entidades</option>
						<?php } ?>
						<?php while ($l = mysql_fetch_array($lista_entidades)) { ?>
							<option value="<?php echo $l['id_entidade']; ?>"><?php echo $l['entidade']; ?></option>
						<?php } ?>
					</select>
				</div>
                
                
				<div class="form-group campof">
            <label><b>Modalidade de Ensino</b></label>
            <select name='modalidade' id='modalidade'>
						<option value="">Todas as modalidades</option>
						<?php while ($l = mysql_fetch_array($lista_modalidades)) { ?>
						<option value="<?php echo $l['id_modalidade']; ?>"><?php echo $l['modalidade']; ?></option>
						<?php } ?>
					</select>
            </div>
            
            
				<div class="form-group ">
            <label><b>Defici&ecirc;ncia</b></label>
					<select name="deficiencia" id="deficiencia">
						<option value="">Todas as defici&ecirc;ncias</option>
						<?php while ($t = mysql_fetch_array($lista_deficiencias)) { ?>
						<option value="<?php echo $t['id']; ?>"><?php echo $t['deficiencia']; ?></option>
						<?php } ?>
				</select>
                
                </div>
                
                
				<div class="form-group campo ">
        	<div class="campof">
            <label class="campof"><b>Data Inicial</b></label>
            <input type='text' name='data_inicial' id='data_inicial'>
            </div>
            <div class="campof">
            <label class="campof"><b>Data Final</b></label>
					<input type='text' name='data_final' id='data_final'>
                    </div>
		</div>				
        <div class="form-group campo">
					<input type='button' class="btn btn-success" value='Filtrar' onclick="document.getElementById('filtrar').value=1;limpar_pesquisa();document.form.submit();">
                    </div>
	</fieldset>
	<fieldset><legend><b>Pesquisa</b></legend>
		<div class="form-group campo "> 
        	<div class="campof"> 
					<select name='tipo' id='tipo'>
						<option value=''>Tipo de pesquisa</option>
						<option value='1'>N&uacute;mero de protocolo</option>
						<option value='2'>Nome</option>
						<option value='3'>E-mail</option>
						<option value='4'>CPF</option>
					</select>
					<input type='text' name='busca' id='busca'>
					<input type='button' class="btn btn-success" value='Pesquisar' onclick="pesquisa();">
				</div>
    </div>
	</fieldset>
	<table width="100%" border="0" id="tabela" class="tablesorter">
		<thead>
		  <tr>
		    <th>Protocolo</th>
		    <th>Primeira Manifesta&ccedil;&atilde;o</th>
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
			<td><?php echo $r['prim_rec']; ?></td>
			<td><?php echo $r['assunto']; ?></td>
			<td><?php echo $r['entidade']; ?></td>
			<td><?php echo $r['data']; ?></td>
			<td><?php echo $r['data_fim']; ?></td>
			<td><?php echo $r['status_atual']; ?></td>
			<td>
				<a href="?pg=20&id=<?php echo $r['id_ouvidoria']; ?>"><img src='../../imagens/faetec/lupa.png' border='0'><a>
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
						<a href="?pg=19&inicio=<?php echo $i*10; echo $filtro; ?>"><?php echo $i+1; ?></a>
					<?php } ?>
				<?php }?>
			</td>
		</tr>		
	</table>
	<input type='hidden' name='pesquisar' id='pesquisar' value=''>
	<input type='hidden' name='filtrar' id='filtrar' value=''>
</form>


<script>
	document.getElementById('data_inicial').value='<?php echo $filtroInicial; ?>';
	document.getElementById('data_final').value='<?php echo $filtroFinal; ?>';
	document.getElementById('status').value='<?php echo $filtroStatus; ?>';
	document.getElementById('entidade').value='<?php echo $filtroEntidade; ?>';
	document.getElementById('modalidade').value='<?php echo $filtroModalidade; ?>';
	document.getElementById('deficiencia').value='<?php echo $filtroDeficiencia; ?>';
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