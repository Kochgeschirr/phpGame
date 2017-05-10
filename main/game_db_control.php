<?php
require("../infos_db_connect.php");
require("../db_control.php");

Class Game_DB_Control extends DB_Control{
	
	function GetUserInfo($userName){
		$queryString  = "SELECT users.username, babies.bName, babies.bLevel, babies.bPower, babies.bAgility, bLuck, bMaxHealth, bExp ";
		$queryString .= "FROM babies LEFT JOIN users ON users.userid = babies.userid WHERE username LIKE ?;";
		$infoQuery = $this->connection->prepare($queryString);

		if (!$infoQuery){
			echo "<p>Error while fetching Userinformation</p>";
		} else {
			//$userName="ennafp";
			$infoQuery->bind_param('s', $userName);		
			$infoQuery->execute();
			$result = $infoQuery->get_result();
			$row = $result->fetch_array(MYSQLI_NUM);
			
			return $row;	
		}
	}
	
	function RegisterBaby($user, $babyname){
		$uIdQuery = $this->connection->prepare("SELECT userid FROM users WHERE username LIKE ?");
		$uIdQuery->bind_param('s', $user);
		$uIdQuery->execute();
		$uIdQuery->bind_result($userid);
		if (!$uIdQuery->fetch()){
			return false;
		} else {
			$uIdQuery->close();
			$queryString = "INSERT INTO babies (babyid, userid, bName, bLevel, bPower, bAgility, bLuck, bMaxHealth, bEXP) VALUE (null, ?, ?, 1, 3, 3, 2, 20, 0);";
			$babyRegQuery = $this->connection->prepare($queryString);
			$babyRegQuery->bind_param('is',$userid, $babyname);
			$babyRegQuery->execute();
			return $babyRegQuery->affected_rows;
		}		
	}
}

/*
while ( $aRow = $sResult->fetch_assoc() )
{
        foreach($aRow as $fieldname => $fieldvalue) {
             $row_selectProduct[$fieldname] = $fieldvalue;   
        }

}
*/
?>