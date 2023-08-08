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
                    <li><a href="#">Stats</a></li>
                    <div class="dropdown-content">
                        <div class='dropdown-link'>&nbsp;<a href="single.php">Single Factions</a></div>
                        <div class='dropdown-link'>&nbsp;<a href="combo.php">Combos</a></div>
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
            Stats
        </h1>
        <div class="split">

            <a href="single.php" class="infobox -infobox-hover">

                <h3 style="margin-bottom: 2rem;">
                    Single Faction Stats
                </h3> 

                <h4 style="margin-bottom: 1rem;">
                    View tons of stats for each faction!
                </h4>

                <p class="p-proper">
                    It may take a second for the page to load (A LOT of data is processed). 
                    But once the page loads, getting stats for each faction is lightning-quick!
                </p>

            </a>  

            <a href="combo.php" class="infobox -infobox-hover">

                <h3 style="margin-bottom: 2rem;">
                    Combo Stats
                </h3> 

                <h4 style="margin-bottom: 1rem;">
                    View stats for any possible combo!
                </h4>

                <p class="p-proper">
                    The data for your desired combo may be sparse, as there are over 8,000 combos when factoring in titans. 
                    Keep playing and inputting games, and we'll eventually have plenty of data for every combo!
                </p>

            </a>  

        </div>
    </div>
</section>


</body>
</html>