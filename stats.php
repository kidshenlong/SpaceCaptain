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

        /*echo"
        <div id='game'>
        <h2>
        $ship
        </h2>";*/
        $userid = $_SESSION['userid'];

        if (isset($_GET['id'])) {

            $playerid = $_GET['id'];

            $result1001 = mysql_query("SELECT * FROM userinfo WHERE userid='$playerid'");
            $row1001 = mysql_fetch_assoc($result1001);
            $playercount = mysql_num_rows($result1001);
            $location = $row1001["location"];
            $name = $row1001["name"];
            $credit = $row1001["credit"];


            $result1002 = mysql_query("SELECT * FROM ship WHERE userid='$playerid'");
            $row1002 = mysql_fetch_assoc($result1002);
            $shipname = $row1002["name"];
            $level = $row1002["level"];
            $experience = $row1002["experience"];

            /*$result2=mysql_query("SELECT * FROM inventory WHERE userid='$playerid'");
            $row2= mysql_fetch_assoc($result2);
            $credit = $row2["credit"];*/

            $levelplus = $level + 1;

            $levelfinal = $levelplus * 500 + $power;

            $experiencediff = $levelfinal - $experience;


            echo "
<div id='game'>";

            if ($playercount >= 1) {
                ECHO "<h2>
$shipname
</h2><br /><p>This ship is currently level $level<br /> It is piloted by the good captain $name!</p>";
            } else {
                echo "<h3>This Player does not exist!</h3>";
            }

        } else {
            $result = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
            $row = mysql_fetch_assoc($result);
            $location = $row["location"];
            $name = $row["name"];
            $credit = $row["credit"];


            $result1 = mysql_query("SELECT * FROM ship WHERE userid='$userid'");
            $row1 = mysql_fetch_assoc($result1);
            $shipname = $row1["name"];
            $level = $row1["level"];
            $experience = $row1["experience"];

            /*$result2=mysql_query("SELECT * FROM inventory WHERE userid='$playerid'");
            $row2= mysql_fetch_assoc($result2);
            $credit = $row2["credit"];*/

            $levelplus = $level + 1;

            $levelfinal = $levelplus * 500 + $power;

            $experiencediff = $levelfinal - $experience;


            echo "
<div id='game'>
<h2>
$shipname
</h2>";

            ECHO "<br /><p>Current ship level is $level<br /> You currently have $experience experience points and are $experiencediff experience points away from the next level</p>";


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
