<?php		
	require 'db_conn.php';							
	$user_name = $_POST['uname'];
	$comment = $_POST['comm'];
	$pname = $_POST['projname'];
	echo $comment;
	$sqlquery3 = "insert into comments values('$user_name','$comment','$pname',now())";
    $conn->query($sqlquery3);
    echo'success';
  ?>