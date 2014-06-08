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
        echo '
<div id="game">
<h2>
Home
</h2>';

        if (isset($_GET['id'])) {

            $playerid = $_GET['id'];

            $result = mysql_query("SELECT * FROM userinfo WHERE userid='$playerid'");
            $row = mysql_fetch_assoc($result);
            $usernum = mysql_num_rows($result);
            if ($userid == $playerid) {
                echo "<h3>You cannot message yourself!</h3>";
            } else if ($row > 0) {
                $locationid = $row["locationid"];

                $name = $row["name"];
                $herego7 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");


                $row7 = mysql_fetch_assoc($herego7);

                $location = $row7["name"];


                $result1 = mysql_query("SELECT * FROM ship WHERE userid='$playerid'");
                $row1 = mysql_fetch_assoc($result1);
                $shipname = $row1["name"];


                echo '<p>';
                echo " Message Captain " . $name . "<br />";
                echo "Currently Located at " . $location . "<br />";
                echo '</p>';


                echo '<form action="sendmessage.php" method="post">
<textarea name="message" id="message" rows="15" cols="80"></textarea><br /><p>
<br />
<div id="w_count">

</div>
<br />
    <input type="submit" value="Send Message" /></p>';
                echo " <input type='hidden' name='messagerec' id='messagerec' value='$playerid'/>
	</form>";

            } else {
                echo "<h3>This Player does not exist!</h3>";
            }
        } else if (isset($_POST['messagerec']) && $_POST['messagerec'] != '') {

            $playerid = $_POST['messagerec'];

            $result10 = mysql_query("SELECT * FROM userinfo WHERE userid='$playerid'");
            $row10 = mysql_fetch_assoc($result10);
            $usernum10 = mysql_num_rows($result10);

            if ($userid == $playerid) {
                echo "<h3>You cannot message yourself!</h3>";
            } else if ($usernum10 == 0) {
                echo "<h3>This player does not exist!</h3>";
            } else {

                if ($_POST['message'] == '') {
                    echo "<h3>Blank Message! Please try again!</h3>";
                } else {


                    $usermessage = sanitizeString($_POST['message']);
                    $timestuff = strtotime('now');
                    $result3 = mysql_query("INSERT INTO message VALUES(NULL,'$userid','$playerid','$usermessage','$timestuff','0')") or die (mysql_error() . "UH OHHHH");
                    if (isset($result3)) {
                        echo "<h3>Your message has been successfully sent!<h3>";
                        echo "<h4>$usermessage</h4>";
                    }

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
