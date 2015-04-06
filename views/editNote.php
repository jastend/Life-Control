<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (isset($_GET["nId"]))
	{
		$nId = $_GET["nId"];
	}
    else if (isset($_POST["nId"]))
	{
		$nId = $_POST["nId"];
	}
    else if (isset($_POST["pId"])) {
        $nId = null;
        $pId = $_POST["pId"];
        echo "<center><h1 style='color: white;'>Create new note</h1></center>";
    }
	else
	{
		$nId = null;
        $pId = null;
        echo "<center><h1 style='color: white;'>Create new note</h1></center>";
	}

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
                            User Note <small>Editing</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-bell"></i> Notes
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bell fa-fw"></i> Note</h3>
                        </div>
                        <div class="panel-body">
                            <form method="post" action="editNote-action.php" name="editform">
                                <?php
                                    if (!$db_connection->connect_errno) 
                                    {
                                        if ($nId != null){
                                            $sql = 'SELECT * FROM `lc_notes` WHERE `id` ="'.$nId.'";';
                                            $result_of_query = $db_connection->query($sql);
                                            if ($result_of_query->num_rows > 0)
                                            {
                                                while($row = mysqli_fetch_assoc($result_of_query)) 
                                                {
                                                    echo "<center>";
                                                        echo "<td><h4>Note ID: ".$nId."</h4></td>";
                                                        echo "<td><h4>Player ID: ".$row["playerid"]."</h4></td><br/>";
                                                        echo "<td><h4>Creator: ".$row["admin"]."</h4></td>";
                                                        echo "<td><h4>Last updated: ".$row["time"]."</h4></td><br/>";
                                                        echo "<td><h4>Note:</h4><textarea id='note' name='note' cols='50' rows='5'>".$row["note"]."</textarea></td><br/>";
                                                    echo "</center>";
                                                ?>
                                                <div class="col-md-3"></div>					
                                                <div class="col-md-6">
                                                    <center>
                                                        <?php
                                                            echo "<input id='nId' type='hidden' name='nId' value='".$nId."'></input>";
                                                            echo "<input id='admin' name='admin' type='hidden' value='".$_SESSION['user_name']."'></input>";
                                                            echo "<input id='adminid' name='adminid' type='hidden' value='".$_SESSION['user_playerid']."'></input>";
                                                            echo "<input id='playerid' name='playerid' type='hidden' value='".$row['playerid']."'></input>";
                                                            echo "<input class='btn btn-lg btn-primary'  type='submit'  name='update' value='UPDATE'>";
                                                            if($_SESSION['user_level'] >= '3') {
                                                                echo " <input class='btn btn-lg btn-danger'  type='submit'  name='drop' value='DELETE'>";
                                                            }
                                                        ?>
                                                        <br/>
                                                    </center>
                                                </div>
                                    <?php
                                                };
                                            }
                                            else 
                                            {
                                                echo "<center><h1 style='color:red'>ERROR NO RESULTS</h1></center>";
                                            }
                                        } else {
                                            echo "<center>";
                                                if ($pId != null){
                                                    echo "<td><h4>Player ID: <input id='playerid' name='playerid' type='text' value='".$pId."'></input></h4></td>";
                                                } else {
                                                echo "<td><h4>Player ID: <input id='playerid' name='playerid' type='text' value=''></input></h4></td>";
                                                }
                                                echo "<td><h4>Note:</h4><textarea id='note' name='note' cols='50' rows='5'></textarea></td><br/>";
                                            echo "</center>";
                                            ?>
                                            <div class="col-md-3"></div>					
                                            <div class="col-md-6">
                                                <center>
                                                    <?php
                                                        echo "<input id='admin' name='admin' type='hidden' value='".$_SESSION['user_name']."'></input>";
                                                        echo "<input id='adminid' name='adminid' type='hidden' value='".$_SESSION['user_playerid']."'></input>";
                                                        echo "<br/><br/><input class='btn btn-lg btn-primary'  type='submit'  name='new' value='Create Note'>";
                                                    ?>
                                                    <br/>
                                                </center>
                                            </div>
                                            <?php    
                                        }
                                    } 
                                    else 
                                    {
                                        $this->errors[] = "Database connection problem.";
                                    }
                                ?>  
                            </form>
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
