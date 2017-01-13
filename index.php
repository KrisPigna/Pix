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

    <title>Pix | Sign in</title>

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
          <div class=sign-in>
              <div class="col-sm-offset-5 col-sm-10 col-md-6">
                  <h3>Sign in</h3>
              </div>
          <form class="form-horizontal" action="index.php" method="POST">
              <div class="form-group">
                  <div class="col-sm-offset-1 col-sm-10">
                      <input type="text" class="form-control" id="inputUser" name="userid" placeholder="Username">
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-sm-offset-1 col-sm-10">
                      <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-sm-offset-5 col-sm-10">
                      <button type="submit" class="btn btn-info">Sign in</button>
                  </div>
              </div>
          </form>
          </div>
              <div class="col-md-4 col-md-offset-4">
              <a href="./sign_up.php">Create an account</a>
          </div>
          </div>
      </div> <!-- /container -->

<?php
function sanitizeString($str){
    $str = strip_tags($str);
    $str = htmlentities($str);
    $str = stripslashes($str);
    return $str;
}

if(isset($_POST['userid']) && isset($_POST['password'])){
    $un_temp = sanitizeString($_POST['userid']); //sanitizes the equation entered
    $pw_temp = sanitizeString($_POST['password']); //sanitizes the equation entered

    $query  = "SELECT * FROM users2 WHERE userid='$un_temp'";
    $result = $db->query($query);
    if (!$result){
        die($db->error);
    }
    else if ($result->num_rows){
        $row = $result->fetch_array(MYSQLI_NUM);

        $salt1 = "qm&h*";
        $salt2 = "pg!@";
        $token = hash('ripemd128', "$salt1$pw_temp$salt2");

        if ($token == $row[1]){
            session_start();
			$_SESSION['userid'] = $un_temp;
			$_SESSION['password'] = $pw_temp;
            $_SESSION['moderator'] = $row[2];
            //echo "$row[0] : 
        	//Hi $row[0], you are now logged in";
            header('Location: wall.php');
        }
        else{
            die('<div class="col-sm-offset-4 col-sm-10 col-md-4"><div class="alert alert-danger">Invalid username/password combination</div></div>');
        }
    }
    else die('<div class="col-sm-offset-4 col-sm-10 col-md-4"><div class="alert alert-danger">Invalid username/password combination</div></div>');
  $db->close();
}

  function mysql_entities_fix_string($db, $string)
  {
    return htmlentities(mysql_fix_string($db, $string));
  }	

  function mysql_fix_string($db, $string)
  {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $db->real_escape_string($string);
  }
?>  
     <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
</body>
</html>
