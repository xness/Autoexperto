<?php 

require_once realpath(dirname(__FILE__)) . '../../autoloads.php';

$instagram = new Instagram('119e4c2771aa410bbd1ceb30039550be');

$tag = 'autoexperto';

$client = '119e4c2771aa410bbd1ceb30039550be';

$api = "https://api.instagram.com/v1/tags/$tag/media/recent?client_id=".$client;

$i = 1;

while ($api !== NULL) {
	$response = get_curl($api);
	$api = addData($response);
	echo "Verificada P&aacute;gina: " . $i .'<br>';
	$i++;
}

function addData($response)
{	
	$user = new Usuario();
	
	$datos = new Dato();
	
	$comments = new Comentario();
	
	/* each */
	foreach ( json_decode($response)->data as $data )
	{
		/* if data has location */
		if ( isset($data->location->id) )
		{
			// if user exists
			$exist = $user->checkIfuserExist($data->user->id);
			if ( $exist[0]['cantidad'] == 0 )
			{
				// insert data
				$user->insertUser($data->user);
				$datos->insertData($data);
				// comments
				foreach ( $data->comments->data as $comment )
				{
					$commentexist = $comments->checkIfCommentExistById($comment->id);
					if ( $commentexist[0]['cantidad'] == 0 )
					{
						$postid = $datos->getIdByPostID($data->location->id);
						$comments->insertComentario($comment,$postid[0]['id']);
					}
				}
			} else {
				// if post exist
				$postexist = $datos->checkIfPostExistById($data->location->id);
				if ( $postexist[0]['cantidad'] == 0 )
				{
					$datos->insertData($data);
					// comments
					foreach ( $data->comments->data as $comment )
					{
						$commentexist = $comments->checkIfCommentExistById($comment->id);
						if ( $commentexist[0]['cantidad'] == 0 )
						{
							$postid = $datos->getIdByPostID($data->location->id);
							$comments->insertComentario($comment,$postid[0]['id']);
						}
					}
				} else {
					if ( $data->comments->count != 0  )
					{
						// if comment exist
						foreach ( $data->comments->data as $comment )
						{
							$commentexist = $comments->checkIfCommentExistById($comment->id);
							// addcomment
							if ( $commentexist[0]['cantidad'] == 0 )
							{
								$postid = $datos->getIdByPostID($data->location->id);
								$comments->insertComentario($comment,$postid[0]['id']);
							}
						}
					}
	
				}
			}
		}
	}	
	
	return (isset(json_decode($response)->pagination->next_url) ? json_decode($response)->pagination->next_url : NULL);
}

function get_curl($url)
{
	if( function_exists('curl_init') ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$output = curl_exec($ch);
		echo curl_error($ch);
		curl_close($ch);
		return $output;
	} else{
		return file_get_contents($url);
	}
}


?>