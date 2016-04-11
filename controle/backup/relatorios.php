<?php
function controle_relatorios($acao) {
	switch ($acao) {
		case 'entidades':
			session_start();
			
			global $lista_entidades;
			global $lista_status;
			global $lista_tipos;
			global $lista_assuntos;
			global $inicio;
			global $fim;
			
			require_once('../../classe/entidades.php');
			$entidades = new entidades();
			
			require_once('../../classe/status.php');
			$status = new status();
			
			require_once('../../classe/tipo_usuario.php');
			$tipo_usuario = new tipo_usuario();
			
			require_once('../../classe/assuntos.php');
			$assuntos = new assuntos();
			
			$lista_tipos = $tipo_usuario -> listar();
			
			$lista_entidades = $entidades -> listar($_SESSION['entidade']);
			
			$lista_status = $status -> listar();
			
			$lista_assuntos = $assuntos -> listar();
			
			switch (substr($_SESSION['periodo'], -2)) {
				case '01':
					$inicio = '01/01/'.substr($_SESSION['periodo'], -2);
					$fim = '30/06/'.substr($_SESSION['periodo'], -2);
				break;
				case '02':
					$inicio = '01/07/'.substr($_SESSION['periodo'], 0, 4);
					$fim = '31/12/'.substr($_SESSION['periodo'], 0, 4);
				break;
			}
		break;
		case 'comparativo':
			session_start();
			
			global $lista_entidades;
			global $lista_status;
			global $inicio;
			global $fim;
			
			require_once('../../classe/entidades.php');
			$entidades = new entidades();
			
			require_once('../../classe/status.php');
			$status = new status();
			
			$lista_entidades = $entidades -> listar($_SESSION['entidade']);
			
			$lista_status = $status -> listar();
			
			switch (substr($_SESSION['periodo'], -2)) {
				case '01':
					$inicio = '01/01/'.substr($_SESSION['periodo'], -2);
					$fim = '30/06/'.substr($_SESSION['periodo'], -2);
				break;
				case '02':
					$inicio = '01/07/'.substr($_SESSION['periodo'], 0, 4);
					$fim = '31/12/'.substr($_SESSION['periodo'], 0, 4);
				break;
			}
		break;
	}
}