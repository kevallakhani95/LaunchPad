<?php
	require 'db_conn.php';	
	$uname = $_POST['uname'];
	$pname = $_POST['pname'];
	$rating = $_POST['rating'];
	$comment = $_POST['comment'];

	$sqlquery = $conn->query("update ratings set rating = '$rating', comment = '$comment' where uname = '$uname' and pname = '$pname'");
    echo'success';
  ?>


