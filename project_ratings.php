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

$pname = $_GET['id'];

$sqlquery_ratings = $conn->query("select * from ratings where pname = '$pname' and rating IS NOT NULL");
$count_ratings = $sqlquery_ratings->num_rows;

?>
<div class="container">
<h1>Ratings</h1>
<hr>

<table class="table table-striped table-hover ">
    <thead>
      <tr>
        <th><u>User</u></th>
        <th><u>Rating</u></th>
        <th><u>Comment</u></th>
      </tr>
    </thead>
    <tbody>
      
      <?php

        if($count_ratings == 0)
         {
          echo '<h4 class="text-muted" style="text-align: center; font-size: 30px;">There are no ratings for this Campaign!</h4>';
         }

        while($row_ratings = mysqli_fetch_array($sqlquery_ratings))
        {
          
          echo '<tr>
            <td>'.$row_ratings['uname'].'</td>
            <td>'.$row_ratings['rating'].'</td>
            <td>'.$row_ratings['comment'].'</td>';

            echo '</tr>';
        }
      
      ?>

    </tbody>
  </table>
</div>

</body>
</html>
