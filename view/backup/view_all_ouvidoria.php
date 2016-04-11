<?php 
require ('../../controle/backup/processo.php');
Processo('processo');
$l=mysql_fetch_array($r);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>OUVIDORIA - BACKUP</title>
<link href="../../css/backup/style_all.css" rel="stylesheet" type="text/css"/>
<link href="../../css/backup/style_historico.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery.tablesorter.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#status").change(function(){
		if ($(this).val()=='2'){
			$('#td').css('display','block');
		}
		else {
			$('#td').css('display','none');
		}
	});

	$("#historico").tablesorter({
		headers: { 
	        // colunas que não estão com sort
	        2: { 
	            //resumo
	            sorter: false 
	        },
			3: { 
	            //usuario
	            sorter: false 
	        },
			4: { 
	            //origem
	            sorter: false 
	        },
			5: { 
	            //destino
	            sorter: false 
	        }			
	    } 
	}); 

	$("#prioridade").change(function(){
		if (confirm("Tem certeza que deseja alterar a prioridade?")) {
			$.post('../../controle/backup/processo.php',{prioridade: $(this).val(),id_ouvidoria: <?php echo $_GET['p']; ?>});	
		}
		else {
			if ($("#prioridade").val()==1) {
				$("#prioridade").val(2);
			}
			else {
				$("#prioridade").val(1);
			}
		}
	});

	$("#entidade_nova").change(function(){
		if (confirm("Tem certeza que deseja alterar a entidade?")) {
			$.post('../../controle/backup/processo.php',{entidade_nova: $(this).val(),id_ouvidoria: <?php echo $_GET['p']; ?>});	
		}
		else {
			$("#entidade_nova").val(<?php echo $l['ent']; ?>)
		}
	});
	
	$("#assunto_novo").change(function(){
		if (confirm("Tem certeza que deseja alterar o assunto?")) {
			$.post('../../controle/backup/processo.php',
			{assunto_novo: $(this).val(),id_ouvidoria: <?php echo $_GET['p']; ?>},
			function(resposta){$("#sub").html(resposta);});
		}
		else {
			$("#assunto_novo").val(<?php echo $l['id_assunto']; ?>)
		}
	});
	
	//$("#subitem").live("change", function(){
	$("#subitem").change(function(){
		if (confirm("Tem certeza que deseja alterar o Subitem?")) {
			$.post('../../controle/backup/processo.php',
			{subitem: $(this).val(),assunto: $("#assunto_novo").val(),id_ouvidoria: <?php echo $_GET['p']; ?>},
			function(resposta){$("#sub").html(resposta);});
		}
		else {
			$("#subitem").val('')
		}
	});
	
	$("#resposta").change(function(){
		$.post('../../controle/backup/processo.php',{id: $(this).val()},function(resposta){$("#resumo").html(resposta);});	
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
				
				document.getElementById('alterar').style.display='';
				document.getElementById('btn_cidadao').style.display='none';
				document.getElementById('btn_vinculada').style.display='none';
				document.getElementById('texto').innerHTML='Resumo:';
				document.getElementById('titulo').innerHTML='Alteração do Status';
			break;
			case 'cidadao':
				document.getElementById('historico').style.display='none';
				document.getElementById('cidadao').style.display='';
				document.getElementById('vinculada').style.display='none';
				
				document.getElementById('alterar').style.display='none';
				document.getElementById('btn_cidadao').style.display='';
				document.getElementById('btn_vinculada').style.display='none';
				document.getElementById('texto').innerHTML='Mensagem:';
				document.getElementById('titulo').innerHTML='Enviar E-mail para Cidadão';
			break;
			case 'vinculada':
				document.getElementById('historico').style.display='none';
				document.getElementById('cidadao').style.display='none';
				document.getElementById('vinculada').style.display='';
				
				document.getElementById('alterar').style.display='none';
				document.getElementById('btn_cidadao').style.display='none';
				document.getElementById('btn_vinculada').style.display='';
				document.getElementById('texto').innerHTML='Mensagem:';
				document.getElementById('titulo').innerHTML='Enviar E-mail para Vinculada';
			break;
		}
	}
</script>
</head>

