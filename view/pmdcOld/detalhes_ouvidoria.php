<?php 
session_start();
require_once('../../controle/pmdc/processos.php');
controle_processos('detalhes');

$detalhes = mysql_fetch_array($resultado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ouvidoria - FAETEC</title>
<link href="../../css/pmdc/style_all.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="../../css/pmdc/style_historico.css"/>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery.tablesorter.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	$("#resposta_padrao").change(function(){
		$.post('../../controle/pmdc/processos.php',{id: $(this).val()},function(resposta){$("#resumo").val(resposta);});	
	});
	
	$("#prioridade").change(function(){
		if (confirm('Alterar Prioridade?')) {
			$.post('../../controle/pmdc/processos.php',{prioridade: $(this).val(),id_ouvidoria: <?php echo $_GET['id']; ?>});	
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

	$("#tipo_usuario").change(function(){
		if (confirm("Tem certeza que deseja alterar o tipo de usuário?")) {
			$.post('../../controle/pmdc/processos.php',{id_tipo_usuario: $(this).val(),id_ouvidoria: <?php echo $_GET['id']; ?>});	
		}
		else {
			$("#tipo_usuario").val(<?php echo $detalhes['tipo_usuario']; ?>)
		}
	});
	
	$("#entidade_nova").change(function(){
		if (confirm("Tem certeza que deseja alterar a entidade?")) {
			$.post('../../controle/pmdc/processos.php',{entidade_nova: $(this).val(),id_ouvidoria: <?php echo $_GET['id']; ?>});	
		}
		else {
			$("#entidade_nova").val(<?php echo $detalhes['ent']; ?>)
		}
	});

	$("#modalidade_nova").change(function(){
		if (confirm("Tem certeza que deseja alterar a modalidade?")) {
			$.post('../../controle/pmdc/processos.php',{modalidade_nova: $(this).val(),id_ouvidoria: <?php echo $_GET['id']; ?>});	
		}
		else {
			$("#modalidade_nova").val(<?php echo $detalhes['id_modalidade']; ?>)
		}
	});
	
	$("#tipo_novo").change(function(){
		if (confirm("Tem certeza que deseja alterar o tipo?")) {
			$.post('../../controle/pmdc/processos.php',{tipo_novo: $(this).val(),id_ouvidoria: <?php echo $_GET['id']; ?>});	
		}
		else {
			$("#tipo_novo").val(<?php echo $detalhes['id_tipo']; ?>)
		}
	});
	
	$("#assunto").change(function(){
		if (confirm("Tem certeza que deseja alterar o assunto?")) {
			$.post('../../controle/pmdc/processos.php',{assunto_novo: $(this).val(),id_ouvidoria: <?php echo $_GET['id']; ?>});	
		}
		else {
			$("#assunto").val(<?php echo $detalhes['id_assunto']; ?>)
		}
	});
	
	
	$("#novo_status").change(function(){
		if ($(this).val() == 2) {
			$('#td').css('display','block');
		}
		else {
			$('#td').css('display','none');
		}
	});

	$("#inibir_dados").change(function() {
		if (confirm("Tem certeza que deseja alterar essa opção?")) {
			$.post('../../controle/pmdc/processos.php',{inibir_dados_novo: $(this).val(),id_ouvidoria: <?php echo $_GET['id']; ?>},
			function(resposta) {
				window.location=window.location;
			});	
		}
		else {
			$("#inibir_dados").val(<?php echo $detalhes['inibir_dados']; ?>)
		}
	});
	
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
	});

	$("#form").submit(function() {
		<?php
		if ($detalhes['inibir_dados'] == '1') { ?>
			$("#dados_manifestacao").val($("#coment").val());
		<?php
		}
		else { ?>
			$("#valor_assunto").html($("#assunto :selected").text());
			$("#valor_tipo").html($("#tipo_novo :selected").text());
			$("#valor_prioridade").html($("#prioridade :selected").text());
			$("#valor_entidade").html($("#entidade_nova :selected").text());
			$("#valor_tipo_usuario").html($("#tipo_usuario :selected").text());
			$("#linha_inibicao").hide();
			$("#dados_manifestacao").val($("#manifestacao").html());
		<?php } ?>
	});
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
	function confirmar_inibicao() {
		if (!confirm('Tem certeza que deseja inibir essa manifestação?')) {
			return false;
		}
	}
	function mostrar_div(div) {
		switch (div) {
			case 'historico':
				document.getElementById('historico').style.display='';		
				document.getElementById('cidadao').style.display='none';
				document.getElementById('vinculada').style.display='none';
				if ($("#novo_status").val() == 2) {
					$('#td').css('display','block');
				}
				
				document.getElementById('alterar').style.display='';
				document.getElementById('btn_cidadao').style.display='none';
				document.getElementById('btn_vinculada').style.display='none';
				document.getElementById('texto').innerHTML='Resumo:';
				document.getElementById('resumo').value='';
				document.getElementById('titulo').innerHTML='Alteração do Status';
			break;
			case 'cidadao':
				document.getElementById('historico').style.display='none';
				document.getElementById('cidadao').style.display='';
				document.getElementById('vinculada').style.display='none';
				$('#td').css('display','none');
				
				document.getElementById('alterar').style.display='none';
				document.getElementById('btn_cidadao').style.display='';
				document.getElementById('btn_vinculada').style.display='none';
				document.getElementById('texto').innerHTML='Mensagem:';
				/*document.getElementById('resumo').value=document.getElementById('coment').value;*/
				document.getElementById('titulo').innerHTML='Enviar E-mail para Cidadão';
			break;
			case 'vinculada':
				document.getElementById('historico').style.display='none';
				document.getElementById('cidadao').style.display='none';
				document.getElementById('vinculada').style.display='';
				$('#td').css('display','none');
				
				document.getElementById('alterar').style.display='none';
				document.getElementById('btn_cidadao').style.display='none';
				document.getElementById('btn_vinculada').style.display='';
				document.getElementById('texto').innerHTML='Mensagem:';
				/*document.getElementById('resumo').value=document.getElementById('coment').value;*/
				document.getElementById('titulo').innerHTML='Enviar E-mail para Vinculada';
			break;
		}
	}
	/*function remover() {
		var str = document.getElementById('resumo').value;
		var limite = 360;
		if (str.length > limite) {
			while (str.length > limite) {
				var newStr = str.substring(0, str.length-1);
				document.getElementById('resumo').value = newStr;
				str = document.getElementById('resumo').value;
			}
		}
		document.getElementById('tamanho').innerHTML = limite - str.length;
	}*/
</script>
</head>

<body>
<p>Visualização da manifestação</p>
<div id='manifestacao'>
	<table width="100%" border="0">
		<tr class='odd'>
			<td width="15%" class="td">Protocolo:</td><td width="25%" class='textol'><?php echo $detalhes['protocolo'] ?></td>
			<td width="10%" class="td">Data:</td><td width="20%" class='textol'><?php echo $detalhes['data'] ?></td>
			<td width="10%" class="td">Data Limite:</td><td width="20%" class='textol' colspan=2><?php echo $detalhes['data_fim'] ?></td>
		</tr>
		<tr class="column1">
			<td class="td">Assunto</td>
			<td class="textol" id='valor_assunto'>
				<select name='assunto' id='assunto'>
					<option value='0'>N&Atilde;O INFORMADO</option>
					<?php while ($ra = mysql_fetch_array($resultado_assunto)) { ?>
						<option value='<?php echo $ra['id_assunto']; ?>'><?php echo $ra['assunto']; ?></option>
					<?php } ?>
				</select>
			</td>
			<td class="td">Tipo:</td>
			<td class='textol' colspan='3' id='valor_tipo'>
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
			<?php } else { ?>
				<?php echo $l['tipo']; ?>
			<?php } ?>
			</td>
		</tr>
		<tr class="column1">
			<td class="td">Status:</td><td class='textol'><?php echo $detalhes['status_atual'] ?></td>
			<td class="td">Prioridade:</td>
			<td colspan='3' id='valor_prioridade'>
				<select name='prioridade' id='prioridade'>
					<?php while ($rp = mysql_fetch_array($resultado_pri)) { ?>
						<option value='<?php echo $rp['id_prioridade']; ?>'><?php echo $rp['prioridade']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr class="odd">
			<td class="td">Nome:</td><td colspan="3" class='textol'><?php echo $detalhes['nome'] ?></td>
			<td class="td">CPF:</td><td class='textol'><?php echo $detalhes['cpf']; ?></td>
		</tr>
		<tr class="column1">
			<td class="td">Sexo:</td>
			<td class='textol'><?php echo ($detalhes['sexo'] != '') ? $detalhes['sexo'] : 'NÃO INFORMADO';?></td>
			<td class="td">Data Nascimento:</td>
			<td class='textol'><?php echo $detalhes['data_nasc'] ?></td>
			<td class="td">Tipo de usu&aacute;rio:</td>
			<td class="textol" id='valor_tipo_usuario'><?php //echo $detalhes['tipo_usuario'] ?>
				<select name='tipo_usuario' id='tipo_usuario'>
					<?php while ($rt = mysql_fetch_array($resultado_tipo)) { ?>
						<option value='<?php echo $rt['id_tipo_usuario']; ?>'><?php echo $rt['descricao']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr class="odd">
			<td class="td">Escolaridade:</td>
			<td class='textol'><?php echo ($detalhes['escolaridade'] != '') ? $detalhes['escolaridade'] : 'NÃO INFORMADO' ?></td>
			<td class="td">Defici&ecirc;ncia:</td>
			<td class='textol' colspan="3"><?php echo ($detalhes['deficiencia'] == '') ? 'Nenhuma' : $detalhes['deficiencia']; ?></td>
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
			<td class="textol" id='valor_entidade'>
				<?php if ($permissoes['alterar'] == 1) { ?>
				<select name="entidade_nova" id="entidade_nova">
				<?php for ($ent=0;$ent<mysql_num_rows($resultado_ent);$ent++) { ?>
					<?php $sel = ($detalhes['ent'] == mysql_result($resultado_ent,$ent,'id_entidade')) ? "selected='selected'" : ""; ?>
					<option value="<?php echo mysql_result($resultado_ent,$ent,'id_entidade'); ?>" <?php echo $sel; ?>>
					<?php echo mysql_result($resultado_ent,$ent,'entidade'); ?></option>
				<?php } ?>
				</select>
				<?php } else {?>
					<?php echo $detalhes['entidade']; ?>
				<?php } ?>
			</td>
			<td class="td">Modalidade de Ensino:</td>
			<td colspan="5" class='textol'>
				<?php if ($permissoes['alterar'] == 1) { ?>
					<select name='modalidade_nova' id='modalidade_nova'>
					<option value="0">N&Atilde;O INFORMADO</option>
					<?php for ($mod=0;$mod<mysql_num_rows($lista_modalidades);$mod++) { ?>
					<?php $sel = ($detalhes['id_modalidade'] == mysql_result($lista_modalidades,$mod,'id_modalidade')) ? "selected='selected'" : ""; ?>
					<option value="<?php echo mysql_result($lista_modalidades,$mod,'id_modalidade'); ?>" <?php echo $sel; ?>>
					<?php echo mysql_result($lista_modalidades,$mod,'modalidade'); ?></option>
					<?php } ?>
					</select>
				<?php } else { ?>
				<?php echo $detalhes['modalidade'] ?>
				<?php } ?>
			</td>
		</tr>
		<tr class="odd">
			<td class="td">Primeira Manifesta&ccedil;&atilde;o:</td>
			<td class='textol'><?php echo $detalhes['prim_rec'] ?></td>
			<td class="td">Protocolo(s) Anteriore(s):</td>
			<td colspan="5" class='textol'><?php echo $detalhes['protocolo_anterior'] ?></td>
		</tr>
		<tr class="column1">
			<td class="td">Coment&aacute;rio:</td><td colspan="7" class='textol'><?php echo nl2br($detalhes['comentario']); ?></td>
			<input type='hidden' name='coment' id='coment' value='<?php echo $detalhes['comentario']; ?>'>
		</tr>
		<?php if ($permissoes['alterar'] == 1) { ?>
		<tr class="odd" id='linha_inibicao'>
			<td colspan="6" class="td">Inibir dados do manifestante: 
				<select name='inibir_dados' id='inibir_dados'>
					<option value='0' <?php echo ($detalhes['inibir_dados'] == '0') ? "selected='selected'" : "" ?> >N&atilde;o</option>
					<option value='1'<?php echo ($detalhes['inibir_dados'] == '1') ? "selected='selected'" : "" ?>>Sim</option>
				</select>
			</td>
		</tr>
		<?php } ?>
	</table>
</div>
<form method='post' id='form' name='form'>
<input type='hidden' name='excluir' id='excluir' value = ''>
<input type='hidden' name='dados_manifestacao' id='dados_manifestacao'>
	<?php if ($permissoes['excluir']==1) { ?>
		<input type='submit' name='inibir' id='inibir' value = 'Inibir Manifestação' onclick='return confirmar_inibicao();'>
		<!--<img src='../../imagens/logo_excluir.jpg' class='btn_excluir' onclick='confirmar_exclusao();'>-->
	<?php } ?>
	
	<?php
	if (($permissoes['alterar']==1) && ($detalhes['id_status_atual']!=5))
	{
	?>
	<br />
	<table width="100%">
		<tr class="column1">
			<td height="28" class="td">
				<span class="style4">
					<a href="javascript:mostrar_div('historico')" class="textoo">Hist&oacute;rico</a>
					<a href="javascript:mostrar_div('cidadao')" class="textoo">Cidad&atilde;o</a>
					<a href="javascript:mostrar_div('vinculada')" class="textoo">Vinculada</a>
				</span>
			</td>
		</tr>
		<tr>
			<td height="34">
				<p id='titulo'>Altera&ccedil;&atilde;o do Status</p>
			</td>
		</tr>
	</table>
	
	<table width="100%" border="0">
		<tr class="column1">
			<td class="td">
				<div id='historico'>
					<span>Status</span>
					<?php if ($detalhes["id_status_atual"] == 2 && $id_destino == $_SESSION['entidade']) { ?>
						<select disabled>
							<option value=''>Respondida</option>
						</select>
					<?php } else { ?>
					<select name="novo_status" id="novo_status">
						<?php while ($ls = mysql_fetch_array($lista_status)) { 
							if ($ls['id_status'] != 5) { ?>
							<option value="<?php echo $ls['id_status']; ?>"><?php echo $ls['status']; ?></option>
						<?php }} ?>
					</select>
					<?php } ?>
				</div>
				<div id='cidadao' style='display:none'>
					Nome: <input type='text' value='<?php echo $l['nome']; ?>' id='nome_cidadao' name='nome_cidadao'>
					E-mail: <input type='text' value='<?php echo $l['email']; ?>' id='email_cidadao' name='email_cidadao'>
					C&oacute;pias: <input type='text' size='30px' value='' id='copia_cidadao' name='copia_cidadao'>
				</div>
				<div id='vinculada' style='display:none'>
					Nome: <input type='text' value='<?php echo $l['entidade']; ?>' id='nome_vinculada' name='nome_vinculada'>
					E-mail: <input type='text' value='' id='email_vinculada' name='email_vinculada'>
					C&oacute;pias: <input type='text' size='30px' value='' id='copia_vinculada' name='copia_vinculada'>
				</div>
			</td>
			
			<td class="td" id="td" <?php echo ($detalhes["id_status_atual"] == 2) ? "" : "style='display:none;'"; ?> >
				<label>Destino</label>
				<select name="entidade" id="entidade">
						<option value="">SELECIONE A ENTIDADE</option>
						<?php while ($s = mysql_fetch_array($resultado_entidade)) { ?>
						<option value="<?php echo $s['id_entidade']; ?>"><?php echo $s['entidade']; ?></option>
						<?php } ?>
				</select>
			</td>
			
		</tr>
		<tr class="odd">
			<td class="td" colspan=2><label>Resposta</label>
				<select name='resposta_padrao' id='resposta_padrao'>
					<?php while ($rs = mysql_fetch_array($lista_resposta)) { ?>
						<option value='<?php echo $rs['id_resposta_padrao']; ?>'><?php echo $rs['resposta_padrao']; ?></option>
					<?php } ?>
				</select>
			</td>			
		</tr>
		<tr class="column1">
			<td colspan="3" class="td">
				<span id='texto'>Resumo:</span><br>
				<textarea name="resumo" id="resumo" cols="70" rows="6"></textarea>
				<!--<span id='tamanho' style="font-family:Arial; font-size:12px; color:#666666; font-weight:bold;">360</span><span style="font-family:Arial; font-size:12px; color:#666666; font-weight:bold;"> caractere(s)</span>-->
			</td>
		</tr>
		<tr class='odd'>
			<td colspan=3>
				<input name="id_ouvidoria" type="hidden" value="<?php echo $detalhes['id_ouvidoria']; ?>" />
				<?php if ($detalhes['alt'] == 1) { ?>
					<br><input name="alterar" type="submit" value="Alterar" id="alterar"/>
				<?php } ?>
				<?php if ($detalhes["id_status_atual"] == 2 && $id_destino == $_SESSION['entidade']) { ?>
					<input type='hidden' name="novo_status" id="novo_status" value=5>
					<input type='hidden' name="entidade" id="entidade" value=<?php echo $id_origem; ?>>
				<?php } ?>
				<input type="submit" value="Enviar" id="btn_cidadao" name="btn_cidadao" style='display:none' />
				<input type="submit" value="Enviar" id="btn_vinculada" name="btn_vinculada" style='display:none' />
				<select name='publico' id='publico'>
					<option value=0>Privado</option>
					<option value=1>P&uacute;blico</option>
				</select>
			</td>
		</tr>
	</table>
</form>
<?php
}
if (mysql_num_rows($resultado_historico) > 0) {
?>
<p>Hist&oacute;rico</p>
<table id="historico" width="100%" border="0" class="tablesorter">
	<thead>
		<tr>
		    <th>Data</th>
		    <th>Status</th>
		    <th>Resumo</th>
			<th>Usu&aacute;rio</th>
		    <!--<th>Origem</th>-->
		    <th>Destino</th>
		    <th>Acesso</th>
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
		<!--<td><?php echo mysql_result($resultado_historico,$i,'origem'); ?></td>-->
		<td><?php echo mysql_result($resultado_historico,$i,'destino'); ?></td>
		<td><?php echo mysql_result($resultado_historico,$i,'acesso'); ?></td>
	</tr>
	<?php } ?>
</table>
<?php } ?>
<script>
<?php
if (($detalhes['alterar']==1) && (($detalhes['id_status_atual']!=3) && ($detalhes['id_status_atual']!=5)))
{
?>
if (document.getElementById('novo_status').value != 5) {
	document.getElementById('novo_status').value='<?php echo $detalhes["id_status_atual"]; ?>';
}
<?php 
}
?>
document.getElementById('prioridade').value = '<?php echo $detalhes['id_prioridade'] ?>';
document.getElementById('tipo_usuario').value = '<?php echo $detalhes['id_tipo_usuario'] ?>';
document.getElementById('assunto').value = '<?php echo $detalhes['id_assunto'] ?>';
</script>
</body>
</html>