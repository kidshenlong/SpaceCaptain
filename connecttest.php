<?php
include_once '/home/kidshenlong/Private/login.php';

$result = mysql_query("SELECT * FROM userinfo WHERE userid='1'");
$row = mysql_fetch_assoc($result);
echo $row["name"];
?>