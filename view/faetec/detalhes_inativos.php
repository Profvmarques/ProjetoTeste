<?php 
session_start();
require_once('../../controle/faetec/processos.php');
controle_processos('detalhes');

$detalhes = mysql_fetch_array($resultado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ouvidoria - FAETEC</title>
<link href="../../css/faetec/style_all.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="../../css/faetec/style_historico.css"/>
<script type="text/javascript" src="../../js/jquery.tablesorter.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	$("#resposta_padrao").change(function(){
		$.post('../../controle/faetec/processos.php',{id: $(this).val()},function(resposta){$("#resumo").html(resposta);});	
	});
	
	$("#prioridade").change(function(){
		if (confirm('Alterar Prioridade?')) {
			$.post('../../controle/faetec/processos.php',{prioridade: $(this).val(),id_ouvidoria: <?php echo $_GET['id']; ?>});	
		}
		else {
			if ($(this).val() == 1) {
				$(this).val(2);
			}
			else {
				$(this).val(1);
			}
		}
	});
	
	$("#entidade").change(function(){
		if (confirm("Tem certeza que deseja alterar a entidade?")) {
			$.post('../../controle/faetec/processos.php',{entidade: $(this).val(),id_ouvidoria: <?php echo $_GET['id']; ?>});	
		}
		else {
			$("#entidade").val(<?php echo $detalhes['ent']; ?>)
		}
	});
	
	/*
	$("#novo_status").change(function(){
	if ($(this).val()==2)
		{$('#td').css('display','block');
	}
	else
		{$('#td').css('display','none');
	}
	});
	*/
	$("#historico").tablesorter( {
		headers: { 
            // colunas que não estão com sort
            2: { 
                //resumo
                sorter: false 
            },
			3: { 
	            //origem
	            sorter: false 
	        },
			4: { 
	            //destino
	            sorter: false 
	        }
        } 
	} ); 


});	
</script>
<script>
	function confirmar_exclusao() {
		if (!confirm('Tem certeza que deseja excluir essa manifestação?')) {
			return false;
		}
		else {
			document.getElementById('excluir').value = 1;
			document.form.submit();
		}
	}
	function confirmar_restauracao() {
		if (!confirm('Tem certeza que deseja restaurar essa manifestação?')) {
			return false;
		}
	}
</script>
</head>

