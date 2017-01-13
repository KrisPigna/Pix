<?php require_once './php/db_connect.php'; ?>

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
      <div class="container">
          <div class="col-sm-offset-5 col-sm-10 col-md-6">
              <header class="header"></header>
          </div>
          <div class="col-sm-offset-3 col-sm-10 col-md-6">
          <div class=sign-up>
              <div class="col-sm-offset-3 col-sm-10 col-md-6">
                  <h3>Create account</h3>
              </div>
          <form class="form-horizontal" action="sign_up.php" method="POST">
              <div class="form-group">
                  <div class="col-sm-offset-1 col-sm-10">
                      <div class="input-group"><input type="text" class="form-control" id="userid" name="userid" placeholder="Choose username" onBlur="checkAvailability()"><span class="input-group-addon" id="available"></span></div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-sm-offset-1 col-sm-10">
                      <input type="password" class="form-control" id="password" name="password" placeholder="Choose password">
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-sm-offset-1 col-sm-10">
                      <input type="password" class="form-control" id="conpassword" name="conpassword" placeholder="Confirm password">
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-10">
                      <button type="submit" class="btn btn-info">Create account</button>
                  </div>
              </div>
          </form>
              </div>
              <div class="col-md-6 col-md-offset-3">
              Have an account? <a href="./index.php">Sign in here</a>
          </div>
          </div>
      </div> <!-- /container -->
      

<?php
      
if(isset($_POST['userid']) && isset($_POST['password']) && !empty($_POST['userid']) && !empty($_POST['password'])){
    if($_POST['password'] == $_POST['conpassword']){
        $query = "CREATE TABLE users2 (
        userid VARCHAR(32) NOT NULL UNIQUE,
        password VARCHAR(32) NOT NULL,
        moderator CHAR
        )";
        $result = $db->query($query);

        $salt1    = "qm&h*";
        $salt2    = "pg!@";

        $username = $_POST['userid'];
        $password = $_POST['password'];
        $token    = hash('ripemd128', "$salt1$password$salt2");

        add_user($db, $username, $token);
    }
    else{
        echo '<div class="col-sm-offset-4 col-sm-10 col-md-4"><div class="alert alert-danger">Error: Password fields do not match.</div>/div>' ;
    }
            
}

  function add_user($db, $un, $pw)
  {
    $query  = "INSERT INTO users2 VALUES('$un', '$pw', '0')";
    $result = $db->query($query);
    if (!$result){
        die('<div class="col-sm-offset-4 col-sm-10 col-md-4"><div class="alert alert-danger">'.$db->error.'</div></div>');
    }
      else{
           session_start();
			$_SESSION['userid'] = $un;
			$_SESSION['password'] = $pw;
            $_SESSION['moderator'] = '0';
            //echo "$row[0] : 
        	//Hi $row[0], you are now logged in";
            header('Location: wall.php');
      }
  }
?>
<!-- JavaScript placed at bottom for faster page loadtimes. -->
 <!-- jQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
<script src="functions.js"></script>
</body>
</html>
