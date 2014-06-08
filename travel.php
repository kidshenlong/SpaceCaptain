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

        $result9 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
        $row9 = mysql_fetch_assoc($result9);
        $oldlocation = $row9["locationid"];

        $result932 = mysql_query("SELECT * FROM travellog WHERE userid='$userid' ORDER BY travelid DESC LIMIT 1");
        $row932 = mysql_fetch_assoc($result932);
        $lasttravel = $row932["time"];
        echo '
<head>
<link href="jquery.qtip.min.css" rel="stylesheet" type="text/css" />
<link href="jquery.countdown.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="jquery.qtip.min.js"></script>
<script type="text/javascript" src="jquery.countdown.js"></script>
<script type="text/javascript">';
        ?>

        $(document).ready(function(){
        $('.dropit').each(function()
        {
        $(this).qtip({
        position: {
        at:'center',
        adjust: {
        screen: "fit"
        },
        viewport: $(window)
        },
        content: {
        text: 'Loading...',
        ajax: {
        url: $(this).attr('href') +' .myclass',
        type: "GET",
        data: {}

        }
        }
        })
        });
        var sum1= <?php echo $lasttravel; ?>+86400;
        var austDay = new Date(sum1*1000);
        $('#defaultCountdown').countdown({until: austDay, format: 'HMS'});

        });

        <?php

        $day = strtotime('-1 day');
        //$hours = strtotime('-6 hours');
        $result3 = mysql_query("SELECT * FROM travellog WHERE userid='$userid' and time>'$day'") or die (mysql_error());
        $rowt3 = mysql_fetch_assoc($result3);
        $time = $row3["time"];
        $travelnum = mysql_num_rows($result3);


        echo '
</script>
</style>


<style type="text/css">
table{
 text-align:center;
table-layout: fixed;
/* width:600px;
 height:600px;*/ 
 border:1px
 /*cellpadding=auto*/
 width:100%;
 margin-right:auto;
 margin-left:auto;
 margin-bottom:100px;
}
td
{
height:110px;
width:110px;
}
td img{
	
	height:85%;
	width:85%;
	margin-top:10px;
border: 2px solid black;

}

td  a img:hover
{ 
border: 2px solid yellow;
}
.aldo{



}
.dropit{
height:100%;

}