<body>
<p>Visualização da manifestação</p>
<table width="100%" border="0">
	<tr class='odd'>
		<td width="15%" class="td">Protocolo:</td><td width="25%" class='textol'><?php echo $detalhes['protocolo'] ?></td>
		<td width="10%" class="td">Data:</td><td width="20%" class='textol'><?php echo $detalhes['data'] ?></td>
		<td width="10%" class="td">Data Limite:</td><td width="20%" class='textol' colspan=2><?php echo $detalhes['data_fim'] ?></td>
	</tr>
	<tr class="column1">
		<td class="td">Assunto</td>
		<td class='textol'><?php echo $detalhes['assunto']; ?></td>
		<td class="td">Tipo:</td>
		<td class='textol' colspan=3>
		<?php if ($permissoes['alterar'] == 1) { ?>
			<select name="tipo_novo" id="tipo_novo">
			<?php for ($ass=0;$ass<mysql_num_rows($resultado_tipo_manifestacao);$ass++) { 
				if (mysql_result($resultado_tipo_manifestacao,$ass,'id_tipo') != 8) { ?>
					<?php $sel = ($detalhes['id_tipo'] == mysql_result($resultado_tipo_manifestacao,$ass,'id_tipo')) ? "selected='selected'" : ""; ?>
					<option value="<?php echo mysql_result($resultado_tipo_manifestacao,$ass,'id_tipo'); ?>" <?php echo $sel; ?>>
					<?php echo mysql_result($resultado_tipo_manifestacao,$ass,'tipo'); ?></option>
				<?php } ?>
			<?php } ?>
			</select>
		<?php } else {?>
			<?php echo $l['tipo']; ?>
		<?php } ?>
		</td>
	</tr>
	<tr class="column1">
		<td class="td">Status:</td><td class='textol'><?php echo $detalhes['status_atual'] ?></td>
		<td class="td">Prioridade:</td>
		<td class='textol' colspan=3>
			<!--<select name='prioridade' id='prioridade'>-->
				<?php while ($rp = mysql_fetch_array($resultado_pri)) {
					echo ($rp['id_prioridade'] == $detalhes['prioridade'])? $rp['prioridade'] :  '';
				} ?>
			<!--</select>-->
		</td>
	</tr>
	<tr class="odd">
		<td class="td">Nome:</td><td colspan="3" class='textol'><?php echo $detalhes['nome'] ?></td>
		<td class="td">CPF:</td><td class='textol'><?php echo $detalhes['cpf']; ?></td>
	</tr>
	<tr class="column1">
	    <td class="td">Sexo:</td>
	    <td class='textol'><?php echo $detalhes['sexo'] ?></td>
	    <td class="td">Data Nascimento:</td>
	    <td class='textol'><?php echo $detalhes['data_nasc'] ?></td>
		<td class="td">Tipo de usu&aacute;rio:</td><td class="textol"><?php echo $detalhes['tipo_usuario'] ?></td>
	</tr>
	<tr class="odd">
		<td class="td">Escolaridade:</td>
		<td class='textol'><?php echo $detalhes['escolaridade'] ?></td>
		<td class="td">Defici&ecirc;ncia:</td>
		<td class='textol' colspan=3><?php echo ($detalhes['deficiencia'] == '') ? 'Nenhuma' : $detalhes['deficiencia']; ?></td>
	</tr>
	<tr  class="column1">
		<td class="td">E-mail:</td>
		<td colspan="7" class='textol'><?php echo $detalhes['email'] ?></td>
	</tr>
	<tr class="odd">
		<td class="td">Endere&ccedil;o:</td>
		<td colspan="7" class='textol'><?php echo $detalhes['endereco'] ?></td>
	</tr>
	<tr class="column1">
		<td class="td">Bairro:</td>
		<td class='textol'><?php echo $detalhes['bairro'] ?></td>
		<td class="td">Cidade:</td>
		<td colspan="5" class='textol'><?php echo $detalhes['cidade'] ?></td>
	</tr>
	<tr class="odd">
		<td class="td">Telefone:</td>
		<td class='textol'><?php echo $detalhes['telefone'] ?></td>
		<td class="td">Celular:</td>
		<td colspan="5" class='textol'><?php echo $detalhes['celular'] ?></td>
	</tr>
	<tr class="column1">
		<td class="td">Entidade:</td>
		<td class="textol">
			<?php /*if ($permissoes['alterar'] == 1) { ?>
			<select name="entidade_nova" id="entidade_nova">
			<?php for ($ent=0;$ent<mysql_num_rows($resultado_ent);$ent++) { ?>
				<?php $sel = ($detalhes['ent'] == mysql_result($resultado_ent,$ent,'id_entidade')) ? "selected='selected'" : ""; ?>
				<option value="<?php echo mysql_result($resultado_ent,$ent,'id_entidade'); ?>" <?php echo $sel; ?>>
				<?php echo mysql_result($resultado_ent,$ent,'entidade'); ?></option>
			<?php } ?>
			</select>
			<?php } else {*/?>
				<?php echo $detalhes['entidade']; ?>
			<?php// } ?>
		</td>
		<td class="td">Modalidade de Ensino:</td>
		<td colspan="5" class='textol'><?php echo $detalhes['modalidade'] ?></td>
	</tr>
	<tr class="odd">
		<td class="td">Primeira Manifesta&ccedil;&atilde;o:</td>
		<td class='textol'><?php echo $detalhes['prim_rec'] ?></td>
		<td class="td">Protocolo(s) Anteriore(s):</td>
		<td colspan="5" class='textol'><?php echo $detalhes['protocolo_anterior'] ?></td>
	</tr>
	<tr class="column1">
		<td class="td">Coment&aacute;rio:</td><td colspan="7" class='textol'><?php echo nl2br($detalhes['comentario']) ?></td>
	</tr>
	<?php if ($detalhes['anexo1'] != '') { ?>
		<tr class='column1'>
			<td class='td'>Anexos:</td>
			<td class='texto1' colspan=5>
				<?php echo "<a href='../../anexos/".$detalhes['anexo1']."'>Anexo 1</a>";
				if ($detalhes['anexo2'] != '') {
					echo "&nbsp;&nbsp;<a href='../../anexos/".$detalhes['anexo2']."'>Anexo 2</a>";
				}
				?>
			</td>
		</tr>
	<?php } ?>
