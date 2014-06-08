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
        header("Location:home.php");
    } else {

        if (!isset($_POST['capname']) && (!isset($_POST['shipname']))) {
            include_once 'header.php';
            echo '
<div id="game">
<h2>
Setup
</h2>';
            echo '
<h3>You have been chosen by the federation to become the captain of our newest star ship.</h3>
<h3>Please successfully fill out this form to enlist. We\'ll need you to confirm your name, Captain and a name for your ship.</h3>
<div>
<form name="setup" method="post" action="setup.php">
<table >
  <tr>
    <td>Your name: </td>
    <td><input type="text" maxlength="200" name="capname" id="capname"/></td>
  </tr>
  <tr>
    <td>Your Ship\'s name:</td>
    <td><input type="text" maxlength="200" name="shipname" id="shipname"/></td>
    
  </tr>

    <tr>
    <td>Your Ship\'s class:</td>
    <td><select name="class">
  <option value="1">Mid</option>
  <option value="2">Defense Specialist</option>
  <option value="3">Attack Specialist</option>
</select></td>
    
  </tr>
  <tr>
    
    <td><input type="submit" value="Good luck!" /> </td>
    <td></td>
  </tr>
</table>
</form>
</div>
';
        } else if (isset($_POST['capname']) && $_POST['capname'] == '' || isset($_POST['shipname']) && $_POST['shipname'] == '' || isset($_POST['class']) && $_POST['class'] == '') {
            echo "Blank fields please return.";
        } else {
//echo "SAY";

//$result2=mysql_query("SELECT * FROM user WHERE userid='$userid'");
            $capname = sanitizeString($_POST['capname']);
            $shipname = sanitizeString($_POST['shipname']);
            $shipclass = sanitizeString($_POST['class']);

            /*$result3=mysql_query("INSERT INTO inventory VALUES('$userid','1000', NULL)") or die (mysql_error()."NUM1");
            $result3s=mysql_query("SELECT * FROM inventory WHERE userid='$userid'")or die (mysql_error()."NUM2");
            $row0= mysql_fetch_assoc($result3s);
            $invid = $row0['inventoryid'];*/

            if ($shipclass == 1) {
                $result4 = mysql_query("INSERT INTO ship VALUES(NULL,'$userid','$shipname','1','1000','1000','100','0','0','0','0','$shipclass','700','700') ") or die (mysql_error() . "NUM3");
                $result4s = mysql_query("SELECT * FROM ship WHERE userid='$userid'") or die (mysql_error() . "NUM4");
                $row1 = mysql_fetch_assoc($result4s);
                $shipid = $row1['shipid'];
            } else if ($shipclass == 2) {
                $result4 = mysql_query("INSERT INTO ship VALUES(NULL,'$userid','$shipname','1','800','1200','100','0','0','0','0','$shipclass','500','1000') ") or die (mysql_error() . "NUM3i");
                $result4s = mysql_query("SELECT * FROM ship WHERE userid='$userid'") or die (mysql_error() . "NUM4i");
                $row1 = mysql_fetch_assoc($result4s);
                $shipid = $row1['shipid'];

            } else {
                $result4 = mysql_query("INSERT INTO ship VALUES(NULL,'$userid','$shipname','1','1200','800','100','0','0','0','0','$shipclass','1000','500') ") or die (mysql_error() . "NUM3ii");
                $result4s = mysql_query("SELECT * FROM ship WHERE userid='$userid'") or die (mysql_error() . "NUM4ii");
                $row1 = mysql_fetch_assoc($result4s);
                $shipid = $row1['shipid'];

            }
            $result5 = mysql_query("INSERT INTO userinfo VALUES('$userid','$capname','1000','$shipid','33','10000')") or die (mysql_error() . "NUM5");

            $result6 = mysql_query("UPDATE user SET setup=TRUE,active=TRUE WHERE userid='$userid'") or die (mysql_error() . "NUM6");

//$setup = $row0["setup"];
            header("Location:home.php");
        }
    }
} else {
    header("Location:index.php");
}
?>


<?php
include_once 'footer.php';
?>
