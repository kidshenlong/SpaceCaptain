<?php
include_once 'start.php';
$var = $_GET['var'];
//if(isset($_GET['var'])){

$userid = $_SESSION['userid'];
$result9 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
$row9 = mysql_fetch_assoc($result9);
$ol = $row9["locationid"];

//$nl = $_GET['id']; 
$nl = $_GET['var'];


$tile_org_value = $ol;
$tile_new_value = $nl;


$row_org = floor($tile_org_value / 10);
$column_org = $tile_org_value % 10;

$row_new = floor($tile_new_value / 10);
$column_new = $tile_new_value % 10;

$row_diff = $row_new - $row_org;
$col_diff = $column_new - $column_org;

echo $distance = sqrt(pow($row_diff, 2) + pow($col_diff, 2));
echo "<br />";

if ($distance <= 1) {
    echo "credits cost 100";

} else if ($distance <= 2) {

    echo "credits cost 1000";
} else if ($distance <= 3) {

    echo "credits cost 1500";
} else if ($distance <= 4) {

    echo "credits cost 2000";
} else if ($distance <= 5) {

    echo "credits cost 3000";
} else {
    echo "credits cost 5000";
}



/*echo $nl;
if($ol-11==$nl || $ol-10==$nl || $ol-9==$nl || $ol+1==$nl || $ol+11==$nl || $ol+10==$nl || $ol+9==$nl || $ol-1==$nl || $ol-11==$nl ){
echo "cost 100 credits!";
}
else if($ol-22==$nl || $ol-21==$nl || $ol-20==$nl || $ol-19==$nl || $ol-18==$nl || $ol-8==$nl || $ol+2==$nl || $ol+12==$nl || $ol+22==$nl 
	
|| $ol+21==$nl || $ol+20==$nl || $ol+19==$nl || $ol+18==$nl || $ol+8==$nl || $ol-2==$nl || $ol-12==$nl ){
echo "cost 200 credits!";
}
else{
echo "not the one!";
}*/
//}