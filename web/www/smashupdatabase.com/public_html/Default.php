<?php
require_once('general_functions/connection.php');
require_once('classes/BasicStats.php');

$conn = get_connection();

$num_games = BasicStats::get_num_games($conn);
$num_users = BasicStats::get_num_users($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
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
            <a id="logo-link" href="#">
                <img class="logo" src="images/sudb_logo_transparent.png" width="100" height="50"></img>
            </a>
        </div>
        <nav>
            <ul>
                <li><a href="input_data/input_page.php">Input Data</a></li>
                <li><a href="random/random_page.php">Random Game</a></li>
                <div class="dropdown">
                    <li><a href="stats/stats.php">Stats</a></li>
                    <div class="dropdown-content">
                        <div class='dropdown-link'>&nbsp;<a href="stats/single.php">Single Factions</a></div>
                        <div class='dropdown-link'>&nbsp;<a href="stats/combo.php">Combos</a></div>
                    </div>
                </div>
                <div class="dropdown">
                    <li><a href="graphs/graphs.php">Graphs</a></li>
                    <div class="dropdown-content">
                        <div class='dropdown-link'>&nbsp;<a href="graphs/single.php">Single Factions</a></div>
                        <div class='dropdown-link'>&nbsp;<a href="graphs/combo.php">Combos</a></div>
                    </div>
                </div>
                <li><a href="sudl/sudl.php">SUDL</a></li>
                <li><a href="download/download_page.php">Data</a></li>
                <li><a href="account/manage.php">Account</a></li>
                <li><a href="about/about.php">About</a></li>
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
            The Smash Up Database
        </h1>
        <div class="split">
            <div class="infobox">
                <h3>
                    The Smash Up Database is a hub for Smash Up and data lovers alike!
                </h3>
            </div>  
            <div class="infobox">
                    <h3 class="games-played-box">
                        Games Played: <?php echo $num_games; ?>
                    </h3>
                    <h3>
                        Accounts Registered: <?php echo $num_users; ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h1>
            Explore
        </h1>
        <div class="split">

            <a href="stats/stats.php" class="infobox -infobox-hover infobox--right">
                <h3 class="subtitle">
                    Stats
                </h3>
                <p class="p-proper">
                    Lightning-quick stats and rankings for each faction - including with/without titans!
                </p>
            </a>

            <a href="graphs/graphs.php" class="infobox -infobox-hover">
                <h3 class="subtitle">
                    Graphs
                </h3>
                <p class="p-proper">
                    Clean, easy to use graphs to compare the stats of different factions.
                </p>
            </a>
        </div>

        <div class="split">

            <a href="sudl/sudl.php" class="infobox -infobox-hover infobox--left">
                <h3 class="subtitle">
                    Smash Up Data Language
                </h3>
                <p class="p-proper" style="margin-bottom: 1rem;">
                    Ever wonder which factions can take on the Aliens in 2-player games?
                    Which factions you play better and worse with compared to everyone else?
                    Which factions have the biggest drop off between 2- and 3-player games?
                </p>
                <p class="p-proper">
                    The Smash Up Data Language (SUDL) will allow you to easily answer these questions - and many more!
                    Coming soon!
                </p>
            </a>  

        </div>
    </div>

    <div class="container">
        <h1>
            Contribute
        </h1>
        <div class="split">

            <a href="input_data/input_page.php" class="infobox -infobox-hover">
                <h3 class="subtitle">
                    Input Data
                </h3>
                <p class="p-proper" style="margin-bottom: .5rem;">
                    Data inputs are what keeps this website running! 
                </p>
                <p class="p-proper">
                    Easily input which the factions and victory points of each player to contribute to the database.
                </p>
            </a>

            <a href="random/random_page.php" class="infobox -infobox-hover infobox--right">
                <h3 class="subtitle">
                    Random Game
                </h3>
                <p class="p-proper">
                    After you create an account with your expansions, getting a random game is as simple as a couple clicks!
                </p>
            </a>
        </div>

        <div class="split">

            <a href="account/manage.php" class="infobox -infobox-hover infobox--left">
                <h3 class="subtitle">
                    Account
                </h3>
                <p class="p-proper" style="margin-bottom: .5rem;">
                    Creating an account allows you to input games and get personalized Smash Up stats! 
                </p>
                <p class="p-proper" style="margin-bottom: .5rem;">
                    All you need to create an account is your email, password, and the expansions that you own.
                    Join SUDB and start contributing to the database!
                </p>
            </a> 
        
        </div>
    </div>
</section>


</body>
</html>