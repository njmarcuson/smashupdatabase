<?php
session_start();

// redirect to login page if they're not logged in
if ( ! array_key_exists('user', $_SESSION) ) {
    header('Location: login_page.php');
    die();
}
require_once('../general_functions/connection.php');
require_once('../classes/Factions.php');
require_once('../classes/User.php');
require_once('../classes/UserEditor.php');

$conn = get_connection();

$user = unserialize($_SESSION['user']);

$factions = new Factions();
$all_expansions = $factions->get_expansions(false, true, false);
$user_editor = new UserEditor($user, $conn);

// update the expansions and send them back to the manage page
// if something went wrong, exp_success=0 and we handle it there
$success = intval($user_editor->update_expansions($_POST, $all_expansions));
header("Location: manage.php?exp_success={$success}");
?>