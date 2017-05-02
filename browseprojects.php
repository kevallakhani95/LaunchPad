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
$sqlquery="select * from projects order by datetime desc";   
$result = $conn->query($sqlquery);
// echo '<img height="200" width="200" src="data:image;base64,'.$row[5].'" >';
// echo 'hello '.$user_name;
while($row = mysqli_fetch_array($result))                     // Display all images
{
  $sqlquery1 = "select ptag from tags where pname ='".$row[0]."'";
  $res = $conn->query($sqlquery1);
  $sqlquery2 = "select count(*) from likes where project_name ='".$row[0]."'";
  $res1 = $conn->query($sqlquery2);
  $row1 = mysqli_fetch_array($res1);
  $sqlquery3 = "select count(*) from pledges where pname ='".$row[0]."'";
  $res2 = $conn->query($sqlquery3);
  $row2 = mysqli_fetch_array($res2);
  echo'<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-lg-12">
          <h4><strong><a href="projectpage.php?id='.$row[0].'">'.$row[0].'</a></strong></h4>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-2">
          <a href="#" class="thumbnail">
              <img src="http://placehold.it/260x180" alt="">
          </a>
        </div>
        <div class="col-lg-10">      
          <p>
            '.$row[2].'
          </p>
          
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <p></p>
          <p>
            <i class="icon-user"></i> by <a href="#">'.$row[1].'</a> 
            | <i class="icon-calendar"></i> Posted on : '.$row[8].'<br>
            <i class="icon-comment"></i> <a href="#">'.$row1[0].' Likes</a>
            | <i class="icon-share"></i> <a href="#">'.$row2[0].' Plegdes</a>
            | <i class="icon-tags"></i> Tags :'; 
                   while($tag = mysqli_fetch_array($res))
                   { 
                      echo '<span class="label label-info" style="margin-left: 1em"><a href="#" style="color: white">'.$tag[0].'</a></span>';    
                   }
  echo'</p>
        </div>
      </div>
    </div>
  </div>
  </div>
  <hr>';
}
?>
</body>
</html>