#defaultCountdown { width: 320px; height: 65px;
margin:0 auto;
}
/*iPhone 5:*/
@media screen and (device-aspect-ratio: 40/71) {

td
{
height:170px;
width:170px;
}
.ui-tooltip .ui-tooltip-content,
.ui-tooltip p,
.ui-tooltip ul,
.ui-tooltip li,
.ui-tooltip,
.qtip {

     
   line-height:36px;
    font-size: 47px;
   /*white-space: nowrap;*/
	/*max-width: none;*/
}

}
</style>
</head>
<div id="game1">
<h2>
Travel
</h2>
';
        if ($travelnum < 2) {
            echo "<p> Times travelled today: $travelnum/2</p>";
        } else {
            echo '<P>Travel Limit reached!</P>

<div id="defaultCountdown"></div><br /> <br /><p>Until you can travel again</p><br  />';
        }
        echo '<table>';

        $test1 = '';
        for ($i = 11; $i <= 15; $i++) {

            if ($oldlocation == $i) {

                $test1 = $test1 . "<td><img style=' border:2px solid red;' src='galaxyimg/space1.jpg' alt='spacetile' /></td>";
            } else {
                $test1 = $test1 . "<td><a  id='t$i' class='dropit' href='travelto.php?id=$i'><img class='aldo' src='galaxyimg/space1.jpg' alt='spacetile' /></a></td>";
            }
        }
        echo '<tr>' . $test1 . '</tr>';

        $test2 = '';
        for ($i = 21; $i <= 25; $i++) {


            if ($i == 24) {
                if ($oldlocation == $i) {

                    $test2 = $test2 . "<td><img style=' border:2px solid red;'  src='galaxyimg/Koruban.jpg' alt='korubantile' /></td>";
                } else {
                    $test2 = $test2 . "<td><a  id='t$i' class='dropit' href='travelto.php?id=$i'><img src='galaxyimg/Koruban.jpg' alt='korubantile' /></a></td>";
                }
            } else {
                if ($oldlocation == $i) {
                    $test2 = $test2 . "<td><img style=' border:2px solid red;'  src='galaxyimg/space1.jpg' alt='spacetile' /></td>";
                } else {
                    $test2 = $test2 . "<td><a  id='t$i' class='dropit' href='travelto.php?id=$i'><img src='galaxyimg/space1.jpg' alt='spacetile' /></a></td>";
                }
            }

        }
        echo '<tr>' . $test2 . '</tr>';

        $test3 = '';
        for ($i = 31; $i <= 35; $i++) {


            if ($i == 33) {
                if ($oldlocation == $i) {
                    $test3 = $test3 . "<td><img style=' border:2px solid red;' src='galaxyimg/Corrusk.jpg' alt='corrusktile' /></td>";
                } else {
                    $test3 = $test3 . "<td><a  id='t$i' class='dropit' href='travelto.php?id=$i'><img src='galaxyimg/Corrusk.jpg' alt='corrusktile' /></a></td>";
                }
            } else {
                if ($oldlocation == $i) {
                    $test3 = $test3 . "<td><img style=' border:2px solid red;'  src='galaxyimg/space1.jpg' alt='spacetile'/></td>";
                } else {
                    $test3 = $test3 . "<td><a  id='t$i' class='dropit' href='travelto.php?id=$i'><img src='galaxyimg/space1.jpg' alt='spacetile' /></a></td>";
                }
            }

        }
        echo '<tr>' . $test3 . '</tr>';

        $test4 = '';
        for ($i = 41; $i <= 45; $i++) {
            if ($oldlocation == $i) {

                $test4 = $test4 . "<td><img style=' border:2px solid red;' src='galaxyimg/space1.jpg' alt='spacetile'/></td>";
            } else {
                $test4 = $test4 . "<td><a  id='t$i' class='dropit' href='travelto.php?id=$i'><img src='galaxyimg/space1.jpg' alt='spacetile'/></a></td>";
            }
        }
        echo '<tr>' . $test4 . '</tr>';

        $test5 = '';
        for ($i = 51; $i <= 55; $i++) {

            if ($i == 51) {
                if ($oldlocation == $i) {
                    $test5 = $test5 . "<td><img style=' border:2px solid red;' src='galaxyimg/blackhole.jpg' alt='blackhole'/></td>";
                } else {
                    $test5 = $test5 . "<td><a  id='t$i' class='dropit' href='travelto.php?id=$i'><img src='galaxyimg/blackhole.jpg' alt='blackhole'/></a></td>";
                }
            } else if ($i == 55) {
                if ($oldlocation == $i) {
                    $test5 = $test5 . "<td><img style=' border:2px solid red;' src='galaxyimg/Osheth.jpg' alt='oshethtile'/></td>";
                } else {
                    $test5 = $test5 . "<td><a  id='t$i' class='dropit' href='travelto.php?id=$i'><img src='galaxyimg/Osheth.jpg' alt='oshethtile' /></a></td>";
                }
            } else {
                if ($oldlocation == $i) {
                    $test5 = $test5 . "<td><img style=' border:2px solid red;'  src='galaxyimg/space1.jpg' alt='spacetile'/></td>";
                } else {
                    $test5 = $test5 . "<td><a  id='t$i' class='dropit' href='travelto.php?id=$i'><img src='galaxyimg/space1.jpg' alt='spacetile'/></a></td>";
                }
            }
        }
        echo '<tr>' . $test5 . '</tr>';
        echo '</table></div>';

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
