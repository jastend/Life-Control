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
                                    <h3 class="panel-title"><i class="fa fa-child fa-fw"></i>New Player Check</h3><small>Showing the latest 100 new players on the server</small>
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
                                                    <th>Last update</th>
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
                                                            if(strpos($row['civ_licenses'],'[`license_civ_rebel`,1]') !== false){echo ' <b>Rebell License</b><br />';}
                                                            if(strpos($row['civ_gear'],'arifle_Katiba') !== false){echo 'Katiba 6.5 mm Series<br />';}
                                                            if(strpos($row['civ_gear'],'arifle_Mk20') !== false){echo 'MK20 5.56 mm Series<br />';}
                                                            if(strpos($row['civ_gear'],'arifle_MX') !== false){echo 'MX 6.5 mm Series<br />';}
                                                            if(strpos($row['civ_gear'],'arifle_SDAR') !== false){echo 'SDAR 5.56 mm<br />';}
                                                            if(strpos($row['civ_gear'],'arifle_TRG') !== false){echo 'TRG-20 5.56 mm Series<br />';}
                                                            if(strpos($row['civ_gear'],'hgun_PDW2000') !== false){echo 'PDW 9 mm Series<br />';}
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
                                                            if(strpos($row['civ_gear'],'LMG_Mk200') !== false){echo 'Mk200 6.5 mm Series<br />';}
                                                            if(strpos($row['civ_gear'],'LMG_Zafir') !== false){echo 'Zafir 7.62 mm Series<br />';}
                                                            if(strpos($row['civ_gear'],'MMG_01') !== false){echo 'Navid 9.3 mm Series<br />';}
                                                            if(strpos($row['civ_gear'],'MMG_02') !== false){echo 'SPMG .338 Series<br />';}
                                                            if(strpos($row['civ_gear'],'SMG_01') !== false){echo 'Vermin SMG .45 Series<br />';}
                                                            if(strpos($row['civ_gear'],'SMG_02') !== false){echo 'Sting 9 mm Series<br />';}
                                                            if(strpos($row['civ_gear'],'srifle_DMR_01') !== false){echo 'Rahim 7.62 mm Series<br />';}
                                                            if(strpos($row['civ_gear'],'srifle_DMR_02') !== false){echo 'MAR-10 .338 Series<br />';}
                                                            if(strpos($row['civ_gear'],'srifle_DMR_03') !== false){echo 'Mk-1 EMR 7.62 mm Series<br />';}
                                                            if(strpos($row['civ_gear'],'srifle_DMR_04') !== false){echo 'ASP-1 Kir 12.7 mm Series<br />';}
                                                            if(strpos($row['civ_gear'],'srifle_DMR_05') !== false){echo 'Cyrus 9.3 mm Series<br />';}
                                                            if(strpos($row['civ_gear'],'srifle_DMR_06') !== false){echo 'Mk14 7.62 mm Series<br />';}
                                                            if(strpos($row['civ_gear'],'srifle_EBR') !== false){echo 'Mk18 ABR 7.62 mm Series<br />';}
                                                            if(strpos($row['civ_gear'],'srifle_GM6') !== false){echo 'GM6 Lynx 12.7 mm Series<br />';}
                                                            if(strpos($row['civ_gear'],'srifle_LRR') !== false){echo 'M320 LRR .408 Series<br />';}
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
                                                        echo "<td>".$row["timeupdated"]."</td>";
                                                        echo "<td><a href='editPlayer.php?pId=".$playersID."'><div class='btn btn-sn btn-primary'>Edit Player</div></a></td>";
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
                                            <input class='btn btn-sm btn-primary'  type='submit'  name='edit' value='Search' style="margin-top: -3px;"></input>
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
                                                                        echo "<td><a href='editPlayer.php?pId=".$playersID."'><div class='btn btn-sm btn-primary'>Edit Player</div></a></td>";
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
                                                                        echo "<td><a href='editPlayer.php?pId=".$playersID."'><div class='btn btn-sm btn-primary'>Edit Player</div></a></td>";
                                                                        echo "<td><a href='editHouse.php?hId=".$hId."'><div class='btn btn-sm btn-primary'>Edit House</div></a></td>";
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
                                                                echo "<td><a href='editPlayer.php?pId=".$playersID."'><div class='btn btn-sm btn-primary'>Edit Player</div></a></td>";
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Custom JavaScript -->
    <script>

        $(document).ready(function() {
            $(window).load(function(){
                var l_hash = +-64location.hash;    //onloadFake
                if(((l_hash).indexOf('#tab')) == 0) {
                    $('.tab-content ' + l_hash).fadeIn(400).siblings().hide();
                    $('.tab-links a[href="'+l_hash+'"]').parent('li').addClass('active').siblings().removeClass('active');
                }
            });

            $('.tab-links a').click(function()  {
                var $this = $(this),
                    currentAttrValue = $this.attr('href');

                // Show/Hide Tabs
                $('.tab-content ' + currentAttrValue).fadeIn(400).siblings().hide();
                // Change/remove current tab to active
                $this.parent('li').addClass('active').siblings().removeClass('active');
                return false;
            });
        });
        
    </script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