<body>
<p>Visualiza&ccedil;&atilde;o da Manifesta&ccedil;&atilde;o</p>
<table width="100%" border="0">
  <tr class="odd">
    <td width="15%" class="td">Protocolo:</td>
    <td width="25%" class="textol"><?php echo $l['protocolo'] ?></td>
    <td width="10%" class="td">Data:</td>
    <td width="20%" class="textol"><?php echo $l['data'] ?></td>
    <td width="10%" class="td">Data Limite:</td>
    <td width="20%" class="textol" colspan=3><?php echo $l['data_fim'] ?></td>
  </tr>
  <tr class="column1">
    <td class="td">Assunto:</td>
    <td class="textol"><?php if ($l['alterar'] == 1) { ?>
        <select name="assunto_novo" id="assunto_novo">
          <?php for ($ass=0;$ass<mysql_num_rows($resultado_assunto);$ass++) {
			if (mysql_result($resultado_assunto,$ass,'id_assunto') != 8) { ?>
          <?php $sel = ($l['id_assunto'] == mysql_result($resultado_assunto,$ass,'id_assunto')) ? "selected='selected'" : ""; ?>
          <option value="<?php echo mysql_result($resultado_assunto,$ass,'id_assunto'); ?>" <?php echo $sel; ?>> <?php echo mysql_result($resultado_assunto,$ass,'assunto'); ?></option>
          <?php } ?>
          <?php } ?>
        </select>
        <?php } else {?>
        <?php echo $l['assunto']; ?>
        <?php } ?>
    </td>
    <td class="td">Status:</td>
    <td class="textol"><?php echo $l['status_atual'] ?></td>
    <td class="td">Prioridade:</td>
    <td class="textol" colspan=3><select name="prioridade" id="prioridade">
      <option value="1">Normal</option>
      <option value="2">Urgente</option>
    </select>
        <script>document.getElementById('prioridade').value=<?php echo $l['id_prioridade'];?></script>
    </td>
  </tr>
  <tr class='column1' id='tr_sub' style="visibility:hidden;position:absolute">
	<td class='td'>Subitem</td>
	<td class='texto1' colspan=5 id='sub'>
		<select name='subitem' id='subitem'>
			<option value=''>Nenhum</option>
			<?php while ($s = mysql_fetch_array($lista_sub)) { ?>
				<?php $sel = ($l['id_subitem'] == $s['id_subitem']) ? "selected='selected'" : ''; ?>
				<option value=<?php echo $s['id_subitem']." ".$sel; ?>><?php echo $s['subitem']; ?></option>
			<?php } ?>
		</select></td>
	<?php if ($l['id_subitem'] != '' || mysql_num_rows($lista_sub) > 0) { ?>
		<script>document.getElementById('tr_sub').style.visibility='visible';</script>
		<script>document.getElementById('tr_sub').style.position='relative';</script>
	<?php } ?>
  </tr>
  <tr class="odd">
    <td class="td">Nome:</td>
    <td colspan="7" class="textol"><?php echo $l['nome'] ?></td>
  </tr>
  <tr class="column1">
    <td class="td">Sexo:</td>
    <td class="textol"><?php echo $l['sexo'] ?></td>
    <td class="td">Data Nascimento:</td>
    <td class="textol"><?php echo $l['data_nasc'] ?></td>
    <td class="td">Tipo de usu&aacute;rio:</td>
    <td class="textol"><?php echo $l['tipo_usuario'] ?></td>
  </tr>
  <tr class="odd">
    <td class="td">Escolaridade:</td>
    <td colspan="7" class="textol"><?php echo $l['escolaridade'] ?></td>
  </tr>
  <tr  class="column1">
    <td class="td">E-mail:</td>
    <td colspan="7" class="textol"><?php echo $l['email'] ?></td>
  </tr>
  <tr class="odd">
    <td class="td">Endere&ccedil;o:</td>
    <td colspan="7" class="textol"><?php echo $l['endereco'] ?></td>
  </tr>
  <tr class="column1">
    <td class="td">Bairro:</td>
    <td class="textol"><?php echo $l['bairro'] ?></td>
    <td class="td">Cidade:</td>
    <td colspan="5" class="textol"><?php echo $l['cidade'] ?></td>
  </tr>
  <tr class="odd">
    <td class="td">Telefone:</td>
    <td class="textol"><?php echo $l['telefone'] ?></td>
    <td class="td">Celular:</td>
    <td colspan="5" class="textol"><?php echo $l['celular'] ?></td>
  </tr>
  <tr class="column1">
    <td class="td">Entidade:</td>
    <td class="textol"><?php if ($l['alterar'] == 1) { ?>
        <select name="entidade_nova" id="entidade_nova">
          <?php for ($ent=0;$ent<mysql_num_rows($resultado_entidades);$ent++) { ?>
          <?php $sel = ($l['ent'] == mysql_result($resultado_entidades,$ent,'id_entidade')) ? "selected='selected'" : ""; ?>
          <option value="<?php echo mysql_result($resultado_entidades,$ent,'id_entidade'); ?>" <?php echo $sel; ?>> <?php echo mysql_result($resultado_entidades,$ent,'entidade'); ?></option>
          <?php } ?>
        </select>
        <?php } else {?>
        <?php echo $l['entidade']; ?>
        <?php } ?>
    </td>
    <td class="td">Primeira Manifesta&ccedil;&atilde;o:</td>
    <td colspan="5" class="textol"><?php echo $l['prim_rec'] ?></td>
  </tr>
  <tr class="odd">
    <td class="td">Coment&aacute;rio:</td>
    <td colspan="7" class="textol"><?php echo nl2br($l['comentario']) ?></td>
  </tr>
  <?php if ($l['anexo1'] != '') { ?>
  <tr class='column1'>
    <td class='td'>Anexos:</td>
    <td class='texto1' colspan=5><?php echo "<a href='../../anexos/".$l['anexo1']."'>Anexo 1</a>";
				if ($l['anexo2'] != '') {
					echo "&nbsp;&nbsp;<a href='../../anexos/".$l['anexo2']."'>Anexo 2</a>";
				}
				?> </td>
  </tr>
  <?php } ?>
