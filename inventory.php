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

        echo '<div id="game">
<h2>
Inventory
</h2>
';
        $result = mysql_query("SELECT * FROM inventory WHERE playerid='$userid'");
        $itemcheck = mysql_num_rows($result);

        if ($itemcheck == 0) {
            echo "<h3>No items in your inventory!</h3>";
        } else {
            echo "<br /><table >";
            echo "<tr><th class='table1'>Item Name</th><th class='table2'>Quantity</th></tr>";


            while ($row = mysql_fetch_array($result)) {
                $quantity = $row['quantity'];
                $itemid = $row['itemid'];

                $herego1 = mysql_query("SELECT * FROM items WHERE itemid='$itemid'");

                $row2 = mysql_fetch_assoc($herego1);
                $itemname = $row2["name"];
//$shiplevel = $row2["level"];


                echo "<tr><td class='table1'><a href='useitem.php?id=$itemid'>$itemname</a></td>
<td class='table2'>$quantity";
                echo "</td></tr>";

            }
            echo "</table>";
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
