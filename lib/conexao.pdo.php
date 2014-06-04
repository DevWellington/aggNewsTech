<?php
	
class conn{

	public $ip, $user, $pass, $db;
	
	public function __construct(){
		$this->ip = null;
		$this->user = null;
		$this->pass = null;
		$this->db = null;
	}
	public function getHost(){
		return $this->ip;
	}		
	public function getUsuario(){
		return $this->user;
	}		
	public function getSenha(){
		return $this->pass;
	}		
	public function getBanco(){
		return $this->db;
	}
	public function getLinkConnection(){

		// Realizando conexao e selecioando banco de dados
		$conn = mysql_connect($this->ip, $this->user, $this->pass) or die(mysql_error());
		$db = mysql_select_db($this->db, $conn) or die(mysql_error()); 
		mysql_set_charset('utf8');

		return $conn;
	}
	public function setCloseMysql($conx){
		if ($conx){
			mysql_close($conx);
		} 
	}
}

class connPDO extends PDO {
 
    private static $instancia;
    private static $connMySQL;
    private static $dsnAux;
 
    public function conectar($dsn, $username = "", $password = "") {
        // O construtro abaixo é o do PDO

        parent::__construct($dsn, $username, $password);
    }
 
    public static function getInstance() {
        // Se o a instancia não existe eu faço uma
        if(!isset( self::$instancia )){
            try {

		    	$connMySQL = new conn();			    	
		    	$dsnAux = "mysql:host=".$connMySQL->getHost().";dbname=".$connMySQL->getBanco();

                self::$instancia = new connPDO($dsnAux, $connMySQL->getUsuario(), $connMySQL->getSenha());
            } catch(Exception $e) {
                echo "Erro ao conectar\n " . $e->getMessage();
                exit();
            }
        }
        // Se já existe instancia na memória eu retorno ela
        return self::$instancia;
    }
}

