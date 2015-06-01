<?php

header("Content-type: application/atom+xml");

echo '<?xml version="1.0" encoding="utf-8"?>
<feed xml:lang="en-US" xmlns="http://www.w3.org/2005/Atom">
     <title>Users ranking</title>
     <subtitle>The latest rankings from Guess the Star</subtitle>
     <link href="http://localhost/gus/getRankingAtom.php" rel="self"/>';
date_default_timezone_set('Europe/Bucharest');
echo '<updated>' . $date = date('Y-m-d\TH:i:sP', time()) . '</updated>
     <author>
          <name>Guess the Star</name>
     </author>
     <id>
     tag:users ranking:http://localhost/gus/getRankingAtom.php
     </id>';
$c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
$disp = oci_parse($c,
    'select rownum, a.*
             from ( select *
                    from user_profile
                    order by points desc
                    ) a ');
oci_execute($disp);
$i = 0;
while($row = oci_fetch_array($disp))
{
    if ($i > 0) {
        echo "</entry>";
    }

    echo "<entry>";
    echo "<title>";
    echo 'Users ranking';
    echo "</title>";
    echo '<link type="text/html"
                    href="http://localhost/gus/getRankingAtom.php"/>';
           echo "<username>";
           echo $row['USERNAME'];
           echo "</username>";
           echo "<lastName>";
           echo $row['LAST_NAME'];
           echo "</lastName>";
           echo "<firstName>";
           echo $row['FIRST_NAME'];
           echo "</firstName>";
           echo "<points>";
           echo $row['POINTS'];
           echo "</points>";

           $i++;
     }
echo "</entry>";
echo "</feed>";
oci_close($c);



