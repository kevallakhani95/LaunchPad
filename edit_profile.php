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

if(isset($_POST['btn_save']))
{
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	if($password == $row['password'])
	{
		if(getimagesize($_FILES['propic']['tmp_name']) != FALSE)
		{	
			$imageFile = $_FILES['propic']['name'];
			$imgExt = strtolower(pathinfo($imageFile,PATHINFO_EXTENSION));
			$image = addslashes($_FILES['propic']['tmp_name']);
			$image = file_get_contents($image);
			$image = base64_encode($image);
			
			$qry = "Update users set fname = '$fname', lname = '$lname', email = '$email', profile_pic = '$image' 
					where uname = '$user_name'";
			$result = $conn->query($qry);
		}
		else
		{
			$qry = "Update users set fname = '$fname', lname = '$lname', email = '$email' where uname = '$user_name'";
			$result = $conn->query($qry);	
		}
		
		echo '<script>
			window.location = "user_profile.php"
		</script>';
	}
	else
	{
		echo '
        		<div class="alert alert-info alert-dismissable">
          		<a class="panel-close close" data-dismiss="alert">×</a> 
          		Not you? The password is not correct.
        		</div>
        	';
	}
}

?>

<div class="container">
    <h1>Edit Profile</h1>
  	<hr>
  		<form method="post" enctype="multipart/form-data" class="form-horizontal">
		<div class="row">
      		<div class="col-md-3">
      			<div class="text-center">

	      		<?php 

	      		if(!empty($row[5]))
	  			{
	  				echo '<img class="avatar img-circle" alt="avatar" src="data:image;base64,'.$row[5].'" 
	  				style="width: 180px; height: 150px; border-radius: 50%; border: 2px solid #00bfff;">';
	  			}
	  			else
	  			{
	  				echo '<img class="avatar img-circle" alt="avatar" src="default-user-image.png"  
	  				style="max-width: 180px; max-height: 150px; border-radius: 50%; border: 2px solid #00bfff;">';		
	  			}
          
          		?>
          
          	<br><br>
          	<h6>Upload a different photo</h6>
          
          		<input class="form-control" type="file" name="propic" accept="image/*" />
        		</div>
      		</div>
      
      		<!-- edit form column -->
      		<div class="col-md-9 personal-info">
        
        	<h3>Personal info</h3>
        	<br>
          	<div class="form-group">
            <label class="col-lg-3 control-label">First name:</label>
            	<div class="col-lg-8">
              	<input class="form-control" type="text" value="<?php echo $row['fname']; ?>" required="" name="fname">
            	</div>
          	</div>
          
          	<div class="form-group">
            <label class="col-lg-3 control-label">Last name:</label>
            	<div class="col-lg-8">
              	<input class="form-control" type="text" value="<?php echo $row['lname']; ?>" required="" name="lname">
            	</div>
         	 </div>
          
          	<div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            	<div class="col-lg-8">
              	<input class="form-control" type="text" value="<?php echo $row['email']; ?>" required="" name="email">
            	</div>
          	</div>
          
          	<div class="form-group">
            <label class="col-md-3 control-label">Password:</label>
            	<div class="col-md-8">
              	<input class="form-control" type="password" required="" name="password">
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