</table>
<form method="post" id="form" name='form'>   

  <input type='hidden' name='excluir' id='excluir' value = ''>
  <?php if ($l['excluir']==1) { ?>
    <input type='submit' name='inibir' id='inibir' value = 'Inibir Manifestação' onclick='return confirmar_inibicao();' >
    <!--<img src='../../imagens/logo_excluir.jpg' class='btn_excluir' onclick='confirmar_exclusao();'>-->
    <?php } ?>
    <?php
if (($l['alterar']==1) && ($l['id_status_atual']!=5))
{
?>
  <table width="100%">
  <tr class="column1"> <td height="28" class="td">
  <span class="style4"><a href="javascript:mostrar_div('historico')" class="textoo">Hist&oacute;rico</a>
  <a href="javascript:mostrar_div('cidadao')" class="textoo">Cidad&atilde;o</a>
  <a href="javascript:mostrar_div('vinculada')" class="textoo">Vinculada</a></span></td>
</tr>
<tr> <td height="34">
  <p id='titulo'>Altera&ccedil;&atilde;o do Status</p></td></tr>
</table>
  <table width="100%" border="0">
	<tr class="column1">
	<td class="td">
		<div id='historico'>
			Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<select name="status" id="status">
				<?php while ($ls = mysql_fetch_array($lista_status)) { 
					if ($ls['id_status'] != 5 && $ls['id_status'] != 4) { ?>
						<option value="<?php echo $ls['id_status']; ?>"><?php echo $ls['status']; ?></option>
				<?php }} ?>
			</select>
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

	<td class="td" id="td" style="display:none;" >
	<label>Destino</label>
	<select name="destino" id="destino">
	<?php while ($s = mysql_fetch_array($resultado_ent)) { ?>
		<option value="<?php echo $s['id_entidade']; ?>"><?php echo $s['entidade']; ?></option>
	<?php } ?>
	</select>
	</td>
	</tr>
	<tr class="odd">
	<td class="td" colspan="2"><label>Resposta</label>
	<select name="resposta" id="resposta">
	<?php while ($rs = mysql_fetch_array($lista_resposta)) { ?>
		<option value='<?php echo $rs['id_resposta_padrao']; ?>'><?php echo $rs['resposta_padrao']; ?></option>
	<?php } ?>
	</select>
	</td>
	</tr>
	<tr class="column1">
	<td colspan="3" class="td">
	<span id='texto'>Resumo:</span>
	<textarea name="resumo" id="resumo" cols="90" rows="6"></textarea></td>
	</tr>
	<tr class="odd">
	<td><br>
		<input type="submit" value="Alterar" id="alterar" name="alterar" />
		<input type="submit" value="Enviar" id="btn_cidadao" name="btn_cidadao" style='display:none' />
		<input type="submit" value="Enviar" id="btn_vinculada" name="btn_vinculada" style='display:none' />
		<select name='publico' id='publico'>
			<option value=1>P&uacute;blico</option>
			<option value=0>Privado</option>
		</select>
	</td>
	</tr>
  </table>
</form>
<?php
}
?>
<br /><br />
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
    <th>Acesso</th>
  </tr>
</thead>
<tbody>
<?php 

while ($lh=mysql_fetch_array($res_o))
{

$cor='#000000';
  
if ($lh['status']=='Atendida')
$cor='#1d6302';

if ($lh['status']=='Encaminhada')
$cor='#d08a03';

if ($lh['status']=='Pendente')
$cor='#a30d02';

if ($lh['status']=='Reiterada')
$cor='#FF0066';

echo "<tr style='color:$cor;font-weight:bold'>
    <td>".$lh['hdata']."</td>
    <td>".$lh['status']."</td>
    <td>".$lh['resumo']."</td>
    <td>".$lh['nome']."</td>
    <td>".$lh['origem']."</td>
    <td>".$lh['destino']."</td>
    <td>".$lh['acesso']."</td>
    </tr>";
 
}


?>
</tbody>
</table>
</body>
</html>
<script>
	document.getElementById('status').value=<?php echo $l['id_status_atual']; ?>;
	document.getElementById('subitem').value='<?php echo $l['id_subitem']; ?>';
</script>