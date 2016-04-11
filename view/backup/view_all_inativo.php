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
	            //origem
	            sorter: false 
	        },
			4: { 
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
			$.post('../../controle/backup/processo.php',{entidade: $(this).val(),id_ouvidoria: <?php echo $_GET['p']; ?>});	
		}
		else {
			$("#entidade").val(<?php echo $l['ent']; ?>)
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
	function confirmar_restauracao() {
		if (!confirm('Tem certeza que deseja restaurar essa manifestação?')) {
			return false;
		}
	}
</script>
</head>

<body>
<p>Visualiza&ccedil;&atilde;o da Manifesta&ccedil;&atilde;o</p>
<table width="100%" border="0">
  <tr class="odd">
    <td width="15%" class="td">Protocolo:</td><td width="25%" class="textol"><?php echo $l['protocolo'] ?></td>
    <td width="10%" class="td">Data:</td><td width="20%" class="textol"><?php echo $l['data'] ?></td>
    <td width="10%" class="td">Data Limite:</td><td width="20%" class="textol" colspan=3><?php echo $l['data_fim'] ?></td>
  </tr>
<tr class="column1">
    <td class="td">Assunto:</td><td class="textol"><?php echo $l['assunto'] ?></td>
    <td class="td">Status:</td><td class="textol"><?php echo $l['status_atual'] ?></td>
    <td class="td">Prioridade:</td><td class="textol" colspan=3><?php echo $l['prioridade'];?>
<!--<select name="prioridade" id="prioridade">
    <option value="1">Normal</option>
    <option value="2">Urgente</option>
    </select>
    <script>document.getElementById('prioridade').value=<?php echo $l['id_prioridade'];?></script>-->

</td>
   
  </tr>

  <tr class="odd">
    <td class="td">Nome:</td><td colspan="7" class="textol"><?php echo $l['nome'] ?></td>

  </tr>
  <tr class="column1">
    <td class="td">Sexo:</td>
    <td class="textol"><?php echo $l['sexo'] ?></td>
    <td class="td">Data Nascimento:</td>
    <td class="textol"><?php echo $l['data_nasc'] ?></td>
	<td class="td">Tipo de usu&aacute;rio:</td><td class="textol"><?php echo $l['tipo_usuario'] ?></td>
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
	<td class="textol">
	<?php /*if ($l['alterar'] == 1) { ?>
		<select name="entidade_nova" id="entidade_nova">
		<?php for ($ent=0;$ent<mysql_num_rows($resultado_entidades);$ent++) { ?>
			<?php $sel = ($l['ent'] == mysql_result($resultado_entidades,$ent,'id_entidade')) ? "selected='selected'" : ""; ?>
			<option value="<?php echo mysql_result($resultado_entidades,$ent,'id_entidade'); ?>" <?php echo $sel; ?>>
			<?php echo mysql_result($resultado_entidades,$ent,'entidade'); ?></option>
		<?php } ?>
		</select>
	<?php } else {*/?>
		<?php echo $l['entidade']; ?>
	<?php //} ?>
	</td>
    <td class="td">Primeira Manifesta&ccedil;&atilde;o:</td>
    <td colspan="5" class="textol"><?php echo $l['prim_rec'] ?></td>
  </tr>
  <tr class="odd">
  <td class="td">Coment&aacute;rio:</td><td colspan="7" class="textol"><?php echo nl2br($l['comentario']) ?></td>
    </tr>
	<?php if ($l['anexo1'] != '') { ?>
		<tr class='column1'>
			<td class='td'>Anexos:</td>
			<td class='texto1' colspan=5>
				<?php echo "<a href='../../anexos/".$l['anexo1']."'>Anexo 1</a>";
				if ($l['anexo2'] != '') {
					echo "&nbsp;&nbsp;<a href='../../anexos/".$l['anexo2']."'>Anexo 2</a>";
				}
				?>
			</td>
		</tr>
	<?php } ?>
   </table>

<form method="post" id="form" name='form'>   
<input type='hidden' name='status' id='status' value = '<?php echo $l['id_status_atual']; ?>'>
<input type='hidden' name='excluir' id='excluir' value = ''>
<?php if ($l['excluir']==1) { ?>
	<input type='submit' name='restaurar' id='restaurar' value = 'Restaurar Manifestação' onclick='return confirmar_restauracao();'>
	<!--<img src='../../imagens/logo_excluir.jpg' class='btn_excluir' onclick='confirmar_exclusao();'>-->
<?php } ?>

<?php/*
if (($l['alterar']==1) && (($l['id_status_atual']!=3) && ($l['id_status_atual']!=5)))
{
?>
<br />
<p>Altera&ccedil;&atilde;o do Status</p>

<table width="100%" border="0">
<tr class="column1">
<td class="td">Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<select name="status" id="status">
<option value="1">Nova</option>
<option value="2">Encaminhada</option>
<option value="3">Atendida</option>
<option value="4">Pendente</option>
</select>
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
<span>Resumo:</span>
<textarea name="resumo" id="resumo" cols="90" rows="6"></textarea></td>
</tr>
<tr class="odd">
<td><br><input type="submit" value="Alterar" id="alterar" name="alterar" /></td>
</tr>
</table>
</form>
<?php
}*/
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
  </tr>
</thead>
<tbody>
<?php 

while ($l=mysql_fetch_array($res_o))
{

$cor='#000000';
  
if ($l['status']=='Atendida')
$cor='#1d6302';

if ($l['status']=='Encaminhada')
$cor='#d08a03';

if ($l['status']=='Pendente')
$cor='#a30d02';

if ($l['status']=='Reiterada')
$cor='#FF0066';

echo "<tr style='color:$cor;font-weight:bold'>
    <td>".$l['hdata']."</td>
    <td>".$l['status']."</td>
    <td>".$l['resumo']."</td>
	<td>".$l['nome']."</td>
    <td>".$l['origem']."</td>
    <td>".$l['destino']."</td>
    </tr>";
 
 }


?>
</tbody>
</table>
</body>
</html>