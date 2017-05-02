<?php
	require 'db_conn.php';	
	$uname = $_POST['uname'];
	$pname = $_POST['projname'];
	$ccno = $_POST['ccno'];
	$pamt = $_POST['pledgeamt'];

	$sqlquery6 = "insert into pledges values('$uname','$pname','$pamt',now(),'$ccno')";
    $conn->query($sqlquery6);
    echo'success';
  ?>


