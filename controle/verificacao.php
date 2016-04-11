<?php
session_start();
if ($_SESSION['usuario'] == '') {
	echo "<script>window.location='../../view'</script>";
	die;
}
?>