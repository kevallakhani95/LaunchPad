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

$sqlquery_projects = $conn->query("select * from projects where uname = '$user_name' order by datetime desc");
$count_campaigns = $sqlquery_projects->num_rows;

$sqlquery = $conn->query("select * from follows where uname2 = '$user_name'");
$count_followers = $sqlquery->num_rows;

$sqlquery = $conn->query("select * from follows where uname1 = '$user_name'");
$count_following = $sqlquery->num_rows;

$sqlquery = $conn->query("select * from pledges where uname = '$user_name'");
$count_pledges = $sqlquery->num_rows;



echo '<br>
	<div class="container target">
    	<div class="row">
        	<div class="col-sm-10">
             	<h1 style="font-family: Poiret One; font-size: 60px;">'.$row[1].' '.$row[2].'</h1>
             	<h4 class="text-muted" style="font-family: Poiret One; font-size: 30px;">@'.$row[0].'</h4>
             	<br>
     			<button type="button" class="btn btn-success">Edit Profile</button>  
    			<br>
    			<br>
        	</div>
      		<div class="col-sm-2">
      		<a href="/users" class="pull-right">';
      			if(!empty($row[5]))
      			{
      				echo '<img title="profile image" class="img-circle img-responsive" src="data:image;base64,'.$row[5].'" alt="" style="width: 180px; height: 150px; border-radius: 50%; border: 2px solid #00bfff;">';
      			}
      			else
      			{
      				echo '<img title="profile image" class="img-circle img-responsive" src="default-user-image.png" alt="" 
      					style="max-width: 180px; max-height: 150px; border-radius: 50%; border: 2px solid #00bfff;">';	
      			}
      		echo '</a>
        	</div>
    	</div>
	  	<br>
	    <div class="row">
	        <div class="col-sm-3">
	            <ul class="list-group">
	                <li class="list-group-item text-muted"><bold>Activity</bold> <i class="fa fa-dashboard fa-1x"></i></li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Campaigns</strong></span>
	                '.$count_campaigns.'</li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Followers</strong></span>
	                '.$count_followers.'</li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Following</strong></span>
	                '.$count_following.'</li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Pledges</strong></span>
	                '.$count_pledges.'</li>
	            </ul>
	        </div>
	        
	        <div class="col-sm-9" contenteditable="false" style="">
	            <div class="panel panel-default target">
	                <div class="panel-heading" contenteditable="false">All Campaigns</div>
	                	<div class="panel-body">
	                  		<div class="row">';

	                  		while($row_camp = mysqli_fetch_array($sqlquery_projects))
	                  		{
	                  			echo '<div class="col-md-4">
	                    			<div class="thumbnail">';
	                    			
	                    			if(!empty($row_camp[9]))
					      			{
					      				echo '<img alt="300x200" src="data:image;base64,'.$row_camp[9].'">';
					      			}
					      			else
					      			{
					      				echo '<img alt="300x200" src="default-cover-image.jpg">';	
					      			}
	                        		
	                        		echo '<div class="caption">
		                            		<h3>'.$row_camp[0].'</h3>
		                            		<p>'.$row_camp[2].'</p>
	                        			</div>
	                    			</div>
	                			</div>';
	                  		}
	                			
	                			

	            			echo '</div>
	            		</div>
	                </div>
	    		</div>
	    	</div>
		</div>
	</div>';
?>


</body>
</html>
