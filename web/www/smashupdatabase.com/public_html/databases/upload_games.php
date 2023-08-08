<?php
/*
 * Just loop through the old games and get them 
 * up for development's sake (won't be used on
 * the live website)
 */
require_once('../classes/User.php');
require_once('../classes/GameAdder.php');
require_once('../general_functions/connection.php');

$conn = get_connection();

$user1 = new GameAdder('nnnnkids@aol.com', 'asdf', $conn);
$user2 = new GameAdder('njmarcuson@gmail.com', 'asdf', $conn);

$file = fopen("games.csv","r");

$row = fgetcsv($file);

while (($row = fgetcsv($file)) !== false) {

    if ($row[1] == "") {
        continue;
    }

    // randomly set the game adder as one of the two users
    $temp_adder = (rand(0, 2) == 0) ? $user1 : $user2;

    // array to simulate the $_POST that GameAdder usually takes
    $a = array();

    $a['p1f1'] = $row[2];
    $a['p1f2'] = $row[3];
    $a['p1vp'] = $row[4];
    $a['p2f1'] = $row[5];
    $a['p2f2'] = $row[6];
    $a['p2vp'] = $row[7];
    $a['p3f1'] = $row[8];
    $a['p3f2'] = $row[9];
    $a['p3vp'] = $row[10];
    $a['p4f1'] = $row[11];
    $a['p4f2'] = $row[12];
    $a['p4vp'] = $row[13];


    if ($a['p3f1'] == "") {
        $a['number_of_players'] = 2;
    } elseif ($a['p4f1'] == "") {
        $a['number_of_players'] = 3;
    } else {
        $a['number_of_players'] = 4;
    }

    if ($row['14'] == "player1") {
        $a['went_first'] = 1;
    } elseif ($row['14'] == "player2") {
        $a['went_first'] = 2;
    } elseif ($row['14'] == "player3") {
        $a['went_first'] = 3;
    } elseif ($row['14'] == "player4") {
        $a['went_first'] = 4;
    }

    if (! $temp_adder->add_game($a)) {
        echo "FAILURE: {$row[0]}<br>";
    }

}

fclose($file);

?>