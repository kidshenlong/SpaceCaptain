<?php

echo "Seconds since 01/01/1970 " . time(now);

echo "<br />";
$date = '25/05/2010';
$date = str_replace('/', '-', $date);
echo strtotime($date);
echo "<br />";
echo date('d-m-Y', strtotime($date));


echo "<br />";
echo 33 / 10;
echo "<br />";
echo 33 % 10;
echo "<br />";

$tile_org_value = 45;
$tile_new_value = 33;

$row_org = floor($tile_org_value / 10);
$column_org = $tile_org_value % 10;

$row_new = floor($tile_new_value / 10);
$column_new = $tile_new_value % 10;

$row_diff = $row_new - $row_org;
$col_diff = $column_new - $column_org;

ECHO $distance = sqrt(pow($row_diff, 2) + pow($col_diff, 2));

echo "<br />";

for ($i = 1; $i <= 20; $i++) {
    $power = pow($i, 3);
    echo $levelup = $i * 500 + $power;
    echo "<br />";
}



?>