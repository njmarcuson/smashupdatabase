<?php
session_start();

require_once('../general_functions/connection.php');
require_once('../classes/Factions.php');
require_once('../classes/User.php');
require_once('../classes/StatsHelper.php');
require_once('../classes/ComboStats.php');

$conn = get_connection();
$user = unserialize($_SESSION['user']);

// instantiate the objects we need
$factions = new Factions();

// get the shit from the header
$f1 = $_GET['f1'];
$f2 = $_GET['f2'];
$use_user = $_GET['user'];

// true if we should load the stats
$load_stuff = !is_null($f1) and !is_null($f2);
$email = (is_null($user) || is_null($use_user)) ? "" : $user->get_email();

// get the data we need
if ($load_stuff) {
    $stats = ComboStats::get_combo_stats($conn, $f1, $f2, $email);
}

$faction_options1 = $factions->get_faction_options(true, true, $f1);
$faction_options2 = $factions->get_faction_options(true, true, $f2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="combo_scripts.js"></script>
    <script src="../general_scripts/scripts.js"></script>
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
                    <li><a href="stats.php">Stats</a></li>
                    <div class="dropdown-content">
                        <div class='dropdown-link'>&nbsp;<a href="single.php">Single Factions</a></div>
                        <div class='dropdown-link'>&nbsp;<a href="#">Combos</a></div>
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
            Combo Stats
        </h1>
    </div>
    

    <form action="combo.php" method="get" class="container">
        <?php
        // give them a nice prompting
        if (is_null($_SESSION['user'])) {
            echo "<h3 style='margin-bottom:1em;'>
                <a href='../account/login_page.php' style='color: inherit;'>Login</a> to view stats for your games!
                </h3>";
        } else {

            $checked = ($email == "") ? "" : "checked='checked'";

            echo "
            <center>
            <label for='checkbox'>
                <span id='all_games'>All Games &nbsp;&nbsp;</span>
                <div class='switch'>
                    <input name='user' type='checkbox' id='checkbox' onchange='toggleStats();' {$checked}>
                    <span class='slider round'></span>
                </div> 
                <span id='your_games' style='color: #4d6366;'>&nbsp;&nbsp; Your Games</span>
            </label>
            </center>
            ";
        }
        ?>
        
        <h3>
            Which factions?
        </h3>

        <center>
        <div class="select_factions">
            <select name="f1" id="f1" class="big-select" onchange="toggleStats();" required>
                <option value="">Select</option>
                <?php echo $faction_options1; ?>
            </select>

            <select name="f2" id="f2" class="big-select" onchange="toggleStats();" required>
                <option value="">Select</option>
                <?php echo $faction_options2; ?>
            </select>
        </div>

        <input type="submit" value="Get Stats" class="submit_button" style="font-size: 1.25rem; width: 9rem; height: 3.5rem;" />
        </center>


    </form>

    <div class="container" id="stats_container" <?php if (!$load_stuff) { echo "style='display:none'"; } ?>>

        <div class="split" style="margin-bottom: 1em;">

            <div class="infobox statbox">

                <h3 class="subtitle">
                    All
                </h3>

                <div class="stat-text-container">

                    <div class="stat-text" style="margin-bottom: 1em">
                        <h4 class="header-left">
                            Win Stats
                        </h4>
                        <p class="small p-stats">
                            
                            Wins: 
                            <span class="stats">
                                <span id="all_wp_nwins">420</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Games: 
                            <span class="stats">
                                <span id="all_wp_count">420</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Win %: 
                            <span class="stats">
                                <span id="all_wp_mean">16.4%</span>
                            </span>
                        </p>
                    </div>

                    <div class="stat-text" style="margin-bottom: 1em">
                        <h4 class="header-left">
                            Victory Points
                        </h4>
                        <p class="small p-stats">
                            
                            Mean: 
                            <span class="stats">
                                <span id="all_vp_mean">69</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="all_vp_median">420</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="all_vp_sd">16.4%</span>
                            </span>
                        </p>
                    </div>
                    
                    <div class="stat-text" style="margin-bottom: 1em">
                        <h4 class="header-left">
                            Points From First
                        </h4>
                        <p class="small p-stats">
                            
                            Mean: 
                            <span class="stats">
                                <span id="all_pff_mean">69</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="all_pff_median">420</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="all_pff_sd">16.4%</span>
                            </span>
                        </p>
                    </div>
                </div>
            </div>  

            <div class="infobox statbox">
                <h3 class="subtitle">
                    2 Players
                </h3>

                <div class="stat-text-container">

                    <div class="stat-text" style="margin-bottom: 1em">
                        <h4 class="header-left">
                            Win Stats
                        </h4>
                        <p class="small p-stats">
                            
                            Wins: 
                            <span class="stats">
                                <span id="2p_wp_nwins">69</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Games: 
                            <span class="stats">
                                <span id="2p_wp_count">420</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Win %: 
                            <span class="stats">
                                <span id="2p_wp_mean">16.4%</span>
                            </span>
                        </p>
                    </div>

                    <div class="stat-text" style="margin-bottom: 1em">
                        <h4 class="header-left">
                            Victory Points
                        </h4>
                        <p class="small p-stats">
                            
                            Mean: 
                            <span class="stats">
                                <span id="2p_vp_mean">69</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="2p_vp_median">420</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="2p_vp_sd">16.4%</span>
                            </span>
                        </p>
                    </div>
                    
                    <div class="stat-text" style="margin-bottom: 1em">
                        <h4 class="header-left">
                            Points From First
                        </h4>
                        <p class="small p-stats">
                            
                            Mean: 
                            <span class="stats">
                                <span id="2p_pff_mean">69</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="2p_pff_median">420</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="2p_pff_sd">16.4%</span>
                            </span>
                        </p>
                    </div>
                </div>
            </div>  

            <div class="infobox statbox" id="box3">
                <h3 class="subtitle">
                    3 Players
                </h3>
                <div class="stat-text-container">
                    <div class="stat-text" style="margin-bottom: 1em">
                        <h4 class="header-left">
                            Win Stats
                        </h4>
                        <p class="small p-stats">
                            
                            Wins: 
                            <span class="stats">
                                <span id="3p_wp_nwins">69</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Games: 
                            <span class="stats">
                                <span id="3p_wp_count">420</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Win %: 
                            <span class="stats">
                                <span id="3p_wp_mean">16.4%</span>
                            </span>
                        </p>
                    </div>

                    <div class="stat-text" style="margin-bottom: 1em">
                        <h4 class="header-left">
                            Victory Points
                        </h4>
                        <p class="small p-stats">
                            
                            Mean: 
                            <span class="stats">
                                <span id="3p_vp_mean">69</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="3p_vp_median">420</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="3p_vp_sd">16.4%</span>
                            </span>
                        </p>
                    </div>
                    
                    <div class="stat-text" style="margin-bottom: 1em">
                        <h4 class="header-left">
                            Points From First
                        </h4>
                        <p class="small p-stats">
                            
                            Mean: 
                            <span class="stats">
                                <span id="3p_pff_mean">69</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="3p_pff_median">420</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="3p_pff_sd">16.4%</span>
                            </span>
                        </p>
                    </div>
                </div>
            </div>  

            <div class="infobox statbox" id="box4">
                <h3 class="subtitle">
                    4 Players
                </h3>
                <div class="stat-text-container">
                    <div class="stat-text" style="margin-bottom: 1em">
                        <h4 class="header-left">
                            Win Stats
                        </h4>
                        <p class="small p-stats">
                            
                            Wins: 
                            <span class="stats">
                                <span id="4p_wp_nwins">69</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Games: 
                            <span class="stats">
                                <span id="4p_wp_count">420</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Win %: 
                            <span class="stats">
                                <span id="4p_wp_mean">16.4%</span>
                            </span>
                        </p>
                    </div>

                    <div class="stat-text" style="margin-bottom: 1em">
                        <h4 class="header-left">
                            Victory Points
                        </h4>
                        <p class="small p-stats">
                            
                            Mean: 
                            <span class="stats">
                                <span id="4p_vp_mean">69</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="4p_vp_median">420</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="4p_vp_sd">16.4%</span>
                            </span>
                        </p>
                    </div>
                    
                    <div class="stat-text" style="margin-bottom: 1em">
                        <h4 class="header-left">
                            Points From First
                        </h4>
                        <p class="small p-stats">
                            
                            Mean: 
                            <span class="stats">
                                <span id="4p_pff_mean">69</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="4p_pff_median">420</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="4p_pff_sd">16.4%</span>
                            </span>
                        </p>
                    </div>
                </div>
            </div>  
        </div>

    </div>
</section>

<script>
var stats = <?php echo json_encode($stats); ?>;
toggleStats();
</script>

</body>
</html>