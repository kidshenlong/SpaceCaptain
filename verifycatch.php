<?php

if (isset($_GET['confirm'])) {


    $confirm = $_GET['confirm'];
    //echo $confirm;
    //echo $captchaRef = $_SESSION['captchastring'];

    /*$result=mysql_query("SELECT * FROM user WHERE verifycode='$confirm'");
$row= mysql_fetch_assoc($result);*/
//echo $email = $row["email"];
    header("Location:verify.php");
} else {
    header("Location:index.php");

}
?>