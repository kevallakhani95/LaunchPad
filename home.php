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
                        where f.uname1 ='$user_name' and f.uname2 = p.uname ) order by d desc

                           ");   
?>
<hr>

<?php
  while($row = mysqli_fetch_array($sqlquery))
{  
  if(!$row[1])
 {   
      echo'
        <div class="container" style="margin-top:20px;">
          <div class="row">
            <div class="col-md-12"> 
                <span class="pull-right text-muted small time-line">
                    '.$row[3].' <span class="glyphicon glyphicon-time timestamp" data-toggle="tooltip" data-placement="bottom" title="Lundi 24 Avril 2014 à 18h25"></span>
                </span> 
                
                <i class="glyphicon glyphicon-user icon-activity"></i> <a href="user_profile.php?id='.$row[0].'">'.$row[0].'</a> liked <a href="projectpage.php?id='.$row[2].'">'.$row[2].'</a>
            </div>
          </div>
        </div>
        <hr>';
  }
  else if(!$row[0])
  {
      echo'
        <div class="container" style="margin-top:20px;">
          <div class="row">
            <div class="col-md-12"> 
                <span class="pull-right text-muted small time-line">
                    '.$row[3].' <span class="glyphicon glyphicon-time timestamp" data-toggle="tooltip" data-placement="bottom" title="Lundi 24 Avril 2014 à 18h25"></span>
                </span> 
                
                <i class="glyphicon glyphicon-user icon-activity"></i> <a href="user_profile.php?id='.$row[1].'">'.$row[1].'</a> commented on <a href="projectpage.php?id='.$row[2].'">'.$row[2].'</a>
            </div>
          </div>
        </div>
        <hr>';
  }

  else if(!$row[2])
  {
    echo'
    <div class="container" style="margin-top:20px;">
      <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            Update on <a href="projectpage.php?id='.$row[6].'">'.$row[6].'</a> by <a href="user_profile.php?id='.$row[5].'">'.$row[5].'</a>
            <span class="pull-right text-muted small time-line">
                        '.$row[7].'<span class="glyphicon glyphicon-time timestamp" data-toggle="tooltip" data-placement="bottom" title="Lundi 24 Avril 2014 à 18h25"></span>
                    </span> 
            <h4><strong>'.$row[0].'</strong></h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">';
                if(!empty($row[3]))
                    {
                        echo '<img class="img-responsive" alt="" src="data:image;base64,'.$row[3].'">';
                    }
                    else
                    {
                        echo '<img class="img-responsive" alt="" src="default-cover-image.jpg">';
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
        </div>
        ';
      }

      else if(!$row[3])
      {
        echo'
    <div class="container" style="margin-top:20px;">
      <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
          <a href="user_profile.php?id='.$row[2].'">'.$row[2].'</a> added a new Campaign
          <span class="pull-right text-muted small time-line">
                        '.$row[6].'<span class="glyphicon glyphicon-time timestamp" data-toggle="tooltip" data-placement="bottom" title="Lundi 24 Avril 2014 à 18h25"></span>
                    </span> 
            <h4><strong><a href="projectpage.php?id='.$row[0].'">'.$row[0].'</a></strong></h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">';
                if(!empty($row[5]))
                    {
                        echo '<img class="img-responsive" alt="" src="data:image;base64,'.$row[5].'">';
                    }
                    else
                    {
                        echo '<img class="img-responsive" alt="" src="default-cover-image.jpg">';
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
        </div>';

      }
  
}
?>
  

</body>
</html>
