<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$page_rows = results_per_page;
	// change character set to utf8 and check it
	if (!$db_connection->set_charset("utf8")) {
		$db_connection->errors[] = $db_connection->error;
	}
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
                            New Players <small>Overview</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-bullseye"></i> Player Check
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-child fa-fw"></i> Players
                            </div>
                            <div class="panel-body">

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Player Name</th>
                                                        <th>Player ID</th>
                                                        <th>Cash</th>
                                                        <th>Bank</th>
                                                        <th>Alert</th>
                                                        <th>Edit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    if (!$db_connection->connect_errno) 
                                                    {
                                                        $sql = "SELECT * FROM `players` ORDER BY `uid` DESC LIMIT 100";
                                                        
                                                        $result_of_query = $db_connection->query($sql);
                                                        while($row = mysqli_fetch_assoc($result_of_query)) 
                                                        {
                                                            $playersID = $row["playerid"];
                                                            if ($row["cash"] == 1337 && $row["bankacc"] == 1337) {
                                                                echo "<tr style='background: #ffeeee; color: #cc0000; border-color: #ff9999;'>";
                                                            } else {
                                                                echo "<tr>";
                                                            }
                                                                echo "<td>".$row["name"]."</td>";
                                                                echo "<td>".$playersID."</td>";
                                                                echo "<td>".$row["cash"]."</td>";
                                                                echo "<td>".$row["bankacc"]."</td>";
                                                                echo "<td>";
                                                                    if(strpos($row['civ_licenses'],'[`license_civ_rebel`,1]') !== false){echo ' <b>Rebellenlizenz</b><br />';}
                                                                    if(strpos($row['civ_gear'],'srifle_EBR_F') !== false){echo 'Mk18 ABR 7.62 mm<br />';}
                                                                    if(strpos($row['civ_gear'],'srifle_GM6_F') !== false){echo 'GM6 Lynx 12.7 mm<br />';}
                                                                    if(strpos($row['civ_gear'],'srifle_LRR_F') !== false){echo 'M320 LRR .408<br />';}
                                                                    if(strpos($row['civ_gear'],'arifle_Katiba_F') !== false){echo 'Katiba 6.5 mm<br />';}
                                                                    if(strpos($row['civ_gear'],'arifle_Katiba_C_F') !== false){echo 'Katiba Carbine 6.5 mm<br />';}
                                                                    if(strpos($row['civ_gear'],'arifle_Katiba_GL_F') !== false){echo 'Katiba GL 6.5 mm<br />';}
                                                                    if(strpos($row['civ_gear'],'arifle_MXC_F') !== false){echo 'MXC 6.5 mm<br />';}
                                                                    if(strpos($row['civ_gear'],'arifle_MX_F') !== false){echo 'MX 6.5 mm<br />';}
                                                                    if(strpos($row['civ_gear'],'arifle_MX_GL_F') !== false){echo 'MX 3GL 6.5 mm<br />';}
                                                                    if(strpos($row['civ_gear'],'arifle_MX_SW_F') !== false){echo 'MX SW 6.5 mm<br />';}
                                                                    if(strpos($row['civ_gear'],'arifle_MXM_F') !== false){echo 'MXM 6.5 mm<br />';}
                                                                    if(strpos($row['civ_gear'],'LMG_Zafir_F') !== false){echo 'Zafir 7.62 mm<br />';}
                                                                    if(strpos($row['civ_gear'],'srifle_DMR_01_F') !== false){echo 'Rahim 7.62 mm<br />';}
                                                                    if(strpos($row['civ_gear'],'launch_NLAW_F') !== false){echo 'PCML Rocket Launcher<br />';}
                                                                    if(strpos($row['civ_gear'],'launch_RPG32_F') !== false){echo 'RPG-42 Alamut<br />';}
                                                                    if(strpos($row['civ_gear'],'launch_B_Titan_F') !== false){echo 'Titan MPRL Launcher<br />';}
                                                                    if(strpos($row['civ_gear'],'launch_I_Titan_F') !== false){echo 'Titan MPRL Launcher<br />';}
                                                                    if(strpos($row['civ_gear'],'launch_O_Titan_F') !== false){echo 'Titan MPRL Launcher<br />';}
                                                                    if(strpos($row['civ_gear'],'launch_Titan_F') !== false){echo 'Titan MPRL Launcher<br />';}
                                                                    if(strpos($row['civ_gear'],'launch_B_Titan_short_F') !== false){echo 'Titan MPRL Compact<br />';}
                                                                    if(strpos($row['civ_gear'],'launch_I_Titan_short_F') !== false){echo 'Titan MPRL Compact<br />';}
                                                                    if(strpos($row['civ_gear'],'launch_O_Titan_short_F') !== false){echo 'Titan MPRL Compact<br />';}
                                                                    if(strpos($row['civ_gear'],'launch_Titan_short_F') !== false){echo 'Titan MPRL Compact<br />';}
                                                                    if(strpos($row['civ_gear'],'optic_SOS') !== false){echo 'SOS Sight<br />';}
                                                                    if(strpos($row['civ_gear'],'optic_DMS') !== false){echo 'DMS Sight<br />';}
                                                                    if(strpos($row['civ_gear'],'optic_LRPS') !== false){echo 'LRPS Sight<br />';}
                                                                    if(strpos($row['civ_gear'],'optic_NVS') !== false){echo 'NVS Sight<br />';}
                                                                    if(strpos($row['civ_gear'],'optic_Nightstalker') !== false){echo 'Nightstalker Sight<br />';}
                                                                    if(strpos($row['civ_gear'],'optic_tws') !== false){echo 'TWS Sight<br />';}
                                                                    if(strpos($row['civ_gear'],'optic_tws_mg') !== false){echo 'TWS MG Sight<br />';}
                                                                    if(strpos($row['civ_gear'],'optic_Arco') !== false){echo 'ARCO Sight<br />';}
                                                                    if(strpos($row['civ_gear'],'optic_Hamr') !== false){echo 'RCO Sight<br />';}
                                                                    if(strpos($row['civ_gear'],'optic_MRCO') !== false){echo 'MRCO Sight<br />';}
                                                                    if(strpos($row['civ_gear'],'Laserdesignator') !== false){echo 'Laserdesignator<br />';}
                                                                "</td>";
                                                                echo "<td><a href='/editPlayer.php?pId=".$playersID."'><div class='btn btn-sn btn-primary'>Edit Player</div></a></td>";
                                                            echo "</tr>";

                                                        };
                                                        echo "</tbody></table>";
                                                    } 
                                                    else 
                                                    {
                                                        $this->errors[] = "Database connection problem.";
                                                    }
                                                ?>  
                                        </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

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
