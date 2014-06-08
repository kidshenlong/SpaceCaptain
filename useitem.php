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

        if (!isset($_POST['itemno'])) {
            $itemid = $_GET['id'];

            $result = mysql_query("SELECT * FROM inventory WHERE playerid='$userid' AND itemid='$itemid'") or die (mysql_error() . "UH OHHHH");
            $row = mysql_fetch_assoc($result);
            $quantity = $row['quantity'];
            $itemcheck = mysql_num_rows($result);

            $herego1 = mysql_query("SELECT * FROM items WHERE itemid='$itemid'");
            $row2 = mysql_fetch_assoc($herego1);
            $itemname = $row2["name"];
            $itemdesc = $row2["itemdesc"];
            $test = '';
            for ($i = 1; $i <= $quantity; $i++) {
                $test = $test . "<option value='$i'>$i</option>";
            }

            if ($itemcheck == 0) {

                echo "<div id='game'>
<h2>
$itemname
</h2>
";
                echo "<p>$itemdesc</p>";
                echo "<h3>You do not own this item or it does not exist!</h3>";
            } else {

                echo "<div id='game'>
<h2>
$itemname
</h2>
";

                echo "<p>$itemdesc</p>";
                echo "<form action='useitem.php' method='post'>Quantity:<select name='quantity'>$test</select><br /><input id='button'
 type='submit' value='Use item' />
 <input type='hidden' name='itemno' value='$itemid'>
 </form>";

                /*echo '<form action="travelto.php" method="post">
                <input type="hidden" name="travelto" value="travelto">
                <input id="button" type="submit" value="Travel Here!" />
                </form></div>';*/
            }
        } else if (isset($_POST['itemno']) && $_POST['itemno'] != '') {
            $itemid = $_POST['itemno'];
            $usequantity = $_POST['quantity'];

            $result13 = mysql_query("SELECT * FROM inventory WHERE playerid='$userid' AND itemid='$itemid'") or die (mysql_error() . "UH OHHHH");
            $row13 = mysql_fetch_assoc($result13);
            $quantity = $row13['quantity'];
            $itemcheck = mysql_num_rows($result13);

            if ($itemcheck == 0) {
                echo "<div id='game'>
<h2>
$itemname
</h2>
";

                echo "<h3>You do not own this item or it does not exist!</h3>";
            } else if ($usequantity > $quantity) {
                echo "<div id='game'>
<h2>
$itemname
</h2>
";

                echo "<h3>You do not have enough!</h3>";
            } else if ($usequantity <= 0) {
                echo "<div id='game'>
<h2>
$itemname
</h2>
";

                echo "<h3>This is a negative number!</h3>";
            } else {
                $timestuff = strtotime('now');

                echo "<div id='game'>
<h2>
$itemname
</h2>
";
                echo "<h3>You have successfully used your item.</h3>";

                $result61 = mysql_query("UPDATE inventory SET quantity=quantity-$usequantity WHERE playerid='$userid' AND itemid='$itemid'") or die (mysql_error() . "UH OHHHH2");


                $result62 = mysql_query("INSERT INTO itemlog VALUES(NULL,'$userid','$itemid','-$usequantity','$timestuff')") or die (mysql_error() . "CRAP");

                $result13 = mysql_query("SELECT * FROM inventory WHERE playerid='$userid' AND itemid='$itemid'") or die (mysql_error() . "UH OHHHH");
                $row13 = mysql_fetch_assoc($result13);
                $quantity = $row13['quantity'];
                if ($quantity == 0) {

                    $result61 = mysql_query("DELETE FROM inventory WHERE playerid='$userid' AND itemid='$itemid'") or die (mysql_error() . "UH OHHHH2");


                }
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
