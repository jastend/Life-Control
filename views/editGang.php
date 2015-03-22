<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (isset($_POST["gID"]))
	{
		$gID = $_POST["gID"];
	}
	else
	{
		echo "<center><h1 style='color:red'>PLAYERID NOT SET</h1></center>";
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

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Life Control</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>  <?php echo $_SESSION['user_name']; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
						<?php
								if ($_SESSION['user_level'] >= 3)
								{

									echo"<li class='divider'></li>";
									echo"<li>";
									echo"<a href='admin.php'><i class='fa fa-fw fa-cog'></i> Admin</a>";
									echo"</li>";

									echo"<li class='divider'></li>";
									echo"<li>";
									echo"<a href='register.php'><i class='fa fa-fw fa-cog'></i> Add New User</a>";
									echo"</li>";
								}
						
						?>
                        <li class="divider"></li>
                        <li>
                            <a href="index.php?logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="players.php"><i class="fa fa-fw fa-child "></i> Players</a>
                    </li>
                    <li>
                        <a href="vehicles.php"><i class="fa fa-fw fa-car"></i> Vehicles</a>
                    </li>
                    <li>
                        <a href="houses.php"><i class="fa fa-fw fa-home"></i> Houses</a>
                    </li>
                    <li class="active">
                        <a href="gangs.php"><i class="fa fa-fw fa-sitemap"></i> Gangs</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Gang <small>Editing</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-wrench"></i> Gangs Editor
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
					<div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-child fa-fw"></i> Player</h3>
                            </div>
                            <div class="panel-body">
								<form method="post" action="edit-actionG.php" name="editform">
									<?php
										if (!$db_connection->connect_errno) 
										{
											$sql = 'SELECT * FROM `gangs` WHERE `id` ="'.$gID.'";';
											$result_of_query = $db_connection->query($sql);
											if ($result_of_query->num_rows > 0)
											{
												while($row = mysqli_fetch_assoc($result_of_query)) 
												{
													$gID = $row["id"];
													echo "<center>";
														echo "<h3>Name:    <input id='gname' name='gname' type='text' value='".$row["name"]."'></td><br/>";
														echo "<h4>Owner:    <input id='gowner' name='gowner' type='text' value='".$row["owner"]."'></td><br/>";
														echo "<h4>Max Members:    <input id='gMM' name='gMM' type='text' value='".$row["maxmembers"]."'></td><br/>";
														echo "<h4>Bank:     <input id='gbank' name='gbank' type='text' value='".$row["bank"]."'></td><br/>";
														echo "<h4>Active:   <input id='gAct' name='gAct' type='text' value='".$row["active"]."'></td><br/>";
													echo "</center>";
									?>
							</div>		
						</div>
					</div>
						<div class='col-lg-12'>
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h3 class='panel-title'><i class='fa fa-users fa-fw'></i> Members</h3>
								</div>
								<div class="panel-body">
									<div class="col-md-4" style="padding-left:425px;">
										<?php
											echo "<textarea id='gMem' name='gMem' cols='100' rows='5'>".$row["members"]."</textarea>";
										?>
									</div>
								</div>
							</div>
					<div class="col-md-4"></div>					
					<div class="col-md-4">
								<center>
									<?php
                                        if($_SESSION['user_level'] >= '2') {
										echo "<input id='gID' type='hidden' name='gID' value='".$gID."'>";
										echo "<input class='btn btn-lg btn-primary'  type='submit'  name='edit' value='Submit Changes'>  ";
										echo "<input class='btn btn-lg btn-danger'  type='submit'  name='drop' value='DELETE'>";
                                        } else {
                                               echo "Your permission level is insufficient to submit these changes";
                                        };
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
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
