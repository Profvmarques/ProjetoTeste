<?php 
require_once('../../controle/faetec/processos.php');
controle_processos('bloco');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Ouvidoria - FAETEC</title>
		<link rel="stylesheet" type="text/css" href="../../css/faetec/style_historico.css"/>
		<link rel="stylesheet" type="text/css" href="../../css/style_rel.css" />
		<link rel="stylesheet" type="text/css" href="../../css/faetec/style_bloco.css" />
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
				
				//listar processos
				$("#filtrar").click(function() {
					$("#processos").html("<img src='../../imagens/faetec/loading2.gif'>");
					$.post('../../controle/faetec/processos.php',{filtrar_bloco:1,status:$("#status").val(),tipo:$("#tipo").val(),
					entidade:$("#entidade").val(),modalidade:$("#modalidade").val(),deficiencia:$("#deficiencia").val(),
					data_inicial:$("#data_inicial").val(),data_final:$("#data_final").val()},
					function (resposta) {
						$("#resposta").fadeIn();
						$("#exibir_total").fadeIn();
						$("#processos").html(resposta);
						$("#total").html($("#tabela tr").length-1);
					});
				});
				
				//responder
				$("#alterar").click(function() {
					$("#acoes").html("Realizando altera&ccedil;&otilde;es... <img src='../../imagens/faetec/loading2.gif'>");
					var num = $("input[name=processos_escolhidos]:checked").length;
					var ids = new Array();
					$("input[name=processos_escolhidos]:checked").each(function(i) {
						ids[ids.length] = $(this).val()
					});
					if (ids.length > 0) {
						$.post('../../controle/faetec/processos.php',{escolhido:1,ids:ids.join("|"),novo_status:$("#novo_status").val(),
						resposta_padrao:$("#resposta_padrao").val(),resumo:$("#resumo").val(),publico:$("#publico").val()},
						function (resposta) {
							alert('Alterações realizadas');
							window.location=window.location;
						});
					}
				});
				
				//responder
				$("#inibir").click(function() {
					$("#acoes").html("Realizando altera&ccedil;&otilde;es... <img src='../../imagens/faetec/loading2.gif'>");
					var num = $("input[name=processos_escolhidos]:checked").length;
					var ids = new Array();
					$("input[name=processos_escolhidos]:checked").each(function(i) {
						ids[ids.length] = $(this).val()
					});
					if (ids.length > 0) {
						$.post('../../controle/faetec/processos.php',{inibir_blobo:1,ids:ids.join("|")},
						function (resposta) {
							alert('Alterações realizadas');
							window.location=window.location;
						});
					}
				});
				
				//enviar email cidadao
				$("#btn_cidadao_bloco").click(function() {
					var ids = new Array();
					$("input[name=processos_escolhidos]:checked").each(function(i) {
						ids[ids.length] = $(this).val()
					});
					if (ids.length > 0) {
						$("#acoes").html("Enviando... <img src='../../imagens/faetec/loading2.gif'>");
						$(this).attr('disabled',true);
						$.post('../../controle/faetec/processos.php',{email_bloco:1,email:$("#email_cidadao").val(),destino:'Cidadão',
						nome:$("#nome_cidadao").val(),copia:$("#copia_cidadao").val(),resumo:$("#resumo").val(),publico:$("#publico").val()},
						function (resposta) {
							if (resposta == 1) {
								alert('Mensagem enviada');
								$.post('../../controle/faetec/processos.php',{historico_bloco:1,ids:ids.join("|"),
								email:$("#email_cidadao").val(),destino:'Cidadão',copia:$("#copia_cidadao").val(),publico:$("#publico").val()},
								function (resposta) {
									alert('Históricos atualizados');
									window.location=window.location;
								});
							}
							else {
								alert(resposta);
								$("#btn_cidadao_bloco").attr('disabled',false);
							}
							$("#acoes").html("");
						});
					}
				});
				
				//enviar email vinculada
				$("#btn_vinculada").click(function() {
					var ids = new Array();
					$("input[name=processos_escolhidos]:checked").each(function(i) {
						ids[ids.length] = $(this).val();
					});
					if (ids.length > 0) {
						$("#acoes").html("Enviando... <img src='../../imagens/faetec/loading2.gif'>");
						$(this).attr('disabled',true);
						$.post('../../controle/faetec/processos.php',{email_bloco:1,email:$("#email_vinculada").val(),destino:'Vinculada',ids:ids.join("|"),
						nome:$("#nome_vinculada").val(),copia:$("#copia_vinculada").val(),resumo:$("#resumo").val(),publico:$("#publico").val()},
						function (resposta) {
							if (resposta == 1) {
								alert('Mensagem enviada');
								$.post('../../controle/faetec/processos.php',{historico_bloco:1,ids:ids.join("|"),
								email:$("#email_vinculada").val(),destino:'Vinculada',copia:$("#copia_vinculada").val(),publico:$("#publico").val()},
								function (resposta) {
									alert('Históricos atualizados');
									window.location=window.location;
								});
							}
							else {
								alert(resposta);
								$("#btn_vinculada").attr('disabled',false);
							}
							$("#acoes").html("");
						});
					}
				});
				
				$("input[name=processos_escolhidos]").live('click',function() {
					var t = parseInt($("#selecionados").html());
					if ($(this).attr('checked') == 'checked') {
						$("#selecionados").html(t+1);
					}
					else {
						$("#selecionados").html(t-1);
					}
				});
				
				var sel = 0;
				$("#selecionar_todos").live('click',function() {
					if (sel == 0) {
						$("input[name=processos_escolhidos]").each(function() {
							$(this).attr('checked',true);
						});
						sel = 1;
						$("#selecionados").html($("#tabela tr").length-1);
					}
					else {
						$("input[name=processos_escolhidos]").each(function() {
							$(this).attr('checked',false);
						});
						sel = 0;
						$("#selecionados").html(0);
					}
				});
				
				$("#resposta_padrao").change(function(){
					$.post('../../controle/faetec/processos.php',{id: $(this).val()},
					function(resposta){
						$("#resumo").val(resposta);
					});	
				});
				
				$('#data_inicial').datePicker({startDate:'01/01/2000'});
				$('#data_final').datePicker({startDate:'01/01/2000'});

				$("#data_inicial").mask("99/99/9999");
				$("#data_final").mask("99/99/9999");
			});
		
			function mostrar_div(div) {
				switch (div) {
					case 'historico':
						document.getElementById('historico').style.display='';		
						document.getElementById('cidadao').style.display='none';
						document.getElementById('vinculada').style.display='none';
						
						document.getElementById('alterar').style.display='';
						document.getElementById('btn_cidadao_bloco').style.display='none';
						document.getElementById('btn_vinculada').style.display='none';
						document.getElementById('texto').innerHTML='Resumo:';
						document.getElementById('resumo').value='';
						document.getElementById('titulo').innerHTML='Alteração do Status';
					break;
					case 'cidadao':
						document.getElementById('historico').style.display='none';
						document.getElementById('cidadao').style.display='';
						document.getElementById('vinculada').style.display='none';
						
						document.getElementById('alterar').style.display='none';
						document.getElementById('btn_cidadao_bloco').style.display='';
						document.getElementById('btn_vinculada').style.display='none';
						document.getElementById('texto').innerHTML='Mensagem:';
						document.getElementById('titulo').innerHTML='Enviar E-mail para Cidadão';
					break;
					case 'vinculada':
						document.getElementById('historico').style.display='none';
						document.getElementById('cidadao').style.display='none';
						document.getElementById('vinculada').style.display='';
						
						document.getElementById('alterar').style.display='none';
						document.getElementById('btn_cidadao_bloco').style.display='none';
						document.getElementById('btn_vinculada').style.display='';
						document.getElementById('texto').innerHTML='Mensagem:';
						document.getElementById('titulo').innerHTML='Enviar E-mail para Vinculada';
					break;
				}
			}
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
						<td><b>Modalidade de Ensino</b></td>
						<td><b>Defici&ecirc;ncia</b></td>
					</tr>
					<tr>
						<td>
							<select name='modalidade' id='modalidade'>
								<option value="">Todas as modalidades</option>
								<?php while ($l = mysql_fetch_array($lista_modalidades)) { ?>
								<option value="<?php echo $l['id_modalidade']; ?>"><?php echo $l['modalidade']; ?></option>
								<?php } ?>
							</select>
						</td>
						<td>
							<select name="deficiencia" id="deficiencia" style='line-height:8px; width:550px; font-size:11px;'>
								<option value="">Todas as defici&ecirc;ncias</option>
								<?php while ($t = mysql_fetch_array($lista_deficiencias)) { ?>
								<option value="<?php echo $t['id']; ?>"><?php echo $t['deficiencia']; ?></option>
								<?php } ?>
							</select>
						</td>
					<tr>
					<tr>
						<td><b>Data Inicial</b></td>
						<td><b>Data Final</b></td>
					</tr>
					<tr>
						<td>
							<input type='text' name='data_inicial' id='data_inicial' value='<?php echo date("d/m/Y", strtotime("-5 months")) ?>'>
						</td>
						<td>
							<input type='text' name='data_final' id='data_final' value='<?php echo date('d/m/Y'); ?>'>
						</td>
					</tr>
					<tr>
						<td><b>tipo</b></td>
						<td><b>Assunto</b></td>
					</tr>
					<tr>
						<td>
							<select name='tipo' id='tipo'>
								<?php if (mysql_num_rows($lista_tipo) > 0) { ?>
									<option value="">Todos os tipos</option>
								<?php } ?>
								<?php while ($a = mysql_fetch_array($lista_tipo)) { ?>
									<option value="<?php echo $a['id_tipo']; ?>"><?php echo $a['tipo']; ?></option>
								<?php } ?>
							</select>
						</td>
						<td>
							<select name='assunto' id='assunto'>
								<?php if (mysql_num_rows($lista_assunto) > 0) { ?>
									<option value="">Todos os assuntos</option>
								<?php } ?>
								<?php while ($a = mysql_fetch_array($lista_assunto)) { ?>
									<option value="<?php echo $a['id_assunto']; ?>"><?php echo $a['assunto']; ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<input type='button' value='Filtrar' id='filtrar'>
						</td>
					</tr>
				</table>
			</fieldset>
			<div id='processos'></div>
			<div id='exibir_total' style='display:none'>
				<b>Total de Manifesta&ccedil;&otilde;es: <label id='total'></label></b>
				<br>
				<b>Manifesta&ccedil;&otilde;es Selecionadas: <label id='selecionados'>0</label></b>
			</div>
			
			<table width="100%" border="0" id='resposta' style='display:none'>
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
				<tr class="column1">
					<td class="td">
						<div id='historico'>
							<span>Status</span>
							<select name="novo_status" id="novo_status">
								<?php while ($ls = mysql_fetch_array($lista_status_resposta)) { 
									if ($ls['id_status'] != 5) { ?>
										<option value="<?php echo $ls['id_status']; ?>"><?php echo $ls['status']; ?></option>
									<?php } ?>
								<?php } ?>
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
				</tr>
				<tr class="odd">
					<td class="td" colspan=2><span>Resposta</span>
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
					</td>
				</tr>
				<tr class='odd'>
					<td colspan=3>
						<input name="alterar" type="button" value="Alterar" id="alterar"/>
						<input name="inibir" type="button" value="Inibir Selecionadas" id="inibir"/>
						<input type="button" value="Enviar" id="btn_cidadao_bloco" name="btn_cidadao_bloco" style='display:none' />
						<input type="button" value="Enviar" id="btn_vinculada" name="btn_vinculada" style='display:none' />
						<select name='publico' id='publico'>
							<option value=1>P&uacute;blico</option>
							<option value=0>Privado</option>
						</select>
						<div id='acoes'></div>
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>