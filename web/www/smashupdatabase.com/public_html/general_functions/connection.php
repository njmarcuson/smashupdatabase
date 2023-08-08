<?php
/*
This is the function to get a nice little connection 
for the smashupdatabse :)
*/
function get_connection() {

    // inital variables and stuff
    $servername = "localhost";
    $username = "";
    $password = "";
    $database = "";

    // create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // check connection
    if ($conn->connect_error) {
        throw new ErrorException('we failed to connect to the database :(');
    }

    return $conn;
}
?>
