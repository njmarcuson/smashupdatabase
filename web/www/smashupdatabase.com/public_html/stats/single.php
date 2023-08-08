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
$faction_options = $factions->get_faction_options(true, true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="single_scripts.js"></script>
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
                    <li><a href="stats.php">Stats</a></li>
                    <div class="dropdown-content">
                        <div class='dropdown-link'>&nbsp;<a href="#">Single Factions</a></div>
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
            Single Faction Stats
        </h1>
    </div>
    

    <div class="container">
        <?php
        // give them a nice prompting
        if ($email == null) {
            echo "<h3 style='margin-bottom:1em;'>
                    <a href='../account/login_page.php' style='color: inherit;'>Login</a> to view stats for your games!
                </h3>";
        } else {
            echo "
            <center>
            <label for='checkbox'>
                <span id='all_games'>All Games &nbsp;&nbsp;</span>
                <div class='switch'>
                    <input type='checkbox' id='checkbox' onchange='toggleStats();'>
                    <span class='slider round'></span>
                </div> 
                <span id='your_games' style='color: #4d6366;'>&nbsp;&nbsp; Your Games</span>
            </label>
            </center>
            ";
        }
        ?>
        <h3>
            Which faction?
        </h3>

        <select id="faction" class="big-select" onchange="toggleStats();">
            <option value="null">Select</option>
            <?php echo $faction_options; ?>
        </select>

    </div>

    <div class="container" id="stats_container" style="display: none;">

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
                                <span id="all_wp_nwins">69</span>
                                <span id="all_wp_nwins_rank" class="ranking">(10th)</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Games: 
                            <span class="stats">
                                <span id="all_wp_count">420</span>
                                <span id="all_wp_count_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Win %: 
                            <span class="stats">
                                <span id="all_wp_mean">16.4%</span>
                                <span id="all_wp_mean_rank" class="ranking">10th</span>
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
                                <span id="all_vp_mean_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="all_vp_median">420</span>
                                <span id="all_vp_median_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="all_vp_sd">16.4%</span>
                                <span id="all_vp_sd_rank" class="ranking">10th</span>
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
                                <span id="all_pff_mean_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="all_pff_median">420</span>
                                <span id="all_pff_median_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="all_pff_sd">16.4%</span>
                                <span id="all_pff_sd_rank" class="ranking">10th</span>
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
                                <span id="2p_wp_nwins_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Games: 
                            <span class="stats">
                                <span id="2p_wp_count">420</span>
                                <span id="2p_wp_count_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Win %: 
                            <span class="stats">
                                <span id="2p_wp_mean">16.4%</span>
                                <span id="2p_wp_mean_rank" class="ranking">10th</span>
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
                                <span id="2p_vp_mean_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="2p_vp_median">420</span>
                                <span id="2p_vp_median_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="2p_vp_sd">16.4%</span>
                                <span id="2p_vp_sd_rank" class="ranking">10th</span>
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
                                <span id="2p_pff_mean_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="2p_pff_median">420</span>
                                <span id="2p_pff_median_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="2p_pff_sd">16.4%</span>
                                <span id="2p_pff_sd_rank" class="ranking">10th</span>
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
                                <span id="3p_wp_nwins_rank" class="ranking">(10th)</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Games: 
                            <span class="stats">
                                <span id="3p_wp_count">420</span>
                                <span id="3p_wp_count_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Win %: 
                            <span class="stats">
                                <span id="3p_wp_mean">16.4%</span>
                                <span id="3p_wp_mean_rank" class="ranking">10th</span>
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
                                <span id="3p_vp_mean_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="3p_vp_median">420</span>
                                <span id="3p_vp_median_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="3p_vp_sd">16.4%</span>
                                <span id="3p_vp_sd_rank" class="ranking">10th</span>
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
                                <span id="3p_pff_mean_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="3p_pff_median">420</span>
                                <span id="3p_pff_median_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="3p_pff_sd">16.4%</span>
                                <span id="3p_pff_sd_rank" class="ranking">10th</span>
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
                                <span id="4p_wp_nwins_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Games: 
                            <span class="stats">
                                <span id="4p_wp_count">420</span>
                                <span id="4p_wp_count_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Win %: 
                            <span class="stats">
                                <span id="4p_wp_mean">16.4%</span>
                                <span id="4p_wp_mean_rank" class="ranking">10th</span>
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
                                <span id="4p_vp_mean_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="4p_vp_median">420</span>
                                <span id="4p_vp_median_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="4p_vp_sd">16.4%</span>
                                <span id="4p_vp_sd_rank" class="ranking">10th</span>
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
                                <span id="4p_pff_mean_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            Median: 
                            <span class="stats">
                                <span id="4p_pff_median">420</span>
                                <span id="4p_pff_median_rank" class="ranking">10th</span>
                            </span>
                        </p>
                        <p class="small p-stats">
                            
                            SD: 
                            <span class="stats">
                                <span id="4p_pff_sd">16.4%</span>
                                <span id="4p_pff_sd_rank" class="ranking">10th</span>
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
</script>

</body>
</html>