<?php
function controle_relatorios($acao) {
	switch ($acao) {
		case 'entidades';
			global $lista_entidades;
			global $lista_status;
			global $lista_tipos;
			global $lista_sub;
			
			require_once('../../classe/entidades.php');
			$entidades = new entidades();
			
			require_once('../../classe/status.php');
			$status = new status();
			
			require_once('../../classe/tipo_usuario.php');
			$tipo_usuario = new tipo_usuario();
			
			require_once('../../classe/sub_item.php');
			$sub_item = new sub_item();
			
			$lista_tipos = $tipo_usuario -> listar();
			
			$lista_entidades = $entidades -> listar(1);
			
			$lista_status = $status -> listar();
			
			$lista_sub = $sub_item -> listar_subitens($_SESSION['entidade']);
		break;
		case 'comparativos';
			global $lista_entidades;
			global $lista_modalidades;
			global $lista_status;
			global $lista_assunto;
			global $lista_tipo_usuario;
			global $lista_deficiencia;
			global $lista_tipos;
			global $lista_canais;
			
			require_once('../../classe/entidades.php');
			$entidades = new entidades();
			require_once('../../classe/pmdc/modalidades.php');
			$modalidades = new modalidades();
			require_once('../../classe/status.php');
			$status = new status();
			require_once('../../classe/pmdc/assunto.php');
			$assunto = new assunto();
			require_once('../../classe/deficiencia.php');
			$deficiencia = new deficiencia();
			require_once('../../classe/tipo_usuario.php');
			$tipo_usuario = new tipo_usuario();
			require_once('../../classe/tipos.php');
			$tipos = new tipos();
			require_once('../../classe/canais.php');
			$canais = new canais();
			
			$lista_tipo_usuario = $tipo_usuario -> listar();
			$lista_entidades = $entidades -> listar(1);
			$lista_modalidades = $modalidades -> listar();
			$lista_status = $status -> listar();
			$lista_deficiencia = $deficiencia -> listar();
			$lista_assunto = $assunto -> listar();
			$lista_tipos = $tipos -> listar();
			$lista_canais = $canais -> listar();
		break;
		case 'comparativo':
			global $lista_entidades;
			global $lista_status;
			
			require_once('../../classe/entidades.php');
			$entidades = new entidades();
			
			require_once('../../classe/status.php');
			$status = new status();
			
			$lista_entidades = $entidades -> listar(1);
			
			$lista_status = $status -> listar();
		break;
		case 'diretoria';	
			global $lista_diretoria;		
			global $lista_entidades;
			global $lista_status;
			global $lista_tipos;
			global $lista_sub;
			
			require_once('../../classe/pmdc/diretoria.php');
			$diretoria = new diretoria();
			
			require_once('../../classe/entidades.php');
			$entidades = new entidades();
			
			require_once('../../classe/status.php');
			$status = new status();
			
			require_once('../../classe/tipo_usuario.php');
			$tipo_usuario = new tipo_usuario();
			
			require_once('../../classe/sub_item.php');
			$sub_item = new sub_item();
			
			$lista_diretoria = $diretoria -> listar(1);
			
			$lista_tipos = $tipo_usuario -> listar();
			
			$lista_entidades = $entidades -> listardir();
			
			$lista_status = $status -> listar();
			
			$lista_sub = $sub_item -> listar_subitens($_SESSION['entidade']);
		break;
	}
}
?>