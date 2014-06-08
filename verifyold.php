<?php
include_once 'start.php';
?>
<?php
$confirm = $confirm1 = "";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {

    header("Location:index.php");


} else if (!isset($_SESSION['loggedin'])) {
    function genCaptcha()
    {
        $charArray = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '2', '3', '4', '6', '7', '8', '9');
        $captchaString = '';
        shuffle($charArray);
        for ($i = 0; $i < 8; $i++) $captchaString .= $charArray[$i];

        $_SESSION['captchastring'] = $captchaString;
    }

    if (isset($_GET['confirm'])) {


        //echo $confirm;
        //echo $captchaRef = $_SESSION['captchastring'];

        /*$result=mysql_query("SELECT * FROM user WHERE verifycode='$confirm'");
    $row= mysql_fetch_assoc($result);*/
//echo $email = $row["email"];
    }

    $result = mysql_query("SELECT * FROM user WHERE verifycode='$confirm'");
//$row= mysql_fetch_assoc($result);
    if (mysql_num_rows($result) == 0) {

        header("Location:index.php");
    } else {
        if (isset($_POST['captchacode']) && $_POST['captchacode'] != '') {

            //echo"I want my scalps!";
            $captchacode = $_POST['captchacode'];
            $captchaRef = $_SESSION['captchastring'];
            if (strcasecmp($captchaRef, $captchacode) == 0) {
                //if(strcasecmp('e',$captchacode)==0){

                $herego10 = mysql_query("UPDATE user SET verify=TRUE WHERE verifycode='$confirm'") or die (mysql_error());
                header("refresh:5;url=index.php");
                echo "YOOOO" . $confirm1;
                echo "<h1>Your account has been succesfully verified! Please wait to be redirected to the login page or click <a href='index.php'>here.</a></h1>";


            } else {
                genCaptcha();
            }
        } else {
            $result = mysql_query("SELECT * FROM user WHERE verifycode='$confirm'");
            $row = mysql_fetch_assoc($result);
            genCaptcha();
            //echo "one".$captchaRef = $_SESSION['captchastring'];
        }
        echo <<<_END


<body>


<div id="verify">

<h1>Please enter the Captcha Image below into the text box to successfully verify your account.</h1>
<form name="verify" method="post" action="verify.php">
<table > 
 <tr>
    <td>Email: </td>
    <td></td>
  </tr>
  <tr>
    <td><input type="text" maxlength="15" name="emaillogin" id="emaillogin"  /></td>
    <td></td>
    
  </tr>
  
  <tr>
    <td>Captcha: </td>
    <td></td>
  </tr>
  
  
  <tr>
    <td><img src="captcha.php" alt="CAPTCHA image" /> </td>
    <td></td>
  </tr>
  
  <tr>
    <td><input type="text" maxlength="8" name="captchacode" id="captchacode" /></td>
    <td><input type="submit" value="Verify" /></td>
    
  </tr>
 </table>
 </form>
 

  </div>
  </body>
</html>


	
	

_END;


    }
}



?>


<?php
include_once 'footer.php';
?>
