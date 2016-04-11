<?php
require_once('../../controle/faetec/relatorios.php');
controle_relatorios('comparativos');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Ouvidoria - FAETEC</title>
		<link rel="stylesheet" type="text/css" href="../../css/style_rel.css" />
		<link rel="stylesheet" type="text/css" href="../../css/datePicker.css" />
		<script src="../../js/jquery.validate.js" type="text/javascript"></script>
		<script src="../../js/jquery.maskedinput.js" type="text/javascript"></script>
		<script type="text/javascript" src="../../js/jquery.datePicker.js"></script>
		<script type="text/javascript" src="../../js/date.js"></script>
		<script type="text/javascript">
		$().ready(function() {
			$("#tipo").change(function() {
				$("select").each(function() {
					var id = $(this).attr('id');
					if (id == $("#tipo").val()) {
						$(this).val('');
						$(this).attr('disabled',true);
						$("#desc_tipo").val($("#tipo :selected").text());
					}
					else {
						$(this).attr('disabled',false);
					}
				});
				
				if ($(this).val() == 'assunto' || $(this).val() == 'entidade') {
					$("#tipo_grafico").val('barras');
				}
			});
			
			$("#tipo_grafico").change(function() {
				if ($("#tipo").val() == 'assunto' || $("#tipo").val() == 'entidade') {
					$(this).val('barras');
				}
			});
			
			$("select").change(function() {
				if ($(this).attr('id') != 'tipo') {
					var campo = $(this).attr('id');
					var filtro = "#"+campo;
					$("#desc_"+campo).val($(filtro+" :selected").text());
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
		<p>Comparativos</p>
		<form action="../../controle/faetec/rel_comparativos.php" method="post" name="form" target="blank">
			<input type='hidden' name='desc_tipo' id='desc_tipo' value='Entidade'>
			<input type='hidden' name='desc_entidade' id='desc_entidade' value=''>
			<input type='hidden' name='desc_modalidade' id='desc_modalidade' value=''>
			<input type='hidden' name='desc_status' id='desc_status' value=''>
			<input type='hidden' name='desc_assunto' id='desc_assunto' value=''>
			<input type='hidden' name='desc_deficiencia' id='desc_deficiencia' value=''>
			<input type='hidden' name='desc_tipo_usuario' id='desc_tipo_usuario' value=''>
			<input type='hidden' name='desc_tipo_manifestacao' id='desc_tipo_manifestacao' value=''>
			<input type='hidden' name='desc_canais' id='desc_canais' value=''>
			<table>
				<tr>
					<td><span>Tipo de comparativo:</span></td>
					<td><select name="tipo" id="tipo" style='line-height:8px; width:550px; font-size:11px;'>
							<option value="entidade">Entidade</option>
							<option value="modalidade">Modalidade</option>
							<option value="status">Status</option>
							<option value="assunto">Assunto</option>
							<option value="tipo_usuario">Tipo de Usu&aacute;rio</option>
							<option value="deficiencia">Defici&ecirc;ncia</option>
							<option value="tipo_manifestacao">Tipo</option>
							<option value="canais">Canais</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><span>Secretaria/Autarquia:</span></td>
					<td><select name="entidade" id="entidade" style='line-height:8px; width:550px; font-size:11px;' disabled>
							<option value="">Todas as entidades</option>
							<?php while ($u = mysql_fetch_array($lista_entidades)) { ?>
							<option value="<?php echo $u['id_entidade']; ?>"><?php echo $u['entidade']; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><span>Modalidade:</span></td>
					<td><select name="modalidade" id="modalidade" style='line-height:8px; width:550px; font-size:11px;'>
							<option value="">Todas as modalidades</option>
							<?php while ($u = mysql_fetch_array($lista_modalidades)) { ?>
							<option value="<?php echo $u['id_modalidade']; ?>"><?php echo $u['modalidade']; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><span>Status:</span></td>
					<td><select name="status" id="status" style='line-height:8px; width:550px; font-size:11px;'>
							<option value="">Todos os status</option>
							<?php while ($s = mysql_fetch_array($lista_status)) { ?>
							<option value="<?php echo $s['id_status']; ?>"><?php echo $s['status']; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><span>Assunto:</span></td>
					<td><select name="assunto" id="assunto" style='line-height:8px; width:550px; font-size:11px;'>
							<option value="">Todos os assuntos</option>
							<?php while ($a = mysql_fetch_array($lista_assunto)) { ?>
							<option value="<?php echo $a['id_assunto']; ?>"><?php echo $a['assunto']; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><span>Tipo de usu&aacute;rio:</span></td>
					<td><select name="tipo_usuario" id="tipo_usuario" style='line-height:8px; width:550px; font-size:11px;'>
							<option value="">Todos os tipos</option>
							<?php while ($t = mysql_fetch_array($lista_tipo_usuario)) { ?>
							<option value="<?php echo $t['id_tipo_usuario']; ?>"><?php echo $t['descricao']; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><span>Defici&ecirc;ncia:</span></td>
					<td><select name="deficiencia" id="deficiencia" style='line-height:8px; width:550px; font-size:11px;'>
							<option value="">Todas as defici&ecirc;ncias</option>
							<?php while ($t = mysql_fetch_array($lista_deficiencia)) { ?>
							<option value="<?php echo $t['id']; ?>"><?php echo $t['deficiencia']; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><span>Tipo de manifesta&ccedil;&atilde;o:</span></td>
					<td><select name='tipo_manifestacao' id='tipo_manifestacao' style='line-height:8px; width:550px; font-size:11px;'>
							<option value=''>Todos os tipos</option>
							<?php while ($a = mysql_fetch_array($lista_tipos)) { ?>
							<option value='<?php echo $a['id_tipo']; ?>'><?php echo $a['tipo']; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><span>Canais de acesso:</span></td>
					<td><select name='canais' id='canais' style='line-height:8px; width:550px; font-size:11px;'>
							<option value=''>Todos os canais</option>
							<?php while ($c = mysql_fetch_array($lista_canais)) { ?>
							<option value='<?php echo $c['id_canal']; ?>'><?php echo $c['canal']; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><span>Data inicial:</span> </td>
					<td><input type='text' name='data_inicial' id='data_inicial' value='' size="11" maxlength="10"></td>
				</tr>
				<tr>
					<td><span>Data final:</span> </td>
					<td><input type='text' name='data_final' id='data_final' value='' size="11" maxlength="10"></td>
				</tr>
				<tr>
					<td><span>Tipo de gr&aacute;fico:</span> </td>
					<td>
						<select name='tipo_grafico' id='tipo_grafico'>
							<option value='barras'>Barras</option>
							<option value='pizza'>Pizza</option>
						</select>
					</td>
				<tr>
					<td>
						<input type="button" value="Gerar" id="gerar" onclick="document.form.submit();">
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>