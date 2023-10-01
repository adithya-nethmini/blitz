<?php 

function connect(){
	$mysqli = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);
	if($mysqli->connect_error != 0){
		$error = $mysqli->connect_error;
		$error_date = date("F j, Y, g:i a");
		$message = "{$error} | {$error_date} \r\n";
		file_put_contents("db-log.txt", $message, FILE_APPEND);
		return false;
	}else{
		$mysqli->set_charset("utf8mb4");
		return $mysqli;
	}
}

?>