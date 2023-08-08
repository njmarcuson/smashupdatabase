<?php
session_start();

require_once('../general_functions/connection.php');

$conn = get_connection();

// check if the codes matched
if ($_SESSION['code'] != $_POST['code']) {
    header('Location: forgot_password.php?bad_code=1');
    die();
}

// check if the passwords matched
if ($_POST['password'] != $_POST['repeat_password']) {
    header('Location: forgot_password.php?bad_password=1');
    die();
}

$prep = "UPDATE users SET password = ? WHERE email = ?";
$stmt = $conn->prepare($prep);
$stmt->bind_param("ss", $_POST['password'], $_SESSION['email']);
if ( ! $stmt->execute() ) {
    header('Location: forgot_password.php?fail=1');
    die();
}

header('Location: login_page.php');
?>