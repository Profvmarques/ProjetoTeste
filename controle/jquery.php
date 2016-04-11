<?php
//listar subitens
if ($_POST['tipo']) {
	require_once('../classe/sub_item.php');
	$sub_item = new sub_item();
	
	$lista_sub = $sub_item -> subitens($_POST['tipo']);
	
	if (mysql_num_rows($lista_sub) > 0) {
		echo '<label style="font-weight:bold; color:#666666" for="sub">Subitem:</label>';
		echo "<select name='sub' id='sub'>";
		echo "<option value=''>Selecione</option>";
		while ($l = mysql_fetch_array($lista_sub)) {
			echo "<option value=".$l['id_subitem'].">".$l['subitem']."</option>";
		}
		echo "</select>";
	}
}
?>