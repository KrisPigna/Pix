<?php
require_once "php/db_connect.php";
require_once "php/functions.php";
session_start();
if (!isset($_SESSION['userid']))
  {
     header('Location: index.php');;
}
if(isset($_POST['name']) && isset($_POST['title']) && isset($_POST['text']) && isset($_POST['imgData']))
{    
    sleep(5);
    $name = sanitizeString($db, $_POST['name']);
    $title = sanitizeString($db, $_POST['title']);
    $text = sanitizeString($db, $_POST['text']);
    
    $time = $_SERVER['REQUEST_TIME'];
	$file_name = $time . '.jpg';
    define('UPLOAD_DIR', 'users/');
    $file = UPLOAD_DIR . $file_name;
    $image_data = $_POST['imgData'];
        $removeHeaders = substr($image_data, strpos($image_data, ',')+1);
	$decode = base64_decode($removeHeaders);
	$f = file_put_contents($file, $decode);

    SavePostToDB($db, $name, $title, $text, $time, $file_name);
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

    <title>Pix | Wall</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/1-col-portfolio.css" rel="stylesheet">
    
    <!-- My Own Custom CSS -->
    <link href="pix.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="wall.php">Pix | Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="logout.php">Log Out</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <a name="top"></a><div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                Upload Photo
                </h1>
                <div class="form-group">
                      <a href="form.php"><button type="button" class="btn btn-info">Upload</button></a>
                  </div>
            </div>
            <div class="col-lg-12">
                <h1 class="page-header">
                    Photo Wall
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Project One -->
            <?php
                if($_SESSION['moderator'] == '1'){
                    echo getImageMod($db);
                }
                else{
                    echo getImage($db);
                }
            ?>

        <!-- Footer -->
         <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Kris Pigna 2015
                    <br>Theme via Start Bootstrap</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <a href="#top" id="toTop"><img class="img-responsive" src="./images/arrow.png"></a>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <script src="functionsV3.js"></script>

</body>

</html>