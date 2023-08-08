<?php
session_start();

// redirect to login page if they're not logged in
if ( ! array_key_exists('user', $_SESSION) ) {
    header('Location: login_page.php');
    die();
}

require_once('../general_functions/connection.php');
require_once('../classes/User.php');
require_once('../classes/UserGames.php');

$conn = get_connection();
$user = unserialize($_SESSION['user']);

$prep = "DELETE FROM games WHERE email = ? AND game_id = ?";
$stmt = $conn->prepare($prep);
$stmt->bind_param("ss", $user->get_email(), $_GET['game']);
$success = intval($stmt->execute());
header("Location: view_games.php?deletion={$success}");
die();
?>