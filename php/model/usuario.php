<?php 

class Usuario extends db
{
	
	public function __construct()
	{
		parent::__construct();
	}	
	
	public function checkIfuserExist($id)
	{
		$this->connect();
		$res = $this->consulta("SELECT COUNT(*) AS cantidad FROM usuario WHERE userid = $id");
		$this->cerrar();
		
		return $res;
	}
	
	public function insertUser($data)
	{
		$this->connect();
		$this->sql(sprintf("INSERT INTO usuario (username,userid) VALUES ('%s','%s')",$data->username,$data->id));
		$this->cerrar();
	}
	
	public function getIdByUserId($id)
	{
		$this->connect();
		$userid = $this->consulta(sprintf("SELECT id FROM usuario WHERE userid = '%s'", $id));
		$this->cerrar();
		
		return $userid;
	}
	
}

?>