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
        $result3 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
        $row2 = mysql_fetch_assoc($result3);
        echo "
<div id='game'>
<h2>
";

        $locationid = $row2["locationid"];

        $herego7 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");


        $row7 = mysql_fetch_assoc($herego7);

        $location = $row7["name"];
        $population = $row7["population"];
        $marketplace = $row7["marketplace"];

        echo $location;

        echo "
</h2>
<ul>";

        if ($population > 1) {
            echo "<li><a href='localranks.php'>Battle Players</a></li>";
        }
        if ($marketplace == TRUE) {
            echo "<li><a href='marketplace.php'>Marketplace</a></li>";
        }
        echo "<li><a href='mission.php'>Missions</a></li>

<li><a href='recruit.php'>Recruit</a></li>

<li><a href='speciality.php'>Jobs</a></li>

<li><a href='locationship.php'>Ship Hangar</a></li>
</ul>
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
