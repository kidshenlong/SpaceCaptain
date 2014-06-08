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


        if (!isset($_POST['travel'])) {

            $day = strtotime('-1 day');
            $result3 = mysql_query("SELECT * FROM travellog WHERE userid='$userid' and time>'$day'") or die (mysql_error());
            $rowt3 = mysql_fetch_assoc($result3);
            $time = $row3["time"];
            $travelnum = mysql_num_rows($result3);


            include_once 'header.php';
            echo "
	
	
	<script type='text/javascript'>
	$(document).ready(function () {
    $('.travelcost').hide();
    $('#1').show();


    $('#travel').change(function () {
        $('.travelcost').hide();
        $('#'+$(this).val()).show();
    
    })
});
</script>
	";
            echo '
<head>

</head>
<div id="game">
<h2>
Travel
</h2>
';
            if ($travelnum < 10) {
                echo "<p> Times travelled today: $travelnum/10</p>";

                echo '
Warp Hole to:
<form action="travel.php" method="post">
<select id="travel" name="travel">
  <option value="33">Corusk</option>
  <option value="2">Osheth</option>
  <option value="3">Koruban</option>
</select>
<input id="button" type="submit" value="Travel Here!" />
</form>
<div id="33" class="travelcost">This will cost: 1000 credits</div>
<div id="2" class="travelcost">This will cost: 2000 credits</div>
<div id="3" class="travelcost">This will cost: 3000 credits</div>


</div>
';
            } else {
                echo '<h3>Travel Limit reached! </h3></div>';
            }
        } else {

            $travel = $_POST['travel'];

            $result9 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
            $row9 = mysql_fetch_assoc($result9);
            $oldlocation = $row9["locationid"];

            $timestuff = strtotime('now');

            $result6 = mysql_query("UPDATE userinfo SET locationid=$travel WHERE userid='$userid'") or die (mysql_error() . "UH OHHHH");

            $result5 = mysql_query("INSERT INTO travellog VALUES(NULL,'$userid','$travel','$oldlocation','$timestuff')") or die (mysql_error() . "CRAP");

            if ($travel == 1) {
                $travelfare = '1000';
            } else if ($travel == 2) {
                $travelfare = '2000';
            } else {
                $travelfare = '3000';
            }

            $result6 = mysql_query("UPDATE userinfo SET credit=credit-$travelfare WHERE userid='$userid'") or die (mysql_error() . "UH OHHHH2");

            $result7 = mysql_query("SELECT * FROM location WHERE locationid='$travel'");
            $row7 = mysql_fetch_assoc($result7);
            $travelname = $row7["name"];

            include_once 'header.php';

            echo '<div id="game">
<h2>
Travel
</h2>
';
            echo "<h3>
You have successfully travelled to $travelname

</h3> </div>";


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
