<?php
session_start();

require_once('../general_functions/connection.php');
require_once('../classes/Factions.php');
require_once('../classes/User.php');
require_once('../classes/StatsHelper.php');
require_once('../classes/SingleStats.php');

$conn = get_connection();
$user = unserialize($_SESSION['user']);

$email = $user ? $user->get_email() : "";

// instantiate the objects we need
$factions = new Factions();
$single_stats = new SingleStats();

// get the data we need
$stats = $single_stats->get_all_stats($conn, $factions, $email);
$exp_checkboxes = $factions->get_expansions_checkboxes(array('Base Set'), true, "onchange='doD3()'");

$exps_to_factions = $factions->get_expansions_to_factions();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="style.css">
    <script src="graph_scripts.js"></script>
    <script src="https://d3js.org/d3.v4.js"></script>
    <script src="../general_scripts/scripts.js"></script>
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
                    <li><a href="graphs.php">Graphs</a></li>
                    <div class="dropdown-content">
                        <div class='dropdown-link'>&nbsp;<a href="#">Single Factions</a></div>
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
            Single Faction Graphs
        </h1>
    </div>
    
    <div class="container" id="container">

        <center>
        <div id="single_graph">
        </div>
        </center>

        <div class="split">
            <div class="infobox">
                <?php echo $exp_checkboxes; ?>
            </div>
            <div class="infobox">

                <?php
                // give them a nice prompting
                if ($email == null) {
                    echo "<h3 style='margin-bottom:1em;'>
                        <a class='link-account' href='../account/login_page.php'>Login</a> to view graphs for your games!
                        </h3>";
                } else {
                    echo "
                    <center>
                    <label for='checkbox' style='padding: 0'>
                        <span id='all_games'>All Games &nbsp;&nbsp;</span>
                        <div class='switch'>
                            <input type='checkbox' id='checkbox' onchange='doD3();'>
                            <span class='slider round graph'></span>
                        </div> 
                        <span id='your_games'>&nbsp;&nbsp; Your Games</span>
                    </label>
                    </center>
                    ";
                }
                ?>


                <select id="players" class="big-select" onchange="doD3();">

                    <option value="2p">
                        2-Players
                    </option>

                    <option value="3p">
                        3-Players
                    </option>

                    <option value="4p">
                        4-Players
                    </option>

                    <option value="all">
                        All Games
                    </option>

                </select>

                <select id="stat1" class="big-select" onchange="doD3();">

                    <option value="wp">
                        Wins
                    </option>

                    <option value="vp">
                        Victory Points
                    </option>

                    <option value="pff">
                        Points From First
                    </option>
                    
                </select>

                <select id="stat2" class="big-select" onchange="doD3();">
                    
                </select>

            </div>
            
        </div>
    </div>


</section>

<script>
var bigKahuna = <?php echo json_encode($stats); ?>;
var expsToFactions = <?php echo json_encode($exps_to_factions); ?>;

let factions = [];

var oldStats = {
    stat1: "",
    stat2: ""
}

doD3();

</script>

</body>
</html>