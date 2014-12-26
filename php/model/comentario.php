<?php 

class Comentario extends db
{
	
	public function __construct()
	{
		parent::__construct();
	}	
	
	public function checkIfCommentExistById($id)
	{
		$this->connect();
		$res = $this->consulta("SELECT COUNT(*) AS cantidad FROM comments WHERE identifier = $id");
		$this->cerrar();
		
		return $res;
	}
	
	public function insertComentario($comment,$datoid)
	{
		$this->connect();
		$this->sql(sprintf("INSERT INTO comments (identifier,dato_id,texto) VALUES ('%s','%s','%s')", $comment->id,$datoid,$comment->text));
	}
	
}

?>