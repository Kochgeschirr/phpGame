<?php
require("infos_db_connect.php");

class DB_Control{
	private $connection;
	
	function __construct(){
		global $servername, $username, $password, $dbname;
		$this->connection = new mysqli($servername, $username, $password, $dbname);
		if ($this->connection->connect_error) {
			die("Connection failed: " . $this->connection->connect_error);
		} else {
			echo "db connected<br/>";
		}
	}
	
	function __destruct(){
		$this->connection->close();
	}
	
	function RegisterUser($userName, $password){
		if (strlen($password)<4){
			return 0;
		}
		$regQuery = $this->connection->prepare("INSERT INTO users (id, username, hashedPW) VALUE (NULL, ?, ?);");
		$regQuery->bind_param("ss", $userName, password_hash($password, PASSWORD_BCRYPT));
		$regQuery->execute();
		return $regQuery->affected_rows;
	}
	
	function LoginCheck($userName, $password){
		$regQuery = $this->connection->prepare("SELECT hashedPW FROM users WHERE username LIKE ?;");
		$regQuery->bind_param("s", $userName);
		$regQuery->execute();
		$regQuery->bind_result($hashedPW);
		$regQuery->fetch();
		$result = password_verify($password, $hashedPW);
		return $result;
		
	}
}

//session_start();
//$userlogin= "";

?>