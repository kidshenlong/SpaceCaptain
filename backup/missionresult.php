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
                $attack_effect = $turns * 0.1 * $row5['attack'];

                /*$opponentshipquery = mysql_query("SELECT * FROM ship WHERE userid='$opponentid'") or die(mysql_error());
                $row6= mysql_fetch_assoc($opponentshipquery);
                $defence_effect = $row6['defence'];*/
                $defence_effect = $_SESSION['defenceoffer'];


                $message = "You send your warriors into battle!<br><br>" .
                    "Your warriors dealt " . number_format($attack_effect) . " damage!<br>" .
                    "The enemy's defenders dealt " . number_format($defence_effect) . " damage!<br><br>";


                if ($attack_effect > $defence_effect) {

                    $expoffer = $_SESSION['expoffer'];
                    $joboffer = $_SESSION['joboffer'];
                    $jobdifficulty = $_SESSION['difficulty'];


                    $timestuff = strtotime('now');
                    $winnerid = $userid;
                    $query = mysql_query("INSERT INTO missionlog VALUES(NULL,'$userid','$timestuff',TRUE,'$joboffer','$expoffer','$location','$jobdifficulty')") or die (mysql_error() . "OH WOW");

                    $givecredits = mysql_query("UPDATE inventory SET credit=credit+$joboffer WHERE userid=$userid") or die(mysql_error() . "2");
                    $giveexp = mysql_query("UPDATE ship SET experience=experience+$expoffer WHERE userid=$userid") or die(mysql_error() . "7");

                    $message = $message . " You have successfully defeated the tyrants! Congrats you have been rewarded $joboffer Credits! ";

                } else {
                    $timestuff = strtotime('now');
                    //$winnerid = $opponentid;
                    $query = mysql_query("INSERT INTO missionlog VALUES(NULL,'$userid','$timestuff','FALSE','$joboffer','$expoffer','$location','$jobdifficulty')") or die (mysql_error() . "3");
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
