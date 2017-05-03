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

$sqlquery=$conn->query("select f.uname2, l.project_name, date(now())-date(l.datetime) from follows f,likes l where f.uname1 ='$user_name' and f.uname2 = l.user_name order by l.datetime desc ;");
?>

<div class="container">
  <ul class="nav nav-pills">
    <li ><a href="home.php">Campaigns</a></li>
    <li class="active"><a href="recentlikes.php">Likes</a></li>
    <li><a href="recentcomments.php">Comments</a></li>
    <li><a href="recentupdates.php">Updates</a></li>
  </ul>
  <hr>
<?php
while($row = mysqli_fetch_array($sqlquery))
{  
  if($row[2]==0)
  {
    $a = 'today';
  }
  else
  {
    $a = "$row[2] days ago";
  }
  echo'
    <div class="container" style="margin-top:20px;">
      <div class="row">
        <div class="col-md-11"> 
            <span class="pull-right text-muted small time-line">
                '.$a.' <span class="glyphicon glyphicon-time timestamp" data-toggle="tooltip" data-placement="bottom" title="Lundi 24 Avril 2014 à 18h25"></span>
            </span> 
            
            <i class="glyphicon glyphicon-user icon-activity"></i> <a href="#">'.$row[0].'</a> liked <a href="#">'.$row[1].'</a>
        </div>
      </div>
    </div>
    <hr>';
  }
?>
 </div>
</body>
</html>
