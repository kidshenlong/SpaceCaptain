<?php
include_once 'start.php';
?>
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {

    $userid = $_SESSION['userid'];

    $result2 = mysql_query("SELECT * FROM user WHERE userid='$userid'");
    $row0 = mysql_fetch_assoc($result2);
    $setup = $row0["setup"];
    if ($setup == TRUE) {


        if (isset($_POST['turns'])) {

            $turns = $_POST['turns'];
            $opponentid = $_POST['opponentid'];

            $usercheck = mysql_query("SELECT * FROM userinfo WHERE userid='$opponentid'") or die(mysql_error());
            $row1 = mysql_fetch_assoc($usercheck);
            $opponentlocation = $row1['locationid'];

            $userlocationcheck = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'") or die(mysql_error());
            $row2 = mysql_fetch_assoc($userlocationcheck);
            $userlocation = $row2['locationid'];
            $userturns = $row2['turns'];

            $day = strtotime('-1 day');
            $timecheck = mysql_query("SELECT * FROM battlelog WHERE player='$userid' and opponent='$opponentid' and time>'$day'") or die (mysql_error());
            $battlenum = mysql_num_rows($timecheck);

            if (mysql_num_rows($usercheck) == 0) {
                $warning = "There is no user with that ID!";
            } else {
                if ($userid == $opponentid) {
                    $warning = "You cannot battle yourself!";
                } elseif ($turns < 1 || $turns > 10) {
                    $warning = "You must attack with 1-10 turns!";
                } else if ($userlocation != $opponentlocation) {
                    $warning = "You're not in the same quadrant!";
                } else if ($turns > $userturns) {
                    $warning = "You don't have enough turns!";
                } else if ($battlenum >= 5) {
                    $warning = "You've reached your 24 hour attack limit for this player!";
                } else {
                    //$warning =  "Success";

                    $turnupdate = mysql_query("UPDATE userinfo SET turns=turns-'$turns' WHERE userid='$userid'") or die (mysql_error());

                    $usershipquery = mysql_query("SELECT * FROM ship WHERE userid='$userid'") or die(mysql_error());
                    $row5 = mysql_fetch_assoc($usershipquery);
                    //NEW EFFICIENT SHIELD SYSTEM
                    $playerattack = $row5['attack'];
                    $playershield = $row5['shield'];

                    $shieldefficiency = $playershield / 100;

                    //$attackefficiency = min($playerattack,$shieldefficiency);
                    //$finalattack = floor ($attackefficiency * $playerattack);

                    $finalattack = floor($shieldefficiency * $playerattack);

                    $attack_effect = $turns * 0.1 * $finalattack;
                    //$attack_effect = $turns * 0.1 * $row5['attack'];
                    //END OF NESS

                    $opponentshipquery = mysql_query("SELECT * FROM ship WHERE userid='$opponentid'") or die(mysql_error());
                    $row6 = mysql_fetch_assoc($opponentshipquery);

                    //NEW EFFICIENT SHIELD SYSTEM
                    $opponentdefence = $row6['defence'];
                    $opponentshield = $row6['shield'];

                    $opponentshieldefficiency = $opponentshield / 100;

                    //$defenceefficiency = min($opponentdefence,$opponentshieldefficiency);
                    //$finaldefence = floor ($defenceefficiency * $opponentdefence);

                    $finaldefence = floor($opponentshieldefficiency * $opponentdefence);

                    $defence_effect = $finaldefence;
                    //$defence_effect = $row6['defence'];

                    $message = "Your ship enters the battle!<br><br>" .
                        "Your ship dealt " . number_format($attack_effect) . " damage!<br>" /*.
		"The enemy's defenders dealt " . number_format($defence_effect) ." damage!<br><br>";*/ . "<br />";


                    if ($attack_effect > $defence_effect) {

                        $opponentinventoryquery = mysql_query("SELECT * FROM userinfo WHERE userid='$opponentid'") or die(mysql_error());
                        $row9 = mysql_fetch_assoc($opponentinventoryquery);
                        $credit = $row9['credit'];

                        $ratio = ($attack_effect - $defense_effect) / $attack_effect * $turns;
                        $ratio = min($ratio, 0.2);
                        $creditswon = floor($ratio * $credit);
                        //SHIELD DAMAGE WIN
                        $count = $attack_effect / $defence_effect;

                        $count = min($count, 20);
                        $shielddamage = floor($count);
                        //END SHIELD DAMAGE WIN

                        $timestuff = strtotime('now');
                        $winnerid = $userid;
                        $query = mysql_query("INSERT INTO battlelog VALUES(NULL,'$userid', '$opponentid', '$timestuff','$winnerid','$attack_effect','$defence_effect','$shielddamage')") or die (mysql_error());
                        $takecredits = mysql_query("UPDATE userinfo SET credit=credit-$creditswon WHERE userid=$opponentid") or die(mysql_error());
                        $givecredits = mysql_query("UPDATE userinfo SET credit=credit+$creditswon WHERE userid=$userid") or die(mysql_error());

                        if ($shielddamage > $opponentshield) {
                            $takeshield = mysql_query("UPDATE ship SET shield='0' WHERE userid=$opponentid") or die(mysql_error());
                        } else {
                            $takeshield = mysql_query("UPDATE ship SET shield=shield-$shielddamage WHERE userid=$opponentid") or die(mysql_error());
                        }

                        $message = $message . " You have won the battle! Congrats you successfully plundered $creditswon Credits! ";

                    } else {

                        //SHIELD DAMAGE LOSS
                        $count = $defence_effect / $attack_effect;

                        $count = min($count, 20);
                        $shielddamage = floor($count);
                        //END SHIELD DAMAGE LOSS
                        $timestuff = strtotime('now');
                        $winnerid = $opponentid;
                        $query = mysql_query("INSERT INTO battlelog VALUES(NULL,'$userid', '$opponentid', '$timestuff','$winnerid','$attack_effect','$defence_effect','$shielddamage')") or die (mysql_error());


                        if ($shielddamage > $opponentshield) {
                            $takeshield = mysql_query("UPDATE ship SET shield='0' WHERE userid=$userid") or die(mysql_error());
                        } else {
                            $takeshield = mysql_query("UPDATE ship SET shield=shield-$shielddamage WHERE userid=$userid") or die(mysql_error());
                        }
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

            }

            /*echo'
            <div id="game">
            <h2>
            Game
            </h2>
            </div>
            ';*/
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
