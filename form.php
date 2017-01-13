<?php
require_once "php/db_connect.php";
require_once "php/functions.php";

session_start();
if (!isset($_SESSION['userid'])){
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Pix | Create an account</title>

    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
      
<!-- My CSS -->
<link rel="stylesheet" href="pix.css">
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
    
    
	<div class="container">    
		<div class="row">
            <div class="col-lg-12">
			<div id="formParent" class="col-md-6 col-md-offset-3">
				<form id="form" class="form-horizontal" method="POST" action="wall.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-xs-11">
                            <h1 class="page-header"><p></p></h1>
                        <label class="sr-only" for="image">Original Image</label>
                            <div class="btn-group" role="group" aria-label="...">
  <button type="button" class="btn btn-warning" onclick="Original();">Reset</button>
                                 <div class="btn-group" role="group">
  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Brightness<span class="caret"></span></button>
                                <ul class="dropdown-menu">
      <li> <input type="range" name="Brighten" min="0" max="200" value="100" id="slider" step="1" oninput="applyBrightenFilter(value)"></li>
                                </ul>
                                </div>
                                 <div class="btn-group" role="group">
  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filters<span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li> <a href="#" onclick="applyGrayscale();">Grayscale</a></li>
                                     <li> <a href="#" onclick="applySepia();">Sepia</a></li>
                                    <li> <a href="#" onclick="applyRed();">Red</a></li>
                                    <li> <a href="#" onclick="applyGreen();">Green</a></li>
                                    <li> <a href="#" onclick="applyBlue();">Blue</a></li>
                                </ul>
                                </div>
                                <button type="button" class="btn btn-warning" onclick="RotateLeft();">Rotate Left</button>
                                <button type="button" class="btn btn-warning" onclick="RotateRight();">Rotate Right</button>
</div>
                            <canvas class="img-responsive" id="myCanvas" width="500" height="300"></canvas>
                        <input type="file" id="upload" name="upload" accept="image/*">
                            <input type="hidden" id="imgData" name="imgData" value="">
                    </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label col-xs-1">Name</label>
                        <div class="col-xs-11">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user fa-fw"></span></span>
                                <input type="text" class="form-control" id="name" name="name" 
                            maxlength="20" size="20" value="" required placeholder="Johnny" autofocus>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="title" class="control-label col-xs-1">Title</label>
                        <div class="col-xs-11">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-header fa-fw"></span></span>
                                <input type="text" class="form-control" id="title" name="title" 
                            maxlength="20" size="20" value="" required placeholder="Summer Vacation" autofocus>
                            </div>
                        </div>
                    </div>
                      
                    <div class="form-group">
                        <label for="text" class="control-label col-xs-1">Text</label>
                        <div class="col-xs-11">
                            <textarea class="form-control" id="text" name="text" maxlength="140" placeholder="140 characters"></textarea>
                        </div>
                    </div>
        
                    <input type="submit" value="Upload" class="btn btn-primary col-md-offset-1" onclick="saveImage()">
                    <input type="button" id="resetForm" value="Clear fields" class="btn btn-default">
                    <a href="wall.php"><input type="button" id="cancel" value="Cancel" class="btn btn-default"></a>
				</form>
                </div>
			</div>
            <img src="images/placeholder_image.png" id="placeholder" style="display:none">
		</div>
        <footer>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <p></p>
                    <p>Copyright &copy; Kris Pigna 2015
                    <br>Theme via Start Bootstrap</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>
	</div>

	<!-- JavaScript placed at bottom for faster page loadtimes. -->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	
	<!-- jQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
	<script src="functionsV2.js"></script>

</body>
</html>
<?php $db->close(); ?>