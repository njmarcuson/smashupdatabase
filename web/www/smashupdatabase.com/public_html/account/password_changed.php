<?php
session_start();

// redirect to login page if they're not logged in
if ( ! array_key_exists('user', $_SESSION) ) {
    header('Location: login_page.php');
    die();
}

$success = $_GET['success'];
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
                <li><a href="manage.php">Account</a></li>
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
            Manage Account
        </h1>
        <div class="split">

            <div class="infobox loginbox">

                <h3 style="margin-bottom: 2rem;">
                    <?php
                    if ($success) {
                        echo "Your password has been changed!";
                    } else {
                        echo "Something went wrong... please try again. If the problem persists, shoot me an email.";
                    }
                    ?>
                </h3>

            </div>
        </div>
    </div> 
</section>


</body>
</html>