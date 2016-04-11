<?php 
require ('../../controle/backup/processo.php');
Processo('processo_d');
$l=mysql_fetch_array($r);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DEN&Uacute;NCIA - BACKUP</title>
<link href="../../css/backup/style_all.css" rel="stylesheet" type="text/css"/>
<link href="../../css/backup/style_historico.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery.tablesorter.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#resposta").change(function(){
			$.post('../../controle/backup/processo.php',{id: $(this).val()},function(resposta){$("#resumo").html(resposta);});	
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
		
		$("#entidade_nova").change(function(){
			if (confirm("Tem certeza que deseja alterar a entidade?")) {
				$.post('../../controle/backup/processo.php',{entidade_nova: $(this).val(),id_ouvidoria: <?php echo $_GET['p']; ?>});	
			}
			else {
				$("#entidade_nova").val(<?php echo $l['ent']; ?>)
			}
		});
		
	});
</script>
<script>
	function confirmar_exclusao() {
		if (!confirm('Tem certeza que deseja excluir essa denúncia?')) {
			return false;
		}
		else {
			document.getElementById('excluir').value = 1;
			document.form.submit();
		}
	}
	function confirmar_inibicao() {
		if (!confirm('Tem certeza que deseja inibir essa denúncia?')) {
			return false;
		}
	}
</script>
</head>

<body>
<p>Visualiza&ccedil;&atilde;o da Den&uacute;ncia</p>

<table width="100%" border="0">
  <tr class="odd">
  <td width="15%" class="td">Protocolo:</td><td width="25%" class="textol"><?php echo $l['protocolo'] ?></td>
  <td width="10%" class="td">Data:</td><td width="20%" class="textol"><?php echo $l['data'] ?></td>
  <td width="10%" class="td">Data Limite:</td><td width="20%" class="textol"><?php echo $l['data_fim'] ?></td>
</tr>
  <tr class="column1">
    <td class="td">Nome:</td><td colspan="5" class="textol"><?php echo $l['nome_ouvidoria'] ?></td>

  </tr>
  <tr class="odd">
    <td class="td">Data Nascimento:</td><td class="textol"><?php echo $l['data_nasc'] ?></td>
    <td class="td">Primeira Manifesta&ccedil;&atilde;o:</td><td class="textol"><?php echo $l['prim_rec'] ?></td>
    <td class="td">Status:</td><td class="textol"><?php echo $l['status_atual'] ?></td>
  </tr>
 <tr class="column1">
    <td class="td">E-mail:</td>
    <td colspan="5" class="textol"><?php echo $l['email'] ?></td>
  </tr>
  <tr class="odd">
    <td class="td">Endere&ccedil;o:</td>
    <td colspan="5" class="textol"><?php echo $l['endereco'] ?></td>
  </tr>
  <tr class="column1">
    <td class="td">Bairro:</td><td class="textol"><?php echo $l['bairro'] ?></td>
    <td class="td">Cidade:</td><td colspan="3" class="textol"><?php echo $l['cidade'] ?></td>
  </tr>
   <tr class="odd">
    <td class="td">Telefone:</td><td class="textol"><?php echo $l['telefone'] ?></td>
    <td class="td">Celular:</td><td colspan="3" class="textol"><?php echo $l['celular'] ?></td>
  </tr>
  <tr class="column1">
    <td class="td">Escolaridade:</td><td colspan="5" class="textol"><?php echo $l['escolaridade'] ?></td> 
  </tr>
   <tr class="odd">
    <td class="td">Entidade:</td>
	<td class="textol" colspan=5>
	<?php if ($l['alterar'] == 1) { ?>
		<select name="entidade_nova" id="entidade_nova">
		<?php for ($ent=0;$ent<mysql_num_rows($resultado_entidades);$ent++) { ?>
			<?php $sel = ($l['ent'] == mysql_result($resultado_entidades,$ent,'id_entidade')) ? "selected='selected'" : ""; ?>
			<option value="<?php echo mysql_result($resultado_entidades,$ent,'id_entidade'); ?>" <?php echo $sel; ?>>
			<?php echo mysql_result($resultado_entidades,$ent,'entidade'); ?></option>
		<?php } ?>
		</select>
	<?php } else {?>
		<?php echo $l['entidade']; ?>
	<?php } ?>
	</td>
	</tr>
 <tr class="column1">
  <td class="td">Den&uacute;ncia:</td><td colspan="5" class="textol"><?php echo nl2br($l['comentario']) ?></td>
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
<input type='hidden' name='excluir' id='excluir' value = ''>
<?php if ($l['excluir']==1) { ?>
	<input type='submit' name='inibir' id='inibir' value = 'Inibir Denúncia' onclick='return confirmar_inibicao();'>
	<!--<img src='../../imagens/logo_excluir.jpg' class='btn_excluir' onclick='confirmar_exclusao();'>-->
<?php } ?>

<?php
if (($l['alterar']==1) && ($l['id_status_atual']!=5))
{
?>
<br />
<p>Altera&ccedil;&atilde;o do Status</p>
<table width="100%" border="0">
<tr class="column1">
<td class="td">Altera&ccedil;&atilde;o do Status</td>
</tr>
<tr class="odd">
<td class="td">Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <select name="status" id="status">
	<?php while ($ls = mysql_fetch_array($rs)) { 
			if ($ls['id_status'] != 5 && $ls['id_status'] != 4) { ?>
			<option value="<?php echo $ls['id_status']; ?>"><?php echo $ls['status']; ?></option>
	<?php }} ?>
  </select></td>
</tr>
<tr class="column1">
<td class="td"><label>Resposta</label>
<select name='resposta' id='resposta'>
	<?php while ($res = mysql_fetch_array($rr)) { ?>
		<option value="<?php echo $res['id_resposta_padrao']; ?>"><?php echo $res['resposta_padrao']; ?></option>
	<?php } ?>
</select></td>
</tr>
<tr class="odd">
<td class="td">
<span>Resumo:</span>
  <textarea name="resumo" id="resumo" cols="90" rows="6"></textarea>
</td>
</tr>
<tr class="column1">
<td><br>
<input type="submit" value="Alterar" id="alterar" name="alterar" />
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
<table width="100%" border="0" class="tablesorter" id="historico">
<thead>
<tr>
<th>Data</th>
<th>Status</th>
<th>Resumo</th>
<th>Usu&aacute;rio</th>
<th>Acesso</th>
</tr>
</thead>
<tbody>
<?php 
while ($l=mysql_fetch_array($rh)) {

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
	<td>".$l['acesso']."</td>
    </tr>";
 
 }


?>
</tbody>
</table>
</form>
</body>
</html>