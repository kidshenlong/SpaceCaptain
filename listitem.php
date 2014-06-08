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

        $result = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
        $row = mysql_fetch_assoc($result);
        $location = $row["locationid"];

        $result2 = mysql_query("SELECT * FROM location WHERE locationid='$location' AND marketplace=TRUE ");
        $row2 = mysql_fetch_assoc($result2);
        $marketplacecheck = mysql_num_rows($result2);

        if ($marketplacecheck == 0) {
            include_once 'header.php';
            echo '
<div id="game">
<h2>
Marketplace
</h2><h3>There are no marketplaces in this sector!</h3>';

        } else if (!isset($_POST['itemno'])) {
            include_once 'header.php';
            echo "<head>
	<script type='text/javascript'>
	$(document).ready(function () {
   $('.itemhide').hide();

    $('.itemmain').click(function () {
       
        $(this).closest('tr').next().toggle();
    });

});
</script>
<style type='text/css'>
.clickme{
	color:blue;
text-decoration:underline;
cursor:pointer;
}
.itemhide{
text-align:left;
}
</style>
	</head>";


            $result = mysql_query("SELECT * FROM inventory WHERE playerid='$userid'");
            $itemcheck = mysql_num_rows($result);
            echo '<div id="game">
<h2>
Inventory
</h2>
';

            if ($itemcheck == 0) {
                echo "<h3>No items in your inventory!</h3>";
            } else {
                echo "<br /><table >";
                echo "<tr><th>Item Name</th><th>Quantity</th></tr>";


                while ($row = mysql_fetch_array($result)) {

                    $quantity = $row['quantity'];
                    $itemid = $row['itemid'];

                    $quantitydrop = '';
                    for ($i = 1; $i <= $quantity; $i++) {
                        $quantitydrop = $quantitydrop . "<option value='$i'>$i</option>";
                    }

                    $herego1 = mysql_query("SELECT * FROM items WHERE itemid='$itemid'");

                    $row2 = mysql_fetch_assoc($herego1);
                    $itemname = $row2["name"];
                    $itemdesc = $row2["itemdesc"];
//$shiplevel = $row2["level"];


                    echo "<tr class='itemmain'><td class='clickme'>$itemname</td>
<td >$quantity</td></tr>";

                    echo "<tr class='itemhide'><td colspan='2'>Description: $itemdesc.<br />
<form action='listitem.php' method='post'>Quantity:<select name='quantity'>$quantitydrop</select><input type='hidden' name='itemno' value='$itemid'>Price:<input type='text' name='price'><input style='float: right;' id='button'
 type='submit' value='List item(s)' /> </form>

</td></tr> ";

                }
                echo "</table>";


            }
            echo "</div>";
        } else {
            include_once 'header.php';
            $itemid = $_POST['itemno'];
            $usequantity = $_POST['quantity'];
            $price = $_POST['price'];

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
            } else if (!is_numeric($price)) {
                echo "<div id='game'>
<h2>
$itemname
</h2>
";

                echo "<h3>This is not a number!</h3>";

            } else if ($usequantity > $quantity) {
                echo "<div id='game'>
<h2>
$itemname
</h2>
";

                echo "<h3>You do not have enough!</h3>";
            } else if ($price <= 0) {
                echo "<div id='game'>
<h2>
$itemname
</h2>
";

                echo "<h3>You cannot sell your item for a negative price!</h3>";
            } else if ($usequantity <= 0) {
                echo "<div id='game'>
<h2>
$itemname
</h2>
";

                echo "<h3>This is a negative number!</h3>";
            } else {

                $result9 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
                $row9 = mysql_fetch_assoc($result9);
                $location = $row9["locationid"];
                $timestuff = strtotime('now');

                $result62 = mysql_query("INSERT INTO marketplace VALUES(NULL,$location,'$userid','$itemid','$price','$quantity','$timestuff')") or die (mysql_error() . "CRAP");

                $herego20 = mysql_query("SELECT * FROM marketplace WHERE userid='$userid' ORDER BY marketplaceid DESC") or die(mysql_error());
                $num_results = mysql_num_rows($herego20);
                $row20 = mysql_fetch_assoc($herego20);
                $marketplaceid = $row20['marketplaceid'];


                $result68 = mysql_query("INSERT INTO marketplaceselllog VALUES(NULL,$marketplaceid,'$userid','$itemid','$price','$timestuff','$location','$quantity')") or die (mysql_error() . "CRAP");


                $result61 = mysql_query("UPDATE inventory SET quantity=quantity-$usequantity WHERE playerid='$userid' AND itemid='$itemid'") or die (mysql_error() . "UH OHHHH2");

                $result61 = mysql_query("UPDATE userinfo SET credit=credit-$price WHERE userid='$userid'") or die (mysql_error() . "UH OHHHH2");

                $result13 = mysql_query("SELECT * FROM inventory WHERE playerid='$userid' AND itemid='$itemid'") or die (mysql_error() . "UH OHHHH");
                $row13 = mysql_fetch_assoc($result13);
                $quantity = $row13['quantity'];
                if ($quantity == 0) {

                    $result61 = mysql_query("DELETE FROM inventory WHERE playerid='$userid' AND itemid='$itemid'") or die (mysql_error() . "UH OHHHH2");
//echo "DELETE ME";

                }

                echo '<div id="game">
<h2>
Inventory
</h2>
<h3>Item succesfully listed.</h3>';
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
