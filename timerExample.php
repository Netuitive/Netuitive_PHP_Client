<?php
//TO DO: Add the include for the PHP client. Add this at the start of your PHP code.
require_once ('StatsD_Client.php');

//TO DO: Create a start timer.  Add this at the start of your PHP code.
$startTimer = gettimeofday(true);
echo $startTimer . "<br>";



//This section would be all your PHP code
//In this example we just cause the page to load at random time between 1 - 5 seconds.  This code is not required.
$n = rand(1,5);
sleep($n);



//TO DO: end timer  Add this at the end of your PHP code.
$endTimer = gettimeofday(true);
echo $endTimer . "<br>";

//TO DO: set timer duration in ms
$totalTime = $endTimer - $startTimer;
$msTotalTime = round($totalTime, 0) * 1000;

//Display page load time.  This code is not required.
echo "Page load time:";
echo $msTotalTime;
echo "ms";

//TO DO: call the timing function in the StatsD PHP client.  test.data.metric is the name of the metric in Netuitive
timing('test.data.metric', $msTotalTime, 1);

?>
