<?php
include_once 'start.php';
?>
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {

    $userid = $_SESSION['userid'];

    $result2 = mysql_query("SELECT * FROM user WHERE userid='$userid'");
    $row0 = mysql_fetch_assoc($result2);
    $setup = $row0["setup"];

    $result22 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
    $row22 = mysql_fetch_assoc($result22);
    $credit = $row22["credit"];


    if ($setup == TRUE) {

        if (!isset($_POST['recruit'])) {
            include_once 'header.php';

            $result20 = mysql_query("SELECT * FROM ship WHERE userid='$userid'");
            $row20 = mysql_fetch_assoc($result20);
            $maxcrewsize = $row20["crew"];
            $result21 = mysql_query("SELECT * FROM crew WHERE userid='$userid'");
            $row21 = mysql_fetch_assoc($result21);
            $currentcrewsize = $row21["size"];
            echo "<div id='game'>
<h2>
Recruit
</h2>
<h3> You Currently Have $currentcrewsize Crew Members. You may have up to $maxcrewsize on your current ship</h3>
";
            if ($currentcrewsize >= $maxcrewsize) {
                echo "<h4>Your ship is currently at full capacity! Please upgrade ships.</h4>";

            } else {

                echo "<h4>Hiring another crew member will require an upfront payment of 6000 Credits. Their wage will be 500 credits weekly.</h4>";
                echo "<h4>Hire an additional crew member?</h4>";
                echo "<form action='recruit.php' method='post'>
<input type='hidden' name='recruit' value='1'>
<input type='submit' value='Hire'>
</form>";

            }
        } else {
            if ($credit < 6000) {
                include_once 'header.php';
                echo "<div id='game'>
<h2>
Recruit
</h2>
<h3> You currently have insufficient funds! Please return!</h3>
";
            } else {
                $result6 = mysql_query("UPDATE userinfo SET credit=credit-6000 WHERE userid='$userid'") or die (mysql_error() . "UH OHHHH");
                $result6 = mysql_query("UPDATE crew SET size=size+1, wages=wages+500 WHERE userid='$userid'") or die (mysql_error() . "UH OHHHH");
                include_once 'header.php';
                echo "<div id='game'>
<h2>
Recruit
</h2>
<h3> You have successfully hired a crew member!</h3>
";
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
