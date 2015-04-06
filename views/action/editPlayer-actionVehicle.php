<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (isset($_POST["vehID"]))
	{
		$pId   = $_POST["pId"];
        $vId   = $_POST["vehID"];
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
		
		$sql = "UPDATE `vehicles` SET `alive`='1',`active`='0' WHERE `id` = '".$vId."'";
        
        $result_of_query = $db_connection->query($sql);

	}
	else 
	{
		$this->errors[] = "Database connection problem.";
	}

	header('Location: editPlayer.php?pId='.$pId.'');
?>
