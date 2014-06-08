<?php
include_once 'start.php';
?>
<?php

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {

    $userid = $_SESSION['userid'];

    $result2 = mysql_query("SELECT * FROM user WHERE userid='$userid'");
    $row0 = mysql_fetch_assoc($result2);
    $setup = $row0["setup"];

    $result3 = mysql_query("SELECT * FROM ship WHERE userid='$userid'");
    $row3 = mysql_fetch_assoc($result3);
    $shipid = $row3["shipid"];

    $result37 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
    $row37 = mysql_fetch_assoc($result37);
    $locationid = $row37["locationid"];
    $credit = $row37["credit"];

    $result38 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");
    $row38 = mysql_fetch_assoc($result38);
    $difficulty = $row38["difficulty"];

    if ($setup == TRUE) {
//CREW VARIABLES
        $crewquery = mysql_query("SELECT * FROM crew WHERE userid='$userid'");
        $crewarray = mysql_fetch_assoc($crewquery);
        $speciality = $crewarray["speciality"];
        $size = $crewarray["size"];
        $crewlevel = $crewarray["level"];
        $skill = $crewarray["skill"];
        $crewid = $crewarray["crewid"];
        $onmission = $crewarray["onmission"];
        $usablecrew = $size - $onmission;

        $crewcount = mysql_num_rows($crewquery);


//END OF CREW VARIABLES
        //BUY SPECIALITY
        if ($crewcount == 0) {

            if (!isset($_POST['speciality'])) {


                include_once 'header.php';


                echo '<div id="game">
<h2>
Speciality
</h2>
';
                echo "<h3>To do jobs you must first acquire Speacialist Gear for your ship.</h3>";
                echo '<form method="post" action="speciality.php">
<input type="radio" name="speciality" value="0">Mining Geer - 10,000 credits <br />
<input type="radio" name="speciality" value="1">Engineering Geer - 10,000 credits <br />
<input type="submit" value="Submit">
</form>';
            } else if (isset($_POST['speciality']) && $_POST['speciality'] == 0 || $_POST['speciality'] == 1) {
                $speciality = $_POST['speciality'];
                $specialityfee = 10000;
                if ($specialityfee > $credit) {
                    include_once 'header.php';
                    echo '<div id="game">
<h2>
Speciality
</h2>
<h3> Insufficient funds!</h3>
';
                } else {
                    $result608 = mysql_query("UPDATE userinfo SET credit=credit-$specialityfee WHERE userid='$userid'") or die (mysql_error() . "UH OHHHH");
                    $result5 = mysql_query("INSERT INTO crew VALUES(NULL,'$shipid','$userid','0','0','0','0','$speciality',0,0,0)") or die (mysql_error() . "CRAP");

                    include_once 'header.php';
                    echo '<div id="game">
<h2>
Speciality
</h2>
';
                }
            }
            //END OF BUY SPECIALITY
        } else {
            if (isset($_POST['onmission']) && $_POST['onmission'] != '') {
                include_once 'header.php';
                echo '<head>

<script type="text/javascript" src="jquery.countdown.js"></script>
<link href="jquery.countdown2.css" rel="stylesheet" type="text/css" />
</head>';
                echo '<div id="game">
<h2>
Jobs
</h2>
';
                $crewpost = $_POST['onmission'];

                if ($crewpost < 1) {

                    echo "<h3>You have not entered a number please return!</h3>";
                } else if ($crewpost > $usablecrew) {
                    echo "<h3>You have not got enough crew members to do this. Please return.</h3>";
                } else {
                    echo "<h3> You have successfully started this mission. Your crew has been deployed!</h3>";
                    if ($difficulty == 1) {
                        $missiontime = 86400; //How long the mission is


                        $jobskill = rand(800, 1200);
                        $randomsub1 = rand(100, 200);
                        $randomsub = $randsub1 * $crewlevel;
                        $jobskilloffer = $jobskill * $crewlevel - $randomsub;

                    } else if ($difficulty == 2) {
                        $missiontime = 172800;


                        $jobskill = rand(1000, 1200);
                        $randomsub1 = rand(120, 200);
                        $randomsub = $randsub1 * $crewlevel;
                        $jobskilloffer = $jobskill * $crewlevel - $randomsub;
                    } else if ($difficulty == 3) {
                        $missiontime = 259200;

                        $jobskill = rand(1100, 1300);
                        $randomsub1 = rand(140, 200);
                        $randomsub = $randsub1 * $crewlevel;
                        $jobskilloffer = $jobskill * $crewlevel - $randomsub;
                    } else {
                        $missiontime = 345600;

                        $jobskill = rand(1200, 1600);
                        $randomsub1 = rand(100, 200);
                        $randomsub = $randsub1 * $crewlevel;
                        $jobskilloffer = $jobskill * $crewlevel - $randomsub;
                    }

                    $timetaken = floor(max($missiontime / $crewpost, 1)); //How long it is going to take you depending on your crew input
                    $timestuff = strtotime('now'); //the time now
                    $timeend = $timestuff + $timetaken; // the time it will be when the mission is finished

                    $joblog = mysql_query("INSERT INTO joblog VALUES(NULL,'$userid','$crewid','$skill','$jobskilloffer','$timestuff','$timeend','','','','','$locationid',TRUE,'$crewpost')") or die (mysql_error() . "CRAP");
                    $result6 = mysql_query("UPDATE crew SET onmission=onmission+$crewpost WHERE crewid='$crewid'") or die (mysql_error() . "UH OHHHH");
                }

            }
            //END OF

            //Start missions
            else {
                include_once 'header.php';
                echo '<head>

<script type="text/javascript" src="jquery.countdown.js"></script>
<link href="jquery.countdown2.css" rel="stylesheet" type="text/css" />
</head>';

                echo '<div id="game">
<h2>
Jobs
</h2>
';
                /*$activejob = mysql_query("SELECT * FROM joblog WHERE playerid='$userid' AND locationid='$locationid' AND active=TRUE");
                $activejobarray = mysql_fetch_assoc($activejob);
                $timeend=$activejobarray['timeend'];

                $jobcount = mysql_num_rows($activejob);

                if($jobcount>0){
                echo "You running already";

                }
                else{*/


                if ($speciality == 0) {
                    echo "MINER!";
                    echo "<br />";

// <input type='hidden' name='specialityclass' value='$speciality' />
                    echo "<h3>You have $usablecrew available crew member(s) out of a total crew of $size</h3>";

                    if ($size == 0) {
                        echo "<p>You cannot do any jobs. You must first recruit crew members.</p><br /><a href='recruit.php'>Recruit</a><br />";
                    } else if ($usablecrew == 0) {
                        echo "<p>All your crew members are currently in jobs.</p>

<p> Please recruit more crew members or wait until your current missions have completed.</p>
<br /><a href='recruit.php'>Recruit</a>";
                    } else {
                        echo "<form action='speciality.php' method='post'>
<input type='text' name='onmission'>/$usablecrew
<input type='submit'>
</form>
";
                    }
                } else {
                    echo "Science";
                    echo "<br />";

// <input type='hidden' name='specialityclass' value='$speciality' />
                    echo "<h3>You have $usablecrew available crew member(s) out of a total crew of $size</h3>";


                    if ($size == 0) {
                        echo "<p>You cannot do any jobs. You must first recruit crew members.</p><br /><a href='recruit.php'>Recruit</a>";
                    } else if ($usablecrew == 0) {
                        echo "<p>All your crew members are currently in jobs.</p>

<p> Please recruit more crew members or wait until your current missions have completed.</p>
<br /><a href='recruit.php'>Recruit</a>";
                    } else {
                        echo "<form action='speciality.php' method='post'>
<input type='text' name='onmission'>/$usablecrew
<input type='submit'>
</form>
";
                    }
                }


//}
            }
//Active Jobs!
            $result111 = mysql_query("SELECT * FROM joblog WHERE playerid='$userid' AND locationid='$locationid' AND active=TRUE") or die (mysql_error() . "CRAP");


            $i = 1;


            echo "<script type='text/javascript'>
$(document).ready(function(){";
            while ($row = mysql_fetch_array($result111)) {

                $jobeta = $row['timeend'];


                echo " var austDay$i = new Date( $jobeta*1000);
 $('#defaultCountdown$i').countdown({until: austDay$i, format: 'HMS'});


";
                $i++;
            }
            echo "});</script>";


            $result112 = mysql_query("SELECT * FROM joblog WHERE playerid='$userid' AND locationid='$locationid' AND active=TRUE") or die (mysql_error() . "CRAP");

            echo "<br /><br /><h4>Active Jobs on $location </h4>";
            $rowcount111 = mysql_num_rows($result111);
            if ($rowcount111 == 0) {
                echo "<br /><h3>No active jobs!</h3>";
            } else {
                echo "<table >";
                echo "<tr><th>Active Job Number</th><th>Crew members on mission</th><th>Time till completion</th><th>Success Ratio</th><th>Cancel</th></tr>";


                $i = 1;
                while ($row2 = mysql_fetch_array($result112)) {
                    $crewonmission = $row2['crewonmission'];
                    $jobid = $row2['jobid'];
                    $row2jobeta = $row2['timeend'];
                    $row2crewskill = $row2['crewskill'];
                    $row2jobskill = $row2['jobskill'];

                    echo "<tr><td>$i</td><td>$crewonmission</td><td>";

                    if ($row2jobeta <= strtotime('now')) {
                        echo "<a href='jobcomplete.php?id=$jobid'>Complete</a>";
                    } else {

                        echo "	<div style='width:200px;'id ='defaultCountdown$i'>";
                    }
                    $div = floor($row2crewskill / $row2jobskill * 100);
                    $div = min($div, 99);
                    $div = max($div, 1);
                    echo "</div></td><td>$div%</td><td>Cancel?</td></tr>";

                    $i++;
                }

                echo "</table >";

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
