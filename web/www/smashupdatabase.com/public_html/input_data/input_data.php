<?php
session_start();

// redirect to login page if they're not logged in
if ( ! array_key_exists('user', $_SESSION) ) {
    header('Location: ../account/login_page.php?from=input_page');
    die();
}

require_once('../general_functions/connection.php');
require_once('../classes/Factions.php');
require_once('../classes/User.php');
require_once('../classes/UserFactions.php');
require_once('../classes/GameAdder.php');

$conn = get_connection();
$user = unserialize($_SESSION['user']);

if (GameAdder::add_game($conn, $user, $_POST)) {
    $success = "true";
} else {
    $success = "false";
}

header("Location: input_thanks.php?success={$success}");

?>