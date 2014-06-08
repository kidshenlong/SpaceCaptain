<?php
include_once 'start.php';
?>
<?php
$passwdcaution = '';
$username = $passwd = $emailrec = $postcode = $usernamelogin = $passwdlogin = "";

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
    if (isset($_POST['emaillogin']) && $_POST['emaillogin'] != '' && $_POST['passwdlogin'] != '' && isset($_POST['passwdlogin'])) {

        $emaillogin = sanitizeString($_POST['emaillogin']);
        $passwdlogin = sanitizeString($_POST['passwdlogin']);

//$passwdlogin0 = sanitizeString($_POST['passwdlogin']);

//$passwdlogin=md5($passwdlogin0);
//$passwdlogin=hash('sha256',$passwdlogin0);


        $herego = mysql_query("SELECT * FROM user WHERE email='$emaillogin' and passwd='$passwdlogin'");


        $row1 = mysql_fetch_assoc($herego);

//if (mysql_num_rows(queryMysql("SELECT * FROM temporaryusers WHERE user='$usernamelogin' and passwd='$passwdlogin' and active=TRUE")))
        if ( /*strcasecmp($row1['username'],$usernamelogin)==0 &&*/
            $row1['passwd'] == $passwdlogin && $row1['verify'] == TRUE
        ) {
            $_SESSION['userid'] = $row1['userid'];
            $_SESSION['email'] = $emaillogin;
            $_SESSION['passwd'] = $passwdlogin;
            $_SESSION['loggedin'] = TRUE;
            $timestuff = strtotime('now');
            $userid = $row1['userid'];
            $herego10 = mysql_query("UPDATE user SET lastlogin='$timestuff' WHERE userid='$userid'") or die (mysql_error());
            if ($row1['setup'] == TRUE) {
                $herego11 = mysql_query("UPDATE user SET active=TRUE WHERE userid='$userid'") or die (mysql_error());
                header("Location:home.php");
            } else {
                header("Location:setup.php");
            }
            $passwdcaution = "RADICAL";
        } else if ($row1['passwd'] == $passwdlogin && $row1['verify'] == FALSE) {
            $passwdcaution = "Your account has not been verified yet...";
        } else {
            $passwdcaution = "Wrong Password? Please try again!";
        }
    }
//AIL;FBSE;FGBSE'FGKNES'LFKSNE'FK REGISTER


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

    if ($passwdregister == $passwdregister2) {
        if (strlen($passwdregister) < 8) {
            $passwdcaution = "Password is too short!";
        } else {
            $passwdstring = $passwdregister;
        }

    } else {
        $passwdcaution = "Passwords do not match!";
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
    }


}
include_once 'header.php';


echo '<link href="login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.placeholder.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    
	$("input, text").placeholder();
	
       $("#register").hide();
       $("#loginb").hide();

	   $("#registerb").show();

	   $("#register").css( "top", "25px" );
    
  $("#loginb").click(function(){
        $("#loginb").fadeOut();
      
 $("#registerb").fadeIn();
 $("#register").fadeOut();
       $("#form1").animate({height:"120"});
 $("#login").fadeIn();
     

  });

  $("#registerb").click(function(){
    
     $("#registerb").fadeOut();
$("#loginb").fadeIn();
   $("#login").fadeOut();
       $("#form1").animate({height:"150"});
       $("#register").fadeIn();
      
        


  });
});

</script>';

echo <<<_END
</head>

<body>
<div id='logo'>
<img src="logo.png"/>
</div>
<div id="form1">
<input type="button" id="loginb" value="login"/>  
        <input type="button" id="registerb" value="register"/>


<div id="login">
 <form name="login" method="post" action="newindex.php">
<table >
  <tr><td><input type="text" maxlength="80" placeholder="Email"name="emaillogin" id="emaillogin" />   </td></tr>
      <tr><td><input type="password" maxlength="20" placeholder="Password" name="passwdlogin" id="passwdlogin" /></td><td>$passwdcaution</td></tr>
	  <tr><td><input type="submit" value="Login" name="loginbutton" id="loginbutton" /></td></tr>
    </table>
</form>

</div>
<div id="register">
 <form name="register" method="post" action="newindex.php">
<table >
  <tr><td><input type="text" maxlength="80" placeholder="Email" name="emaillogin" id="emaillogin" /></td><td>$emailcaution</td></tr>
        <tr><td><input type="password" maxlength="20" placeholder="Password" name="passwdregister1" id="passwdlogin1" /> </td><td>$passwdcaution</td></tr>
           <tr><td><input type="password" maxlength="20" placeholder="Verify Password" name="passwdregister2" id="passwdlogin2" /></td><td>$passwdcaution2</td></tr>
		   <tr><td><input type="submit" value="Register" name="registerbutton" id="registerbutton" /></td></tr>
    
    </table>
</form>

</div>
    </div>
  

</body>
</html>

_END;
?>
<?php
include_once 'footer.php';
?>