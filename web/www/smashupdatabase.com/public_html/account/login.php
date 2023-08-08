<?php
session_start();

require_once('../general_functions/connection.php');
require_once('../classes/User.php');

$conn = get_connection();

// try to create a user. 
// if we get an exception, destroy the user object
try {
    $user = new User($_POST['email'], $_POST['password'], $conn);
} catch (Exception $e) {
    unset($user);
}

// set the user object into our session if passed above test
// or unset it from the session
if ( !is_null($user) ) {
    $_SESSION['user'] = serialize($user);
    header('Location: manage.php');
    die();
} else {
    unset($_SESSION['user']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Smash Up Database</title>
</head>

<body>

<header>
    <div class="container --header-container">
        <input class="toggle" id="toggle" type="checkbox">
        <label for="toggle" class="toggle-label">
            <span></span>
        </label>
        <div class='logo-container'>
            <a id="logo-link" href="../Default.php">
                <img class="logo" src="../images/sudb_logo_transparent.png" width="100" height="50"></img>
            </a>
        </div>
        <nav>
            <ul>
                <li><a href="../input_data/input_page.php">Input Data</a></li>
                <li><a href="../random/random_page.php">Random Game</a></li>
                <div class="dropdown">
                    <li><a href="../stats/stats.php">Stats</a></li>
                    <div class="dropdown-content">
                        <div class='dropdown-link'>&nbsp;<a href="../stats/single.php">Single Factions</a></div>
                        <div class='dropdown-link'>&nbsp;<a href="../stats/combo.php">Combos</a></div>
                    </div>
                </div>
                <div class="dropdown">
                    <li><a href="../graphs/graphs.php">Graphs</a></li>
                    <div class="dropdown-content">
                        <div class='dropdown-link'>&nbsp;<a href="../graphs/single.php">Single Factions</a></div>
                        <div class='dropdown-link'>&nbsp;<a href="../graphs/combo.php">Combos</a></div>
                    </div>
                </div>
                <li><a href="../sudl/sudl.php">SUDL</a></li>
                <li><a href="../download/download_page.php">Data</a></li>
                <li><a href="login_page.php">Account</a></li>
                <li><a href="../about/about.php">About</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="spacer">
    &nbsp;
</div>

<section>
    <div class="container">
        <h1>
            Login
        </h1>
        <div class="split">
            <div class="infobox loginbox" style="padding: 3rem;">

                <h3 style="margin-bottom: 3rem;">
                    Email and password did not match
                </h3>

                <div class="link-container">
                    <a href="login_page.php" class="link-login">Log In</a>
                </div>

                <div class="link-container">
                    <a href="create_page.php" class="link-login">Create Account</a>
                </div>
                
                <div class="link-container">
                    <a href="forgot_password.php" class="link-login">Forgot Password</a>
                </div>
                
            </div>  
        </div>
    </div>
</section>


</body>
</html>