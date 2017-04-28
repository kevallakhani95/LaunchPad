<?php
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);
error_reporting(0);
?>

<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>LaunchPad</title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" rel="stylesheet" integrity="sha384-+ENW/yibaokMnme+vBLnHMphUYxHs34h9lpdbSLuAwGkOKFRl4C34WkjazBtb7eT" crossorigin="anonymous">
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>

<?php
session_start();										
require 'db_conn.php';	
require 'navbar.php';		

$user_name = $_SESSION['user_session'];

$sqlquery = $conn->query("select * from users where uname='$user_name'");   
$row = $sqlquery->fetch_array();

$query = $conn->query("select * from creditcard where uname='$user_name'");

if(isset($_POST['btn_save']))
{
	$cc_new = $_POST['cc_new'];
		
  $qry = "insert into creditcard values('$user_name','$cc_new')";
	$result = $conn->query($qry);
	
	echo '<script>
		window.location = "user_profile.php"
	</script>';
	
}

?>

<div class="container">
    <h1>Edit Card Details</h1>
  	<hr>
  		<form method="post" enctype="multipart/form-data" class="form-horizontal">
		<div class="row">
      		<!-- edit form column -->
      		<div class="col-md-9 personal-info">
        
        	<h3>Payment Cards</h3>
        	<hr>
          <?php

          while($row_credit = mysqli_fetch_array($query))
          {
            echo '<label class="control-label" style="padding-left: 50px">'.$row_credit['ccno'].'</label><br>';
          }

          
          ?>
          <hr>
          	<div class="form-group">
            <label class="col-lg-3 control-label">Card Number:</label>
            	<div class="col-lg-8">
              	<input class="form-control" type="text" placeholder="Enter Credit card number" required="" name="cc_new" maxlength="16"> 
            	</div>
          	</div>

          	<div class="form-group">
            <label class="col-md-3 control-label"></label>
            	<div class="col-md-8">
              	<button type="Submit" class="btn btn-info" style="margin-right: 15px;" name="btn_save">Save Changes</button>
              	<span></span>
              	<a href="user_profile.php"><button type="button" class="btn btn-default">Cancel</button></a>
            	</div>
          	</div>
      	
      </div>
  </div>
  </form>
</div>

</body>
</html>