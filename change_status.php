<?php

require 'db_conn.php';

$pname = $_POST['pname'];

$sqlquery = $conn->query("Update projects set pstatus='Complete' where pname = '$pname'");

$sqlquery = $conn->query("Insert into ratings (uname, pname, rating, comment) select distinct u_name, p_name, null, null from charges where p_name = '$pname'");
echo "success";

?>