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
                    <li><a href="#">Graphs</a></li>
                    <div class="dropdown-content">
                        <div class='dropdown-link'>&nbsp;<a href="single.php">Single Factions</a></div>
                        <div class='dropdown-link'>&nbsp;<a href="combo.php">Combos</a></div>
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
            Graphs
        </h1>
        <div class="split">

            <a href="single.php" class="infobox -infobox-hover">

                <h3 style="margin-bottom: 2rem;">
                    Single Faction Graphs
                </h3> 

                <h4 style="margin-bottom: 1rem;">
                    Visually compare factions with tons of graphs!
                </h4>

                <p class="p-proper">
                    As of right now, you cannot choose individual factions, but rather expansions.
                    This was to avoid cluttering of the page, as 99 faction checkboxes would create quite a mess!
                    If you find this unsatisfactory, shoot me an email.
                </p>

            </a>  

            <a href="combo.php" class="infobox -infobox-hover">

                <h3 style="margin-bottom: 2rem;">
                    Combo Graphs
                </h3> 

                <h4 style="margin-bottom: 1rem;">
                    See which factions best pair with each other!
                </h4>

                <p class="p-proper">
                    Choose a single faction, and compare how different factions pair with it!
                    The same limitation in the single stats applies - don't hesitate to email me if you would like this changed!
                </p>

            </a>  

        </div>
    </div>
</section>


</body>
</html>