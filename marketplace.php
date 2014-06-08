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

        $result = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
        $row = mysql_fetch_assoc($result);
        $location = $row["locationid"];

        $result2 = mysql_query("SELECT * FROM location WHERE locationid='$location' AND marketplace=TRUE ");
        $row2 = mysql_fetch_assoc($result2);
        $marketplacecheck = mysql_num_rows($result2);

        if ($marketplacecheck == 0) {
            echo '
<div id="game">
<h2>
Marketplace
</h2><h3>There are no marketplaces in this sector!</h3>';

        } else {
            echo "
		<div id='game'>
		<h2>
		Marketplace
		</h2>
		<h3>
		<ul>
		<li><a href='listitem.php'>List item</a></li>

<li><a href='marketplaceitem.php'>Buy item!</a></li>

</ul>
</h3>
			";
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
