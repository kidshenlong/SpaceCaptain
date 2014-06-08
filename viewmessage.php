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

        $topdiv = '
<div id="game">
<h2>
Message
</h2>';

        if (isset($_GET['id'])) {

            $messageid = $_GET['id'];

            $result200 = mysql_query("SELECT * FROM message WHERE messageid='$messageid'");
            $row200 = mysql_fetch_assoc($result200);
            $message = $row200["message"];
            $receiverid = $row200['receiverid'];
            $haveread = $row200['haveread'];
            $senderid = $row200['senderid'];

            if ($receiverid == $userid) {
                if ($haveread == FALSE) {
                    $result700 = mysql_query("UPDATE message SET haveread=TRUE WHERE messageid='$messageid'") or die (mysql_error());
                }
                include_once 'header.php';
                echo "

<script type='text/javascript'>
counter = function() {
    var value = $('#message').val();

    if (value.length == 0) {
        $('#w_count').html('Word Count: '+0);

        return;
    }

  var regex = /\s+/gi;
    var wordCount = value.trim().replace(regex, ' ').split(' ').length;

    $('#w_count').html('Word Count: '+wordCount);

};

$(document).ready(function() {
    $('#message').click(counter);
    $('#message').change(counter);
    $('#message').keydown(counter);
    $('#message').keypress(counter);
    $('#message').keyup(counter);
    $('#message').blur(counter);
    $('#message').focus(counter);
});
</script>

";
                echo $topdiv;
                echo "<table >
<tr><th>Message</th></tr>";
                echo "<tr><td>$message</td></tr></table>";

                echo "<table >
<tr><th>Reply</th></tr>";
                echo '<form action="viewmessage.php" method="post">
<tr><td><textarea name="message" id="message" rows="15" cols="80"></textarea>';
                echo "<input type='hidden' name='messagerec' id='messagerec' value='$senderid'/>";
                echo '</td></tr>
<tr><td><div id="w_count"></div></tr></td>
<tr><td><input type="submit" value="Send Message" /></td></tr></form> </table><br />';


            } else {
                include_once 'header.php';
                echo $topdiv;
                echo "<h3> This message cannot be viewed by you.</h3>";
            }
        } else if (isset($_POST['message']) && $_POST['message'] != '') {
            include_once 'header.php';
            $messagerec = $_POST['messagerec'];

            $result10 = mysql_query("SELECT * FROM userinfo WHERE userid='$messagerec'");

            $usernum10 = mysql_num_rows($result10);

            if ($messagerec == $userid) {
                echo $topdiv;
                echo "<h3> You cannot message yourself</h3>";
            } else if ($usernum10 == 0) {
                echo $topdiv;
                echo "<h3> This user does not exist</h3>";
            } else {
                echo $topdiv;

                $usermessage = sanitizeString($_POST['message']);
                $timestuff = strtotime('now');
                $result3 = mysql_query("INSERT INTO message VALUES(NULL,'$userid','$messagerec','$usermessage','$timestuff','0')") or die (mysql_error() . "UH OHHHH");
                if (isset($result3)) {
                    echo "<h3>Your message has been successfully sent!<h3>";
                    echo "<h4>$usermessage</h4>";
                }

            }
        } else if (isset($_POST['message']) && $_POST['message'] == '') {
            include_once 'header.php';
            echo $topdiv;
            echo "<h3>Your message is blank please return.</h3>";
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
