<?php
include_once 'start.php';
?>
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {
    function truncate($mytext)
    {
//Number of characters to show  
        $chars = 25;
        $mytext = substr($mytext, 0, $chars);
        $mytext = substr($mytext, 0, strrpos($mytext, ' '));
        return $mytext . "...";
    }

    $userid = $_SESSION['userid'];

    $result2 = mysql_query("SELECT * FROM user WHERE userid='$userid'");
    $row0 = mysql_fetch_assoc($result2);
    $setup = $row0["setup"];
    if ($setup == TRUE) {
        include_once 'header.php';


        $result = mysql_query("SELECT * FROM message WHERE receiverid='$userid'");
        echo "<div id='game'>
<h2>
Message Inbox
</h2>
<table >";
        echo "<tr><th>Sender</th><th>Location</th><th>Message</th></tr>";


        while ($row = mysql_fetch_array($result)) {

            $senderid = $row['senderid'];
            $message = $row['message'];
            $messageid = $row['messageid'];

            $herego = mysql_query("SELECT * FROM userinfo WHERE userid='$senderid'");


            $row98 = mysql_fetch_assoc($herego);


            $locationid = $row98["locationid"];
            $sendername = $row98["name"];

            $herego2 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");
            $row99 = mysql_fetch_assoc($herego2);

            $locationname = $row99["name"];


            echo "<tr><td class='table1'><a href=''>Captain $sendername</a></td>
<td>$locationname</td><td><a href='viewmessage.php?id=$messageid'>";
            echo truncate($message) . "</a>";
            echo "</td></tr>";

        }
        echo "</table>";


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
