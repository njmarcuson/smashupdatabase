<?php
/*
This file is simply to play around with classes for 
debugging purposes.
*/

$start_time = microtime(true);

require_once('../general_functions/connection.php');
require_once('Factions.php');
require_once('User.php');
require_once('UserFactions.php');
require_once('RandomGame.php');
require_once('StatsHelper.php');
require_once('SingleStats.php');
require_once('ComboStats.php');
require_once('UserEditor.php');

$conn = get_connection();

var_dump(ComboStats::get_combo_stats($conn, "Dinosaurs", "Zombies", ""));



echo "<br><br>EOF";

$end_time = microtime(true);
echo "<br>milliseconds to execute: " . ($end_time-$start_time)*1000;
?>
