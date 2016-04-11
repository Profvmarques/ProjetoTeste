<?php 
class conexao {

	/*------------- Funчуo de conexуo com o banco de dados --------------*/
	public function __construct() {
		$servidor='localhost';
		$usuario='pmdc_ouvidoria';
		$senha='!@$pmdc_ouvidoria';
		$banco='pmdc_ouvidoria';
		
		$conexao=mysql_connect($servidor,$usuario,$senha) or die (mysql_error());
		mysql_select_db($banco,$conexao) or die (mysql_error());
	}
	
	/*ini_set('zend.ze1_compatibility_mode', 0);*/
	/*------------- Funчуo de conexуo com o banco de dados para backup--------------*/
	/*public function conexao_backup() {
		$servidor='10.10.100.41';
		$usuario='anderson';
		$senha='123';
		$banco='sect_backup';
		
		$conexao2=mysql_connect($servidor,$usuario,$senha) or die (mysql_error());
		mysql_select_db($banco,$conexao2) or die (mysql_error());
	}*/
	
	/*-------------- Funчуo para executar querys -----------------*/
	public function query($sql) {
		$resultado = mysql_query($sql) or die (mysql_error());
		return $resultado;
	}
	
	public function log($log) {
		$x=	mysql_query($log) or die("Erro no log !!!<br>".mysql_error());
		return $x;
	}

	//Stored Procedures
	public function Conecta_Procedure() {		
		$this->cnx_p = new mysqli('localhost','ouvidoria','ouvidoria','ouvidoria');
		if (mysqli_connect_error()) {
    		die('Connect Error (' . mysqli_connect_errno() . ') '
			. mysqli_connect_error());
		}
	}
	
	public function Query_Procedure($sql, $cnx_p) {
		$this->result_p=mysqli_query($cnx_p,$sql) or die(mysqli_error($this->cnx_p));
		//$this->linha_p=mysqli_fetch_array($this->result_p) or die (mysqli_error());
	}

	public function Query_Procedure_M($sql, $cnx_p) {
		if(mysqli_multi_query($cnx_p, $sql)) {
			do {
				if ($resultado = mysqli_store_result($cnx_p)) {
					while ($row = mysqli_fetch_row($resultado)) {
						$retorno = $row[0];
					}
					mysqli_free_result($resultado);
				}
				/*else {
					echo erro;die(mysqli_error($this->cnx_p));
				}*/
			} 
			while (mysqli_next_result($cnx_p));
			mysqli_close($cnx_p);
			return $retorno;
		}
	}

	public function Desconecta_Procedure() {
		mysqli_close($this->cnx_p);
	}
	
	public function begin() {
		@mysql_query("BEGIN");
	}

	public function commit() {
		@mysql_query("COMMIT");
	}

	public function rollback() {
		@mysql_query("ROLLBACK");
	}
	
	public function query_transaction($sql) {
		$resultado = mysql_query($sql);
		return $resultado;
	}

}
?>