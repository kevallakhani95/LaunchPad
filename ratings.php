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

$sqlquery_ratings = $conn->query("select * from ratings where uname = '$user_name' and rating IS NULL");
$count_ratings = $sqlquery_ratings->num_rows;

$sqlquery_rat = $conn->query("select * from ratings where uname = '$user_name' and rating IS NOT NULL");
$count_rat = $sqlquery_rat->num_rows;


?>
<div class="container">
<h1>New Ratings</h1>
<hr>
<?php
	
	if($count_ratings == 0)
	{
		echo '<h4 class="text-muted" style="text-align: center; font-size: 30px;">There are no new ratings at this time!</h4>'; 
	}
	else
	{
		echo '<div class="container">';
		
		while($row_ratings = mysqli_fetch_array($sqlquery_ratings))
		{
			echo '<form method="post" enctype="multipart/form-data" class="form-horizontal">
					  <fieldset>
					    <div class="form-group">
					      <label for="projectName" class="col-lg-2 control-label">Campaign name:</label>
					      <div class="col-lg-4">
					      	<input type="text" class="form-control" id="projname" value="'.$row_ratings['pname'].'" required="" disabled />
					        
					      </div>
					    </div>
					    
					    <div class="form-group">
					      <label for="projectName" class="col-lg-2 control-label">Rating (Out of 5):</label>
					      <div class="col-lg-1">
						    <input type="number" class="form-control" id="rating" placeholder="" required="" />
						    
					      </div>
					    </div>

					    <div class="form-group">
					      <label for="textArea" class="col-lg-2 control-label">A small comment:</label>
					      <div class="col-lg-6">
					        <textarea class="form-control" rows="2" id="comment" required=""></textarea>
					        <span class="help-block">A small comment about the campaign</span>
					      </div>
					    </div>

					    
					    <div class="form-group">
					      <div class="col-lg-8 col-lg-offset-2">
					        <button type="submit" class="btn btn-info" name="btnsubmit" onclick="addrating()">Submit</button>
					      </div>
					    </div>

					  </fieldset>
					  </form>
					<hr>';
		}
		echo '</div>';
	}
?>
<h1>Old Ratings</h1>
<hr>

<table class="table table-striped table-hover ">
    <thead>
      <tr>
        <th><u>Campaign name</u></th>
        <th><u>Rating</u></th>
        <th><u>Comment</u></th>
      </tr>
    </thead>
    <tbody>
      
      <?php

        if($count_rat == 0)
         {
          echo '<h4 class="text-muted" style="text-align: center; font-size: 30px;">This user has not rated any Campaign!</h4>';
         }

        while($row_rat = mysqli_fetch_array($sqlquery_rat))
        {
          
          echo '<tr>
            <td>'.$row_rat['pname'].'</td>
            <td>'.$row_rat['rating'].'</td>
            <td>'.$row_rat['comment'].'</td>';

            echo '</tr>';
        }
      
      ?>

    </tbody>
  </table>
<hr>
</div>

<script>

function addrating()
{
	var uname = '<?php echo $user_name;?>';
	var pname = document.getElementById("projname").value;
	var rating = document.getElementById("rating").value;
	var comment = document.getElementById("comment").value;

	if(rating != "" && comment != "" && parseInt(rating) <= 5 && parseInt(rating) >= 0)
	{
		$.ajax({ url: 'addrating.php',
            data: {uname:uname, pname: pname, rating: rating, comment: comment},
            type: 'post',
            success: function(out) {
                  window.location = "ratings.php";
              }
        });
	}
	else
	{
		alert("Please enter a valid input!"); 
	}
} 


</script>

</body>
</html>
