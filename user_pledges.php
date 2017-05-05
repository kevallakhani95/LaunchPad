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
$user = $_GET['id'];

$query = $conn->query("select pname, pamt, date(ptime) as pdate, ccno from pledges where uname='$user'");
$count_pledge = $query->num_rows;

$sqlquery = $conn->query("select * from users where uname = '$user'");
$row_user_details = mysqli_fetch_array($sqlquery);

?>
<div class="container">
  <h1><?php echo $row_user_details['fname']." "; echo $row_user_details['lname']; ?>'s Pledges -</h1>
  <hr>
  <table class="table table-striped table-hover ">
    <thead>
      <tr>
        <th><u>Campaign name</u></th>
        <th><u>Pledge Amount</u></th>
        <th><u>Pledge Date</u></th>
        <?php
        
        if($user_name == $user)
        {
          echo '<th><u>Payment card</u></th>';
        }
        
        ?>
      </tr>
    </thead>
    <tbody>
      <?php

        if($count_pledge == 0)
         {
          echo '<h4 class="text-muted" style="text-align: center; font-size: 30px;">This user does not have any pledges!</h4>';
         }

        while($row_pledges = mysqli_fetch_array($query))
        {
          $sqlquery_checkp = $conn->query("select * from charges where u_name = '$user_name' and p_name = '$row_pledges[0]' and camt = '$row_pledges[1]' and ccno = '$row_pledges[3]'");
          $flag = $sqlquery_checkp->num_rows;
          if($flag != '0')
          {
            echo '<tr class="active">
            <td>'.$row_pledges['pname'].'</td>
            <td>'.$row_pledges['pamt'].'</td>
            <td>'.$row_pledges['pdate'].'</td>';

            if($user_name == $user)
            {
              echo '<td>'.$row_pledges['ccno'].'</td>';
            }
            echo '</tr>';
          }
          else
          {
              echo '<tr>
            <td>'.$row_pledges['pname'].'</td>
            <td>'.$row_pledges['pamt'].'</td>
            <td>'.$row_pledges['pdate'].'</td>';

            if($user_name == $user)
            {
              echo '<td>'.$row_pledges['ccno'].'</td>';
            }

            echo '</tr>';
          }
          
        }
      ?>
    </tbody>
  </table>
</div>


</body>
</html>
