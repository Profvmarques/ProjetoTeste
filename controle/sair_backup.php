<?php
switch ($_SESSION['entidade']) {
	//SECT
	case 10:
		$ent = 'sect';
	break;
	//FAETEC
	case 1:
		$ent = 'faetec';
	break;
	//CECIERJ
	case 44:
		$ent = 'cecierj';
	break;
}
echo "<script> window.location='../../view/".$ent."/?pg=1'</script>";
?>