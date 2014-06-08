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


        $result20 = mysql_query("SELECT * FROM ship WHERE userid='$userid'");
        $row20 = mysql_fetch_assoc($result20);
        $shield = $row20["shield"];

        $flatrepairrate = 100;

        $shieldrepair = 100 - $shield;

        $shieldrepaircost = $shieldrepair * 100;
        if (!isset($_POST['repairbutton'])) {
            include_once 'header.php';
            echo "
<div id='game'>
<h2>Ship Hangar</h2>
";


            echo "<h3>Your shield's efficiency is currently at $shield%</h3>"; #
            if ($shield == 100) {
                "<h3>Your shields do not need reparing!</h3>";

            } else {
                echo "<h3> Unfortunately your shields have taken damage... This will have an effect on your ship's overall efficiency!</h3><br />";


                echo "<h3> It will cost $shieldrepaircost credits to repair your shield.</h3>";
                echo "<form name='repair' method='post' action='locationship.php'>
		<input type='submit' value='Repair' name='repairbutton' id='repairbutton' />
		
	</form>";
            }
        } else {


            if ($shield == 100) {

            } else {
                $result6 = mysql_query("UPDATE userinfo SET credit=credit-$shieldrepaircost WHERE userid='$userid'") or die (mysql_error() . "UH OHHHH2");
                $takeshield = mysql_query("UPDATE ship SET shield=100 WHERE userid=$userid") or die(mysql_error());
            }
            include_once 'header.php';
            echo "
<div id='game'>
<h2>Ship Hangar</h2>
";
            echo "<h3> Your shields have successfully been repaired.</h3>";

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
