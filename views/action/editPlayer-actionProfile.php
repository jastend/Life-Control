<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (isset($_POST["playerId"]))
	{
		$pId   = $_POST["playerId"];
		$pCash = $_POST["player_cash"];
		$pBank = $_POST["player_bank"];
		$pCopLvl = $_POST["player_coplvl"];
		$pMedLvl = $_POST["player_medlvl"];
		$pAdminLvl = $_POST["player_adminlvl"];
		$pDonLvl = $_POST["player_donlvl"];
	}
	else
	{
		echo "<center><h1 style='color:red'>PLAYERID NOT SET</h1></center>";
	}
	
	// change character set to utf8 and check it
	if (!$db_connection->set_charset("utf8")) {
		$db_connection->errors[] = $db_connection->error;
	}
	
	if (!$db_connection->connect_errno) 
	{
		
		$sql = "UPDATE `players` SET `cash`='".$pCash."',`bankacc`='".$pBank."',`coplevel`='".$pCopLvl."',`mediclevel`='".$pMedLvl."',`adminlevel`='".$pAdminLvl."',`donatorlvl`='".$pDonLvl."' WHERE `playerid` = '".$pId."'";
        
        $result_of_query = $db_connection->query($sql);

	}
	else 
	{
		$this->errors[] = "Database connection problem.";
	}

	header('Location: editPlayer.php?pId='.$pId.'');
?>
