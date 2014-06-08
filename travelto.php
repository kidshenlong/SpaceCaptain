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


        if (isset($_POST['travelto']) && $_POST['travelto'] == 'travelto') {
            /*echo"That's a bingo!";
            echo $_SESSION['cost'];
            echo $_SESSION['newloc'];*/


            $travel = $_SESSION['newloc'];

            $result9 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
            $row9 = mysql_fetch_assoc($result9);
            $oldlocation = $row9["locationid"];
            $credit = $row9["credit"];
            $turns = $row9["turns"];

            $travelfare = $_SESSION['cost'];
            $travelturnfare = $_SESSION['turncost'];

            if ($travelfare > $credit) {
                $message = "<h3>
You have insufficient funds.

</h3> </div>";
            } else if ($travelturnfare > $turns) {
                $message = "<h3>
You do not have enough turns.

</h3> </div>";
            } else {
                $timestuff = strtotime('now');

                $result6 = mysql_query("UPDATE userinfo SET locationid=$travel WHERE userid='$userid'") or die (mysql_error() . "UH OHHHH");

                $result5 = mysql_query("INSERT INTO travellog VALUES(NULL,'$userid','$travel','$oldlocation','$timestuff')") or die (mysql_error() . "CRAP");


//$travelfare= $_SESSION['cost'];
//$travelturnfare= $_SESSION['turncost'];

                $result66 = mysql_query("UPDATE location SET population=population-1 WHERE locationid='$oldlocation'") or die (mysql_error() . "UH OHHHH2");

                $result666 = mysql_query("UPDATE location SET population=population+1 WHERE locationid='$travel'") or die (mysql_error() . "UH OHHHH2");

                $result6 = mysql_query("UPDATE userinfo SET credit=credit-$travelfare WHERE userid='$userid'") or die (mysql_error() . "UH OHHHH2");

                $result10 = mysql_query("UPDATE userinfo SET turns=turns-$travelturnfare WHERE userid='$userid'") or die (mysql_error() . "UH OHHHH2");

                $result7 = mysql_query("SELECT * FROM location WHERE locationid='$travel'");
                $row7 = mysql_fetch_assoc($result7);
                $travelname = $row7["name"];
                $message = "<h3>
You have successfully travelled to $travelname

</h3> </div>";
            }
            include_once 'header.php';

            echo '<div id="game">
<h2>
Travel
</h2>
';
            echo $message;

        } else if (isset($_GET['id'])) {


            $result9 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
            $row9 = mysql_fetch_assoc($result9);
            $ol = $row9["locationid"];


            $nl = $_GET['id'];

            $result10 = mysql_query("SELECT * FROM location WHERE locationid='$nl'");
            $row10 = mysql_fetch_assoc($result10);
            $locationname = $row10["name"];
            $population = $row10["population"];


            $tile_org_value = $ol;
            $tile_new_value = $nl;


            $row_org = floor($tile_org_value / 10);
            $column_org = $tile_org_value % 10;

            $row_new = floor($tile_new_value / 10);
            $column_new = $tile_new_value % 10;

            $row_diff = $row_new - $row_org;
            $col_diff = $column_new - $column_org;

            $distance = sqrt(pow($row_diff, 2) + pow($col_diff, 2));

            include_once 'header.php';
            echo "
		<div id='game'>
		<h2>
		Game
		</h2>
		<h3>
			";


            if ($distance <= 1) {

                $cost = 500;
                $turncost = 20;

            } else if ($distance <= 2) {

                $cost = 1000;
                $turncost = 40;

            } else if ($distance <= 3) {

                $cost = 1500;
                $turncost = 60;

            } else if ($distance <= 4) {

                $cost = 2000;

                $turncost = 80;

            } else if ($distance <= 5) {

                $cost = 3000;

                $turncost = 100;

            } else {
                $cost = 5000;
                $turncost = 120;

            }

            $_SESSION['cost'] = $cost;
            $_SESSION['turncost'] = $turncost;
            $_SESSION['newloc'] = $nl;
            echo "
		<div class='myclass'>$locationname<br />Travelling here will cost $cost credits<br /> And $turncost turns.<br /> The population is $population.</div>
		</h3>
		";


            $day = strtotime('-1 day');
            //$hours = strtotime('-6 hours');
            $result3 = mysql_query("SELECT * FROM travellog WHERE userid='$userid' and time>'$day'") or die (mysql_error());
            $rowt3 = mysql_fetch_assoc($result3);
            $time = $row3["time"];
            $travelnum = mysql_num_rows($result3);

            if ($travelnum < 2) {
                echo '<form action="travelto.php" method="post">
<input type="hidden" name="travelto" value="travelto">
<input id="button" type="submit" value="Travel Here!" />
</form>';
            } else {
                echo "Travel Limit reached!";
            }
            echo '</div>';
        } else {
//echo"DAFUQQQ";

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

}


?>