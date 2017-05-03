<?php		
	require 'db_conn.php';					

	$user_name = $_POST['uname'];
	$projname = $_POST['projname'];

	$sqlquery = "insert into likes values ('$user_name', '$projname', now())";
    $conn->query($sqlquery);

    echo'success';
  ?>