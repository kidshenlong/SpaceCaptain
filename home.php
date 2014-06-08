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
Home
</h2>';
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


        $levelplus = $level + 1;

        $levelfinal = $levelplus * 500 + $power;

        $experiencediff = $levelfinal - $experience;
        /*
        echo"<br />". $level." Level";
        echo"<br />".$levelplus." Level Above";
        echo"<br />".$levelfinal." Level above experience";
        echo"<br />".$experiencediff." experience points left until the next level." ;
        echo"<br />". $experience." current experience";*/
        /*echo'
        </div>
        ';*/
        /*$attackup = $level * $attackmod + $power;
        $defenceup = $level * $defencemod + $power;*/
//srfgsrgsrg
        /*$defenceup = $level * 100 + $power;
        $attackupsub = $level * 50 + $power;
        //esfsesfeg
        $attackupmid = $level * 70 + $power;
        $defenceupmid = $level * 70 + $power;*/
        /*echo"<br />
        attack add on! : $attackup & defence: $defenceupsub
        <br /> defence add on! : $defenceup & attack: $attackupsub
        <br /> mids get: $attackupmid and $defenceupmid
        </div>";*/
        /*echo "<br />
        Next level! : $attackup & defence: $defenceup*/
        echo "
<h2> Welcome!</h2>
</div></div>";

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
