<?php
session_start();

require_once('../general_functions/connection.php');

$conn = get_connection();
$user = unserialize($_SESSION['user']);

$style_prompt = $user ? "style='display:none; margin-bottom: 1rem;'" : "";
$style_split = $user ? "" : "style='display:none'";
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
                <li><a href="#">Data</a></li>
                <li><a href="../account/manage.php">Account</a></li>
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
            Download Data
        </h1>
		
        <div class="split" <?php echo $style_split; ?>>
            <div class="infobox">
                <h3>
                    <a href="download.php?type=all" class="link-account">Download All Games</a>
                </h3>
            </div>
            <div class="infobox">
                <h3>
                    <a href="download.php?type=user" class="link-account">Downlaod Your Games</a>
                </h3>
            </div>
        </div>

        <div class="split">
            <div class="infobox">
                <h3 <?php echo $style_prompt; ?>>
                    You need to <a href="../account/login_page.php" class="link-account">login</a> before downloading data
                </h3>
                <p class="p-proper">
                    If you use this data for a public project (which I encourage), I ask that you <a href="../about/about.php" class="link-account">contact me</a> beforehand to see if there is any extra way I can help you out, and that you give me proper credits on your project.
                    This site will never be about statistical analysis, but I really want to see as much Smash Up analysis out there as possible!
                </p>
            </div>
        </div>
    </div>

</section>

</body>
</html>