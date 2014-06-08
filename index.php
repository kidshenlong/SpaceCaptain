<?php
include_once 'start.php';
?>
<?php
$passwdcaution = '';
$username = $passwd = $emailrec = $postcode = $usernamelogin = $passwdlogin = "";

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != '') {
    header("Location:home.php");
} else {
    if (isset($_POST['emaillogin']) && $_POST['emaillogin'] != '' && $_POST['passwdlogin'] != '' && isset($_POST['passwdlogin'])) {

        $emaillogin = sanitizeString($_POST['emaillogin']);
        $passwdlogin = sanitizeString($_POST['passwdlogin']);

//$passwdlogin0 = sanitizeString($_POST['passwdlogin']);

//$passwdlogin=md5($passwdlogin0);
        $passwdlogin = hash('sha256', $passwdlogin);


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
}
include_once 'header.php';

echo '<head>
<link href="login.css" rel="stylesheet" type="text/css" />
<script  type="text/javascript" src="jquery.placeholder.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    
	$("input, text").placeholder();

});
</script></head>';

echo <<<_END


<div id='logo'>
<img alt="logo" src="logo.png"/>
</div>



<div id="form1">

<div id="login">
 <form name="login" method="post" action="index.php">
<table >
  <tr><td><input type="text" maxlength="80" placeholder="Email"name="emaillogin" id="emaillogin" />   </td></tr>
		<tr><td style="color:white;">$emailcaution </td></tr>
      <tr><td><input type="password" maxlength="20" placeholder="Password" name="passwdlogin" id="passwdlogin" /></td></tr>
	  <tr><td style="color:white;">$passwdcaution </td></tr>
	  <tr><td><input type="submit" value="Login" name="loginbutton" id="loginbutton" /></td></tr>
    </table>
</form>
</div>
 </div>




<h2><!--<a href='forgotpassword.php'><s>Forgot Password?</s></a>--></h2>
</div>

_END;
?>
<?php
include_once 'footer.php';
?>
