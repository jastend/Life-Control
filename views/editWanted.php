<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (isset($_POST["wantedID"]))
	{
		$wantedID = $_POST["wantedID"];
	}
	else
	{
		echo "<center><h1 style='color:red'>wantedID NOT SET</h1></center>";
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
                            Wanted <small>Editing</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-wrench"></i> Wanted
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
					<div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-child fa-fw"></i> Vehicle</h3>
                            </div>
                            <div class="panel-body">
								<form method="post" action="edit-actionW.php" name="editform">
									<?php
										if (!$db_connection->connect_errno) 
										{
											$sql = 'SELECT * FROM `wanted` WHERE `wantedID` ="'.$wantedID.'";';
											$result_of_query = $db_connection->query($sql);
											if ($result_of_query->num_rows > 0)
											{
												while($row = mysqli_fetch_assoc($result_of_query)) 
												{
													echo "<center>";
														echo "<h4>Wanted ID: <input id='wantedID' name='wantedID' type='text' value='".$row["wantedID"]."'></td><br/>";
														echo "<h4>Name:   <input id='wantedName' name='wantedName' type='text' value='".$row["wantedName"]."'></td><br/>";
														echo "<h4>Bounty:    <input id='wantedBounty' name='wantedBounty' type='text' value='".$row["wantedBounty"]."'></td><br/>";
														echo "<h4>Active:";
														echo "<select id='active' name='active'>";
															echo '<option value="0"';
																if($row['active']==0){echo ' selected';}
															echo '>0</option>';	
															echo '<option value="1"';
																if($row['active']==1){echo ' selected';}
															echo '>1</option>';	
														echo "</select>";
													echo "</center>";
									?>
							</div>		
						</div>
					</div>
						<div class='col-lg-12'>
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h3 class='panel-title'><i class='fa fa-suitcase  fa-fw'></i> Crimes</h3>
								</div>
								<div class="panel-body">
									<div class="col-md-4" style="padding-left:425px;">
										<?php
											echo "<textarea id='wantedCrimes' name='wantedCrimes' cols='100' rows='5'>".$row["wantedCrimes"]."</textarea>";
										?>
									</div>
								</div>
							</div>
						</div>
					<div class="col-md-4"></div>					
					<div class="col-md-4">
								<center>
									<?php
										echo "<input class='btn btn-lg btn-primary'  type='submit'  name='update' value='Submit Changes'>  ";
										echo "<input class='btn btn-lg btn-danger'  type='submit'  name='drop' value='DELETE'>";
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>