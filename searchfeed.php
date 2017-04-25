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
    <title>Click 'n' Shop</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>
	    .center{
				text-align: center;
			}

    </style>
</head>

<body>
	
<?php
session_start();
require "dbconn.php";
require "navbar.php";

if(!isset($_SESSION['userSession']))
{
	echo "<script type='text/javascript'>alert('You are not logged in! Please log in.');
										window.location = 'index.php';</script>";
}

$user_name = $_SESSION['userSession'];
$search_word = $_SESSION['search_word'];

if(isset($_GET['flag']))
{
	$id = $_GET['id'];
	$status = $_GET['status'];
	$price = $_GET['price'];
	if($status == "available")
	{
		$sqlquery=$conn->query("select * from Purchase where cname='$user_name' and pname='$id' and status='pending'");
    	$row = $sqlquery->fetch_array();                              
    	$count = $sqlquery->num_rows;

    	if($count == 1)
    	{
    		$sqlquery1 = "Update Purchase Set quantity = quantity + 1, putime = NOW() where cname='$user_name' and pname='$id' and status='pending'";
    		$res1 = $conn->query($sqlquery1);
    	}
		else
		{
			$sqlquery2 = "insert into Purchase values('$user_name', '$id', NOW(), 1, '$price', 'pending')";
			$res2 = $conn->query($sqlquery2);
		}
		echo "<script type='text/javascript'>alert('Product added to your Cart!');</script>";
	}
	else
	{
		echo "<script type='text/javascript'>alert('Product cannot be ordered!');</script>";
	}
}

if($search_word == "")
{
	echo '<center><p class="lead">All Products are displayed below.</p></center><hr width=50%>';

	$sqlquery = "select * from product";
	$result = $conn->query($sqlquery);

	while($row = mysqli_fetch_array($result))
	{
		echo '
		<div class="container">
	        <div class="row">
	          <div class="span12">
	            <div class="row">
	              <div class="span8">
	                <h4><strong>'.$row[0].'</strong></h4>
	              </div>
	            </div>
	            <div class="row">
	              <div class="span10">      
	                <p>
	                  '.$row[1].'
	                </p>
	               <!-- <p><a class="btn" href="#">Read more</a></p>	--> 
	              </div>
	            </div>
	            <div class="row">
	              <div class="span8">
	                <p>Status : ';

	                  echo '<span class="label label-info" style="margin-left: 1em">'.$row[3].'</span>';
	                
	                echo '</p>
	              </div>
	            </div>
	            <div class="row">
	              <div class="span8">
	                <p> Price (USD): '.$row[2].' </p>
	                <br>
	                <a href="searchfeed.php?flag=true&id='.$row[0].'&status='.$row[3].'&price='.$row[2].'"><h4>Add to Cart</h4></a>
	              </div>
	            </div>
	          </div>
	        </div>
       </div>
      <hr>';
	}

}
else
{
	$sqlquery = "select * from product where pdescription like '%$search_word%'";
	$result = $conn->query($sqlquery);
	$count = $result->num_rows;

	if($count == 0)
	{
		echo '<center><p class="lead">You searched for "'.$search_word.'". No related products found.</p></center><hr width=50%>';
	}
	else
	{
		echo '<center><p class="lead">You searched for "'.$search_word.'". Related Products are displayed below.</p></center><hr width=50%>';	
	}
	


	while($row = mysqli_fetch_array($result))
	{
		echo '
		<div class="container">
	        <div class="row">
	          <div class="span12">
	            <div class="row">
	              <div class="span8">
	                <h4><strong>'.$row[0].'</strong></h4>
	              </div>
	            </div>
	            <div class="row">
	              <div class="span10">      
	                <p>
	                  '.$row[1].'
	                </p>
	               <!-- <p><a class="btn" href="#">Read more</a></p>	--> 
	              </div>
	            </div>
	            <div class="row">
	              <div class="span8">
	                <p>Status : ';

	                  echo '<span class="label label-info" style="margin-left: 1em">'.$row[3].'</span>';
	                
	                echo '</p>
	              </div>
	            </div>
	            <div class="row">
	              <div class="span8">
	                <p> Price (USD): '.$row[2].' </p>
	                <br>
	                <a href="searchfeed.php?flag=true&id='.$row[0].'&status='.$row[3].'&price='.$row[2].'"><h4>Add to Cart</h4></a>
	              </div>
	            </div>
	          </div>
	        </div>
       </div>
      <hr>';
	}
}

?>

</body>
</html>