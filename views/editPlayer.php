<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $page_rows_notes = '5';
    $page_rows_vehicles = '10';
    
	if (isset($_GET["playerId"]))
	{
		$pId = $_GET["playerId"];	
        $playersID = $_GET["playerId"];
	}
    else if (isset($_GET["pId"]))
	{
		$pId = $_GET["pId"];	
        $playersID = $_GET["pId"];
	}
    else if (isset($_POST["playerId"]))
	{
		$pId = $_POST["playerId"];	
        $playersID = $_POST["playerId"];
	}
	else
	{
        echo "<center><h1 style='color:red'>PLAYERID NOT SET</h1></center>";
	}

	// change character set to utf8 and check it
	if (!$db_connection->set_charset("utf8")) {
		$db_connection->errors[] = $db_connection->error;
	}
	
	$pGID = "";
		
	$temp = '';

	for ($i = 0; $i < 8; $i++) {
		$temp .= chr($playersID & 0xFF);
		$playersID >>= 8;
	}

	$return = md5('BE' . $temp);
	$pGID = $return;

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Life Control</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <?php include("views/sidebar.php"); ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Player <small>Editing</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-wrench"></i> Player Editor
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                <div class='col-lg-12'>
                        
						<div class='panel panel-default'>
							<div class='panel-heading'>
								<h3 class='panel-title'><i class='fa fa-bell fa-fw'></i> Notes</h3>
							</div>
							<div class="panel-body">
								<div class="col-md-12">
									<div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Admin</th>
                                            <th>Time</th>
                                            <th>Note</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (!$db_connection->connect_errno) 
                                            {
                                                if (!(isset($_POST['pagenum']))) 
                                                    { 
                                                        $pagenum = 1; 
                                                    }
                                                    else
                                                    {
                                                        $pagenum = $_POST['pagenum'];
                                                    }

                                                    $sql = "SELECT * FROM `lc_notes`;";

                                                    $result_of_query = $db_connection->query($sql);
                                                    $rows = mysqli_num_rows($result_of_query); 

                                                    $last = ceil($rows/$page_rows_notes); 

                                                    if ($pagenum < 1) 
                                                    { 
                                                        $pagenum = 1; 
                                                    } 
                                                    elseif ($pagenum > $last) 
                                                    { 
                                                        $pagenum = $last; 
                                                    }

                                                    $max = 'limit ' .($pagenum - 1) * $page_rows_notes .',' .$page_rows_notes;
                                                
                                                    $sql = "SELECT * FROM `lc_notes` WHERE `playerid` = '".$pId."' ORDER BY `time` DESC ".$max." ;";
                                                    $result_of_query = $db_connection->query($sql);
                                                    while($row = mysqli_fetch_assoc($result_of_query)) 
                                                    {
                                                        echo "<tr>";
                                                            echo "<td>".$row["admin"]."</td>";
                                                            echo "<td>".$row["time"]."</td>";
                                                            echo "<td>".$row["note"]."</td>";
                                                            echo "<td><a href='/editNote.php?nId=".$row["id"]."'><div class='btn btn-sm btn-primary'>Edit Note</div></a></td>";
                                                        echo "</tr>";
                                                    };
                                                } 
                                                else 
                                                {
                                                    $this->errors[] = "Database connection problem.";
                                                }
                                                echo "</tbody></table>";
                                                
                                                $sql = "SELECT * FROM `lc_notes` WHERE `playerid` = '".$pId."';";
                                                $result_of_query = $db_connection->query($sql);
                                                if ($result_of_query->num_rows > $page_rows_notes) {
                                                
                                                    echo "<table><thead>";
                                                    echo "<br>";
                                                    if ($pagenum == 1){} 
                                                            else 
                                                            {
                                                                echo "<th><form method='post' action='".$_SERVER['PHP_SELF']."?pId=".$pId."' name='pagenum'>";
                                                                echo "<input id='pagenum' type='hidden' name='pagenum' value='1'>";
                                                                echo "<input type='submit' value=' <<-First  '>";
                                                                echo "</form></th>";
                                                                $previous = $pagenum-1;
                                                                echo "<th><form style='float:right;' method='post' action='".$_SERVER['PHP_SELF']."?pId=".$pId."' name='pagenum'>";
                                                                echo "<input id='pagenum' type='hidden' name='pagenum' value='".$previous."'>";
                                                                echo "<input type='submit' value=' <-Previous  '>";
                                                                echo "</form></th>";
                                                            } 
                                                            //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
                                                            if ($pagenum == $last) {} 
                                                            else 
                                                            {
                                                                $next = $pagenum+1;
                                                                echo "<th><form method='post' action='".$_SERVER['PHP_SELF']."?pId=".$pId."' name='pagenum'>";
                                                                echo "<input id='pagenum' type='hidden' name='pagenum' value='".$next."'>";
                                                                echo "<input type='submit' value=' Next ->  '>";
                                                                echo "</form></th>";
                                                                echo " ";
                                                                echo "<th><form method='post' action='".$_SERVER['PHP_SELF']."?pId=".$pId."' name='pagenum'>";
                                                                echo "<input id='pagenum' type='hidden' name='pagenum' value='".$last."'>";
                                                                echo "<input type='submit' value=' Last ->>  '>";
                                                                echo "</form></th>";
                                                            }
                                                    echo "</thead></table>";
                                                    
                                                };
                                                ?>
                                                <form method="post" action="editNote.php" name="editform">
                                                    <center>
                                                    <?php
                                                        echo "<input id='pId' type='hidden' name='pId' value='".$pId."'>"; 
                                                        echo "<input class='btn btn-lg btn-primary'  type='submit'  name='addNote' value='Add note'>";
                                                    ?>
                                                    </center>
                                                </form>
                                    
                                
                            </div>
								</div>
								<div class="col-md-6">
									
								</div>
							</div>
						</div>
                    
                </div>
                
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-child fa-fw"></i> Player</h3>
                        </div>
                        <div class="panel-body">
                            <form method="post" action="editPlayer-actionProfile.php" name="editform">
                                <?php
                                    if (!$db_connection->connect_errno) 
                                    {
                                        $sql = 'SELECT * FROM `players` WHERE `playerid` ="'.$pId.'";';
                                        $result_of_query = $db_connection->query($sql);
                                        if ($result_of_query->num_rows > 0)
                                        {
                                            while($row = mysqli_fetch_assoc($result_of_query)) 
                                            {
                                                $playersID = $row["playerid"];
                                                echo "<center>";
                                                    echo "<h3>Name: ".$row["name"]."</h3>";
                                                    echo "<h4>Last update: ".$row["timeupdated"]."</h4>";
                                                    echo "<h4>Aliases: ".$row["aliases"]."</h4>";
                                                    echo "<h4>Database ID: ".$row["uid"]."</h4>";
                                                    echo "<h4>Player ID: ".$playersID."</h4>";
                                                    echo "<h4>GUID: ".$pGID."</h4>";                        
                                                    echo "<h4>Cash:    <input id='player_cash' name='player_cash' type='text' value='".$row["cash"]."'></td><br/>";
                                                    echo "<h4>Bank:    <input id='player_bank' name='player_bank' type='text' value='".$row["bankacc"]."'></td><br/>";
                                                    echo "<h4>Cop: ";
                                                    echo "<select id='player_coplvl' name='player_coplvl'>";
                                                        echo '<option value="0"';
                                                            if($row['coplevel']==0){echo ' selected';}
                                                        echo '>0</option>';	
                                                        echo '<option value="1"';
                                                            if($row['coplevel']==1){echo ' selected';}
                                                        echo '>1</option>';	
                                                        echo '<option value="2"';
                                                            if($row['coplevel']==2){echo ' selected';}
                                                        echo '>2</option>';
                                                        echo '<option value="3"';
                                                            if($row['coplevel']==3){echo ' selected';}
                                                        echo '>3</option>';
                                                        echo '<option value="4"';
                                                            if($row['coplevel']==4){echo ' selected';}
                                                        echo '>4</option>';
                                                        echo '<option value="5"';
                                                            if($row['coplevel']==5){echo ' selected';}
                                                        echo '>5</option>';
                                                        echo '<option value="6"';
                                                            if($row['coplevel']==6){echo ' selected';}
                                                        echo '>6</option>';
                                                        echo '<option value="7"';
                                                            if($row['coplevel']==7){echo ' selected';}
                                                        echo '>7</option></h4>';
                                                        echo '<option value="8"';
                                                            if($row['coplevel']==8){echo ' selected';}
                                                        echo '>8</option></h4>';
                                                        echo '<option value="9"';
                                                            if($row['coplevel']==9){echo ' selected';}
                                                        echo '>9</option></h4>';
                                                    echo "</select>";
                                                    echo "<h4>THW: ";
                                                    echo "<select id='player_medlvl' name='player_medlvl'>";
                                                        echo '<option value="0"';
                                                            if($row['mediclevel']==0){echo ' selected';}
                                                        echo '>0</option>';	
                                                        echo '<option value="1"';
                                                            if($row['mediclevel']==1){echo ' selected';}
                                                        echo '>1</option>';	
                                                        echo '<option value="2"';
                                                            if($row['mediclevel']==2){echo ' selected';}
                                                        echo '>2</option>';
                                                    echo "</select>";
                                                    echo "<h4>Admin: ";
                                                    echo "<select id='player_adminlvl' name='player_adminlvl'>";
                                                        if($_SESSION['user_level'] >= '3') {
                                                            echo '<option value="0"';
                                                                if($row['adminlevel']==0){echo ' selected';}
                                                            echo '>0</option>';	
                                                            echo '<option value="1"';
                                                                if($row['adminlevel']==1){echo ' selected';}
                                                            echo '>1</option>';	
                                                            echo '<option value="2"';
                                                                if($row['adminlevel']==2){echo ' selected';}
                                                            echo '>2</option>';
                                                            echo '<option value="3"';
                                                                if($row['adminlevel']==3){echo ' selected';}
                                                            echo '>3</option>';
                                                        } else {
                                                            echo '<option value="'.$row['adminlevel'].'" '.$row['adminlevel'].'>'.$row['adminlevel'].'</option>';
                                                        };
                                                    echo "</select>";
                                                    echo "<h4>Donator: ";
                                                    echo "<select id='player_donlvl' name='player_donlvl'>";
                                                        if($_SESSION['user_level'] >= '3') {
                                                            echo '<option value="0"';
                                                                if($row['donatorlvl']==0){echo ' selected';}
                                                            echo '>0</option>';	
                                                            echo '<option value="1"';
                                                                if($row['donatorlvl']==1){echo ' selected';}
                                                            echo '>1</option>';	
                                                            echo '<option value="2"';
                                                                if($row['donatorlvl']==2){echo ' selected';}
                                                            echo '>2</option>';
                                                            echo '<option value="3"';
                                                                if($row['donatorlvl']==3){echo ' selected';}
                                                            echo '>3</option>';
                                                        } else {
                                                            echo '<option value="'.$row['donatorlvl'].'" '.$row['donatorlvl'].'>'.$row['donatorlvl'].'</option>';
                                                        };
                                                    echo "</select>";
                                                echo "</center>";
                                ?>
                                <?php
                                                $sql = 'SELECT * FROM `gangs` where `members` LIKE "%'.$pId.'%"';
                                                    $result_of_query = $db_connection->query($sql);
                                                    while($row = mysqli_fetch_assoc($result_of_query)) 
                                                    {
                                                         echo "<center><h4>Gang: <a href='/editGang.php?gId=".$row["id"]."'>".$row["name"]."</a></h4></center>";                                                            
                                                    };
                                ?>
                                <center>
                                    <?php
                                        if($_SESSION['user_level'] >= '2')
                                        {
                                            echo "<input id='playerId' type='hidden' name='playerId' value='".$pId."'>";   
                                            echo "<input class='btn btn-lg btn-primary'  type='submit'  name='edit' value='Update Profile'>";
                                        };
                                    ?>
                                    <br/>
                                </center>
                            </form>
                        </div>		
                    </div>
                </div>
                <div class="col-lg-8" style="float:right">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-car fa-fw"></i> Vehicles Quick Look</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Class</th>
                                            <th>Alive</th>
                                            <th>Active</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (!$db_connection->connect_errno) 
                                            {
                                                if (!(isset($_POST['pagenum']))) 
                                                    { 
                                                        $pagenum = 1; 
                                                    }
                                                    else
                                                    {
                                                        $pagenum = $_POST['pagenum'];
                                                    }

                                                    $sql = "SELECT * FROM `vehicles`;";

                                                    $result_of_query = $db_connection->query($sql);
                                                    $rows = mysqli_num_rows($result_of_query); 

                                                    $last = ceil($rows/$page_rows_vehicles); 

                                                    if ($pagenum < 1) 
                                                    { 
                                                        $pagenum = 1; 
                                                    } 
                                                    elseif ($pagenum > $last) 
                                                    { 
                                                        $pagenum = $last; 
                                                    }

                                                    $max = 'limit ' .($pagenum - 1) * $page_rows_vehicles .',' .$page_rows_vehicles;
                                                
                                                    $sql = "SELECT * FROM `vehicles` WHERE `pid` = '".$pId."' ORDER BY `active` DESC , `classname` ASC ".$max." ;";
                                                    $result_of_query = $db_connection->query($sql);
                                                    while($row = mysqli_fetch_assoc($result_of_query)) 
                                                    {
                                                        $vehID = $row["id"];
                                                        echo "<tr>";
                                                            echo "<td>";
                                                            if($row['classname']=='C_Offroad_01_F'){echo 'Offroad';}
                                                            if($row['classname']=='C_SUV_01_F'){echo 'SUV';}
                                                            if($row['classname']=='C_Offroad_01_repair_F'){echo 'Offroad (Repair)';}
                                                            if($row['classname']=='O_Heli_Light_02_unarmed_F'){echo 'PO-30 Orca';}
                                                            if($row['classname']=='C_Heli_Light_01_civil_F'){echo 'M-900';}
                                                            if($row['classname']=='B_Quadbike_01_F'){echo 'Quadbike';}
                                                            if($row['classname']=='C_Hatchback_01_F'){echo 'Hatchback';}
                                                            if($row['classname']=='C_Hatchback_01_sport_F'){echo 'Hatchback Sport';}
                                                            if($row['classname']=='C_Van_01_transport_F'){echo 'Truck';}
                                                            if($row['classname']=='C_Van_01_box_F'){echo 'Truck Boxer';}
                                                            if($row['classname']=='C_Van_01_fuel_F'){echo 'Fuel Truck';}
                                                            if($row['classname']=='I_Truck_02_transport_F'){echo 'Zamak Transport';}
                                                            if($row['classname']=='O_Truck_03_transport_F'){echo 'Tempest Transport';}
                                                            if($row['classname']=='B_Truck_01_transport_F'){echo 'HEMTT Transport';}
                                                            if($row['classname']=='O_Truck_02_covered_F'){echo 'Zamak Transport (Covered)';}
                                                            if($row['classname']=='O_Truck_03_covered_F'){echo 'Tempest Transport (Covered)';}
                                                            if($row['classname']=='B_Truck_01_covered_F'){echo 'HEMTT Transport (Covered)';}
                                                            if($row['classname']=='B_Truck_01_box_F'){echo 'HEMTT Box';}
                                                            if($row['classname']=='O_Truck_03_ammo_F'){echo 'Tempest Ammo';}
                                                            if($row['classname']=='I_Truck_02_fuel_F'){echo 'Zamak Fuel';}
                                                            if($row['classname']=='O_Truck_03_fuel_F'){echo 'Tempest Fuel';}
                                                            if($row['classname']=='B_Truck_01_fuel_F'){echo 'HEMTT Fuel';}
                                                            if($row['classname']=='O_Truck_03_device_F'){echo 'Tempest (Device)';}
                                                            if($row['classname']=='I_Heli_Transport_02_F'){echo 'CH-49 Mohawk';}
                                                            if($row['classname']=='O_Heli_Transport_04_F'){echo 'Mi-290 Taru';}
                                                            if($row['classname']=='O_Heli_Transport_04_covered_F'){echo 'Mi-290 Taru (Transport)';}
                                                            if($row['classname']=='O_Heli_Transport_04_box_F'){echo 'Mi-290 Taru (Cargo)';}
                                                            if($row['classname']=='O_Heli_Transport_04_fuel_F'){echo 'Mi-290 Taru (Fuel)';}
                                                            if($row['classname']=='C_Rubberboat'){echo 'Rescue Boat';}
                                                            if($row['classname']=='C_Boat_Civil_01_F'){echo 'Motorboat';}
                                                            if($row['classname']=='B_SDV_01_F'){echo 'SDV (Submarine)';}
                                                            if($row['classname']=='B_G_Offroad_01_F'){echo 'Offroad';}
                                                            if($row['classname']=='B_Heli_Light_01_F'){echo 'MH-9 Hummingbird';}
                                                            if($row['classname']=='O_MRAP_02_F'){echo 'iFrit';}
                                                            if($row['classname']=='B_G_Offroad_01_armed_F'){echo 'Offroad (Armed)';}
                                                            if($row['classname']=='O_Heli_Transport_04_bench_F'){echo 'Mi-290 Taru (Bench)';}
                                                            if($row['classname']=='O_Heli_Attack_02_black_F'){echo 'Mi-48 Kajman (Black)';}
                                                            if($row['classname']=='B_MRAP_01_F'){echo 'Hunter';}
                                                            if($row['classname']=='I_MRAP_03_F'){echo 'Strider';}
                                                            if($row['classname']=='B_MRAP_01_hmg_F'){echo 'Hunter HMG';}
                                                            if($row['classname']=='I_Heli_light_03_unarmed_F'){echo 'WY-55 Hellcat (Green)';}
                                                            if($row['classname']=='I_Heli_light_03_F'){echo 'WY-55 Hellcat';}
                                                            if($row['classname']=='B_Heli_Transport_01_F'){echo 'UH-80 Ghost Hawk';}
                                                            if($row['classname']=='B_Heli_Transport_03_F'){echo 'CH-67 Huron';}
                                                            if($row['classname']=='B_Heli_Transport_03_unarmed_F'){echo 'CH-67 Huron (Black)';}
                                                            if($row['classname']=='B_Boat_Transport_01_F'){echo 'Assault Boat';}
                                                            if($row['classname']=='C_Boat_Civil_01_police_F'){echo 'Motorboat (Police)';}
                                                            if($row['classname']=='B_Boat_Armed_01_minigun_F'){echo 'Speedboat Minigun';}
                                                            if($row['classname']=='O_Truck_02_Fuel_F'){echo 'Zamak Fuel';}
                                                            if($row['classname']=='O_Truck_03_fuel_F'){echo 'Tempest Fuel';}
                                                            if($row['classname']=='B_Truck_01_ammo_F'){echo 'HEMTT Ammo';}
                                                            if($row['classname']=='O_Truck_02_box_F'){echo 'Zamak Repair';}
                                                            if($row['classname']=='O_Heli_Transport_04_medevac_F'){echo 'Mi-290 Taru (Medical)';}
                                                            if($row['classname']=='O_Boat_Armed_01_hmg_F'){echo 'Speedboat HMG';}
                                                            if($row['classname']=='I_MRAP_03_hmg_F'){echo 'Strider HMG';}
                                                            if($row['classname']=='O_MRAP_02_hmg_F'){echo 'Ifrit HMG';}
                                                            if($row['classname']=='O_Truck_03_Ammo_F'){echo 'Tempest Ammo';}
                                                            if($row['classname']=='Box_IND_AmmoVeh_F'){echo 'Box_IND_AmmoVeh_F';}
                                                            if($row['classname']=='B_Slingload_01_Cargo_F'){echo 'B_Slingload_01_Cargo_F';}
                                                            if($row['classname']=='C_supplyCrate_F'){echo 'C_supplyCrate_F';}
                                                            if($row['classname']=='B_Heli_Attack_01_F'){echo 'AH-99 Blackfoot';}
                                                            echo "</td>";
                                                            echo "<td>".$row["alive"]."</td>";
                                                            echo "<td>".$row["active"]."</td>";
                                                            if($_SESSION['user_level'] == '1') {
                                                                if ($row["alive"] == '1' && $row["active"] == '0') {
                                                                    echo "<td></td>";
                                                                }
                                                                else {
                                                                    echo "<td><a href='/editVeh.php?vId=".$vehID."'><div class='btn btn-sm btn-primary'>Edit Vehicle</div></a></td>";
                                                                };
                                                            } else {                                        
                                                                echo "<td><a href='/editVeh.php?vId=".$vehID."'><div class='btn btn-sm btn-primary'>Edit Vehicle</div></a></td>";
                                                            };
                                                        echo "</tr>";
                                                    };
                                                } 
                                                else 
                                                {
                                                    $this->errors[] = "Database connection problem.";
                                                }
                                                echo "</tbody></table>";
                                                
                                                $sql = "SELECT * FROM `vehicles` WHERE `pid` = '".$pId."';";
                                                $result_of_query = $db_connection->query($sql);
                                                if ($result_of_query->num_rows > $page_rows_vehicles) {
                                                
                                                    echo "<table><thead>";
                                                    echo "<br>";
                                                    if ($pagenum == 1){} 
                                                            else 
                                                            {
                                                                echo "<th><form method='post' action='".$_SERVER['PHP_SELF']."?pId=".$playersID."' name='pagenum'>";
                                                                echo "<input id='pagenum' type='hidden' name='pagenum' value='1'>";
                                                                echo "<input type='submit' value=' <<-First  '>";
                                                                echo "</form></th>";
                                                                $previous = $pagenum-1;
                                                                echo "<th><form style='float:right;' method='post' action='".$_SERVER['PHP_SELF']."?pId=".$playersID."' name='pagenum'>";
                                                                echo "<input id='pagenum' type='hidden' name='pagenum' value='".$previous."'>";
                                                                echo "<input type='submit' value=' <-Previous  '>";
                                                                echo "</form></th>";
                                                            } 
                                                            //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
                                                            if ($pagenum == $last) {} 
                                                            else 
                                                            {
                                                                $next = $pagenum+1;
                                                                echo "<th><form method='post' action='".$_SERVER['PHP_SELF']."?pId=".$playersID."' name='pagenum'>";
                                                                echo "<input id='pagenum' type='hidden' name='pagenum' value='".$next."'>";
                                                                echo "<input type='submit' value=' Next ->  '>";
                                                                echo "</form></th>";
                                                                echo " ";
                                                                echo "<th><form method='post' action='".$_SERVER['PHP_SELF']."?pId=".$playersID."' name='pagenum'>";
                                                                echo "<input id='pagenum' type='hidden' name='pagenum' value='".$last."'>";
                                                                echo "<input type='submit' value=' Last ->>  '>";
                                                                echo "</form></th>";
                                                            }
                                                    echo "</thead></table>";
                                                    
                                                };
                                        ?>
                                    
                                
                            </div>
                        </div>
                    </div>
                </div>
                <?php if($_SESSION['user_level'] >= '2') { ?>
					<div class="col-lg-4">
                       <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-home fa-fw"></i>Houses Quick Look</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <?php if($_SESSION['user_level'] >= '3') { ?>
                                                <th>Position</th>
                                                <?php }; ?>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if (!$db_connection->connect_errno) 
                                                {
                                                    $sql = "SELECT `pos`,`id` FROM `houses` WHERE `pid` = '".$pId."' ORDER BY `id` DESC LIMIT 10";
                                                    $result_of_query = $db_connection->query($sql);
                                                    while($row = mysqli_fetch_assoc($result_of_query)) 
                                                    {

                                                        $temp = '';

                                                        for ($i = 0; $i < 8; $i++) {
                                                            $temp .= chr($playersID & 0xFF);
                                                            $playersID >>= 8;
                                                        }

                                                        $return = md5('BE' . $temp);
                                                        $pGID = $return;

                                                        $hId = $row["id"];
                                                        echo "<tr>";
                                                            if($_SESSION['user_level'] >= '3') {
                                                                echo "<td>".$row["pos"]."</td>";
                                                            };
                                                            echo "<td><form method='post' action='editHouse.php' name='PlayerEdit'>";
                                                            echo "<input id='hId' type='hidden' name='hId' value='".$hId."'>";
                                                            echo "<input class='btn btn-sm btn-primary'  type='submit'  name='editH' value='Edit House'>";
                                                            echo "</form></td>";
                                                        echo "</tr>";
                                                    };
                                                } 
                                                else 
                                                {
                                                    $this->errors[] = "Database connection problem.";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }; ?>
                    <form method="post" action="edit-action.php" name="editform">
                    <?php
                    $sql = 'SELECT * FROM `players` WHERE `playerid` ="'.$pId.'";';
                    $result_of_query = $db_connection->query($sql);
                    while($row = mysqli_fetch_assoc($result_of_query)) 
                    {    
                    ?>
					<div class='col-lg-12'>
                        
						<div class='panel panel-default'>
							<div class='panel-heading'>
								<h3 class='panel-title'><i class='fa fa-child fa-fw'></i> Civilian</h3>
							</div>
							<div class="panel-body">
								<div class="col-md-6">
									<?php
										echo "<h4>Civ Licenses:</h4> <textarea id='civ_lic' name='civ_lic' cols='70' rows='5'>".$row["civ_licenses"]."</textarea>";
									?>
								</div>
								<div class="col-md-6">
									<?php
										echo "<h4>Civ Gear:</h4> <textarea id='civ_gear' name='civ_gear' cols='70' rows='5'>".$row["civ_gear"]."</textarea>";
									?>
								</div>
							</div>
						</div>
                        
                        <div class='panel panel-default'>
							<div class='panel-heading'>
								<h3 class='panel-title'><i class='fa fa-taxi fa-fw'></i> Police</h3>
							</div>
							<div class="panel-body">
								<div class="col-md-6">
									<?php
										echo "<h4>Cop Licenses:</h4> <textarea id='cop_lic' name='cop_lic' cols='70' rows='5'>".$row["cop_licenses"]."</textarea>";
									?>
								</div>
								<div class="col-md-6">
									<?php
										echo "<h4>Cop Gear:</h4> <textarea id='cop_gear' name='cop_gear' cols='70' rows='5'>".$row["cop_gear"]."</textarea>";
									?>
								</div>
							</div>
						</div>

						<div class='panel panel-default'>
							<div class='panel-heading'>
								<h3 class='panel-title'><i class='fa fa-ambulance fa-fw'></i> THW</h3>
							</div>
							<div class="panel-body">
								<div class="col-md-6">
									<?php
										echo "<h4>THW Licenses:</h4> <textarea id='med_lic' name='med_lic' cols='70' rows='5'>".$row["med_licenses"]."</textarea>";
									?>
								</div>
								<div class="col-md-6">
									<?php
										echo "<h4>THW Gear:</h4> <textarea id='med_gear' name='med_gear' cols='70' rows='5'>".$row["med_gear"]."</textarea>";
									?>
								</div>
							</div>
						</div>
                        
					</div>
                    <?php }; ?>
                    <div class='col-lg-12'>
                        <div class='panel panel-default'>
                        <div class='panel-heading'>
                            <h3 class='panel-title'><i class='fa fa-cubes fa-fw'></i> Skills</h3>
                        </div>
                        <?php
                            if (!$db_connection->connect_errno) 
                            {
                                $sql = "SELECT * FROM `skillsys` WHERE `playerid` = '".$pId."' ;";
                                $result_of_query = $db_connection->query($sql);
                                while($row = mysqli_fetch_assoc($result_of_query)) 
                                { ?>
                                    <div class="panel-body">
                                        <div class="col-lg-4" style="float:left;">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><i class="fa fa-apple fa-fw"></i> General</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Ability</th>
                                                                    <th>Points</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php echo "<tr><td>Apple</td><td><input id='skills_apple' name='skills_apple' value='".$row["apple"]."'></textarea></td></tr>"; ?>
                                                                <?php echo "<tr><td>Cherry</td><td><input id='skills_peach' name='skills_peach' value='".$row["peach"]."'></textarea></td></tr>"; ?>
                                                                <?php echo "<tr><td>Salt</td><td><input id='skills_salt' name='skills_salt' value='".$row["salt"]."'></textarea></td></tr>"; ?>
                                                                <?php echo "<tr><td>Sand</td><td><input id='skills_sand' name='skills_sand' value='".$row["sand"]."'></textarea></td></tr>"; ?>
                                                                <?php echo "<tr><td>Rock</td><td><input id='skills_rock' name='skills_rock' value='".$row["rock"]."'></textarea></td></tr>"; ?>
                                                                <?php echo "<tr><td>Frog</td><td><input id='skills_frog' name='skills_frog' value='".$row["frog"]."'></textarea></td></tr>"; ?>
                                                                <?php echo "<tr><td>Oil</td><td><input id='skills_oilu' name='skills_oilu' value='".$row["oilu"]."'></textarea></td></tr>"; ?>
                                                                <?php echo "<tr><td>Uran</td><td><input id='skills_uranu' name='skills_uranu' value='".$row["uranu"]."'></textarea></td></tr>"; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" style="float:left;">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><i class="fa fa-diamond fa-fw"></i> Ores</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Ability</th>
                                                                    <th>Points</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php echo "<tr><td>Copperore</td><td><input id='skills_copperore' name='skills_copperore' value='".$row["copperore"]."'></textarea></td></tr>"; ?>
                                                                <?php echo "<tr><td>Coal</td><td><input id='skills_coal' name='skills_coal' value='".$row["coal"]."'></textarea></td></tr>"; ?>
                                                                <?php echo "<tr><td>Ironore</td><td><input id='skills_ironore' name='skills_ironore' value='".$row["ironore"]."'></textarea></td></tr>"; ?>
                                                                <?php echo "<tr><td>Silver</td><td><input id='skills_silver' name='skills_silver' value='".$row["silver"]."'></textarea></td></tr>"; ?>
                                                                <?php echo "<tr><td>Gold</td><td><input id='skills_gold' name='skills_gold' value='".$row["gold"]."'></textarea></td></tr>"; ?>
                                                                <?php echo "<tr><td>Diamond</td><td><input id='skills_diamond' name='skills_diamond' value='".$row["diamond"]."'></textarea></td></tr>"; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" style="float:left;">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><i class="fa fa-medkit fa-fw"></i> Drugs</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Ability</th>
                                                                    <th>Points</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php echo "<tr><td>Cannabis</td><td><input id='skills_cannabis' name='skills_cannabis' value='".$row["cannabis"]."'></textarea></td></tr>"; ?>
                                                                <?php echo "<tr><td>Cocaine</td><td><input id='skills_cocaine' name='skills_cocaine' value='".$row["cocaine"]."'></textarea></td></tr>"; ?>
                                                                <?php echo "<tr><td>Heroin</td><td><input id='skills_heroinu' name='skills_heroinu' value='".$row["heroinu"]."'></textarea></td></tr>"; ?>
                                                                <?php echo "<tr><td>Theft (Bluemeth)</td><td><input id='skills_diebstahl' name='skills_diebstahl' value='".$row["diebstahl"]."'></textarea></td></tr>"; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                };
                            } 
                            else 
                            {
                                $this->errors[] = "Database connection problem.";
                            }
                        ?>
                        </div>
                    </div>
					<div class="col-md-4"></div>					
					<div class="col-md-4">
                        <center>
                            <?php
                                if($_SESSION['user_level'] >= '2')
                                {
                                    echo "<input id='playerId' type='hidden' name='playerId' value='".$pId."'>";   
                                    echo "<input class='btn btn-lg btn-primary'  type='submit'  name='edit' value='Submit Changes'>";
                                } else {
                                    echo "Your permission level is insufficient to submit these changes.";
                                };
                            ?>
                            <br/>
                        </center>
					</div>
                    <div class="col-md-12" style="margin-bottom: 20px;"></div>
                    <div class="col-md-12">    
                        <div class='panel panel-default'>
                        <div class='panel-heading'>
                            <h3 class='panel-title'><i class='fa fa-envelope-o fa-fw'></i> Messages</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Time</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = 'SELECT * FROM `messages` WHERE `fromID` = "'.$pId.'" OR `toID` = "'.$pId.'" ORDER BY `time` DESC';
                                        $result_of_query = $db_connection->query($sql);
                                        while($row = mysqli_fetch_assoc($result_of_query)) 
                                        {
                                            echo "<tr>";
                                            echo "<td>".$row["fromName"]."</td>";
                                            echo "<td>".$row["toName"]."</td>";
                                            echo "<td>".$row["time"]."</td>";
                                            echo "<td>".$row["message"]."</td>";
                                            echo "</tr>";
                                        };
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
									<?php
												};
											}
											else 
											{
												echo "<center><h1 style='color:red'>ERROR NO RESULTS</h1></center>";
											}
										
										} 
										else 
										{
											$this->errors[] = "Database connection problem.";
										}
									?>  
								</form>
                
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
