<?php
require("game_db_control.php");
session_start();

function PrintBirthError(){
	echo "<h2>Some error occured while giving birth.</h2>
		  <p>I'm sorry it's a stillbirth</p>";	
}

if (!isset($_POST['babyname'])){
	PrintBirthError();
} else {
	$database = new Game_db_control();
	
	$queryResult = $database->RegisterBaby($_SESSION['username'],$_POST['babyname']);
	if($queryResult>0){
		echo "Your child looks healthy :-)";
		echo "\n<br/><a href=\"./\">weiter</a><br/>";
	} else {
		PrintBirthError();
	}
	echo "<br/><a href=\"./\">Back</a>";
}