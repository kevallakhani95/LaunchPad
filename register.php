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

	<style>
	.wrapper {    
		margin-top: 80px;
		margin-bottom: 20px;
	}
	.form-signin {
		max-width: 420px;
		padding: 30px 38px 66px;
		margin: 0 auto;
		background-color: #eee;
		border: 3px dotted rgba(0,0,0,0.1);  
	}
	.form-signin-heading {
		text-align:center;
		margin-bottom: 30px;
	}
	.form-control {
		position: relative;
		font-size: 16px;
		height: auto;
		padding: 10px;
		text-align: center;
	}
	input[type="text"] {
		margin-bottom: 10px;
		border-bottom-left-radius: 0;
		border-bottom-right-radius: 0;
	}
	input[type="password"] {
		margin-bottom: 25px;
		border-top-left-radius: 0;
		border-top-right-radius: 0;
	}
	.colorgraph {
		height: 7px;
		border-top: 0;
		background: #c4e17f;
		border-radius: 5px;
		background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
		background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
		background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
		background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	}
	</style>
</head>
<body>
	<?php
	session_start();										
	require 'db_conn.php';									
/*if(isset($_SESSION['userSession']) != "")				// To keep user signed in if a new tab is openend
{
	header("Location: searchfeed.php");					
	exit;
}
*/
if(isset($_POST['btn_sign_up']))                                 
{
	$uname = strip_tags($_POST['username']);
	$password = strip_tags($_POST['password']);
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	if(getimagesize($_FILES['propic']['tmp_name']) == FALSE)
	{
		echo "Please select an image.";							// Error message
	}
	$imageFile = $_FILES['propic']['name'];
	$imgExt = strtolower(pathinfo($imageFile,PATHINFO_EXTENSION));
	$image = addslashes($_FILES['propic']['tmp_name']);
	$image = file_get_contents($image);
	$image = base64_encode($image);
	echo $imgExt;
	$uname = $conn->real_escape_string($uname);
	$password = $conn->real_escape_string($password);
	$sqlquery=$conn->query("select * from users where uname='$uname'");   
	$row = $sqlquery->fetch_array();                              
	$count = $sqlquery->num_rows;                               
	if($count==0)                   
	{
		$qry = "insert into users values ('$uname', '$fname', '$lname', '$password', '$email', '$image')";
		$result = $conn->query($qry);
		$_SESSION['user_session'] = $uname;
		header("Location: home.php");
	}
	else
	{
		echo "<script type='text/javascript'>alert('Username is already registered. Please try logging in or use some other user name.');</script>";
	}
}
?>
<div class = "container">
	<div class="wrapper">
		<form method="post" enctype="multipart/form-data" name="Login_Form" class="form-signin" >       
			<h3 class="form-signin-heading">Please register to access LaunchPad.</h3>
			<hr class="colorgraph"><br>

			<input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" />
			<input type="text" class="form-control" name="fname" placeholder="First Name" required="" />
			<input type="text" class="form-control" name="lname" placeholder="Last Name" required=""/>
			<input type="text" class="form-control" name="email" placeholder="Email" required=""/>
			<input type="password" class="form-control" name="password" placeholder="Password" />     		  
			<br>
			<input class="input-group" type="file" name="propic" accept="image/*" />
			<br>
			<br>
			<button class="btn btn-lg btn-primary btn-block"  name="btn_sign_up" value="Login" type="Submit">Sign Up</button>  			
		</form>			

	</div>
	
</div>	



</body>
</html>