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

        $vowels = array("a", "e", "o", "u");
        $consonants = array("b", "c", "d", "v", "g", "t", "z", "l");
        $missionjob = array("Merchant", "Enforcer", "Pirate", "Settler", "Pacifist", "Wise");

        function randVowel()
        {
            global $vowels;
            return $vowels[array_rand($vowels, 1)];
        }

        function randConsonant()
        {
            global $consonants;
            return $consonants[array_rand($consonants, 1)];
        }

        function randJob()
        {
            global $missionjob;
            return $missionjob[array_rand($missionjob, 1)];
        }

        $mname = ucfirst("" . randConsonant() . "" . randVowel() . "" . "" . randConsonant() .
            "" . randVowel() . "" . randVowel() . "");

        $job = randJob();
        $result9 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
        $row9 = mysql_fetch_assoc($result9);
        $locationid = $row9["locationid"];

        $herego7 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");


        $row7 = mysql_fetch_assoc($herego7);

        $location = $row7["name"];
        $locdiff = $row7["difficulty"];

        $herego8 = mysql_query("SELECT * FROM ship WHERE userid='$userid'");


        $row8 = mysql_fetch_assoc($herego8);

        $level = $row8["level"];
        $shield = $row8["shield"];

        if (isset($_POST['newopp']) && $_POST['newopp'] == 'TRUE') {
            $herego23 = mysql_query("SELECT * FROM missioncont WHERE playerid='$userid' AND locationid='$locationid' AND active=TRUE ORDER BY missioncontid DESC") or die(mysql_error());

            $row23 = mysql_fetch_assoc($herego23);

            $missioncontid = $row23['missioncontid'];

            $setsuccess = mysql_query("UPDATE missioncont SET active=FALSE WHERE playerid=$userid AND missioncontid=$missioncontid") or die(mysql_error() . "WOOOP");
        }


        $herego20 = mysql_query("SELECT * FROM missioncont WHERE playerid='$userid' AND locationid='$locationid' AND active=TRUE ORDER BY missioncontid DESC") or die(mysql_error());
        $num_results = mysql_num_rows($herego20);
        $row20 = mysql_fetch_assoc($herego20);

