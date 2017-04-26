<html>
<head>

  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>LaunchPad</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">    
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" rel="stylesheet" integrity="sha384-+ENW/yibaokMnme+vBLnHMphUYxHs34h9lpdbSLuAwGkOKFRl4C34WkjazBtb7eT" crossorigin="anonymous">
   
   <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
   <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
   <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


    <style>
    .round_img {
    border-radius: 50%;
    max-width: 150px;
    border: 2px solid #00bfff;
    }
    </style>
</head>

<body>
<?php
session_start();
require "db_conn.php";
if(!isset($_SESSION['user_session']))
{
  echo "<script type='text/javascript'>alert('You are not logged in! Please log in.');
                    window.location = 'index.php';</script>";
}
$user_name = $_SESSION['user_session'];
$sqlquery=$conn->query("select * from users where uname='$user_name'");   
$row = $sqlquery->fetch_array();
if(isset($_POST['btn_logout']))
{
  session_destroy();
  // $URL="index.php";
  // echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
  header("Location: index.php");
}
if(isset($_POST['bnsubmit']))
{
    $URL="searchfeed.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    $searchtext = $_POST['searchtext'];
    $_SESSION['search_word'] = $searchtext;
}
?>

  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">LaunchPad </a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Recent Activity <span class="sr-only">(current)</span></a></li>
        <li><a href="upload.php">Launch Campaign</a></li>
        <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li> -->
      </ul>
      <form method="post" enctype="multipart/form-data" class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search users, projects">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <form method="post" class="navbar-form navbar-right" role="search">
        <button type="Submit" class="btn btn-info" name="btn_logout" >Logout</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a class="navbar-brand" href="user_profile.php">
        <?php
        if(!empty($row[5]))
        {
          echo '<img class="round_img" height="40" width="40" src="data:image;base64,'.$row[5].'" style="margin-top: -9px" alt="">';
        }
        else
        {
          echo '<img class="round_img" height="40" width="40" src="default-user-image.png" style="margin-top: -9px" alt="">'; 
        }
        ?>

        </a></li>
      </ul>
    </div>
  </div>
</nav>
</body>
</html>