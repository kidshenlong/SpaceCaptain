<?php
include_once 'start.php';
?>
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {

    $userid = $_SESSION['userid'];

    $result2 = mysql_query("SELECT * FROM user WHERE userid='$userid'") or die(mysql_error() . "Aldo");
    $row0 = mysql_fetch_assoc($result2);
    $setup = $row0["setup"];


    if ($setup == TRUE) {


        if (isset($_POST['turns'])) {

            $result200 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'") or die(mysql_error() . "Aldo");
            $row100 = mysql_fetch_assoc($result200);
            $locationid = $row100["locationid"];

            $herego20 = mysql_query("SELECT * FROM missioncont WHERE playerid='$userid' AND locationid=$locationid AND active=TRUE ORDER BY missioncontid DESC") or die(mysql_error());
            $num_results = mysql_num_rows($herego20);
            $row20 = mysql_fetch_assoc($herego20);

//else{}

            if ($num_results > 0) {

                $turns = $_POST['turns'];


                $userlocationcheck = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'") or die(mysql_error() . "-1");
                $row2 = mysql_fetch_assoc($userlocationcheck);

                $userturns = $row2['turns'];
                $location = $row2['locationid'];


                if ($turns < 1 || $turns > 10) {
                    $warning = "You must attack with 1-10 turns!";
                } else if ($turns > $userturns) {
                    $warning = "You don't have enough turns!";
                } else if ($battlenum >= 10) {
                    $warning = "You've reached your hourly mission limit";
                } else {
                    //$warning =  "Success";

                    $turnupdate = mysql_query("UPDATE userinfo SET turns=turns-'$turns' WHERE userid='$userid'") or die (mysql_error() . "0");

                    $usershipquery = mysql_query("SELECT * FROM ship WHERE userid='$userid'") or die(mysql_error() . "0.5");
                    $row5 = mysql_fetch_assoc($usershipquery);

                    //NEW EFFICIENT SHIELD SYSTEM
                    $playerattack = $row5['attack'];
                    $playershield = $row5['shield'];

                    $shieldefficiency = $playershield / 100;


                    $finalattack = floor($shieldefficiency * $playerattack);

                    $attack_effect = $turns * 0.1 * $finalattack;
                    //$attack_effect = $turns * 0.1 * $row5['attack'];
                    //END OF NESS

                    /*$opponentshipquery = mysql_query("SELECT * FROM ship WHERE userid='$opponentid'") or die(mysql_error());
                    $row6= mysql_fetch_assoc($opponentshipquery);
                    $defence_effect = $row6['defence'];*/


                    $herego20 = mysql_query("SELECT * FROM missioncont WHERE playerid='$userid' AND locationid='$location' AND active=TRUE") or die(mysql_error() . "HUGO");

                    $row20 = mysql_fetch_assoc($herego20);


                    $joboffer = $row20['joboffer'];
                    $expoffer = $row20['experienceoffer'];
                    $jobdifficulty = $row20['difficulty'];
                    $defence_effect = $row20['defenceoffer'];

                    //$defence_effect = $_SESSION['defenceoffer'];


                    $message = "Your ship enters the battle!<br><br>" /*.
		"Your warriors dealt " . number_format($attack_effect) . " damage!<br>".
		"The enemy's defenders dealt " . number_format($defence_effect) ." damage!<br><br>"*/
                    ;


                    if ($attack_effect > $defence_effect) {

                        //$expoffer = $_SESSION['expoffer'];
                        //$joboffer = $_SESSION['joboffer'];
                        //$jobdifficulty = $_SESSION['difficulty'];


                        $timestuff = strtotime('now');
                        $winnerid = $userid;
                        $query = mysql_query("INSERT INTO missionlog VALUES(NULL,'$userid','$timestuff',TRUE,'$joboffer','$expoffer','$location','$jobdifficulty')") or die (mysql_error() . "OH WOW");

                        $givecredits = mysql_query("UPDATE userinfo SET credit=credit+$joboffer WHERE userid=$userid") or die(mysql_error() . "2 WHOOP");
                        $giveexp = mysql_query("UPDATE ship SET experience=experience+$expoffer WHERE userid=$userid") or die(mysql_error() . "7");

                        $message = $message . " You have successfully defeated the tyrants! Congrats you have been rewarded $joboffer Credits! ";

                        $missioncontid = $_SESSION['missioncontid'];
                        $setsuccess = mysql_query("UPDATE missioncont SET active=FALSE WHERE playerid=$userid AND missioncontid=$missioncontid") or die(mysql_error() . "21");


                        $result3 = mysql_query("SELECT * FROM ship WHERE userid='$userid'");
                        $row3 = mysql_fetch_assoc($result3);
                        $experience = $row3["experience"];
                        $level = $row3["level"];
                        //COOOOOL
                        $attack = $row3['attack'];
                        $defence = $row3['defence'];
                        $class = $row3['class'];
                        $attackmod = $row3['attackmod'];
                        $defencemod = $row3['defencemod'];
                        //BREAK

                        //ENDDDDDD

                        $power = pow($level, 3);

                        $levelup = $level * 500 + $power;

                        $attackup = $level * $attackmod + $power;
                        $defenceup = $level * $defencemod + $power;


                        if ($experience > $level * 500 + $power) {
                            $result4 = mysql_query("UPDATE ship SET level=level+1 WHERE userid='$userid'");
                            $result5 = mysql_query("UPDATE ship SET attack=attack+$attackup WHERE userid='$userid'") or die (mysql_error() . "SWEET");
                            $result5 = mysql_query("UPDATE ship SET defence=defence+$defenceup WHERE userid='$userid'") or die (mysql_error() . "SWEETER");

                        }


                    } else {
                        $timestuff = strtotime('now');
                        //$winnerid = $opponentid;
                        $query = mysql_query("INSERT INTO missionlog VALUES(NULL,'$userid','$timestuff','FALSE','$joboffer','$expoffer','$location','$jobdifficulty')") or die (mysql_error() . "3");
                        $missioncontid = $_SESSION['missioncontid'];
                        $setfail = mysql_query("UPDATE missioncont SET active=FALSE WHERE playerid=$userid AND missioncontid=$missioncontid") or die(mysql_error() . "21");

                        $message = $message . "You have lost the battle!";
                        //  include_once 'header.php';
                    }

                }
                include_once 'header.php';
                echo "
		<div id='game'>
		<h2>
		Game
		</h2>
		<h3>
			
			$warning <br />
			$message
		</h3>
		</div>";


                /*echo'
                <div id="game">
                <h2>
                Game
                </h2>
                </div>
                ';*/
            } else {
                header("Location:mission.php");
            }
        }
    } else {
        header("Location:setup.php");
    }
} else {
    header("Location:index.php");
}
?>


<?php
include_once 'footer.php';
?>
