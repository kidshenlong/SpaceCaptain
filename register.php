<?php
include_once 'start.php';
?>
<?php
$emailcaution = $passwdcaution = $passwdcaution2 = '';
$$emailregister = $passwdregister = $passwdregister2 = '';

function generateRandomString($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != '') {
    header("Location:home.php");
} else {
//First Email catch	
    if (isset($_POST['emailregister']) && $_POST['emailregister'] != '') {

        if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $_POST['emailregister'])) {
            $emailcaution = "This is not a valid email address. Please try again!";
        } else {
            $duplicatetest = strtolower($_POST['emailregister']);
            $result1 = mysql_query("SELECT * FROM user WHERE email='$duplicatetest'") or die (mysql_error());
            $row1 = mysql_fetch_assoc($result1);
            $duplicatenum = mysql_num_rows($result1);

            if ($duplicatenum > 0) {
                $emailcaution = "This email is already registered!";
            } else {
                $emailregister = strtolower(sanitizeString($_POST['emailregister']));
            }
        }
    } else if (isset($_POST['emailregister']) && $_POST['emailregister'] == '') {

        $emailcaution = "Please enter an Email Address";

    }

//First Password catch
    if (isset($_POST['passwdregister1']) && $_POST['passwdregister1'] != '') {

        $passwdregister = sanitizeString($_POST['passwdregister1']);
    } else if (isset($_POST['passwdregister1']) && $_POST['passwdregister1'] == '') {

        $passwdcaution = "Please enter a password here!";

    }
//Second Password catch
    if (isset($_POST['passwdregister2']) && $_POST['passwdregister2'] != '') {

        $passwdregister2 = sanitizeString($_POST['passwdregister2']);
    } else if (isset($_POST['passwdregister2']) && $_POST['passwdregister2'] == '') {

        $passwdcaution2 = "Please enter a password here!";

    }
    if (isset($_POST['passwdregister1']) && $_POST['passwdregister1'] != '' && isset($_POST['passwdregister2']) && $_POST['passwdregister2'] != '') {
        if ($passwdregister == $passwdregister2) {
            if (strlen($passwdregister) < 8) {
                $passwdcaution = "Password is too short!";
            } else {
                //$passwdlogin=hash('sha256',$passwdlogin);
                $passwdstring = hash('sha256', $passwdregister);
            }

        } else {
            $passwdcaution = "Passwords do not match!";
        }
    }

    if ($emailregister != '' && $passwdstring != '') {
        $shenlong0 = generateRandomString(32);
        $shenlong = "www.sc.atomichael.com/verify.php?confirm=" . $shenlong0;

        $result1 = mysql_query("SELECT * FROM user WHERE verifycode='$shenlong0'") or die (mysql_error());
        //$row1= mysql_fetch_assoc($result1);
        //if (mysql_num_rows($result1) != NULL) {
        //if($row1!=''){
        $num_results = mysql_num_rows($result1);
        if ($num_results > 0) {
            echo "repeat";
            $shenlong0 = generateRandomString(32);
            $shenlong = "www.sc.atomichael.com/verify.php?confirm=" . $shenlong0;
        }


        $timestuff = strtotime('now');
        $query = "INSERT INTO user VALUES(NULL,'$emailregister', '$passwdstring', '$timestuff', FALSE, FALSE,FALSE, '$shenlong0')";
        $result = mysql_query($query);
        if (!$result) die ("Database access failed: " . mysql_error());

        else {
            $subject = "You've successfully registered";

            $headers = 'From: DoNotreply@atomichael.com' . "\r\n" .
                'Reply-To: DoNotReply@atomichael.com' . "\r\n" . "Content-type: text/html";
            $message = "<html><head></head><body><p>Hi, Please follow this link to verify<p><br />";
            $message .= $shenlong . "&mail=" . $emailregister . "</body></html>";
            if (mail($emailregister, $subject, $message, $headers)) {
                echo("<p>Verification email successfully sent to</p>" . $emailregister . "<p>Please check your emails and follow the instructions before trying to log in.</p>");
            } else {
                echo("<p>Message delivery failed...</p>");
            }
        }
    } else {

        include_once 'header.php';
        echo '<head>
<link href="login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(document).ready(function(){
    
	$("input, text").placeholder();

});
</script></head>';

        echo <<<_END


<div id='logo'>
<img alt ="logo" src="logo.png"/>
</div>
<div id="registerForm">



	<div id="form1">

<div id="register">
 <form name="register" method="post" action="register.php">
<table >
  <tr><td><input type="text" maxlength="80" placeholder="Email" name="emailregister" id="emaillogin" /></td></tr>
	<tr><td style="color:white;">$emailcaution</td></tr>
        <tr><td><input type="password" maxlength="20" placeholder="Password" name="passwdregister1" id="passwdlogin1" /> </td></tr>
	<tr><td style="color:white;">$passwdcaution</td></tr>
           <tr><td><input type="password" maxlength="20" placeholder="Verify Password" name="passwdregister2" id="passwdlogin2" /></td></tr>
	<tr><td style="color:white;">$passwdcaution2</td></tr>
		   <tr><td><input type="submit" value="Register" name="registerbutton" id="registerbutton" /></td></tr>
    
    </table>
</form>

</div>
    </div>

_END;
    }
}
?>
<?php
include_once 'footer.php';
?>
