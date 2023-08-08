<?php
session_start();

require_once('../general_functions/connection.php');
require_once('../classes/User.php');
require_once('../classes/CsvGetter.php');

$conn = get_connection();
$user = unserialize($_SESSION['user']);

if (!$user) {
    header("Location: download_page.php");
    die();
}

if ($_GET['type'] == "all") {
    CsvGetter::get_csv($conn);
} elseif ($_GET['type'] == "user") {
    CsvGetter::get_csv($conn, $user);
}
?>
