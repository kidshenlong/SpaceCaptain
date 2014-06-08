#!/usr/local/bin/php -q
<?php

session_start();
include_once '/home/kidshenlong/Private/login.php';


$herego = mysql_query("SELECT * FROM user");



while($row=mysql_fetch_array($herego))
{
$week = strtotime('-1 week');
$userid = $row['userid'];
if($row['lastlogin']>$week){
	//echo $row['userid'] + "<br />";
	echo"cool!!";
	//$userid = $row['userid'];
	//$herego2 = mysql_query("UPDATE user SET active = TRUE WHERE userid = '$userid'")or die (mysql_error());
}
else{
	echo $row['userid'] + "<br />";
	echo"bad!";
	//$userid2 = $row['userid'];
	$herego3 = mysql_query("UPDATE user SET active = FALSE WHERE userid ='$userid'")or die (mysql_error());
}

}
?>