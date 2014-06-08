#!/usr/local/bin/php -q
<?php

include_once '/home/kidshenlong/Private/login.php';


$herego = mysql_query("SELECT * FROM user WHERE active = TRUE");


while($row=mysql_fetch_array($herego))
{

$userid = $row['userid'];

	$herego2 = mysql_query("UPDATE userinfo SET turns = turns + 10 WHERE userid = '$userid'") or die (mysql_error());
}


?>