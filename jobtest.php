<?php

$crew = 1200;

$mission = 1200;

echo $div = $crew / $mission * 100;
echo "<br />";
$random = (rand(0, 100));

echo $random;
if ($random <= $div) {
    echo "<br /> success!";
} else {
    echo "<br /> uh oh...!";
}


echo "We have an easy mining mission for you!";
$missiontime = 86400;
//echo gmdate("H:i:s", $missiontime);
echo $hms = floor($missiontime / 3600) . gmdate(':i:s', $missiontime);
$size = 3;
echo "<br />";
echo $timetaken = floor(max($hms / $size, 1));

$finaltime = $timetaken * 3600;
echo gmdate("H:i:s", $finaltime);

$level = 3;
$jobskill = rand(800, 1200);
$randomsub1 = rand(100, 200);
$randomsub = $randsub1 * $level;
echo "<br />";
echo $jobskilloffer = $jobskill * $level - $randomsub;
?>