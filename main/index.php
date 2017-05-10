<?php
require("game_db_control.php");
session_start();

if(isset($_SESSION['username'])){
	$user = $_SESSION['username'];
}
	
function PrintUserInfo(){
	global $user;
	if ( func_num_args() < 1 ){		
		echo "<p>Nutzer: {$user}</p>";
	} else {
		$userData = func_get_args();
		echo "<p>Nutzer: {$userData[0][0]}<br/>
			  Baby: {$userData[0][1]}
			  | Level: {$userData[0][2]} 
			  | Experience: {$userData[0][7]}<br/>
			  Stats: {Power: {$userData[0][3]}
			  | Agility: {$userData[0][4]}
			  | Luck: {$userData[0][5]}
			  | Health: {$userData[0][6]}}<br/></p>";
	}
}
	
function PrintBabyRegisterForm(){
	echo "You don't have a Baby yet. To bear a child, just choose his Name:
		<form method=\"post\" action=\"createbaby.php\">
		<p>The child's name:<input type=\"text\" name=\"babyname\" value=\"Ginger\" /></p>
		<input type=\"submit\" name=\"submit\" value=\"give birth\" />
		</form>";
}

if(!isset($user)){
	echo "<p>You're not logged in!</p>
		  <p><a href=\"../\">Back</a></p>";
} else {	
	$database = new Game_Db_control();
	$userInfo = $database->GetUserInfo($user);
	if (!isset($userInfo) || count($userInfo)<1){
		PrintUserInfo();
		PrintBabyRegisterForm();
	} else{
		PrintUserInfo($userInfo);
	}
	echo '<p><a href="../logout/">Logout</a></p>';
}
?>