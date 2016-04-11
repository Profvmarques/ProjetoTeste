<?php 
require_once('../../controle/pmdc/processos.php');
controle_processos('incluir');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ouvidoria PMDC</title>
<link rel="stylesheet" type="text/css" href="../../css/pmdc/style.css" />
<script src="../../js/jquery.js" type="text/javascript"></script>
<script src="../../js/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery.maskedinput.js" type="text/javascript"></script>
<!--<script src="../../js/jquery.MultiFile.js" type="text/javascript"></script>-->
<script type="text/javascript">
$().ready(function() {
	//ignorar maxlength do campo file
	//delete $.validator.methods.maxlength;	

	$("#form").validate({
		rules: {
			tipo: "required",
			tipo_usuario: "required",
			entidade:"required",
			inibir_dados:"required",
			canal:"required",
			comentario: "required"
		},
		messages: {
			tipo: "Escolha um tipo",
			tipo_usuario: "Escolha o tipo de usuário",
			entidade: "Escolha uma entidade",
			inibir_dados: "Escolha uma opção de privacidade dos dados pessoais",
			canal: "Escolha o canal de acesso",
			comentario: "Preencha o campo Coment&aacute;rio"
		}
	});
	
	$("input[name=question]").change(function() {
		if ($("input[name=question]:checked").attr('id') == 'sim') {
			$("#anteriores").fadeOut();
		}
		else {
			$("#anteriores").fadeIn();
		}
	});

	$("#cpf").mask("99999999999");
	$("#data_nasc").mask("99/99/9999");
	$("#telefone").mask("(99) 9999-9999");
	$("#celular").mask("(99) 9999-9999?9");
});

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

<body style="width:1024px; margin-left:25px;">
    <img src="../../imagens/pmdc/nova_logo_ouvidoria.jpg">
    <br />
<br />
 
    <div style="color:#0000CC;font-weight:bold;">Formas de Contato</div><br />
