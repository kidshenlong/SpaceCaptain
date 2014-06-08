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
        echo '
<head>

<style type="text/css">
#game{
height:100%;
}
</style>
</head>
<div id="game">
<h2>
Leaderboard
</h2>';

        $userid = $_SESSION['userid'];

        $result2 = mysql_query("SELECT * FROM userinfo WHERE userid='$userid'");
        $row0 = mysql_fetch_assoc($result2);
        $location = $row0["location"];

//BREAKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK

        $result = mysql_query("SELECT * FROM userinfo WHERE locationid='33'");

        echo "<br /><h3>Located at Corusk</h3>";
        $rowcount = mysql_num_rows($result);
        if ($rowcount == 0) {
            echo "<br /><h3>No Players currently in this region!</h3>";
        } else {
            echo "<table >";
            echo "<tr><th class='table1'>Captain Name</th><th class='table2'>Ship</th><th class='table3'>Level</th><th>Message</th></tr>";


            while ($row = mysql_fetch_array($result)) {
                $userid2 = $row['userid'];

                $herego = mysql_query("SELECT * FROM userinfo WHERE userid='$userid2'");


                if ($userid == $userid2) {
                    $thisplayer = '*';
                } else {
                    $thisplayer = '';
                }

                $row1 = mysql_fetch_assoc($herego);
                $name = $row1["name"];

                $locationid = $row1["locationid"];

                $herego2 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");
                $row3 = mysql_fetch_assoc($herego2);

                $locationname = $row3["name"];


                $herego1 = mysql_query("SELECT * FROM ship WHERE userid='$userid2'");

                $row2 = mysql_fetch_assoc($herego1);
                $shipname = $row2["name"];
                $shiplevel = $row2["level"];


                echo "<tr><td class='table1'><a href='";
                if ($userid == $userid2) {
                    echo "stats.php";
                } else {
                    echo "stats.php?id=$userid2";
                }
                echo "'>Captain $name $thisplayer</a></td>
<td class='table2'>$shipname </td><td class='table3'>$shiplevel</td><td>";
                if ($userid == $userid2) {
                    echo "-";
                } else {
                    echo "<a href='sendmessage.php?id=$userid2'>Message</a>";
                }
                echo "</td></tr>";

            }
            echo "</table>";
        }

//BREAKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK

        $result = mysql_query("SELECT * FROM userinfo WHERE locationid='55'");

        echo "<br /><div>Located at Osheth</div>";


        $rowcount = mysql_num_rows($result);
        if ($rowcount == 0) {
            echo "<br /><h3>No Players currently in this region!</h3>";
        } else {
            echo "<table >";
            echo "<tr><th class='table1'>Captain Name</th><th class='table2'>Ship</th><th class='table3'>Level</th><th>Message</th></tr>";


            while ($row = mysql_fetch_array($result)) {
                $userid2 = $row['userid'];

                $herego = mysql_query("SELECT * FROM userinfo WHERE userid='$userid2'");


                if ($userid == $userid2) {
                    $thisplayer = '*';
                } else {
                    $thisplayer = '';
                }

                $row1 = mysql_fetch_assoc($herego);
                $name = $row1["name"];

                $locationid = $row1["locationid"];

                $herego2 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");
                $row3 = mysql_fetch_assoc($herego2);

                $locationname = $row3["name"];


                $herego1 = mysql_query("SELECT * FROM ship WHERE userid='$userid2'");

                $row2 = mysql_fetch_assoc($herego1);
                $shipname = $row2["name"];
                $shiplevel = $row2["level"];


                echo "<tr><td class='table1'><a href='";
                if ($userid == $userid2) {
                    echo "stats.php";
                } else {
                    echo "ship.php?id=$userid2";
                }
                echo "'>Captain $name $thisplayer</a></td>
<td class='table2'>$shipname </td><td class='table3'>$shiplevel</td><td>";
                if ($userid == $userid2) {
                    echo "-";
                } else {
                    echo "<a href='sendmessage.php?id=$userid2'>Message</a>";
                }
                echo "</td></tr>";

            }
            echo "</table>";
        }

//BREAKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK


        $result = mysql_query("SELECT * FROM userinfo WHERE locationid='24'");

        echo "<br /><div>Located at Koruban</div>";


        $rowcount = mysql_num_rows($result);
        if ($rowcount == 0) {
            echo "<br /><h3>No Players currently in this region!</h3>";
        } else {
            echo "<table >";
            echo "<tr><th class='table1'>Captain Name</th><th class='table2'>Ship</th><th class='table3'>Level</th><th>Message</th></tr>";


            while ($row = mysql_fetch_array($result)) {
                $userid2 = $row['userid'];

                $herego = mysql_query("SELECT * FROM userinfo WHERE userid='$userid2'");


                if ($userid == $userid2) {
                    $thisplayer = '*';
                } else {
                    $thisplayer = '';
                }

                $row1 = mysql_fetch_assoc($herego);
                $name = $row1["name"];

                $locationid = $row1["locationid"];

                $herego2 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");
                $row3 = mysql_fetch_assoc($herego2);

                $locationname = $row3["name"];


                $herego1 = mysql_query("SELECT * FROM ship WHERE userid='$userid2'");

                $row2 = mysql_fetch_assoc($herego1);
                $shipname = $row2["name"];
                $shiplevel = $row2["level"];


                echo "<tr><td class='table1'><a href='";
                if ($userid == $userid2) {
                    echo "stats.php";
                } else {
                    echo "ship.php?id=$userid2";
                }
                echo "'>Captain $name $thisplayer</a></td>
<td class='table2'>$shipname </td><td class='table3'>$shiplevel</td><td>";
                if ($userid == $userid2) {
                    echo "-";
                } else {
                    echo "<a href='sendmessage.php?id=$userid2'>Message</a>";
                }
                echo "</td></tr>";

            }
            echo "</table>";
        }

//BREAKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK

        $result = mysql_query("SELECT * FROM userinfo WHERE locationid='51'");

        echo "<br /><div>Located at Wormhole(Badlands)</div>";


        $rowcount = mysql_num_rows($result);
        if ($rowcount == 0) {
            echo "<br /><h3>No Players currently in this region!</h3>";
        } else {
            echo "<table >";
            echo "<tr><th class='table1'>Captain Name</th><th class='table2'>Ship</th><th class='table3'>Level</th><th>Message</th></tr>";


            while ($row = mysql_fetch_array($result)) {
                $userid2 = $row['userid'];

                $herego = mysql_query("SELECT * FROM userinfo WHERE userid='$userid2'");


                if ($userid == $userid2) {
                    $thisplayer = '*';
                } else {
                    $thisplayer = '';
                }

                $row1 = mysql_fetch_assoc($herego);
                $name = $row1["name"];

                $locationid = $row1["locationid"];

                $herego2 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");
                $row3 = mysql_fetch_assoc($herego2);

                $locationname = $row3["name"];


                $herego1 = mysql_query("SELECT * FROM ship WHERE userid='$userid2'");

                $row2 = mysql_fetch_assoc($herego1);
                $shipname = $row2["name"];
                $shiplevel = $row2["level"];


                echo "<tr><td class='table1'><a href='";
                if ($userid == $userid2) {
                    echo "stats.php";
                } else {
                    echo "ship.php?id=$userid2";
                }
                echo "'>Captain $name $thisplayer</a></td>
<td class='table2'>$shipname </td><td class='table3'>$shiplevel</td><td>";
                if ($userid == $userid2) {
                    echo "-";
                } else {
                    echo "<a href='sendmessage.php?id=$userid2'>Message</a>";
                }
                echo "</td></tr>";

            }
            echo "</table>";
        }

//BREAKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK

        $result = mysql_query("SELECT * FROM userinfo WHERE locationid='11' AND '12' AND '13' AND '14' AND '15' ");

        echo "<br /><h3>Located at Sector 1</h3>";
        $rowcount = mysql_num_rows($result);
        if ($rowcount == 0) {
            echo "<br /><h3>No Players currently in this region!</h3>";
        } else {
            echo "<table >";
            echo "<tr><th class='table1'>Captain Name</th><th class='table2'>Ship</th><th class='table3'>Level</th><th>Message</th></tr>";


            while ($row = mysql_fetch_array($result)) {
                $userid2 = $row['userid'];

                $herego = mysql_query("SELECT * FROM userinfo WHERE userid='$userid2'");


                if ($userid == $userid2) {
                    $thisplayer = '*';
                } else {
                    $thisplayer = '';
                }

                $row1 = mysql_fetch_assoc($herego);
                $name = $row1["name"];

                $locationid = $row1["locationid"];

                $herego2 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");
                $row3 = mysql_fetch_assoc($herego2);

                $locationname = $row3["name"];


                $herego1 = mysql_query("SELECT * FROM ship WHERE userid='$userid2'");

                $row2 = mysql_fetch_assoc($herego1);
                $shipname = $row2["name"];
                $shiplevel = $row2["level"];


                echo "<tr><td class='table1'><a href='";
                if ($userid == $userid2) {
                    echo "stats.php";
                } else {
                    echo "ship.php?id=$userid2";
                }
                echo "'>Captain $name $thisplayer</a></td>
<td class='table2'>$shipname </td><td class='table3'>$shiplevel</td><td>";
                if ($userid == $userid2) {
                    echo "-";
                } else {
                    echo "<a href='sendmessage.php?id=$userid2'>Message</a>";
                }
                echo "</td></tr>";

            }
            echo "</table>";
        }

//BREAKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK

        $result = mysql_query("SELECT * FROM userinfo WHERE locationid='21' AND '22' AND '23' AND '25' ");

        echo "<br /><h3>Located at Sector 2</h3>";
        $rowcount = mysql_num_rows($result);
        if ($rowcount == 0) {
            echo "<br /><h3>No Players currently in this region!</h3>";
        } else {
            echo "<table >";
            echo "<tr><th class='table1'>Captain Name</th><th class='table2'>Ship</th><th class='table3'>Level</th><th>Message</th></tr>";


            while ($row = mysql_fetch_array($result)) {
                $userid2 = $row['userid'];

                $herego = mysql_query("SELECT * FROM userinfo WHERE userid='$userid2'");


                if ($userid == $userid2) {
                    $thisplayer = '*';
                } else {
                    $thisplayer = '';
                }

                $row1 = mysql_fetch_assoc($herego);
                $name = $row1["name"];

                $locationid = $row1["locationid"];

                $herego2 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");
                $row3 = mysql_fetch_assoc($herego2);

                $locationname = $row3["name"];


                $herego1 = mysql_query("SELECT * FROM ship WHERE userid='$userid2'");

                $row2 = mysql_fetch_assoc($herego1);
                $shipname = $row2["name"];
                $shiplevel = $row2["level"];


                echo "<tr><td class='table1'><a href='";
                if ($userid == $userid2) {
                    echo "stats.php";
                } else {
                    echo "ship.php?id=$userid2";
                }
                echo "'>Captain $name $thisplayer</a></td>
<td class='table2'>$shipname </td><td class='table3'>$shiplevel</td><td>";
                if ($userid == $userid2) {
                    echo "-";
                } else {
                    echo "<a href='sendmessage.php?id=$userid2'>Message</a>";
                }
                echo "</td></tr>";

            }
            echo "</table>";
        }

//BREAKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK

        $result = mysql_query("SELECT * FROM userinfo WHERE locationid='31' AND '32' AND '34' AND '35' ");

        echo "<br /><h3>Located at Sector 3</h3>";
        $rowcount = mysql_num_rows($result);
        if ($rowcount == 0) {
            echo "<br /><h3>No Players currently in this region!</h3>";
        } else {
            echo "<table >";
            echo "<tr><th class='table1'>Captain Name</th><th class='table2'>Ship</th><th class='table3'>Level</th><th>Message</th></tr>";


            while ($row = mysql_fetch_array($result)) {
                $userid2 = $row['userid'];

                $herego = mysql_query("SELECT * FROM userinfo WHERE userid='$userid2'");


                if ($userid == $userid2) {
                    $thisplayer = '*';
                } else {
                    $thisplayer = '';
                }

                $row1 = mysql_fetch_assoc($herego);
                $name = $row1["name"];

                $locationid = $row1["locationid"];

                $herego2 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");
                $row3 = mysql_fetch_assoc($herego2);

                $locationname = $row3["name"];


                $herego1 = mysql_query("SELECT * FROM ship WHERE userid='$userid2'");

                $row2 = mysql_fetch_assoc($herego1);
                $shipname = $row2["name"];
                $shiplevel = $row2["level"];


                echo "<tr><td class='table1'><a href='";
                if ($userid == $userid2) {
                    echo "stats.php";
                } else {
                    echo "ship.php?id=$userid2";
                }
                echo "'>Captain $name $thisplayer</a></td>
<td class='table2'>$shipname </td><td class='table3'>$shiplevel</td><td>";
                if ($userid == $userid2) {
                    echo "-";
                } else {
                    echo "<a href='sendmessage.php?id=$userid2'>Message</a>";
                }
                echo "</td></tr>";

            }
            echo "</table>";
        }

//BREAKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK

        $result = mysql_query("SELECT * FROM userinfo WHERE locationid='41' AND '42' AND '43' AND '44' AND '45' ");

        echo "<br /><h3>Located at Sector 4</h3>";
        $rowcount = mysql_num_rows($result);
        if ($rowcount == 0) {
            echo "<br /><h3>No Players currently in this region!</h3>";
        } else {
            echo "<table >";
            echo "<tr><th class='table1'>Captain Name</th><th class='table2'>Ship</th><th class='table3'>Level</th><th>Message</th></tr>";


            while ($row = mysql_fetch_array($result)) {
                $userid2 = $row['userid'];

                $herego = mysql_query("SELECT * FROM userinfo WHERE userid='$userid2'");


                if ($userid == $userid2) {
                    $thisplayer = '*';
                } else {
                    $thisplayer = '';
                }

                $row1 = mysql_fetch_assoc($herego);
                $name = $row1["name"];

                $locationid = $row1["locationid"];

                $herego2 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");
                $row3 = mysql_fetch_assoc($herego2);

                $locationname = $row3["name"];


                $herego1 = mysql_query("SELECT * FROM ship WHERE userid='$userid2'");

                $row2 = mysql_fetch_assoc($herego1);
                $shipname = $row2["name"];
                $shiplevel = $row2["level"];


                echo "<tr><td class='table1'><a href='";
                if ($userid == $userid2) {
                    echo "stats.php";
                } else {
                    echo "ship.php?id=$userid2";
                }
                echo "'>Captain $name $thisplayer</a></td>
<td class='table2'>$shipname </td><td class='table3'>$shiplevel</td><td>";
                if ($userid == $userid2) {
                    echo "-";
                } else {
                    echo "<a href='sendmessage.php?id=$userid2'>Message</a>";
                }
                echo "</td></tr>";

            }
            echo "</table>";
        }

//BREAKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK

        $result = mysql_query("SELECT * FROM userinfo WHERE locationid='52' AND '53' AND '54' ");

        echo "<br /><h3>Located at Sector 5</h3>";
        $rowcount = mysql_num_rows($result);
        if ($rowcount == 0) {
            echo "<br /><h3>No Players currently in this region!</h3>";
        } else {
            echo "<table >";
            echo "<tr><th class='table1'>Captain Name</th><th class='table2'>Ship</th><th class='table3'>Level</th><th>Message</th></tr>";


            while ($row = mysql_fetch_array($result)) {
                $userid2 = $row['userid'];

                $herego = mysql_query("SELECT * FROM userinfo WHERE userid='$userid2'");


                if ($userid == $userid2) {
                    $thisplayer = '*';
                } else {
                    $thisplayer = '';
                }

                $row1 = mysql_fetch_assoc($herego);
                $name = $row1["name"];

                $locationid = $row1["locationid"];

                $herego2 = mysql_query("SELECT * FROM location WHERE locationid='$locationid'");
                $row3 = mysql_fetch_assoc($herego2);

                $locationname = $row3["name"];


                $herego1 = mysql_query("SELECT * FROM ship WHERE userid='$userid2'");

                $row2 = mysql_fetch_assoc($herego1);
                $shipname = $row2["name"];
                $shiplevel = $row2["level"];


                echo "<tr><td class='table1'><a href='";
                if ($userid == $userid2) {
                    echo "stats.php";
                } else {
                    echo "ship.php?id=$userid2";
                }
                echo "'>Captain $name $thisplayer</a></td>
<td class='table2'>$shipname </td><td class='table3'>$shiplevel</td><td>";
                if ($userid == $userid2) {
                    echo "-";
                } else {
                    echo "<a href='sendmessage.php?id=$userid2'>Message</a>";
                }
                echo "</td></tr>";

            }
            echo "</table>";
        }

//BREAKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK

        echo "
</div>
";
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
