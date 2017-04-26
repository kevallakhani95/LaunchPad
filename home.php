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

$sqlquery=$conn->query("select * from users where uname='$user_name'");   
$row = $sqlquery->fetch_array();
// echo '<img height="200" width="200" src="data:image;base64,'.$row[5].'" >';

// echo 'hello '.$user_name;


?>
<div class="container">
<div class="row">
  <div class="col-lg-12">
    <div class="row">
      <div class="col-lg-12">
        <h4><strong><a href="#">Title of the post</a></strong></h4>
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
          Lorem ipsum dolor sit amet, id nec conceptam conclusionemque. Et eam tation option. Utinam salutatus ex eum. Ne mea dicit tibique facilisi, ea mei omittam explicari conclusionemque, ad nobis propriae quaerendum sea.
        </p>
        <p><a class="btn" href="#">Read more</a></p>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <p></p>
        <p>
          <i class="icon-user"></i> by <a href="#">John</a> 
          | <i class="icon-calendar"></i> Sept 16th, 2012
          | <i class="icon-comment"></i> <a href="#">3 Comments</a>
          | <i class="icon-share"></i> <a href="#">39 Shares</a>
          | <i class="icon-tags"></i> Tags : <a href="#"><span class="label label-info">Snipp</span></a> 
          <a href="#"><span class="label label-info">Bootstrap</span></a> 
          <a href="#"><span class="label label-info">UI</span></a> 
          <a href="#"><span class="label label-info">growth</span></a>
        </p>
      </div>
    </div>
  </div>
</div>
</div>
<hr>


</body>
</html>