<form name="form" id="form" method="POST" enctype='multipart/form-data'>
	<label style="font-weight:bold; color:#666666">Tipo:*</label>
	<select name="tipo" id="tipo" title="Selecione o Tipo">
		<option value = "">Selecione:</option>
		<?php while ($a = mysql_fetch_array($lista_tipos)) { 
			if (!in_array($a['id_tipo'],array(8,9))) {?>
	    <option value="<?php echo $a['id_tipo']; ?>"><?php echo $a['tipo']; ?></option>
		<?php }} ?>
	</select>
	<br>
	<label style="font-weight:bold; color:#666666" for="sub">Assunto:</label>
	<select name='assunto' id='assunto'>
		<option value=''>Selecione</option>
		<?php while ($l = mysql_fetch_array($lista_assunto)) { ?>
			<option value='<?php echo $l['id_assunto']; ?>'><?php echo $l['assunto']; ?></option>
		<?php } ?>
	</select>
	<br>
	<label style="font-weight:bold; color:#666666" for="tipo_usuario">Tipo de usu&aacute;rio:*</label>
	<select name='tipo_usuario' id='tipo_usuario'>
		<option value=''>Selecione</option>
		<?php while ($lt = mysql_fetch_array($lista_tipo)) { ?>
			<option value='<?php echo $lt['id_tipo_usuario']; ?>'><?php echo $lt['descricao']; ?></option>
		<?php } ?>
	</select>
	<br>
	<label style="font-weight:bold; color:#666666" for="deficiencia">Defici&ecirc;ncia:</label>
	<select name='deficiencia' id='deficiencia'>
		<option value=''>Nenhuma</option>
		<?php while ($ld = mysql_fetch_array($lista_deficiencias)) { ?>
			<option value='<?php echo $ld['id']; ?>'><?php echo $ld['deficiencia']; ?></option>
		<?php } ?>
	</select>
	<br>
	<label style="font-weight:bold; color:#666666">Nome Completo:</label>
	<input name="nome" type="text" id="nome" size="45" title="Preencha o campo Nome Completo">
	<br>
	<label style="font-weight:bold; color:#666666">CPF:</label>
	<input name="cpf" type="text" id="cpf" size="12" maxlength='11' title="Preencha o campo CPF">
	<br>
	<label style="font-weight:bold; color:#666666">Sexo:</label>
	<input type="radio" name="sexo" value="Masculino" id="sexo_0">Masculino &nbsp;&nbsp;&nbsp;
	<input type="radio" name="sexo" value="Feminino" id="sexo_1">Feminino
	<br>
	<label style="font-weight:bold; color:#666666">Data de Nascimento:</label>
	<input name="data_nasc" type="text" id="data_nasc" size="11" maxlength="10" title="Preencha o campo Data de Nascimento">
	<br>
	<label style="font-weight:bold; color:#666666">Escolaridade:</label>
	<select name="escolaridade" id="escolaridade">
		<option value="">Selecione:</option>
        <option value="DOUTORADO COMPLETO">DOUTORADO COMPLETO</option>
		<option value="DOUTORADO INCOMPLETO">DOUTORADO INCOMPLETO</option>
		<option value="MESTRADO INCOMPLETO">MESTRADO INCOMPLETO</option>
		<option value="MESTRADO COMPLETO">MESTRADO COMPLETO</option>
		<option value="ESPECIALIZA&Ccedil;&Atilde;O">ESPECIALIZA&Ccedil;&Atilde;O</option>
		<option value="APERFEI&Ccedil;OAMENTO">APERFEI&Ccedil;OAMENTO</option>
		<option value="ENSINO SUPERIOR COMPLETO">ENSINO SUPERIOR COMPLETO</option>
		<option value="ENSINO SUPERIOR INCOMPLETO">ENSINO SUPERIOR INCOMPLETO</option>
		<option value="ENSINO M&Eacute;DIO COMPLETO">ENSINO M&Eacute;DIO COMPLETO</option>
		<option value="ENSINO M&Eacute;DIO INCOMPLETO">ENSINO M&Eacute;DIO INCOMPLETO</option>
		<option value="ENSINO FUNDAMENTAL COMPLETO">ENSINO FUNDAMENTAL COMPLETO</option>
		<option value="ENSINO FUNDAMENTAL INCOMPLETO">ENSINO FUNDAMENTAL INCOMPLETO</option>
		<option value="ALFABETIZADO SEM CURSOS REGULARES">ALFABETIZADO SEM CURSOS REGULARES</option>
		<option value="ANALFABETO">ANALFABETO</option>
    </select>
	<br>
	<label style="font-weight:bold; color:#666666">E-mail:</label>
	<input name="email" type="text" id="email" size="45" title="Preencha o campo E-mail">
	<br>
	<label style="font-weight:bold; color:#666666">Endere&ccedil;o:</label>
	<input name="endereco" type="text" id="endereco" value="" size="45">
	<br>
	<label style="font-weight:bold; color:#666666">Bairro:</label>
	<input name="bairro" type="text" id="bairro" size="45" maxlength="45">
	<br>
	<label style="font-weight:bold; color:#666666">Cidade/Munic&iacute;­pio</label>
	<input name="cidade" type="text" id="cidade" size="45" maxlength="45">
	<br>
	<label style="font-weight:bold; color:#666666">Telefone:</label>
	<input name="telefone" type="text" id="telefone" size="20" maxlength="20"><br>
	<label style="font-weight:bold; color:#666666">Celular: </label>
	<input name="celular" type="text" id="celular" size="20" maxlength="20">
	<br>
	<label style="font-weight:bold; color:#666666" for="entidade">Entidade a que se refere o assunto:*</label>
	<select name='entidade' id='entidade'>
	<?php if (mysql_num_rows($lista_entidades) > 1) { ?>
		<option value="">Selecione</option>
		<?php } ?>
		<?php while ($l = mysql_fetch_array($lista_entidades)) { ?>
		<option value="<?php echo $l['id_entidade']; ?>"><?php echo $l['entidade']; ?></option>
		<?php } ?>
	</select>
	<br>
	<label style="font-weight:bold; color:#666666" for="entidade">Modalidade de ensino:</label>
	<select name='modalidade' id='modalidade'>
	<?php if (mysql_num_rows($lista_modalidades) > 1) { ?>
		<option value="">Selecione</option>
		<?php } ?>
		<?php while ($l = mysql_fetch_array($lista_modalidades)) { ?>
		<option value="<?php echo $l['id_modalidade']; ?>"><?php echo $l['modalidade']; ?></option>
		<?php } ?>
	</select>
	<br>
	<label style="font-weight:bold; color:#666666">&Eacute; a sua primeira manifesta&ccedil;&atilde;o referente a este assunto?</label>
	<input type="radio" name="question" value="SIM" id="sim">SIM &nbsp;&nbsp;&nbsp;
	<input type="radio" name="question" value="N&Atilde;O" id="nao">N&Atilde;O
	<br>
	<div id='anteriores' style='display:none'>
		<label style="font-weight:bold; color:#666666">Protocolo(s) anteriore(s): </label>
		<input type="text" name="protocolo_anterior" id="protocolo_anterior" size='50'>
	</div>
	<label style="font-weight:bold; color:#666666">Inibir os dados pessoais do manifestante (apenas a ouvidoria ter&aacute; acesso):*</label>
    <input type="radio" name="inibir_dados" value="1"><span class="texto">SIM &nbsp;&nbsp;&nbsp;</span>
	<input type="radio" name="inibir_dados" value="0"><span class="texto">N&Atilde;O</span>
    <br />
	<label style="font-weight:bold; color:#666666">Coment&aacute;rio:</label>
	<textarea name="comentario" cols="35" rows="4"  id="resumo" title="Preencha o campo ComentÃ¡rio"></textarea>
<!--  <span id='tamanho' style="font-size:12px; color:#666666; font-weight:bold;">360</span><span style="font-size:12px; color:#666666; font-weight:bold;"> caractere(s)</span>-->
	<br>
	<!--
	<span style="font-weight:bold; color:#a30d02;">
		Ser&atilde;o aceitos arquivos  com m&aacute;ximo de 1MB e dos seguintes tipos: .doc, .pdf, .jpg, .jpeg, .gif, .png
	</span>
	<br>
	<label style="font-weight:bold; color:#666666">Anexar documentos</label>
	<input type="file" class="multi" accept="gif|jpg|jpeg|png|doc|pdf" maxlength="2" id="file" name="file[]"/>
	<br>
	-->
	<label style="font-weight:bold; color:#666666">Canal de Acesso:*</label>
    <input type="radio" name="canal" value="1">At. Pessoal &nbsp;
	<input type="radio" name="canal" value="6">E-Mail &nbsp;
	<input type="radio" name="canal" value="3">Telefone&nbsp;
	<input type="radio" name="canal" value="4">Fax
    <br />
	<input name="incluir" type="hidden" value="1" />
	<input name="enviar" type="submit" id="enviar" value="Enviar">
	<input name="limpar" type="reset" id="limpar" value="Limpar">
</form>
</body>
</html>