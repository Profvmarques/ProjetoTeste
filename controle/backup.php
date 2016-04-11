<?php
function controle_backup($acao) {
	switch ($acao) {
		case 'criar':
			require_once('../../classe/backup.php');
			$backup = new backup();
			
			global $lista_anos;
			
			$lista_anos = $backup -> listar_anos();
			
			if ($_POST) {
				$resultado = $backup -> criar($_POST);
				if ($resultado == 1) {
					echo "<script>alert('Backup criado com sucesso');</script>";
				}
				else {
					echo "<script>alert('".$resultado."');</script>";
				}
			}
		break;
		case 'escolher':
			require_once('../../classe/backup.php');
			$backup = new backup();
			
			global $array_periodos;
			$c = 0;
			
			$lista_periodos = $backup -> listar_periodos();
			
			while ($b = mysql_fetch_array($lista_periodos)) {
				$array_periodos[$c]['periodo'] = substr($b[0], 10);
				$array_periodos[$c]['texto'] = substr($b[0], -1)."º semestre de ".substr($b[0], 10, -2);
				$c++;
			}
			
			if ($_POST) {
				$backup -> escolher($_POST['periodo']);
				echo "<script>window.location='../backup/index.php?pg=1'</script>";
			}
		break;
	}
}
?>