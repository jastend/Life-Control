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
                            Prices <small>Overview</small>
                        </h1>
						<div class="col-lg-4" style="top:3px;float:right;">
						</div>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-money"></i> Prices
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Prices
                            </div>
                            <div class="panel-body">

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Ressource</th>
                                                        <th>Stock</th>
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

                                                        $sql = "SELECT * FROM `stocksys` WHERE `ID`='1';";

                                                        $result_of_query = $db_connection->query($sql);

                                                        while($row = mysqli_fetch_assoc($result_of_query))
                                                        {
                                                            echo "<tr><td>oilp</td><td>".$row["oilp"]."</td></tr>";
                                                                echo "<tr><td>diamondc</td><td>".$row["diamondc"]."</td></tr>";
                                                                echo "<tr><td>diamantring</td><td>".$row["diamantring"]."</td></tr>";
                                                                echo "<tr><td>iron_r</td><td>".$row["iron_r"]."</td></tr>";
                                                                echo "<tr><td>froglegs</td><td>".$row["froglegs"]."</td></tr>";
                                                                echo "<tr><td>glass</td><td>".$row["glass"]."</td></tr>";
                                                                echo "<tr><td>goldr</td><td>".$row["goldr"]."</td></tr>";
                                                                echo "<tr><td>kerosin</td><td>".$row["kerosin"]."</td></tr>";
                                                                echo "<tr><td>salt_r</td><td>".$row["salt_r"]."</td></tr>";
                                                                echo "<tr><td>coalr</td><td>".$row["coalr"]."</td></tr>";
                                                                echo "<tr><td>copper_r</td><td>".$row["copper_r"]."</td></tr>";
                                                                echo "<tr><td>silberarmband</td><td>".$row["silberarmband"]."</td></tr>";
                                                                echo "<tr><td>silverr</td><td>".$row["silverr"]."</td></tr>";
                                                                echo "<tr><td>steel</td><td>".$row["steel"]."</td></tr>";
                                                                echo "<tr><td>cement</td><td>".$row["cement"]."</td></tr>";
                                                                echo "<tr><td>goldbar</td><td>".$row["goldbar"]."</td></tr>";
                                                                echo "<tr><td>bluekbsmeth</td><td>".$row["bluekbsmeth"]."</td></tr>";
                                                                echo "<tr><td>heroinp</td><td>".$row["heroinp"]."</td></tr>";
                                                                echo "<tr><td>cocainep</td><td>".$row["cocainep"]."</td></tr>";
                                                                echo "<tr><td>froglsd</td><td>".$row["froglsd"]."</td></tr>";
                                                                echo "<tr><td>marijuana</td><td>".$row["marijuana"]."</td></tr>";
                                                                echo "<tr><td>krabben</td><td>".$row["krabben"]."</td></tr>";
                                                                echo "<tr><td>uranp2</td><td>".$row["uranp2"]."</td></tr>";
                                                        };
                                                        echo "</tbody></table>";
                                                        echo "<table><thead>";
                                                        echo "<br>";

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
