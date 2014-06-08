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

        if (isset($_GET['id'])) {

            $jobid = $_GET['id'];
            $jobquery = mysql_query("SELECT * FROM joblog WHERE playerid='$userid' AND jobid='$jobid' AND active=TRUE");
            $jobqueryarray = mysql_fetch_assoc($jobquery);
            $timeend = $jobqueryarray["timeend"];
            $crewonmission = $jobqueryarray["crewonmission"];
//BEGIN
            $row2crewskill = $jobqueryarray['crewskill'];
            $row2jobskill = $jobqueryarray['jobskill'];


//END
            $jobquerycount = mysql_num_rows($jobquery);

            if ($jobquerycount == 0) {

                include_once 'header.php';


                echo '<div id="game">
<h2>
Job
</h2>
 <h3>This job does not exist!</h3>';

            } //else if($timeend>=strtotime('now')){
            else if (strtotime('+1 day') <= strtotime('now')) {
                include_once 'header.php';

                echo '<head>

<script type="text/javascript" src="jquery.countdown.js"></script>
<link href="jquery.countdown.css" rel="stylesheet" type="text/css" />
';
                echo "<script type='text/javascript'>
$(document).ready(function(){
 
  
	var austDay = new Date($timeend*1000);
 $('#defaultCountdown').countdown({until: austDay, format: 'HMS'});

});";
                echo '</script> </head>';

                echo "<div id='game'>
<h2>
Job
</h2>
<h3>This mission has not been completed. Please return in:</h3>
 <h3><div style=''id ='defaultCountdown'></h3>";
            } else {

//$joblog=mysql_query("INSERT INTO joblog VALUES(NULL,'$userid','$crewid','$skill','$jobskilloffer','$timestuff','$timeend','','','','','','$locationid',TRUE,'$crewpost')")or die (mysql_error()."CRAP");
                $result32 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'") or die (mysql_error() . "THIS ERROR");
                $row30 = mysql_fetch_assoc($result32);
                $locationid = $row30["locationid"];

                $result33 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");
                $row31 = mysql_fetch_assoc($result33);
                $difficulty = $row31["difficulty"];

                $result34 = mysql_query("SELECT * FROM crew WHERE userid='$userid'");
                $row32 = mysql_fetch_assoc($result34);
                $crewlevel = $row32["level"];
                $speciality = $row32["speciality"];
                $crewexperience = $row32["experience"];


                if ($difficulty == 1) {
                    $exp = rand(200, 300);
                    if ($speciality == 1) {
                        $randgen = rand(0, 100);
                        if ($randgen <= 70) {
                            $item = 5;
                        } else {
                            $item = 6;
                        }

                    } else {
                        $randgen = rand(0, 100);
                        if ($randgen <= 70) {
                            $item = 6;
                        } else {
                            $item = 5;
                        }
                    }
                    $itemquantity = rand(5, 20);
                } else if ($difficulty == 2) {
                    $exp = rand(300, 500);
                    if ($speciality == 1) {
                        $randgen = rand(0, 100);
                        if ($randgen <= 70) {
                            $item = 7;
                        } else {
                            $item = 8;
                        }

                    } else {
                        $randgen = rand(0, 100);
                        if ($randgen <= 70) {
                            $item = 8;
                        } else {
                            $item = 7;
                        }
                    }
                    $itemquantity = rand(5, 20);
                } else if ($difficulty == 3) {
                    $exp = rand(500, 600);
                    if ($speciality == 1) {
                        $randgen = rand(0, 100);
                        if ($randgen <= 70) {
                            $item = 7;
                        } else {
                            $item = 8;
                        }

                    } else {
                        $randgen = rand(0, 100);
                        if ($randgen <= 70) {
                            $item = 8;
                        } else {
                            $item = 7;
                        }
                    }
                    $itemquantity = rand(15, 30);
                } else {
                    $exp = rand(600, 1000);
                    if ($speciality == 1) {
                        $randgen = rand(0, 100);
                        if ($randgen <= 70) {
                            $item = 11;
                        } else {
                            $item = 12;
                        }

                    } else {
                        $randgen = rand(0, 100);
                        if ($randgen <= 70) {
                            $item = 12;
                        } else {
                            $item = 11;
                        }
                    }
                    $itemquantity = rand(1, 3);
                }

                $expoffer = $exp * $crewlevel - 100;
                $expfail = $expoffer / 2;


                $div = floor($row2crewskill / $row2jobskill * 100);
                $div = min($div, 99);
                $div = max($div, 1);
                $random = (rand(0, 100));

                if ($random <= $div) {
                    $result6 = mysql_query("UPDATE crew SET onmission=onmission-$crewonmission WHERE userid='$userid'") or die (mysql_error() . "UH OHHHH");
                    $result7 = mysql_query("UPDATE joblog SET success=TRUE, experience=experience+'$expoffer', active=FALSE, itemid= '$item', itemquantity='$itemquantity' WHERE jobid='$jobid'") or die (mysql_error() . "THIS ERROR");
                    $result1126 = mysql_query("UPDATE crew SET experience=experience+$expoffer WHERE userid='$userid'") or die (mysql_error() . "UH OHHHH");


                    $result340 = mysql_query("SELECT * FROM inventory WHERE playerid='$userid' AND itemid='$item'");
                    $row340 = mysql_fetch_assoc($result340);

                    $result3407 = mysql_query("SELECT * FROM items WHERE itemid='$item'");
                    $row3407 = mysql_fetch_assoc($result3407);
                    $itemname = $row3407['name'];


                    $itemcount = mysql_num_rows($result340);

                    if ($itemcount == 0) {

                        $result500 = mysql_query("INSERT INTO inventory VALUES('$userid','$item','$itemquantity')") or die (mysql_error() . "CRAP");
                    } else {
                        $result800 = mysql_query("UPDATE inventory SET quantity=quantity+$itemquantity WHERE playerid='$userid' AND itemid='$item'") or die (mysql_error() . "UH OHHHH");
                    }

                    $power = pow($crewlevel, 3);

                    $levelup = $crewlevel * 500 + $power;

                    $skillup = $level + $power * 400;


                    if ($crewexperience > $crewlevel * 500 + $power) {
                        $result4009 = mysql_query("UPDATE crew SET level=level+1 WHERE userid='$userid'");
                        $result4007skill = mysql_query("UPDATE crew SET skill=skill+$skillup WHERE userid='$userid'");

                    }
                    include_once 'header.php';
                    echo "<div id='game'>
<h2>
Job
</h2>
";
                    echo "<h3>Your mission was a success! You have gained $expoffer experience and $itemquantity $itemname(s)</h3>";
                } else {
                    $result6 = mysql_query("UPDATE crew SET onmission=onmission-$crewonmission WHERE userid='$userid'") or die (mysql_error() . "UH OHHHH");
                    $result7 = mysql_query("UPDATE joblog SET success=FALSE, experience=experience+'$expfail', active=FALSE  WHERE jobid='$jobid'") or die (mysql_error() . "UH OHHHH");
                    $result1126 = mysql_query("UPDATE crew SET experience=experience+$expfail WHERE userid='$userid'") or die (mysql_error() . "UH OHHHH");

                    $power = pow($crewlevel, 3);

                    $levelup = $crewlevel * 500 + $power;

                    $skillup = $level + $power * 400;


                    if ($crewexperience > $crewlevel * 500 + $power) {
                        $result4skill = mysql_query("UPDATE crew SET level=level+1 WHERE userid='$userid'");
                        $result47skill = mysql_query("UPDATE crew SET skill=skill+$skillup WHERE userid='$userid'");


                    }

//$result8=mysql_query("UPDATE joblog SET success=FALSE AND experience=experience-'$expfail' AND active=FALSE  WHERE userid='$jobid'")or die (mysql_error()."UH OHHHH");
                    include_once 'header.php';
                    echo "<div id='game'>
<h2>
Job
</h2>
";
                    echo "<h3>You have failed this job... You receive no items and your crew gains $expfail experience.</h3>";
                }

//$result6=mysql_query("UPDATE crew SET onmission=onmission-$crewonmission WHERE userid='$userid'")or die (mysql_error()."UH OHHHH");
//$result7=mysql_query("UPDATE joblog SET success=TRUE AND experience='$expoffer' AND active=FALSE AND AND itemquantity='$itemqyantity' WHERE userid='$jobid'")or die (mysql_error()."UH OHHHH");


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
