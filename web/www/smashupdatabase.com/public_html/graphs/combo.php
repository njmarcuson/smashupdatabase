<?php
session_start();

require_once('../general_functions/connection.php');
require_once('../classes/Factions.php');
require_once('../classes/User.php');
require_once('../classes/StatsHelper.php');
require_once('../classes/ComboStats.php');

$conn = get_connection();
$user = unserialize($_SESSION['user']);

$email = $user ? $user->get_email() : "";

// instantiate the objects we need
$factions = new Factions();
$combo_stats = new ComboStats();


$exps_to_factions = $factions->get_expansions_to_factions();

// only do d3 if we have "faction" in the get
$doD3 = intval(!is_null($_GET['faction']) and $_GET['faction'] != "null");

$f1 = $_GET['faction'];
$exps = array();
foreach ($exps_to_factions as $exp => $fs) {

    if (!is_null($_GET[$exp])) {
        array_push($exps, $exp);
    }

}

$stat1 = $_GET['stat1'];
$stat2 = $_GET['stat2'];
$players = $_GET['players'];
$email = ($_GET['allgames'] == "on") ? $user->get_email() : "";

// checkboxes/options
$exp_checkboxes = $factions->get_expansions_checkboxes($exps, true);
$faction_options = $factions->get_faction_options(true, true, $f1);

$stats = array();
$factions = array();
foreach ($exps as $exp) {
    foreach ($exps_to_factions[$exp] as $f2) {
        $s = $combo_stats->get_combo_stats($conn, $f1, $f2, $email);
        $stats[$f2] = $s[$players][$stat1][$stat2];
        array_push($factions, $f2);
    }
}
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
                        <div class='dropdown-link'>&nbsp;<a href="single.php">Single Factions</a></div>
                        <div class='dropdown-link'>&nbsp;<a href="#">Combos</a></div>
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
<form action="#" method="get">
<section>
    <div class="container">
        <h1>
            Combo Graphs
        </h1>
    </div>
    
    <div class="container" id="container">

        <center>
        <div id="single_graph">
        </div>
        </center>

        <div class="split">

            <div class="infobox">

                <select id="faction" name="faction" class="big-select" onchange="toggleStats();" style="font-size: 1rem; height: 2rem; margin-bottom: 1rem;">
                    <option value="null">First Faction</option>
                    <?php echo $faction_options; ?>
                </select>
                
                <h4 style="margin-bottom: .5rem;">
                    Combo Factions
                </h4>
                <?php echo $exp_checkboxes; ?>

            </div>

            <div class="infobox">

                <?php
                // give them a nice prompting
                if (! $user) {
                    echo "<h3 style='margin-bottom:1em;'>
                            <a class='link-account' href='../account/login_page.php'>Login</a> to view graphs for your games!
                        </h3>";
                } else {
                    echo "
                    <center>
                    <label for='checkbox' style='padding: 0'>
                        <span id='all_games'>All Games &nbsp;&nbsp;</span>
                        <div class='switch'>
                            <input type='checkbox' id='checkbox' name='allgames'  onchange='toggleGameLabels(); yourGames(document.getElementById(\"container\").offsetWidth)'>
                            <span class='slider round graph'></span>
                        </div> 
                        <span id='your_games'>&nbsp;&nbsp; Your Games</span>
                    </label>
                    </center>
                    ";
                }
                ?>


                <select id="players" name="players" class="big-select">

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

                <select id="stat1" name="stat1" class="big-select" onchange="changeStat2()">

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

                <select id="stat2" name="stat2" class="big-select">
                    
                </select>

                <center>
                <input type="submit" value="Get Graph" class="submit_button" style="font-size: 1.25rem; width: 9rem; height: 3.5rem; margin-top: 2rem;" />
                </center>
            </div>
            
        </div>
    </div>


</section>
</form>

<script>
var bigKahuna = <?php echo json_encode($stats); ?>;
var expsToFactions = <?php echo json_encode($exps_to_factions); ?>;
var factionsUsed = <?php echo json_encode($factions); ?>;

var oldStats = {
    stat1: "",
    stat2: ""
}

if (<?php echo $doD3; ?>) {
    var stat2PHP = "<?php echo $stat2; ?>";

    document.getElementById('players').value = "<?php echo $players; ?>";
    document.getElementById('stat1').value = "<?php echo $stat1; ?>";
    document.getElementById('stat2').value = stat2PHP;
    doD3(false);
} else {
    changeStat2(true);
    toggleGameLabels(document.getElementById("container").offsetWidth);
}
</script>

</body>
</html>