//else{}

        if ($num_results > 0) {

            $jobname = $row20['name'];
            $joboffer = $row20['joboffer'];
            $expoffer = $row20['experienceoffer'];
            $difficulty = $row20['difficulty'];
            if ($difficulty == '1') {
                $difficultymessage = 'Watch out! They\'re tough.';
            } else if ($difficulty == '2') {
                $difficultymessage = 'You should be fine...';
            } else {
                $difficultymessage = 'This should be a easy for someone like you...';
            }

            $mission = "$jobname needs help dealing with some tryants.<br />
He is offering $joboffer credits for your help.<br />
Successfully completing this mission will earn you $expoffer experience points<br />$difficultymessage<br />";


        } else {
            if ($locdiff == 1) {
                $opponentdefence = rand(800, 1200);
                if ($opponentdefence > 1100 && $opponentdefence < 1200) {
                    $credits = rand(140, 150);
                    $exp = rand(160, 180);
                    $randomsub1 = rand(100, 200);
                    $randomsub = $randsub1 * $level;
                    $difficulty = "1";
                    $difficultymessage = 'Watch out! They\'re tough.';
//$defence = rand(800,1000);
                    $defenceoffer = $opponentdefence * $level - $randomsub;
                } else if ($opponentdefence > 1000 && $opponentdefence < 1200) {
                    $credits = rand(120, 139);
                    $exp = rand(140, 159);
                    $randomsub1 = rand(100, 300);
                    $randomsub = $randsub1 * $level;
                    $difficulty = "2";
                    $difficultymessage = 'You should be fine...';
//$defence = rand(600,799);
                    $defenceoffer = $opponentdefence * $level - $randomsub;
                } else {
                    $credits = rand(100, 119);
                    $exp = rand(120, 139);
                    $randomsub1 = rand(100, 500);
                    $randomsub = $randsub1 * $level;
                    $difficulty = "3";
                    $difficultymessage = 'This should be a easy for someone like you...';
//$defence = rand(300,599);
                    $defenceoffer = $opponentdefence * $level - $randomsub;
                }

                $expoffer = $exp * $level - 100;
                $joboffer = $credits * $level;
//$defenceoffer = $defence * $level;
                /*$_SESSION['defenceoffer'] = $defenceoffer;
                $_SESSION['expoffer'] = $expoffer;
                $_SESSION['joboffer'] = $joboffer;
                $_SESSION['difficulty'] = $difficulty;*/

                $timestuff = strtotime('now');

                $result50 = mysql_query("INSERT INTO missioncont VALUES(NULL,'$userid','$defenceoffer','$expoffer','$joboffer','$difficulty','$timestuff','$mname the $job','$locationid',TRUE)") or die (mysql_error() . "NUM5");


                $mission = "$mname the $job needs help dealing with some tryants.<br />
He is offering $joboffer credits for your help.<br />
Successfully completing this mission will earn you $expoffer experience points<br />$difficultymessage<br />";

            } else if ($locdiff == 2) {
                $opponentdefence = rand(1200, 1400);
                if ($opponentdefence > 1200 && $opponentdefence < 1400) {
                    $credits = rand(240, 250);
                    $exp = rand(260, 280);
                    $randomsub1 = rand(100, 200);
                    $randomsub = $randsub1 * $level;
                    $difficulty = "1";
                    $difficultymessage = 'Watch out! They\'re tough.';
//$defence = rand(800,1000);
                    $defenceoffer = $opponentdefence * $level - $randomsub;
                } else if ($opponentdefence > 1000 && $opponentdefence < 1200) {
                    $credits = rand(220, 239);
                    $exp = rand(240, 259);
                    $randomsub1 = rand(100, 300);
                    $randomsub = $randsub1 * $level;
                    $difficulty = "2";
                    $difficultymessage = 'You should be fine...';
//$defence = rand(600,799);
                    $defenceoffer = $opponentdefence * $level - $randomsub;
                } else {
                    $credits = rand(100, 119);
                    $exp = rand(220, 239);
                    $randomsub1 = rand(200, 500);
                    $randomsub = $randsub1 * $level;
                    $difficulty = "3";
                    $difficultymessage = 'This should be a easy for someone like you...';
//$defence = rand(300,599);
                    $defenceoffer = $opponentdefence * $level - $randomsub;
                }

                $expoffer = $exp * $level - 100;
                $joboffer = $credits * $level;
//$defenceoffer = $defence * $level;
                /*$_SESSION['defenceoffer'] = $defenceoffer;
                $_SESSION['expoffer'] = $expoffer;
                $_SESSION['joboffer'] = $joboffer;
                $_SESSION['difficulty'] = $difficulty;*/

                $timestuff = strtotime('now');

                $result50 = mysql_query("INSERT INTO missioncont VALUES(NULL,'$userid','$defenceoffer','$expoffer','$joboffer','$difficulty','$timestuff','$mname the $job','$locationid',TRUE)") or die (mysql_error() . "NUM5");

                $mission = "$mname the $job needs help dealing with some tryants.<br />
He is offering $joboffer credits for your help.<br />
Successfully completing this mission will earn you $expoffer experience points<br />$difficultymessage<br />";

            }
        }

        $herego21 = mysql_query("SELECT * FROM missioncont WHERE playerid='$userid' AND locationid='$locationid' AND active=TRUE ORDER BY missioncontid DESC") or die(mysql_error());

        $row21 = mysql_fetch_assoc($herego21);
        $_SESSION['missioncontid'] = $missioncontid = $row21['missioncontid'];
        include_once 'header.php';

        $hour = strtotime('-1 hour');
        $result3 = mysql_query("SELECT * FROM missioncont WHERE playerid='$userid' and time>'$hour' and locationid=$locationid") or die (mysql_error());
        $row3 = mysql_fetch_assoc($result3);
        $time = $row3["time"];
        $missionnum = mysql_num_rows($result3);
        $battlecountmessage = "<p> Missions this hour: $missionnum/10</p>";
        echo "
<div id='game'>
<h2>
Mission
</h2>";
        if ($shield == 0) {
            echo "<br /><p>Your shields are too low to do any missions!</p>";
        } else if ($missionnum < 10) {
            /*echo'<form action="result.php" method="post"><p>Turns:<input type="text" maxlength="20" name="turns" id="turns" />/10
                <input type="submit" value="Battle!" /></p></form>';
                echo" <input type='hidden' name='opponentid' id='opponentid' value='$playerid'/>
                ";*/

            echo "
<br />
$battlecountmessage <br />
$mission
<br />

Do you accept??
";
//echo "missioncont id ".$missioncontid;
            echo '<form action="missionresult.php" method="post"><p>Turns:<input type="text" maxlength="20" name="turns" id="turns" />/10 <br />';
            echo '<input type="submit" value="Accept!" /></p>';
            echo " <input type='hidden' name='opponentid' id='opponentid' value='$playerid'/>
	</form>
	";

            echo '<form action="mission.php" method="post">'; //<p></p>Turns:<input type="text" maxlength="20" name="turns" id="turns" />
            echo ' <input type="submit" value="Decline For A New Mission!" />';
            echo " <input type='hidden' name='newopp' id='newopp' value='TRUE'/>
	</form>
</div>
";
        } else {

            echo "<br /><p>You've reached your hourly mission limit on this planet!</p>";

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
