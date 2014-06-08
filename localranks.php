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
        echo '
<div id="game">
<h2>
Battle
</h2>';

        $userid = $_SESSION['userid'];

        $result2 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
        $row0 = mysql_fetch_assoc($result2);
        $locationid = $row0["locationid"];


        $result = mysql_query("SELECT * FROM userinfo WHERE locationid= '$locationid'");
        echo "<table >";
        echo "<tr><th class='table1'>Captain Name</th><th class='table2'>Ship</th><th class='table3'>Level</th></tr>";


        while ($row = mysql_fetch_array($result)) {
            $userid2 = $row['userid'];

            $herego = mysql_query("SELECT * FROM userinfo WHERE userid='$userid2'");


            if ($userid == $userid2) {
                $thisplayer = '*';
            } else {
                $thisplayer = '';
            }

            $row1 = mysql_fetch_assoc($herego);
            $name = $row1["name"];


            $herego7 = mysql_query("SELECT * FROM ship WHERE userid='$userid'");
            $row7 = mysql_fetch_assoc($herego7);
            $level = $row7["level"];

            $herego8 = mysql_query("SELECT * FROM ship WHERE userid='$userid2'");
            $row8 = mysql_fetch_assoc($herego8);
            $levelop = $row8["level"];


            $herego1 = mysql_query("SELECT * FROM ship WHERE userid='$userid2'");

            $row2 = mysql_fetch_assoc($herego1);
            $shipname = $row2["name"];
            $shiplevel = $row2["level"];

            $ten = 10;

            /*echo "user level1 ".$level;
            echo " opp level2 ".$levelop;
            echo " opp level3 ". $sum = $level + $ten;
            echo " opp level4 ". $sum1 = $level - $ten;
            echo "";*/
            $max = $level + $ten;
            $min = $level - $ten;


            if ($levelop >= $min && $levelop <= $max) {
//echo"HEYY <br />";
                echo "<tr><td class='table1'><a href='";
                if ($userid == $userid2) {
                    echo "stats.php";
                } else {
                    echo "battle.php?id=$userid2";
                }
                echo "'>Captain $name $thisplayer</a></td><td class='table2'>$shipname </td><td class='table3'>$shiplevel</td></tr>";
            } else {
                //echo"HEYY <br />";

            }
        }
        echo "</table>";
//echo strtotime("now"), "\n";
        echo "
</div>
";
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
