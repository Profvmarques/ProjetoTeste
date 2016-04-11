<?php
require_once ('../../classe/conexao.php');

class ouvidoria {

	protected $id_assunto;
	protected $id_canal;
	protected $id_prioridade;
	protected $nome;
	protected $sexo;
	protected $data_nasc;
	protected $escolaridade;
	protected $email;
	protected $endereco;
	protected $bairro;
	protected $cidade;
	protected $telefone;
	protected $celular;
	protected $prim_rec;
	protected $comentario;
	
	protected function add_data() {
		$data=date("d/m/Y");
		$vet_data = explode("/","$data");
		
		$d = $vet_data[0];
		$m = $vet_data[1];
		$y = $vet_data[2];
		
		$res = checkdate($m,$d,$y);
		if ($res == 1) {
		   $soma_dias=5;
		   $data_limite = $this -> adicionaDia($data,$soma_dias);
		} 
		else {
		   echo "data invalida!";
		}
		
		return $data_limite;
	}

	protected function adicionaDia($data,$dias) {
		$feriados = array(
		  "01/01",
		  "21/04",
		  "01/05",
		  "07/09",
		  "12/10",
		  "02/11",
		  "25/12",
		);
	    $ano = substr ( $data, 6, 10);
	    $mes= substr ( $data, 3, 5 );
	    $dia=  substr ( $data, 0, 2 );

		$j=0;
		
		for ($i=1;$i<=$dias;$i++) {
			$j++;
			$dia_semana=strftime("%w", mktime(0,0,0,$mes,$dia+ $j,$ano));
			$tmp=strftime("%d/%m",mktime(0,0,0,$mes,$dia+ $j,$ano));
			
			if ((($dia_semana==0) or ($dia_semana==6)) or (in_array($tmp, $feriados))) {
				$dias++;
			}
		}  
		
	    $proxdia= mktime ( 0, 0, 0, $mes, $dia+ $dias, $ano);
	    return strftime("%Y-%m-%d", $proxdia);
	}
	
	//excluir manifestacao
	public function excluir($id) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$sql = "delete _ouvidoria".$_SESSION['periodo'].", _historico".$_SESSION['periodo'].", _processo".$_SESSION['periodo']." 
					from _ouvidoria".$_SESSION['periodo']."
						inner join _historico".$_SESSION['periodo']." on _historico".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
						inner join _processo".$_SESSION['periodo']." on _processo".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
							where _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = ".$id;
		
		$conexao -> query($sql);
		
		return 1;
	}
	
	//inibir manifestacao
	public function inibir($id) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$sql = "update _processo".$_SESSION['periodo']."
					inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
						set ativo = 0
							where _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = ".$id;
		$resultado = $conexao -> query($sql);
		
		return 1;
	}
	
	//restaurar manifestacao
	public function restaurar($id) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		$sql = "update _processo".$_SESSION['periodo']." 
					inner join _ouvidoria".$_SESSION['periodo']." on _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = _processo".$_SESSION['periodo'].".id_ouvidoria
						set ativo = 1
							where _ouvidoria".$_SESSION['periodo'].".id_ouvidoria = ".$id;
		$resultado = $conexao -> query($sql);
		
		return 1;
	}
	
	public function formatar_anexo($texto){
		$substituir = array('à','á','â','ã','ä','å',
		'ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ',
		'À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','Ù','Ü','Ú','Ÿ',' ');
		$novo = array('a','a','a','a','a','a',
		'c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y',
		'A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','U','U','U','Y','_');
		$text = str_replace($substituir, $novo, $texto);
		return $text;
	}
	
	//incluir registro de anexo na tabela ouvidoria
	public function incluir_anexo($id,$anexo,$num) {
		//criar objeto da classe conexão
		$conexao = new conexao();
		
		//atualizacao
		$sql = "update _ouvidoria".$_SESSION['periodo']."
					set anexo".$num." = '".$anexo."' 
						where id_ouvidoria = '".$id."'";
		$resultado = $conexao -> query($sql);
	}
	
}
?>