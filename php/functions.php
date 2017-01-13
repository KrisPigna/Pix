<?php
require_once 'db_connect.php';

function sanitizeString($_db, $str)
{
    $str = strip_tags($str);
    $str = htmlentities($str);
    $str = stripslashes($str);
    return mysqli_real_escape_string($_db, $str);
}

if(!empty($_POST["userid"])) {
    $query  = "SELECT * FROM users2 WHERE userid='" . $_POST["userid"] . "'";
   $result = $db->query($query);
   if (!$result){
        die($db->error);
    }
    else {
        if ($result->num_rows){ 
            echo "<span class='not-available'>Unavailable</span>";
        }
    else {
        echo "<span class='is-available'>Available</span>";
    }
    }
}

function SavePostToDB($_db, $_user, $_title, $_text, $_time, $_file_name)
{
	/* Prepared statement, stage 1: prepare query */
	if (!($stmt = $_db->prepare("INSERT INTO WALL2(USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, IMAGE_NAME) VALUES (?, ?, ?, ?, ?)")))
	{
		echo "Prepare failed: (" . $_db->errno . ") " . $_db->error;
	}

	/* Prepared statement, stage 2: bind parameters*/
	if (!$stmt->bind_param('sssss', $_user, $_title, $_text, $_time, $_file_name))
	{
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	/* Prepared statement, stage 3: execute*/
	if (!$stmt->execute())
	{
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
}

function getImage($_db)
{
    $query = "SELECT USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, IMAGE_NAME FROM WALL2 ORDER BY TIME_STAMP DESC";
    
    if(!$result = $_db->query($query))
    {
        die('There was an error running the query [' . $_db->error . ']');
    }
    
    $output = '';
    while($row = $result->fetch_assoc())
    {
       $output = $output . ' <div class="row"><div class="col-md-7"><a href="http://lamp.cse.fau.edu/~kpigna1/final/users/' . $row['IMAGE_NAME'] . '" target=_blank><img class="img-responsive" src="' . 'users/' . $row['IMAGE_NAME'] . '"></a>
            </div><div class="col-md-5">
                <h3>' . $row['STATUS_TITLE']
        . '</h3>
                <h4>posted by ' . $row['USER_USERNAME'] 
        . '</h4><p>' . $row['STATUS_TEXT'] . '</p></div> </div>
        <!-- /.row -->
        
        <hr>' ;
    }
    
    return $output;
}

function getImageMod($_db)
{
    $query = "SELECT USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, IMAGE_NAME FROM WALL2 ORDER BY TIME_STAMP DESC";
    
    if(!$result = $_db->query($query))
    {
        die('There was an error running the query [' . $_db->error . ']');
    }
    
    $output = '';
    while($row = $result->fetch_assoc())
    {
       $output = $output . ' <div class="row"><div class="col-md-7"><a href="http://lamp.cse.fau.edu/~kpigna1/final/users/' . $row['IMAGE_NAME'] . '" target=_blank><img class="img-responsive" src="' . $server_root . 'users/' . $row['IMAGE_NAME'] . '"></a>
            <input type="hidden" id="timestamp" value="' . $row['TIME_STAMP'] . '"><button type="button" class="btn btn-info" id="delImg">Delete</button></div><div class="col-md-5">
                <h3>' . $row['STATUS_TITLE']
        . '</h3>
                <h4>posted by ' . $row['USER_USERNAME'] 
        . '</h4><p>' . $row['STATUS_TEXT'] . '</p></div> </div>
        <!-- /.row -->
        
        <hr>' ;
    }
    
    return $output;
}

if(!empty($_POST["timestamp"])) {
   $query = "DELETE FROM WALL2 WHERE TIME_STAMP = '" . $_POST["timestamp"] . "'";
    $result = $db->query($query);
    $file = '/home/kpigna1/public_html/final/users/' . $_POST["timestamp"] . '.jpg';
    unlink($file);
    if(!$result){
        die($db->error);
    }
    else{
        echo $file . "deleted";
    }
}
?>