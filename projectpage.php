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
    .round_img {
    border-radius: 50%;
    max-width: 150px;
    border: 0px solid #ccc;

    }
    </style>
</head>
<body>
<?php
session_start();										
require 'db_conn.php';	
require 'navbar.php';								
$user_name = $_SESSION['user_session'];

$pname = $_GET['id'];
// echo $pname;
$sqlquery = " select * from projects where pname = '".$pname."'";
$result = $conn->query($sqlquery);
$row = mysqli_fetch_array($result);
// echo $row[0];
$sqlquery1 = "select * from comments where pname = '".$pname."' order by commtime desc";
$result1 = $conn->query($sqlquery1);
if(isset($_POST['btnsubmit']))
{
	$comment = $_POST['comment'];
	$sqlquery3 = "insert into comments values('$user_name','$comment','$pname',now())";
	$conn->query($sqlquery3);
	header('Location: ' . $_SERVER['PHP_SELF']);
}

echo '

<div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Blog Post -->

                <!-- Title -->
                <h1>'.$row[0].'</h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#">'.$row[1].'</a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on '.$row[8].'</p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="http://placehold.it/900x300?text=No cover image" alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead">Project Description:</p>
                <p>'.$row[2].'</p>
                

                <hr>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="post">
                        <div class="form-group">
                            <textarea class="form-control" name ="comment" rows="3" required=""></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name = "btnsubmit">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->';
                while($row1 = mysqli_fetch_array($result1))
               {
               	$sqlquery2 = " select profile_pic from users where uname = '".$row1[0]."'";
				$result2 = $conn->query($sqlquery2);
				$row2 = mysqli_fetch_array($result2);
               	echo' 	

                <div class="media">';
                	if(!empty($row2[0]))
                {
                	echo'	
                    <a class="pull-left" href="#">
                        <img class="round_img" height="40" width="40" src="data:image;base64,'.$row2[0].'"  alt="">
                    </a>';
                 }
                 else
                 {
                 	echo'	
                    <a class="pull-left" href="#">
                        <img class="round_img" height="40" width="40" src="default-user-image.png"  alt="">
                    </a>';
                 }
                 echo'
                    <div class="media-body">
                        <h4 class="media-heading">'.$row1[0].'
                            <small>'.$row1[3].'</small>
                        </h4>
                        '.$row1[1].'
                    </div>
                </div>';
             }
             echo'
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

            </div>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>';
  ?>

</body>

</html>

</body>
</html>