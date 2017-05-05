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
     .panel-body  {
    word-break:break-all
}
</style>
</head>

<body>
<?php
session_start();										
require 'db_conn.php';	
require 'navbar.php';								
$user_name = $_SESSION['user_session'];

$sqlquery=$conn->query("select NULL, f.uname2, c.pname, date(c.commtime),c.commtime as d,NULL,NULL,NULL
                        from follows f,comments c
                        where f.uname1 ='$user_name' and f.uname2 = c.uname  
                        union
                        (select f.uname2,NULL, l.project_name, date(l.datetime),l.datetime as d,NULL,NULL,NULL
                        from follows f,likes l
                        where f.uname1 ='$user_name' and f.uname2 = l.user_name)
                        union
                        (select u.upname, u.updesc,NULL, u.media,u.timestamp as d, p.uname, p.pname, date(u.timestamp)
                        from follows f,updates u, projects p
                        where f.uname1 ='$user_name' and u.pname = p.pname and p.uname = f.uname2)
                        union
                        (select u.upname, u.updesc,NULL, u.media,u.timestamp as d, p.uname, p.pname, date(u.timestamp)
                        from likes l, updates u, projects p
                        where l.user_name ='$user_name' and l.project_name=p.pname and p.pname = u.pname)
                        union
                        (select p.pname, p.pdesc, p.uname,NULL, p.datetime as d, p.cover_page, date(p.datetime),NULL
                        from follows f,projects p
                        where f.uname1 ='$user_name' and f.uname2 = p.uname ) order by d desc");  

$sqlquery_search = $conn->query("select distinct logdata from logs where uname = '$user_name' and logtype='search' order by logtime desc limit 3;"); 

$sqlquery_visit = $conn->query("select distinct logdata from logs where uname = '$user_name' and logtype='visit' order by logtime desc limit 3;"); 

$sqlquery_profilevisit = $conn->query("select distinct logdata from logs where uname = '$user_name' and logtype='profilevisit' order by logtime desc limit 3;"); 

?>
<div class="container">
<div class="row">

<div class="col-lg-9">

<?php
  while($row = mysqli_fetch_array($sqlquery))
{                   
  if(!$row[1])                                    //Likes
 {   
      echo'
          
          <div class="row">
            <div class="col-md-12"> 
                <span class="pull-right text-muted small time-line">
                    '.$row[3].'  <span class="glyphicon glyphicon-time timestamp" data-toggle="tooltip" data-placement="bottom" title="Lundi 24 Avril 2014 à 18h25"></span>
                </span> 
                
                <i class="glyphicon glyphicon-user icon-activity"></i> <a href="user_profile.php?id='.$row[0].'" style="text-decoration:none;">'.$row[0].'</a> liked <a href="projectpage.php?id='.$row[2].'" style="text-decoration:none;">'.$row[2].'</a>
            </div>
          </div>
        <hr>
        
        ';
  }
  else if(!$row[0])                              //Comments
  {
      echo'
        
          <div class="row">
            <div class="col-md-12"> 
                <span class="pull-right text-muted small time-line">
                    '.$row[3].' <span class="glyphicon glyphicon-time timestamp" data-toggle="tooltip" data-placement="bottom" title="Lundi 24 Avril 2014 à 18h25"></span>
                </span> 
                
                <i class="glyphicon glyphicon-user icon-activity"></i> <a href="user_profile.php?id='.$row[1].'" style="text-decoration:none;">'.$row[1].'</a> commented on <a href="projectpage.php?id='.$row[2].'" style="text-decoration:none;">'.$row[2].'</a>
            </div>
          </div>
        <hr>
        ';
  }

  else if(!$row[2])                             //Updates
  {
    $sqlquery1 = $conn->query("select * from updates where upname ='$row[0]' and pname='$row[6]'");
    $row1 = mysqli_fetch_array($sqlquery1);
    echo'
        <div class="row">
          <div class="col-md-12">
            Update on <a href="projectpage.php?id='.$row[6].'" style="text-decoration:none;">'.$row[6].'</a> by <a href="user_profile.php?id='.$row[5].'" style="text-decoration:none;">'.$row[5].'</a>
            <span class="pull-right text-muted small time-line">
                        '.$row[7].' <span class="glyphicon glyphicon-time timestamp" data-toggle="tooltip" data-placement="bottom" title="Lundi 24 Avril 2014 à 18h25"></span>
                    </span> 
            <h4><strong>'.$row[0].'</strong></h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">';
              // echo $row1[5];
            if(!empty($row[3]))
                {

                    if($row1[5]=='image/jpeg' || $row1[5]=='image/png' || $row1[5]=='image/gif')
                    {  
                      echo '<img class="img-responsive" alt="" src="data:image;base64,'.base64_encode($row[3]).'" style="max-width: 200px; max-height: 100px; overflow: hidden;">';
                    } 

                    else
                    {
                      echo'
                      <video style="max-width: 200px; max-height: 100px; overflow: hidden;" controls>
                        <source src="data:video;base64,'.base64_encode($row[3]).'" type="'.$row1[5].'">
                      
                      </video>';
                    }

                    // else
                    // {
                    //   echo'
                    //   <audio controls="controls" style="max-width: 200px; max-height: 100px; overflow: hidden;">
                    //     Your browser does not support the <code>audio</code> element.
                    //     <source src="testmp3testfile_64kb.m3u" type = "audio/x-mpegurl">
                    //   </audio>';

                    // }
                }
                else
                {
                    echo '<img class="img-responsive" alt="" src="default-cover-image.jpg" style="max-width: 200px; max-height: 100px; overflow: hidden;">';
                }

          echo'
          </div>
          <div class="col-md-9">      
            <p>
              '.$row[1].'
            </p>
          </div>
        </div>
        <hr>
        
        ';
      }

      else if(!$row[3])                           //Cmpaign
      {
        echo'
    
        <div class="row">
          <div class="col-md-12">
          <a href="user_profile.php?id='.$row[2].'" style="text-decoration:none;">'.$row[2].'</a> added a new campaign
          <span class="pull-right text-muted small time-line">
                        '.$row[6].' <span class="glyphicon glyphicon-time timestamp" data-toggle="tooltip" data-placement="bottom" title="Lundi 24 Avril 2014 à 18h25"></span>
                    </span> 
            <h4><strong><a href="projectpage.php?id='.$row[0].'" style="text-decoration:none;">'.$row[0].'</a></strong></h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">';
                if(!empty($row[5]))
                {
                  echo '<img class="img-responsive" alt="" src="data:image;base64,'.$row[5].'" style="max-width: 200px; max-height: 100px; overflow: hidden;">';
                }
                else
                {
                  echo '<img class="img-responsive" alt="" src="default-cover-image.jpg" style="max-width: 200px; max-height: 100px; overflow: hidden;">';
                }
          echo'
          </div>
          <div class="col-md-9">      
            <p>
              '.$row[1].'
            </p>
          </div>
        </div>
        <hr>
        ';

      }
  
}
?>
</div>
<div class="col-lg-3">
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Recent Searches</h3>
  </div>
  <div class="panel-body">
  
    <?php
    while($row = mysqli_fetch_array($sqlquery_search))
    {
         echo '<p class>
                  <a href="search_feed.php?search='.$row[0].'">
                '.$row[0].'</a>
                </p>
                ';
    }
    ?>
  
  </div>
</div>

<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Recent Project Visits</h3>
  </div>
    <div class="panel-body">
       <?php
    while($row1 = mysqli_fetch_array($sqlquery_visit))
    {
         echo '<p class>
                  <a href="projectpage.php?id='.$row1[0].'">
                '.$row1[0].'</a>
                </p>
                ';
    }
    ?>
    </div>
  </div>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Recent Profile Visits</h3>
  </div>
  <div class="panel-body">
    <?php
    while($row2 = mysqli_fetch_array($sqlquery_profilevisit))
    {
         echo '<p class>
                  <a href="user_profile.php?id='.$row2[0].'">
                '.$row2[0].'</a>
                </p>
                ';
    }
    ?>
  </div>
</div>
</div>
</div>
</div>

</body>
</html>
