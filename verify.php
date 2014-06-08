<?php
include_once 'start.php';
?>
<?php
$confirm = $confirm1 = "";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {

    header("Location:index.php");


} else if (!isset($_SESSION['loggedin'])) {


    if (isset($_GET['confirm']) && !empty($_GET['confirm']) AND isset($_GET['mail']) && !empty($_GET['mail'])) {

        $email = $_GET['mail'];
        $confirm = $_GET['confirm'];

        $result = mysql_query("SELECT * FROM user WHERE email='$email' and verifycode='$confirm'") or die (mysql_error());

        if (mysql_num_rows($result) == 1) {
            $result1 = mysql_query("UPDATE user SET verify=TRUE WHERE email='$email'") or die (mysql_error());

            header("refresh:5;url=index.php");
            echo "YOOOO" . $confirm1;
            echo "<h1>Your account has been succesfully verified! Please wait to be redirected to the login page or click <a href='index.php'>here.</a></h1>";
        } else {
            echo "<h1>UH OHHHHHH</h1>";
        }
    } else {
        echo "<h1>UH OHHHHHH</h1>";

    }
} else {

    echo "<h1>UH OHHHHHH</h1>";
}

?>


<?php
include_once 'footer.php';
?>
