<?php
require_once('../../classe/usuario.php');
$usuario = new usuario();

session_start();

global $acesso;

$acesso = $usuario -> permissoes($_SESSION['usuario']);
?>