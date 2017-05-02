<?php
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);
//error_reporting(0);
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

    .custom{
  color:red;
}
    </style>
</head>
<body>
<?php
if (!isset($_SESSION)){
  session_start();
}										
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

$sqlquery4 = "select count(*), sum(pamt) from pledges where pname = '".$pname."'";
$result4 = $conn->query($sqlquery4);
$row4 = mysqli_fetch_array($result4);

$sqlquery5 = "select * from likes where user_name='$user_name' and project_name='$pname'";
$result5 = $conn->query($sqlquery5);
$row5 = mysqli_fetch_array($result5);

$sqlquery7 = "select ccno from creditcard where uname='$user_name'";
$result7 = $conn->query($sqlquery7);

if(!$row5[0])
{
    $a = 'Like';
    $c = 'glyphicon glyphicon-thumbs-up';
}
else
{
    $a = 'Liked';
    $c = 'glyphicon glyphicon-ok';
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
                <form class="lead" method ="post">
                    by <a href="#">'.$row[1].'</a><br>
                    Project Status : '.$row[7].'
                    <button class="btn btn-info btn pull-right" name = "like" onclick="likes()">
                      <span class="'.$c.'" id ="sp1"></span> '.$a.'</button>

                </form>


                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on '.$row[8].'

                </p>


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
                            <textarea class="form-control" id ="comment" rows="3" required=""></textarea>
                        </div>
                        <input type="button" class="btn btn-primary" name="btnsubmit"value="Submit" onclick="addcomm()">
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
            <div class="container" id ="comms1">';

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
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Pledge Status:</h4>
                    <div class="row">
                        <div class="col-lg-8">
                            <ul class="list-unstyled">
                                <li>Minimum Funding Required:
                                </li>
                                <li>Maximum Funding Required:
                                </li>
                                <li>Amount Pledged:
                                </li>
                                <li>Number of Pledges Done:
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <ul class="list-unstyled">
                                <li>$'.$row[3].'
                                </li>
                                <li> $'.$row[4].'
                                </li>
                                <li> $'.$row4[1].'
                                </li>
                                <li> '.$row4[0].'
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <div class="well">
                    <form method="post">
                      <label class="control-label" for="focusedInput">Enter Pledge Amount in $ </label><br>
                      <input class="form-control" id="pledgeamt" type="number" value="Pledge Amount"><br>
                      <label for="select" class="control-label">Select Credit Card</label><br>
                          <div>
                            <select class="form-control" id="select">';
                            while($row7 = mysqli_fetch_array($result7))
                            {  echo' 
                              <option>'.$row7[0].'</option>';
                              }
                              echo'
                            </select>
                          </div>
                          <h4 class ="text-center">OR</h4>
                      <input type="button" class="btn btn-primary center-block" value="Add CreditCard" onClick="redir()"><br>

                      <input type="button"  class="btn btn-primary center-block" value="Pledge" onClick="pledge()">

                    </form>

                    
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
    // if(isset($_POST['btnsubmit']))
    // {
    //     $comment = $_POST['comment'];
    //     $sqlquery3 = "insert into comments values('$user_name','$comment','$pname',now())";
    //     $conn->query($sqlquery3);
       

    // }
  ?>
  <script>
        function addcomm()
         {
            
            var comm= document.getElementById("comment").value;
            
            var projname = '<?php echo $pname;?>';

            var uname = '<?php echo $user_name;?>';
            
            $.ajax({ url: 'addcomm.php',
            data: {comm: comm, projname:projname, uname:uname},
            type: 'post',
            success: function(out) {
                      window.location = "projectpage.php?id="+projname;
                  }
});
            

            
        }

        function likes(e)
            {
                e.preventDefault();
                var projname = '<?php echo $pname;?>';
                // alert('liked');
                // document.getElementById('sp1').className = 'glyphicon glyphicon-ok';
                // document.getElementById('sp1').innerHTML = 'Liked';
                <?php
                $sqlquery5 = "insert into likes values('$user_name','$pname')";
                $conn->query($sqlquery5);
                ?>
                window.location = "projectpage.php?id="+projname;
            }

        function redir()
        {
            window.location = "add_creditcard.php";

        }

        function pledge()
        {
            
            var projname = '<?php echo $pname;?>';
            var pledge= document.getElementById("pledgeamt").value;
            var ccno = document.getElementById("select").value;
            var uname = '<?php echo $user_name;?>';

             $.ajax({ url: 'addpledge.php',
            data: {pledgeamt: pledge, ccno:ccno, projname:projname,uname:uname },
            type: 'post',
            success: function(out) {
                      window.location = "projectpage.php?id="+projname;
                  }
            });

               

        }
     </script>


</body>

</html>

</body>
</html>