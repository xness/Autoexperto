<?php 

class db{

	private $dbhost;
	private $dbuser;
	private $dbpass;
	private $dbname;
	private $conn;

	function __construct($dbuser = 'root', $dbpass = '', $dbname = 'autoexperto', $dbhost = 'localhost')
	{
		$this->dbhost = $dbhost;
		$this->dbuser = $dbuser;
		$this->dbpass = $dbpass;
		$this->dbname = $dbname;
	}

	public function connect()
	{
		$this->conn = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass,$this->dbname);
		if (mysqli_connect_errno()) {
			die('Error al conectar con mysql');
		}
	}

	public function consulta($query)
	{
		
		$valores = array();
		$result = mysqli_query($this->conn,$query);
		if (!$result) {
			die('Error query BD:' . mysqli_error());
		}else{
			$num_rows= mysqli_num_rows($result);
			for($i=0;$i<$num_rows;$i++){
				$row = mysqli_fetch_assoc($result);
				array_push($valores, $row);
			}
		}

		return $valores;
	}

	public function sql($sql)
	{
		mysqli_set_charset($this->conn,"utf8");
		$result=mysqli_query($this->conn,$sql);
		return $result;
	}

	public function id()
	{
		return mysqli_insert_id($this->conn);
	}

	public function cerrar()
	{
		mysqli_close($this->conn);
	}

	public function escape($value)
	{
		return mysqli_real_escape_string($this->conn,$value);
	}

}

?>