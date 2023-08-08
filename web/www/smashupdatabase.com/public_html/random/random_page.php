<?php
session_start();

// redirect to login page if they're not logged in
if ( ! array_key_exists('user', $_SESSION) ) {
    header('Location: ../account/login_page.php?from=random_page');
    die();
}

require_once('../general_functions/connection.php');
require_once('../classes/Factions.php');
require_once('../classes/User.php');
require_once('../classes/UserFactions.php');

$conn = get_connection();

$user = unserialize($_SESSION['user']);


$user_factions = new UserFactions($conn, $user);
$factions = $user_factions->get_factions_merge();
$js_factions = json_encode($factions);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="random_scripts.js"></script>
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
                <li><a href="#">Random Game</a></li>
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
            Random Game
        </h1>
    </div>
    
    <form action="../input_data/input_page.php" method="get">

        <div class="container">
            <h3>
                How many players?
            </h3>

            <select name="number_of_players" id="number_of_players" style="margin-bottom:1.5rem;" onchange='randomize(<?php echo $js_factions; ?>);'>
                <option value="null">Select</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>

            <div id="everything_else" style="display:none">

                <center>
                    <div style="margin-bottom: 1rem;">
                        <a href="#" style="color: inherit;" onclick='randomize(<?php echo $js_factions; ?>);'>
                            Refresh
                        </a>
                    </div>
                </center>

                <div class="split" style="margin-bottom: 1em; align-items:center">
                    <div class="infobox playerbox">
                        <h3>
                            Player 1
                        </h3>
                        <p id="p1f1_p" class="center bottom"></p>
                        <input id="p1f1_input" name="p1f1" type="hidden" value="">
                        <p id="p1f2_p" class="center"></p>
                        <input id="p1f2_input" name="p1f2" type="hidden" value="">
                    </div>  
                    <div class="infobox playerbox">
                        <h3>
                            Player 2
                        </h3>
                        <p id="p2f1_p" class="center bottom"></p>
                        <input id="p2f1_input" name="p2f1" type="hidden" value="">
                        <p id="p2f2_p" class="center"></p>
                        <input id="p2f2_input" name="p2f2" type="hidden" value="">
                    </div>
                    <div class="infobox playerbox" id="box3">
                        <h3>
                            Player 3
                        </h3>
                        <p id="p3f1_p" class="center bottom"></p>
                        <input id="p3f1_input" name="p3f1" type="hidden" value="">
                        <p id="p3f2_p" class="center"></p>
                        <input id="p3f2_input" name="p3f2" type="hidden" value="">
                    </div>
                    <div class="infobox playerbox" id="box4">
                        <h3>
                            Player 4
                        </h3>
                        <p id="p4f1_p" class="center bottom"></p>
                        <input id="p4f1_input" name="p4f1" type="hidden" value="">
                        <p id="p4f2_p" class="center"></p>
                        <input id="p4f2_input" name="p4f2" type="hidden" value="">
                    </div>
                    
                </div>

                <h3>
                    Player <span id="first_span">2</span> Goes First!
                    <input id="first_input" name="first" type="hidden" value="1">
                </h3>

                <center>
                    <input type="submit" id="submit_button" class="submit_button" value="Input Data" >
                </center>
            </div>
        </div>
    </form>
</section>

</body>
</html>