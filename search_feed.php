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
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arima+Madurai:100,200,300,400,500,700,800,900" rel="stylesheet">
    <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
    <link href="css/users_style.css" rel="stylesheet" type="text/css">

    <style>
    .card-container, .front, .back {
    width: 100%;
    height: 425px;
    border-radius: 4px;
    -webkit-box-shadow: 0px 0px 19px 0px rgba(0,0,0,0.16);
    -moz-box-shadow: 0px 0px 19px 0px rgba(0,0,0,0.16);
    box-shadow: 0px 0px 19px 0px rgba(0,0,0,0.16);
    }
    .card .cover{
    height: 155px;
    overflow: hidden;
    border-radius: 4px 4px 0 0;
    }
    </style>

</head>
<body>
<?php
session_start();										
require 'db_conn.php';	
require 'navbar.php';								
$user_name = $_SESSION['user_session'];
$searchtext = $_SESSION['search_word'];

$sqlquery_proj = $conn->query("select distinct p.pname, p.uname, p.cover_page, p.pstatus, 
                                case when DATEDIFF(date(datetime), date(now())) < 1 then 0 
                                    else DATEDIFF(date(datetime), date(now())) END as ddate 
                                from projects as p left join tags as t on p.pname = t.pname where p.pname like '%{$searchtext}%' 
                            or p.pdesc like '%{$searchtext}%' or t.ptag like '%{$searchtext}%'");
$count_projects = $sqlquery_proj->num_rows;

$sqlquery_users = $conn->query("select distinct * from users where fname like '%{$searchtext}%' or lname like '%{$searchtext}%' 
                            or uname like '%{$searchtext}%'");
$count_users = $sqlquery_users->num_rows;

?>

<div class="container">
	<ul class="nav nav-pills">
	  <li class="active"><a href="search_feed.php">Campaigns <span class="badge"><?php echo $count_projects; ?></span></a></li>
	  <li><a href="search_feed_users.php">Users <span class="badge"><?php echo $count_users; ?></span></a></li>
	</ul>
	<hr>
    
    <div class="row">
     <div class="col-sm-10 col-sm-offset-1">
         
         <?php 
         while($row_proj = mysqli_fetch_array($sqlquery_proj))
         {
            $project = $row_proj['pname'];

            $sqlquery2 = $conn->query("select * from likes where project_name = '$project'");
            $count_likes = $sqlquery2->num_rows;

            $sqlquery_pledges = $conn->query("select * from pledges where pname = '$project'");
            $count_pledges = $sqlquery_pledges->num_rows;

            $sqlquery1 = $conn->query("select * from comments where pname = '$project'");
            $count_comments = $sqlquery1->num_rows;            


             echo '<div class="col-md-4 col-sm-6">
                 <div class="card-container">
                    <div class="card">
                        <div class="front">
                            <div class="cover">';
                                if(!empty($row_proj['cover_page']))
                                {
                                    echo '<img alt="" src="data:image;base64,'.$row_proj['cover_page'].'">';
                                }
                                else
                                {
                                    echo '<img alt="" src="default-cover-image.jpg">';   
                                }
                            echo '</div>
                            <div class="content">
                                <div class="main">
                                    <h3 class="name">'.$row_proj['pname'].'</h3>
                                    <p class="profession">by '.$row_proj['uname'].'</p>
                                    <h4 class="text-center" style="margin-top: 25px;">Status:  <span class="badge"><b>'.$row_proj['pstatus'].'</b></span></h4>
                                    <h4 class="text-center" style="margin-top: 25px;"><b><h2>'.$row_proj['ddate'].' </h2>days to go!</b></h4>
                                </div>
                                <div class="footer">
                                    </div>
                            </div>
                        </div> <!-- end front panel -->
                        <div class="back">
                            <div class="header">
                                <h5 class="motto">View Project</h5>
                            </div>
                            <div class="content">
                                <div class="main">
                                    <div class="stats-container">
                                        <div class="stats">
                                            <h4>'.$count_likes.'</h4>
                                            <p>Likes</p>
                                        </div>
                                        <div class="stats">
                                            <h4>'.$count_pledges.'</h4>
                                            <p>Pledges</p>
                                        </div>
                                        <div class="stats">
                                            <h4>'.$count_comments.'</h4>
                                            <p>Comments</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="footer">
                            </div>
                        </div> <!-- end back panel -->
                    </div> <!-- end card -->
                </div> <!-- end card-container -->
            </div> <!-- end col sm 3 -->';
        }

        ?>

        </div> <!-- end col-sm-10 -->
    </div> <!-- end row -->
    <div class="space-200"></div>
</div>

</body>
</html>
