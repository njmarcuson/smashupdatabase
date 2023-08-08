<?php
    $success = $_GET['success'];

    if ($success == "true") {
        $message = "Thanks for Inputting!";
    } else {
        $message = "Something went wrong with the input. Please try again.
            If the problem persists, please email me and I'll get back to you as soon as possible.";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="scripts.js"></script>
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
                <li><a href="input_page.php">Input Data</a></li>
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
            Input Data
        </h1>
    </div>

    <div class="container">
        <h3 style="margin-bottom: 2em;">
            <?php echo $message; ?>
        </h3>
        <div class="split">
            <a href="input_page.php" class="infobox -infobox-hover infobox--left" style="max-width: 30em;">
                <h3 class="subtitle">
                    Input Again!
                </h3>
            </a>
        </div>
    </div>
    

</section>

</body>
</html>