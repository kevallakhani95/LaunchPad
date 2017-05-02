<?php
## This is the file for making a connection to the database
## All the parameters necessary for making a connection are specified in this file.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crowdfunding";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
// If any error in the connection file then Error is displayed


if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}
else
{
	//echo "Connection made";
}
?>
    
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!--<script src="js/bootstrap.min.js"></script>-->
