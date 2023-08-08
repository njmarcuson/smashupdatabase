<?php
session_start();

// redirect to login page if they're not logged in
if ( ! array_key_exists('user', $_SESSION) ) {
    header('Location: login_page.php');
    die();
}

require_once('../general_functions/connection.php');
require_once('../classes/User.php');
require_once('../classes/UserEditor.php');

$conn = get_connection();

$user = unserialize($_SESSION['user']);

// validate the password
if ($_POST['old_password'] != $user->get_password()) {
    header('Location: change_password_page.php?fail=wrong_password');
    die();
}

// validate the new passwords being equal
if ($_POST['new_password'] != $_POST['repeat_new_password']) {
    header('Location: change_password_page.php?fail=no_match');
    die();
}

// update the password and send them to a thankyou page
$user_editor = new UserEditor($user, $conn);
$success = intval($user_editor->change_password($_POST['new_password']));
header("Location: password_changed.php?success={$success}");
die();
?>