<?php
/*echo $attack_effect = 1000;
echo "<br />";
echo $defense_effect = 500;
echo "<br />";
echo $credit = 1000;
echo "<br />";
echo $turns = 10;
echo "<br />";
		
		echo "ratio1". $ratio = ($attack_effect - $defense_effect)/$attack_effect * $turns;
		echo "<br />";
		echo "ratio2".$ratio = min($ratio,0.9);
		echo "<br />";
		echo "creditswon".$creditswon = floor($ratio * $credit);
		echo "<br />";
*/
/*echo $attack = 3000;
$efficiency = 27;
echo $eround = $efficiency/100;
echo "<br />";
echo $attack_efficiency = min($attack,$eround); echo $attack_efficiency1 = $eround;
$final_attack = floor ($attack_efficiency * $attack);
echo "<br />";

echo "Final attack =".$final_attack;*/
/*
$attack = 360;
$defence = 46000;
echo "<br />";
echo $difference = $defence - $attack;
echo "<br />";
echo $sum = min($difference,0.2);
echo $sum2 = floor(100*$sum);*/
/*echo "<br />";
echo $attack_effect = 1000;
echo "<br />";
echo $defense_effect = 500;
echo "<br />";
echo $turns = 10;
echo "<br />";
echo $credit = 1000;
echo "<br />";
		
echo $ratio = ($attack_effect - $defense_effect)/$attack_effect * $turns;
echo "<br />";
		echo $ratio = min($ratio,0.2);
		echo "<br />";
		echo $creditswon = floor($ratio * $credit);*/

$defence = 120000;
$attack = 3500;

$count = $defence / $attack;

$count = min($count, 20);
$shielddamage = floor($count);

//$count1 = max($count1, 1);
//echo $count2 = number_format($count1, 0);
//echo floor($count1);
echo $count;

?>