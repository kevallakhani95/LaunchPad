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
    height: 400px;
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
    .card .content{
    background-color: rgba(0, 0, 0, 0);
    box-shadow: none;
    padding: 0px 0px 0px;
    }
    </style>

</head>

<body>
<?php
session_start();                    
require 'db_conn.php';  
require 'navbar.php';               
$user_name = $_SESSION['user_session']; 

$sqlquery_projects = $conn->query("select p.pname, p.uname, p.cover_page, p.pstatus, p.datetime, 
                                case when DATEDIFF(date(penddate), date(now())) < 1 then 0 
                                    else DATEDIFF(date(penddate), date(now())) END as ddate 
                                from projects as p order by datetime desc");

?>

<div class="container">
  <h1>All Campaigns</h1>
    <hr>
    <div class="row">
     <div class="col-sm-12 col-sm-offset-0">
         
       <?php 
       
       while($row_proj = mysqli_fetch_array($sqlquery_projects))
       {
          $project = $row_proj['pname'];

          $sqlquery2 = $conn->query("select * from likes where project_name = '$project'");
          $count_likes = $sqlquery2->num_rows;

          $sqlquery_pledges = $conn->query("select * from pledges where pname = '$project'");
          $count_pledges = $sqlquery_pledges->num_rows;

          $sqlquery1 = $conn->query("select * from comments where pname = '$project'");
          $count_comments = $sqlquery1->num_rows;            

          $sqlquery1 = $conn->query("select sum(pamt) as tot_funds from pledges where pname = '$project'");
          $total_funds = mysqli_fetch_assoc($sqlquery1);

          $sqlquery1 = $conn->query("select pminamt, pmaxamt, location from projects where pname = '$project'");
          $project_details = mysqli_fetch_assoc($sqlquery1);

          if(is_null($total_funds['tot_funds']))
          {
              $total_funds['tot_funds'] = '0';
          }
          
          $percent_funded = intval(($total_funds['tot_funds']/$project_details['pmaxamt'])*100);
          if($percent_funded > 100)
          {
              $percent_funded = '100';
          }

           echo '<div class="col-md-3 col-sm-4">
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
                                  <h4 class="text-center" style="margin-top: 25px;">Status:  <span class="label label-info"><b>'.$row_proj['pstatus'].'</b></span></h4>';
                                 
                                  if($row_proj['pstatus'] == 'Funding')
                                  {
                                      echo '<h4 class="text-center" style="margin-top: 25px;"><b><h2>'.$row_proj['ddate'].' </h2>days to go!</b></h4>';
                                  }
                              
                              echo '</div>
                          </div>
                      </div> <!-- end front panel -->
                      <div class="back">
                          <div class="header">
                              <h5 class="motto"><a href="projectpage.php?id='.$row_proj['pname'].'" style="text-decoration:none;">View Project</a></h5>
                          </div>
                          <div class="content" >
                              <div class="main">
                                  <div class="stats-container">
                                      <div class="stats">
                                          <h4>'.$count_likes.'</h4>
                                          <p style="font-size: 13px;">Like(s)</p>
                                      </div>
                                      <div class="stats">
                                          <h4>'.$count_pledges.'</h4>
                                          <p style="font-size: 13px;">Pledge(s)</p>
                                      </div>
                                      <div class="stats">
                                          <h4>'.$count_comments.'</h4>
                                          <p style="font-size: 13px;">Comment(s)</p>
                                      </div>
                                  </div>
                                  <hr width="85%">
                                  <div class="stats-container">
                                      <div class="stats">
                                          <h4 style="font-size: 14px; margin-bottom: 9px;">'.$project_details['location'].'</h4>
                                          <p style="font-size: 13px;">Location</p>
                                      </div>
                                      <div class="stats">
                                          <h4>'.$percent_funded.'%</h4>
                                          <p style="font-size: 13px;">Funded</p>
                                      </div>
                                      <div class="stats">
                                          <h4>$'.$project_details['pminamt'].'</h4>
                                          <p style="font-size: 13px;">Goal</p>
                                      </div>
                                  </div>
                                  <hr width="85%">
                                  
                                  <div class="progress progress-striped active" style="margin-top: 50px; margin-left: 15px; margin-right: 15px;">
                                    <div class="progress-bar progress-bar-info" style="width: '.$percent_funded.'%"></div>
                                  </div>

                              </div>
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