<?php 

class Dato extends db
{
	
	public $user;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function fetchByPaginator($start, $per_page)
	{
		$this->connect();
		$res = $this->consulta("SELECT * FROM datos LIMIT $start, $per_page");
		$this->cerrar();
		
		return $res;
	}
	
	public function getCount()
	{
		$this->connect();
		$res = $this->consulta("SELECT COUNT(*) AS cantidad FROM datos");
		$this->cerrar();
		
		return $res;
	}
	
	public function checkIfPostExistById($postid)
	{
		$this->connect();
		$id = $this->consulta("SELECT COUNT(*) AS cantidad FROM datos WHERE postid = $postid");
		$this->cerrar();
		
		return $id;
	}
	
	public function insertData($data)
	{
		
		$this->user = new Usuario();
		
		$userid = $this->user->getIdByUserId($data->user->id);
		$postid = $data->location->id;
		$latitude = $data->location->latitude;
		$longitude = $data->location->longitude;
		$image_thumb = $data->images->thumbnail->url;
		$image_standard = $data->images->standard_resolution->url;
		
		$this->connect();
		$test = $this->sql(sprintf("INSERT INTO datos (postid,user_id,latitude,longitude,image_thumb,image_standard,created_date)
							VALUES ('%s','%s','%s','%s','%s','%s', NOW())", $postid, $userid[0]['id'], $latitude,$longitude,$image_thumb,$image_standard));
		$this->cerrar();
	}
	
	public function getIdByPostID($id)
	{
		$this->connect();
		$res = $this->consulta("SELECT id FROM datos WHERE postid = $id");
		$this->cerrar();
		
		return $res;
	}
	
	public function updateDatoByPostId($postid,$idcomment)
	{
		$this->connect();
		$this->sql("UPDATE datos SET comment_id = $idcomment WHERE postid = $postid");
		$this->cerrar();
	}
	
}

?>