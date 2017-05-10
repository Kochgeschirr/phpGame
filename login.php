<?php
session_start();
if (isset($_SESSION['username'])){
	header('location: ./main/');
	exit();
}
require("db_control.php");
$database = new DB_Control();

function PrintLoginForm(){		
	echo "<form method=\"post\" action=\"login.php\">
		  <p>Username:<input type=\"text\" name=\"username\" /></p>
		  <p>Password: <input type=\"password\" name=\"password\" /></p>
		  <input type=\"submit\" name=\"submit\" value=\"login\" />
		  <input type=\"submit\" name=\"submit\" value=\"register\" />
		  </form>";
}
if (!isset($_POST['submit'])){
	//header('location: ./index.php');
	PrintLoginForm();
} else {
	$submitVar = $_POST['submit'];
	$_SESSION = array();
	if (isset($_SESSION)){
		session_destroy();
	}	
	session_start();
	$user = $_POST['username'];
	$pw = $_POST['password'];
	if( $submitVar=="login" ){
		$loginResult = $database->LoginCheck($user,$pw);
		if($loginResult){
			$_SESSION['username'] = $user;
			header('location: ./main/');
			exit();
		} else {
			echo "Could not Login.";			
		}
	} else if ( $submitVar=="register" ){
		$queryResult = $database->RegisterUser($user,$pw);
		if ($queryResult < 0){
			echo "user does already exist";
		} else if($queryResult>0){
			$_SESSION['username'] = $user;
			echo "registration successful :-)";
			echo "\n<br/><a href=\"./main/\">weiter</a><br/>";
		} else {
			echo "could not register, maybe password too short?";
		}
		echo "<br/><a href=\"./\">Back</a>";
	}
}
?>