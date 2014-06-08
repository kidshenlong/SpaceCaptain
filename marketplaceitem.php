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
        $locationid = $row["locationid"];
        $credits = $row["credit"];

        $result2 = mysql_query("SELECT * FROM location WHERE locationid='$locationid' AND marketplace=TRUE");
        $row2 = mysql_fetch_assoc($result2);
        $marketplacecheck = mysql_num_rows($result2);

        if ($marketplacecheck == 0) {
            include_once 'header.php';
            echo '
<div id="game">
<h2>
Marketplace
</h2><h3>There are no marketplaces in this sector!</h3>';

        } else if (isset($_POST['buyitnow'])) {


            $buyitemid = $_POST['buyitnow'];

            $herego10 = mysql_query("SELECT * FROM marketplace WHERE marketplaceid='$buyitemid'");

            $resubmitcheck = mysql_num_rows($herego10);
            if ($resubmitcheck == 0) {
                include_once 'header.php';
                echo '
<div id="game">
<h2>
Marketplace
</h2><h3>This item does not exist!</h3>';

            } else {

                $row20 = mysql_fetch_assoc($herego10);
                $solditemid = $row20["itemid"];
                $sellerid = $row20["userid"];
                $costofitem = $row20["cost"];
                $quantityofitem = $row20["quantity"];

                if ($costofitem > $credits) {
                    include_once 'header.php';
                    echo '
<div id="game">
<h2>
Marketplace
</h2><h3>Unfortunately you do not have enough credits!</h3>';

                } else {
                    $herego101 = mysql_query("SELECT * FROM inventory WHERE itemid='$solditemid' AND playerid='$sellerid'");

                    $duplicatecheck = mysql_num_rows($herego101);
                    if ($duplicatecheck == 0) {
                        $result68 = mysql_query("INSERT INTO inventory VALUES('$userid','$solditemid','$quantityofitem')") or die (mysql_error() . "CRAP");
                    } else {
                        $result602 = mysql_query("UPDATE inventory SET quantity=quantity+$quantityofitem WHERE playerid='$userid' AND itemid='$solditemid'") or die (mysql_error() . "UH OHHHH2");
                    }
                    $result612 = mysql_query("UPDATE userinfo SET credit=credit-$costofitem WHERE userid='$userid'") or die (mysql_error() . "UH OHHHH2");
                    $result613 = mysql_query("UPDATE userinfo SET credit=credit+$costofitem WHERE userid='$sellerid'") or die (mysql_error() . "UH OHHHH2");

                    $result61 = mysql_query("DELETE FROM marketplace WHERE marketplaceid='$buyitemid'") or die (mysql_error() . "UH OHHHH2");

                    $timestuff = strtotime('now');
                    $result68 = mysql_query("INSERT INTO marketplacebuylog VALUES(NULL,$buyitemid,'$sellerid','$solditemid','$costofitem','$userid','$timestuff','$locationid','$quantityofitem')") or die (mysql_error() . "CRAP");

                    include_once 'header.php';
                    echo '
<div id="game">
<h2>
Marketplace
</h2><h3>Successfully bought this item!</h3>';
                }
            }
        } else if (!isset($_POST['buyitnow'])) {
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
            echo '
<div id="game">
<h2>
Marketplace
</h2><h3>M\'Okay!</h3>';


            $result70 = mysql_query("SELECT * FROM marketplace WHERE locationid='$locationid' AND userid!='$userid'");
            $itemcheck = mysql_num_rows($result70);


            if ($itemcheck == 0) {
                echo "<h3>No one has listed any items on this marketplace! location:$locationid and $userid</h3>";
            } else {
                echo "<br /><table >";
                echo "<tr><th>Item Name</th><th>Quantity</th><th>Price</th><th>Seller</th></tr>";


                while ($row = mysql_fetch_array($result70)) {

                    $quantity = $row['quantity'];
                    $marketplaceid = $row['marketplaceid'];
                    $itemid = $row['itemid'];
                    $price = $row['cost'];
                    $sellerid = $row['userid'];

                    $herego1 = mysql_query("SELECT * FROM items WHERE itemid='$itemid'");

                    $row2 = mysql_fetch_assoc($herego1);
                    $itemname = $row2["name"];
                    $itemdesc = $row2["itemdesc"];

                    $herego2 = mysql_query("SELECT * FROM userinfo WHERE userid='$sellerid'");

                    $row3 = mysql_fetch_assoc($herego2);
                    $sellername = $row3["name"];

                    echo "<tr  class='itemmain'><td class='clickme'>$itemname</td>
<td>$quantity</td><td>$price Credit(s)</td><td>Captain $sellername</td>";
                    echo "</tr>";

                    echo "<tr class='itemhide'><td colspan='4'>Item Description: $itemdesc.<br />
<form action='marketplaceitem.php' method='post'><input style='float: right;' id='button'
 type='submit' value='Buy item(s)' /> <input type='hidden' name='buyitnow' value='$marketplaceid'></form>";


                }
                echo "</table>";
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
