<?php
  ini_set('mysql.connect_timeout', 300);
  ini_set('default_socket_timeout', 300);
  error_reporting(0);
?>
<html style="overflow-x: hidden">
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


</head>

<body>
  
<?php
  session_start();
  
  require "navbar.php";
  require "db_conn.php";
  
  
  $user_name = $_SESSION['user_session'];
  $pname = $_GET['id'];

  if(isset($_POST['btncancel']))
  { 
      header("Location: addupdate.php");
  }

  if(isset($_POST['btnsubmit']))
  {
      $upname = $_POST['upname'];
      $updesc = $_POST['updesc'];
      
      $tagarr = explode(",", $tags);   
     
     
      if(getimagesize($_FILES['uppic']['tmp_name']) == FALSE)
      {
        // echo "Please select an image.";
      }
      
      $imageFile = $_FILES['uppic']['name'];
      $imgExt = strtolower(pathinfo($imageFile,PATHINFO_EXTENSION));
      $image = addslashes($_FILES['uppic']['tmp_name']);
      $image = file_get_contents($image);
      $image = base64_encode($image);

      $sqlquery = "insert into updates values('$pname', '$upname', '$updesc', '$image', now())";
      $result = $conn->query($sqlquery);

       echo '<div class="alert alert-dismissible alert-success" style = "margin-top:-22px">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Well done!</strong> Your project has been successfully added</a>.
        </div>';

      echo '<script>
              window.location = "projectpage.php?id='.$pname.'";
            </script>';

  }
?>

<div class="container">
  <form method="post" enctype="multipart/form-data" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="projectName" class="col-lg-2 control-label">Update Title:</label>
      <div class="col-lg-5">
        <input type="text" class="form-control" name="upname" placeholder="Update Title" required="">
      </div>
    </div>
    
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label">Update Description:</label>
      <div class="col-lg-6">
        <textarea class="form-control" rows="3" name="updesc"></textarea>
        <span class="help-block">A short description about the Update</span>
      </div>
    </div>

    <div class="form-group">
      <label for="contact" class="col-lg-2 control-label">Update Media Image:</label>
      <div class="col-lg-4">
        <input class="input-group" type="file" name="uppic" accept="image/*" style="margin-top: 12px"/>
      </div>
    </div>

    <br>
    <div class="form-group">
      <div class="col-lg-8 col-lg-offset-2">
        <button type="submit" class="btn btn-primary" name="btncancel" style="margin-right: 15px;" formnovalidate>Cancel</button>
        <button type="submit" class="btn btn-info" name="btnsubmit">Submit</button>
      </div>
    </div>

  </fieldset>
  </form>
</div>
  </body>
</html>
