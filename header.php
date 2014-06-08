<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>

    <title>Space Captain!</title>
    <link href="reset.css" rel="stylesheet" type="text/css"/>
    <link href="styles.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="respond.min.js"></script>
</head>
<body>
<?php
$username = $userid = "";


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {
    $email = $_SESSION['email'];
    $userid = $_SESSION['userid'];
    echo "<noscript><div id='noscriptdiv'>The Space Captain works best with Javascript Enabled! :( </div></noscript>";
    echo '
<div id="wrapper">
<div id="top"><img style="width:90%" alt="alt" src="logo.png"/></div>';

    $result2 = mysql_query("SELECT * FROM user WHERE userid='$userid'");
    $row0 = mysql_fetch_assoc($result2);
    $setup = $row0["setup"];


    echo '<div id="sidebar"><ul>';
    if ($setup == TRUE) {
        echo '

<li><a href="home.php">Home</a></li>';
        $herego1 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");


        $row2 = mysql_fetch_assoc($herego1);
        $name = $row2["name"];
        $turns = $row2["turns"];
        $locationid = $row2["locationid"];
        $credit = $row2["credit"];

        $herego7 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");


        $row7 = mysql_fetch_assoc($herego7);

        $location = $row7["name"];


        $random_number = '8';
        if (strlen($name) > $random_number) {
            $font_size = '14pt';
        } else {
            $font_size = '18pt';
        }
//echo "<li style='font-size:$font_size'> Captain $username </li>";

//echo "<li> Captain's Profile </li>";


        $herego = mysql_query("SELECT * FROM ship WHERE userid='$userid'");


        $row1 = mysql_fetch_assoc($herego);
        $ship = $row1["name"];
        $level = $row1["level"];
        $attack = $row1["attack"];
        $defence = $row1["defence"];
        $shield = $row1["shield"];
        $shipid = $row1["shipid"];

        echo "
<li><a href='stats.php'>$ship</a></li>
<li><a href='inventory.php'>Inventory</a></li>

";
//<li>Stats</li>
        echo '
<li><a href="travel.php">Travel</a></li>';

        echo "<li><a href='location.php'>$location</a></li>";
        echo '<li><a href="ranking.php">Leaderboard</a></li>';

        $heregomessage = mysql_query("SELECT * FROM message WHERE receiverid='$userid' AND haveread=FALSE");

        $messagenum = mysql_num_rows($heregomessage);

        echo "<li><a href='messages.php'>Messages";
        if ($messagenum == '') {
            echo "";
        } else {
            echo "(" . $messagenum . ")";
        }
        echo "</a></li>";
    }
    echo '

<li><a href="logout.php">Logout</a></li>

</ul>';


    echo '

 </div>
 <div id="statbar">';

    /*$herego3 = mysql_query("SELECT * FROM inventory WHERE userid='$userid'");


    $row3 = mysql_fetch_assoc($herego3);
    $credit = $row3["credit"];*/
    if ($setup == TRUE) {
        echo "
<ul>
<li>Player's Location: $location </li>
<li>Player Turns: $turns </li>
<li>Player Credits: $credit </li>
<li>Ship Level: $level</li>
<li>Attack: $attack</li>
<li>Defence: $defence</li>
<li>Shield: $shield</li></ul>";


    }

    echo "</div>";

}
?>