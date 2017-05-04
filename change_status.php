<?php

require 'db_conn.php';

$pname = $_POST['pname'];

$sqlquery = $conn->query("Update projects set pstatus='Complete' where pname = '$pname'");
echo "success";

?>