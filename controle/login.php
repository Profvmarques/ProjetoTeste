<?php
session_start();
$_SESSION['login']=$_POST['login'];
$_SESSION['senha'] = $_POST['senha'];

include 'validar.php';

switch ($_SESSION['entidade']) {
	//SECT
	/*case 10:
		$ent = 'sect';
	break;*/
	//FAETEC
	case 1:
		$ent = 'faetec';
	break;
	//CECIERJ
	/*case 44:
		$ent = 'cecierj';
	break;
	//FAPERJ
	case 62:
		$ent = 'faperj';
	break;
	//estado digital
	case 50:
		$ent = 'sect';
	break;*/
	default:
		$ent = 'unidades';
	break;
}

	echo "<script> window.location='../view/".$ent."/?pg=1'</script>";
?>