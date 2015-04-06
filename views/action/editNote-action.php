<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (isset($_POST["admin"]))
	{
		$admin   = $_POST["admin"];
		$adminid = $_POST["adminid"];
		$playerid = $_POST["playerid"];
		$note = $_POST["note"];
        
        if (isset($_POST["nId"]))
        {
            $nId = $_POST["nId"];
        }
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
		if (isset($_POST['new'])) 
		{
            $sql = "INSERT INTO lc_notes (admin, adminid, playerid, time, note)
                    VALUES('".$admin."','".$adminid."','".$playerid."', CURRENT_TIMESTAMP,'".$note."');";
		}
        else if (isset($_POST['drop']))
        {
            $sql = "DELETE FROM `lc_notes` WHERE `id` = '".$nId."'";
        }
		else
		{
			$sql = "UPDATE `lc_notes` SET `admin`='".$admin."', `adminid`='".$adminid."', `note`='".$note."' WHERE `id` = '".$nId."'";
		}		

		$result_of_query = $db_connection->query($sql);
	}
	else 
	{
		$this->errors[] = "Database connection problem.";
	}

	header('Location: editPlayer.php?pId='.$playerid.'');
?>
