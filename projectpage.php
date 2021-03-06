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

    .custom{
    color:red;
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

$sqlquery = " select pname, uname, pdesc, pminamt, pmaxamt, date(penddate) as penddate, date(pcompdate) as pcompdate, pstatus, date(datetime) as datetime, 
                cover_page, location from projects where pname = '".$pname."'";
$result = $conn->query($sqlquery);
$row = mysqli_fetch_array($result);

$sqlquery1 = "select * from comments where pname = '".$pname."' order by commtime desc";
$result1 = $conn->query($sqlquery1);

$sqlquery_likes = $conn->query("select count(*) as cl from likes where project_name = '$pname'");
$count_likes = mysqli_fetch_assoc($sqlquery_likes);

$sqlquery4 = "select count(*), sum(pamt) from pledges where pname = '".$pname."'";
$result4 = $conn->query($sqlquery4);
$row4 = mysqli_fetch_array($result4);

$sqlquery5 = "select * from likes where user_name='$user_name' and project_name='$pname'";
$result5 = $conn->query($sqlquery5);
$row5 = mysqli_fetch_array($result5);

$sqlquery_up = $conn->query("select pname, upname, updesc, media, date(timestamp) as ts, mime from updates where pname = '$pname' order by timestamp desc");
$count_updates = $sqlquery_up->num_rows;

$sqlquery7 = "select ccno from creditcard where uname='$user_name'";
$result7 = $conn->query($sqlquery7);

$sqlquery_ratings = $conn->query("select * from ratings where pname = '$pname' and rating IS NOT NULL");
$count_ratings = $sqlquery_ratings->num_rows;

$sqlquery_tag = $conn->query("select * from tags where pname='$pname'");

$sqlquery_logs = $conn->query("insert into logs values('$user_name','$pname','visit',now())");

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

if(is_null($row4[1]))
{
    $row4[1] = '0';
}

$percent_funded = intval(($row4[1]/$row['pmaxamt'])*100);

if($percent_funded > 100)
{
    $percent_funded = '100';
}

echo '

<div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Blog Post -->

                <!-- Title -->
                <h1>'.$row[0].'</h1>
                <br>
                <!-- Author -->
                
                by <a href="user_profile.php?id='.$row[1].'" style="text-decoration:none;">'.$row[1].'</a><br>
                <h4>Campaign Status : <span  class="label label-success">'.$row[7].'</span></h4>
                <button class="btn btn-info btn" name = "like" onclick="likes()">
                  <span class="'.$c.'" id ="sp1"></span> '.$a.'</button>';
                  
                  if($user_name == $row[1])
                  {
                    echo '<div class="pull-right">
                    <button class="btn btn-warning" name = "add_update" onclick="update()" style="margin-right: 15px; ">Add Update</button>';
                    
                    if($row[7] != "Complete" && $row[7] == "Funded")
                    {
                        echo '<button class="btn btn-danger" name = "add_update" onclick="change_status()">Status: Complete</button>';
                    }
                    
                    echo '</div>';
                  }
            
                echo '<hr>
                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on '.$row[8].' 
                    <span class="pull-right">'.$row['location'].' <span class="glyphicon glyphicon-home"></span></span></p>
                
                <p></p>
                
                <hr>

                <p><span class="glyphicon glyphicon-tags" ></span><strong> Tags: </strong>';

                while($row_tags = mysqli_fetch_array($sqlquery_tag))
                {
                    echo '<span class="label label-default" style="font-size: 15px; margin-left: 10px;">
                    <a href="search_feed.php?search='.$row_tags['ptag'].'" style="color: white; text-decoration: none">'.$row_tags['ptag'].'</a></label></span>';
                }
                
                echo '</p><hr>';
                
                if(!empty($row['cover_page']))
                {
                    echo '<img class="img-responsive" alt="" src="data:image;base64,'.$row['cover_page'].'">';
                }
                else
                {
                    echo '<img class="img-responsive" alt="" src="default-cover-image.jpg">';
                }

                echo '<hr>

                <!-- Post Content -->
                <p class="lead">Campaign Description:</p>
                <p>'.$row[2].'</p>
                
                <hr>

                <ul class="nav nav-pills">
                  <li class="active"><a href="projectpage.php?id='.$pname.'">Updates</a></li>
                  <li><a href="projectpage_comments.php?id='.$pname.'">Comments</a></li>
                </ul>

                <hr>
                <div class="container">';

                if($count_updates == 0)
                {
                    echo '<h4 class="text-muted" style="text-align: center; font-size: 20px;">There are no updates for this campaign.</h4>';
                }
                else
                {
                    while($row_updates = mysqli_fetch_array($sqlquery_up))
                    {
                        echo '
                          <div class="row">
                            <div class = "col-lg-8">
                               <h4>Update #'.$count_updates.'
                                <span class="pull-right text-muted small time-line">
                                            '.$row_updates['ts'].' <span class="glyphicon glyphicon-time timestamp" data-toggle="tooltip" data-placement="bottom"></span>
                                        </span> </h4>
                                <h3><strong>'.$row_updates['upname'].'</strong></h3>

                                <div class="row">
                                <div class="col-md-3">';
                                if(!empty($row_updates['media']))
                                {

                                    if($row_updates['mime']=='image/jpeg' || $row_updates['mime']=='image/png' || $row_updates['mime']=='image/gif' )
                                    {  
                                      echo '<img class="img-responsive" alt="" src="data:image;base64,'.base64_encode($row_updates['media']).'" style="max-width: 200px; max-height: 100px; overflow: hidden;">';
                                    } 

                                    else
                                    {
                                      echo'
                                      <video style="max-width: 200px; max-height: 100px; overflow: hidden;" controls>
                                        <source src="data:video;base64,'.base64_encode($row_updates['media']).'" type="'.$row_updates['mime'].'">
                                      
                                      </video>';
                                    }
                                }
                                else
                                {
                                    echo '<img class="img-responsive" alt="" src="default-cover-image.jpg" style="max-width: 200px; max-height: 100px; overflow: hidden;">';
                                }
                              
                              echo'
                              </div>
                              <div class="col-md-8">
                              <p>'.$row_updates['updesc'].'</p>
                                
                                </div>
                                </div>
                              <hr>
                            </div>
                            </div>
                            ';
                            $count_updates = $count_updates - 1;
                    }
                }
                
                echo'</div>
                </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">
            
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="list-group">
                            <li class="list-group-item text-muted"><bold>Campaign Details</bold><i class="fa fa-dashboard fa-1x"></i></li>
                            <li class="list-group-item text-right"><span class="pull-left"><strong class="">Minimum Funding Required </strong></span>
                            $'.$row[3].'</li>
                            <li class="list-group-item text-right"><span class="pull-left"><strong>Maximum Funding Limit</strong></span>$'.$row[4].'</li>
                            <li class="list-group-item text-right"><span class="pull-left"><strong>Amount Pledged</strong></span>$'.$row4[1].'</li>
                            <li class="list-group-item text-right"><span class="pull-left"><strong>Pledges</strong></span>'.$row4[0].'</li>                            
                            <li class="list-group-item text-right"><span class="pull-left"><strong>Likes</strong></span>'.$count_likes['cl'].'</li>
                        </ul>
                    </div>
                </div>';

                 if($row[7] == "Complete")
                {
                    echo '<div class="panel panel-default">
                              <div class="panel-body">
                                <a href="project_ratings.php?id='.$row[0].'" style="text-decoration: none; color: black;"><h4 class="text-right">
                                <span class="pull-left"><strong>Ratings</strong></span>'.$count_ratings.'</h4></a>
                              </div>
                            </div>';
                }

                 echo '<div class="panel panel-default">
                  <div class="panel-body">
                    <h4 style="text-align: center;"><strong>'.$percent_funded.'%</strong> funded</h4>
                    <div class="progress progress-striped active" style="margin-top: 20px; margin-left: 15px; margin-right: 15px;">
                        <div class="progress-bar progress-bar-info" style="width:'.$percent_funded.'%"></div>
                    </div>
                  </div>
                </div>';
            
                
                if($row[7] == "Funding")
                {
                    echo '<!-- Side Widget Well -->
                            <div class="well">
                                <form method="post">
                                  <label class="control-label" for="focusedInput">Enter Pledge Amount: </label><br>
                                  <input class="form-control" id="pledgeamt" type="number" placeholder="Pledge Amount in $" required="" /><br>
                                  <label for="select" class="control-label">Select Payment Card:</label><br>
                                      <div>
                                        <select class="form-control" id="select" required="">';
                                        while($row7 = mysqli_fetch_array($result7))
                                        {  
                                            echo'<option>'.$row7[0].'</option>';
                                        }
                                          echo'</select>
                                      </div>
                                      <h4 class ="text-center">OR</h4>
                                  <input type="button" class="btn btn-primary center-block" value="Add CreditCard" onClick="redir()"><br>

                                  <input type="button"  class="btn btn-primary center-block" value="Pledge!" onClick="pledge()" >

                                </form>
                            </div>';
                }
                
            echo '</div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>';
    
  ?>
  <script>

    function tag_clicked()
    {
        var tag = "<?php echo $row_tags['ptag'];?>";
        alert(tag);
    }
    function likes()
    {
        var projname = '<?php echo $pname;?>';
        var uname = '<?php echo $user_name;?>';

        $.ajax({ url: 'add_like.php',
        data: {projname: projname, uname: uname},
        type: 'post',
        success: function(out) {
            window.location = "projectpage.php?id="+projname;
        }
    });

    }

    function update()
    {
        var projname = '<?php echo $pname;?>';
        window.location = "addupdate.php?id="+projname;
    }

    function change_status()
    {
        var projname = '<?php echo $pname; ?>';
        
          $.ajax({ url: 'change_status.php',
            data: {pname: projname},
            type: 'post',
            success: function(out) {
                  window.location = "projectpage.php?id="+projname;
              }
        });  
         


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
        var amtpledged = '<?php echo $row4[1]; ?>';
        var maxlimit = '<?php echo $row[4]; ?>';

        if(parseInt(amtpledged)+parseInt(pledge) > parseInt(maxlimit))
        {
            alert("The entered amount allows the project to exceed the maximum funding limit. ")
        }
        else if(pledge != "" && ccno != "")
        {
            $.ajax({ url: 'addpledge.php',
            data: {pledgeamt: pledge, ccno:ccno, projname:projname,uname:uname },
            type: 'post',
            success: function(out) {
                  window.location = "projectpage.php?id="+projname;
              }
        });
        }
        else
        {
            alert("Please enter a valid amount!");
        }        
    }

 </script>

</body>
</html>