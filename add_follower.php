<?php		
	require 'db_conn.php';					

	$user_name = $_POST['uname'];
	$other_uname = $_POST['other_uname'];

	echo $user_name;
	echo $other_uname;

	$sqlquery = "insert into follows values ('$user_name', '$other_uname')";
    $conn->query($sqlquery);

    echo'success';
  ?>