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
Game
</h2>';
        $result3 = mysql_query("SELECT * FROM ship WHERE userid='$userid'");
        $row3 = mysql_fetch_assoc($result3);
        $experience = $row3["experience"];
        $level = $row3["level"];

        $result4 = mysql_query("UPDATE ship SET experience=experience+100 WHERE userid='$userid'");

        echo '
</div>
';

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
