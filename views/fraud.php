<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$page_rows = results_per_page;
	// change character set to utf8 and check it
	if (!$db_connection->set_charset("utf8")) {
		$db_connection->errors[] = $db_connection->error;
	}
    
    if (isset($_POST["searchText"])) {
        $searchText = $_POST['searchText'];        
    } else {
        $searchText = null;
    };
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
    
    <style>
        
        /*----- Tabs -----*/
        .tabs {
            width:100%;
            display:inline-block;
        }
        
        
        
        .tab {
            display:none;
        }
 
        .tab.active {
            display:block;
        }
        
    </style>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
    
        jQuery(document).ready(function() {
            
            $(window).load(function(){
                if((location.hash === "#tabItems")) {
                    jQuery('.tabs ' + '#tabItems').fadeIn(400).siblings().hide();
                    jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
                }
            });
            
            jQuery('.tab-links a').on('click', function(e)  {
                var currentAttrValue = jQuery(this).attr('href');

                // Show/Hide Tabs
                jQuery('.tabs ' + currentAttrValue).fadeIn(400).siblings().hide();

                // Change/remove current tab to active
                jQuery(this).parent('li').addClass('active').siblings().removeClass('active');

                e.preventDefault();
            });
        });
        
    </script>

</head>

<body>

    <div id="wrapper">

    <?php include("views/sidebar.php"); ?>

    <div id="page-wrapper">

        <div class="container-fluid">
                
            <div class="tabs">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Fraud Detection <small>Overview</small>
                        </h1>
                        <ul class="nav nav-pills tab-links" style="margin-bottom: 20px;">
                            <li role="presentation" class="active"><a href="#tabNPC">New Player Check</a></li>
                            <li role="presentation"><a href="#tabItems">Item Check</a></li>
                            <li role="presentation"><a href="#tabLicense">License Fraud</a></li>
                        </ul>
                    </div>
                </div>
                <!-- /.row -->
                <div class="tab-content">
                    <div id="tabNPC" class="tab active">
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
                                                            if(strpos($row['civ_licenses'],'[`license_civ_kautionsbro`,1]') !== false){echo '<b style="color: red;">Bail License</b><br />';}
                                                            if(strpos($row['civ_licenses'],'[`license_civ_explosive`,1]') !== false){echo '<b style="color: red;">Explosive License</b><br />';}
                                                            if(strpos($row['civ_licenses'],'[`license_civ_plastik`,1]') !== false){echo '<b style="color: red;">Plastic License</b><br />';}
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tabItems" class="tab">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="margin-bottom: 20px;">
                                    <h3 class="panel-title"><i class="fa fa-filter fa-fw"></i>Item Check</h3><small>Search for a Arma Item Class Name of your choice</small>
                                    <div class="col-lg-4" style="top:-12px;float:right;">
                                        <form style="float:right;" method='post' action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>#tabItems" name='searchPlayer'>
                                            <input id='searchText' type='text' name='searchText'></input>
                                            <input class='btn btn-sm btn-primary'  type='submit'  name='edit' value='Search Text' style="margin-top: -3px;"></input>
                                        </form>
                                    </div>
                                </div>
                                <?php if ($searchText != null) { ?>
                                    <div class="col-lg-6">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-child fa-fw"></i>Civ Gear</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Player Name</th>
                                                            <th>Player ID</th>
                                                            <th>Edit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if (!$db_connection->connect_errno) 
                                                            {

                                                                $sql = "SELECT * FROM `players` WHERE `civ_gear` LIKE '%\`".$searchText."\`%' ORDER BY `name` DESC;";
                                                                $result_of_query = $db_connection->query($sql);
                                                                while($row = mysqli_fetch_assoc($result_of_query)) 
                                                                {
                                                                    $playersID = $row["playerid"];
                                                                    echo "<tr>";
                                                                        echo "<td>".$row["name"]."</td>";
                                                                        echo "<td>".$playersID."</td>";
                                                                        echo "<td><a href='/editPlayer.php?pId=".$playersID."'><div class='btn btn-sm btn-primary'>Edit Player</div></a></td>";
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
                                    <div class="col-lg-6">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-home fa-fw"></i>House Inventory</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Player ID</th>
                                                            <th>Player Edit</th>
                                                            <th>House Edit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if (!$db_connection->connect_errno) 
                                                            {

                                                                $sql = "SELECT * FROM `houses` WHERE `containers` LIKE '%\"".$searchText."\"%' ORDER BY `id` DESC;";
                                                                $result_of_query = $db_connection->query($sql);
                                                                while($row = mysqli_fetch_assoc($result_of_query)) 
                                                                {
                                                                    $pId = $row["pid"];
                                                                    $hId = $row["id"];
                                                                    echo "<tr>";
                                                                        echo "<td>".$row["pid"]."</td>";
                                                                        echo "<td><a href='/editPlayer.php?pId=".$playersID."'><div class='btn btn-sm btn-primary'>Edit Player</div></a></td>";
                                                                        echo "<td><a href='/editHouse.php?hId=".$hId."'><div class='btn btn-sm btn-primary'>Edit House</div></a></td>";
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
                                <?php } else { ?>
                                    <div class="col-lg-12" style="margin-bottom: 15px;">
                                        <center>Please provide an Arma Class (e.g. 1Rnd_HE_Grenade_shell)</center><br/>
                                        <center><a href="https://community.bistudio.com/wiki/Arma_3_CfgWeapons_Weapons" target="_blank">Weapons</a> - <a href="https://community.bistudio.com/wiki/Arma_3_CfgWeapons_Items" target="_blank">Weapon Attachements</a> - <a href="https://community.bistudio.com/wiki/Arma_3_CfgMagazines" target="_blank">Magazines / Grenades</a></center>
                                    </div>
                                <?php }; ?>
                                <div style="clear: both;"></div>
                            </div>
                        </div>
                    </div>
                    <div id="tabLicense" class="tab">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-eraser  fa-fw"></i>License Fraud</h3><small>Bail, Explosive and Plastic</small>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Player Name</th>
                                                    <th>Player ID</th>
                                                    <th>Alert</th>
                                                    <th>Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    if (!$db_connection->connect_errno) 
                                                    {
                                                        $sql = "SELECT * FROM `players` WHERE `civ_licenses` LIKE '%[`license_civ_kautionsbro`,1]%' OR `civ_licenses` LIKE '%[`license_civ_explosive`,1]%' OR `civ_licenses` LIKE '%[`license_civ_plastik`,1]%' ORDER BY `uid` DESC;";
                                                        $result_of_query = $db_connection->query($sql);
                                                        while($row = mysqli_fetch_assoc($result_of_query)) 
                                                        {
                                                            $playersID = $row["playerid"];
                                                            echo "<tr>";
                                                                echo "<td>".$row["name"]."</td>";
                                                                echo "<td>".$playersID."</td>";
                                                                echo "<td>";
                                                                    if(strpos($row['civ_licenses'],'[`license_civ_kautionsbro`,1]') !== false){echo 'Bail License<br />';}
                                                                    if(strpos($row['civ_licenses'],'[`license_civ_explosive`,1]') !== false){echo 'Explosive License<br />';}
                                                                    if(strpos($row['civ_licenses'],'[`license_civ_plastik`,1]') !== false){echo 'Plastic License<br />';}
                                                                echo "</td>";
                                                                echo "<td><a href='/editPlayer.php?pId=".$playersID."'><div class='btn btn-sm btn-primary'>Edit Player</div></a></td>";
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
                    </div>   
                </div>
            </div>

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