</table>
<form method='post' id='form' name='form'>
<input type='hidden' name='excluir' id='excluir' value = ''>
	<?php if ($permissoes['excluir']==1) { ?>
		<input type='submit' name='restaurar' id='restaurar' value = 'Restaurar Manifestação' onclick='return confirmar_restauracao();'>
		<!--<img src='../../imagens/logo_excluir.jpg' class='btn_excluir' onclick='confirmar_exclusao();'>-->
	<?php } ?>
	
	<?php/*
	if (($permissoes['alterar']==1) && (($detalhes['id_status_atual']!=3) && ($detalhes['id_status_atual']!=5)))
	{
	?>
	<br />
	
	<p>Altera&ccedil;&atilde;o do Status</p>
	
	<table width="100%" border="0">
		<tr class="column2">
			<td class="td"><span>Status</span>
				<?php if ($detalhes["id_status_atual"] == 2 && $id_destino == $_SESSION['entidade']) { ?>
					<select disabled>
						<option value=''>Respondida</option>
					</select>
				<?php } else { ?>
				<select name="novo_status" id="novo_status">
					<?php while ($ls = mysql_fetch_array($lista_status)) { 
						if ($ls['id_status'] != 5 && $ls['id_status'] != 4) { ?>
						<option value="<?php echo $ls['id_status']; ?>"><?php echo $ls['status']; ?></option>
					<?php }} ?>
				</select>
				<?php } ?>
			</td>
			<?php /*
			<td class="td" id="td" style="display:none;" >
				<label>Destino</label>
				<select name="entidade" id="entidade">
						<?php while ($s = mysql_fetch_array($resultado_ent)) { ?>
						<option value="<?php echo $s['id_entidade']; ?>"><?php echo $s['entidade']; ?></option>
						<?php } ?>
				</select>
			</td>
			<?php 
		</tr>
		<tr class="odd1">
			<td class="td" colspan=2><label>Resposta</label>
				<select name='resposta_padrao' id='resposta_padrao'>
					<?php while ($rs = mysql_fetch_array($lista_resposta)) { ?>
						<option value='<?php echo $rs['id_resposta_padrao']; ?>'><?php echo $rs['resposta_padrao']; ?></option>
					<?php } ?>
				</select>
			</td>			
		</tr>
		<tr class="column2">
			<td colspan="3" class="td">
				<p>Resumo:</p>
				<textarea name="resumo" id="resumo" cols="70" rows="6"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan=3>
				<input name="alterar" type="hidden" value="1"/>
				<input name="id_ouvidoria" type="hidden" value="<?php echo $detalhes['id_ouvidoria']; ?>" />
				<?php if ($detalhes['alt'] == 1 && ($id_destino == '' || $id_destino == $_SESSION['entidade'])) { ?>
					<br><input name="enviar" type="submit" value="Alterar" id="alterar"/>
				<?php } ?>
				<?php if ($detalhes["id_status_atual"] == 2 && $id_destino == $_SESSION['entidade']) { ?>
					<input type='hidden' name="novo_status" id="novo_status" value=5>
					<input type='hidden' name="entidade" id="entidade" value=<?php echo $id_origem; ?>>
				<?php } ?>
			</td>
		</tr>
	</table>
</form>
<?php}*/ ?>
<?php
if (mysql_num_rows($resultado_historico) > 0) { ?>
<p>Hist&oacute;rico</p>
<table id="historico" width="100%" border="0" class="tablesorter">
	<thead>
		<tr>
		    <th>Data</th>
		    <th>Status</th>
		    <th>Resumo</th>
		    <th>Usu&aacute;rio</th>
		    <th>Origem</th>
		    <th>Destino</th>
		</tr>
	</thead>
	<?php for ($i=0;$i<mysql_num_rows($resultado_historico);$i++) { ?>
	<?php
	switch (mysql_result($resultado_historico,$i,'status')) {
		case 'Atendida':
			$cor='#1d6302';
		break;
		case 'Encaminhada';
			$cor='#d08a03';
		break;
		case 'Pendente';
			$cor='#a30d02';
		break;
		case 'Reiterada';
			$cor='#FF0066';
		break;
		default:
			$cor='#000000';
		break;
	}
	?>
	
	<tr style='color:<?php echo $cor; ?>;font-weight:bold'>
		<td><?php echo mysql_result($resultado_historico,$i,'hdata'); ?></td>
		<td><?php echo mysql_result($resultado_historico,$i,'status'); ?></td>
		<td><?php echo nl2br(mysql_result($resultado_historico,$i,'resumo')); ?></td>
		<td><?php echo mysql_result($resultado_historico,$i,'nome'); ?></td>
		<td><?php echo mysql_result($resultado_historico,$i,'origem'); ?></td>
		<td><?php echo mysql_result($resultado_historico,$i,'destino'); ?></td>
	</tr>
	<?php } ?>
</table>
<?php } ?>
</body>
</html>