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

        include_once 'header.php';
        echo '<head>

<script type="text/javascript" src="jquery.countdown.js"></script>
<link href="jquery.countdown.css" rel="stylesheet" type="text/css" />
';
        echo "";
        echo ' </head>';

        echo '
<div id="game">
<h2>
Player Info
</h2>';


        if (isset($_GET['id'])) {

            $playerid = $_GET['id'];


            $result = mysql_query("SELECT * FROM userinfo WHERE userid='$playerid'");
            $row = mysql_fetch_assoc($result);

            $playercheck = mysql_num_rows($result);

            if ($playercheck > 0) {

                $locationid = $row["locationid"];
                $herego707 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");


                $row707 = mysql_fetch_assoc($herego707);

                $location = $row707["name"];
                $name = $row["name"];
                $credit = $row["credit"];


                $result1 = mysql_query("SELECT * FROM ship WHERE userid='$playerid'");
                $row1 = mysql_fetch_assoc($result1);
                $shipname = $row1["name"];
                $shiplevel = $row1["level"];


                $result22 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
                $row22 = mysql_fetch_assoc($result22);
                $playerlocation = $row22["locationid"];

                if ($playerlocation == $locationid) {

                    $herego101 = mysql_query("SELECT * FROM ship WHERE userid='$userid'");

                    $row101 = mysql_fetch_assoc($herego101);
                    $levelop = $row101["level"];
                    $shield = $row101['shield'];
                    $ten = 10;

                    $max = $shiplevel + $ten;
                    $min = $shiplevel - $ten;

                    if ($shield == 0) {
                        echo "<br /><p>Your shields are too low to do any missions!</p>";
                    } else if ($levelop >= $min && $levelop <= $max) {

                        echo '<p>';
                        echo "Captain " . $name . "<br />";
                        echo "Currently Located at " . $location . "<br />";
                        echo "Credit(s): " . $credit . "<br />";
                        echo "Currently commanding the ship " . $shipname . ".";
                        echo '</p>';

                        $day = strtotime('-1 day');
                        $result3 = mysql_query("SELECT * FROM battlelog WHERE player='$userid' and opponent='$playerid' and time>'$day'") or die (mysql_error());
                        $rowt3 = mysql_fetch_assoc($result3);
                        $time = $row3["time"];
                        $battlenum = mysql_num_rows($result3);
                        echo "<p> Battles today: $battlenum/5</p>";
                        if ($battlenum < 5) {
                            echo '<form action="result.php" method="post"><p>Turns:<input type="text" maxlength="20" name="turns" id="turns" />/10
    <input type="submit" value="Battle!" /></p>';
                            echo " <input type='hidden' name='opponentid' id='opponentid' value='$playerid'/>
	</form>";
                        } else {

                            $result932 = mysql_query("SELECT * FROM battlelog WHERE player='$userid' AND opponent='$playerid' ORDER BY battleid DESC LIMIT 1") or die (mysql_error());
                            $row932 = mysql_fetch_assoc($result932);
                            $lasttravel = $row932["time"];

                            echo "<script type='text/javascript'>
$(document).ready(function(){
 
     var sum1= $lasttravel+86400;
	
	var austDay = new Date(sum1*1000);
 $('#defaultCountdown').countdown({until: austDay, format: 'HMS'});

});</script>";

                            echo "<h3>You've reached your 24 hour attack limit for this player!</h3>
  <h3><div style=''id ='defaultCountdown'></h3>";
                        }


                    } else {
                        echo "<h3>You are not within this players level range. You must be within 10 levels to battle!</h3>";

                    }

                } else {
                    echo "<h3>You are not in the same sector!</h3>";
                }

            } else {
                echo "<h3>This Player does not exist!</h3>";
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
