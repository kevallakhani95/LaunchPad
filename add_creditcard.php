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

$sqlquery = $conn->query("select * from users where uname='$user_name'");   
$row = $sqlquery->fetch_array();

$query = $conn->query("select * from creditcard where uname='$user_name'");

if(isset($_POST['btn_save']))
{
	$cc_new = $_POST['cc_new'];
  $cvv_new = $_POST['cvv_new'];
  $edm_new = $_POST['edm_new'];
  $edy_new = $_POST['edy_new'];
		
  $qry = "insert into creditcard values('$user_name','$cc_new', '$cvv_new', '$edm_new', '$edy_new')";
	$result = $conn->query($qry);
	
	echo '<script>
		window.location = "add_creditcard.php"
	</script>';
	
}

?>

<div class="container">
    <h1>Edit Card Details</h1>
  	<hr>
  		<form method="post" enctype="multipart/form-data" class="form-horizontal">
		    <div class="row">
      		<!-- edit form column -->
      		<div class="col-md-7 personal-info">
        
        	<h3>Payment Cards</h3>
        	<hr>

          <table class="table table-striped table-hover ">
            <thead>
              <tr>
                <th><u><h4>Card numbers</h4></u></th>
                <th><u><h4>Expiry Date</h4></u></th>
              </tr>
            </thead>
            <tbody>
              
              <?php
                while($row_credit = mysqli_fetch_array($query))
                {
                  echo '<tr>
                        <td><label class="control-label">'.$row_credit['ccno'].'</label></td>
                        <td><label class="control-label">'.$row_credit['exp_date_month'].' 
                        / '.$row_credit['exp_date_year'].'</label></td>
                        </tr>';
                }  
              ?>

            </tbody>
          </table>
          <hr>
          </div>
          <div class="col-md-5 personal-info">
          <h3>Add a new Payment Card</h3>
          <hr>
          	<div class="form-group">
            	<div class="col-lg-8">
              	<input class="form-control" type="text" placeholder="Card number" required="" name="cc_new" maxlength="16"> 
            	</div>
              <div class="col-lg-4">
                <input class="form-control" type="password" placeholder="CVV" required="" name="cvv_new" maxlength="3"> 
              </div>

              <div class="col-lg-4" style="margin-top: 15px;">
                <input class="form-control" type="numeric" placeholder="Expiry month" required="" name="edm_new" maxlength="2"> 
              </div>
              <div class="col-lg-1" style="margin-top: 15px;">
                <label ><h4>-</h4></label>
              </div>
                
              <div class="col-lg-4" style="margin-top: 15px;">
                <input class="form-control" type="numeric" placeholder="Expiry year" required="" name="edy_new" maxlength="4"> 
              </div>
          	</div>
            <hr>
          	<div class="form-group">
            <label class="col-md-3 control-label"></label>
            	<div class="col-md-8">
              	<button type="Submit" class="btn btn-info" style="margin-right: 15px;" name="btn_save">Add Card</button>
              	<span></span>
              	<a href="user_profile.php"><button type="button" class="btn btn-default">Cancel</button></a>
            	</div>
          	</div>
          </div>
        </div>
      </form>
</div>

</body>
</html>