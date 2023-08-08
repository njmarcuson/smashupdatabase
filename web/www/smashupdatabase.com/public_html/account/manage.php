<?php
session_start();

// redirect to login page if they're not logged in
if ( ! array_key_exists('user', $_SESSION) ) {
    header('Location: login_page.php');
    die();
}

require_once('../general_functions/connection.php');
require_once('../classes/Factions.php');
require_once('../classes/User.php');
require_once('../classes/UserFactions.php');
require_once('../classes/StatsHelper.php');
require_once('../classes/SingleStats.php');
require_once('../classes/UserStats.php');
require_once('../classes/BasicStats.php');

$conn = get_connection();

$user = unserialize($_SESSION['user']);

$factions = new Factions();
$user_factions = new UserFactions($conn, $user);
$user_stats = new UserStats($conn, $factions, $user->get_email());

// get the fun stats 
$num_games = BasicStats::get_num_games_user($conn, $user->get_email());


$has_games = $user_stats->has_games();
if ($has_games) {
    $best_faction = $user_stats->get_best_faction();
    $worst_faction = $user_stats->get_worst_faction();


    $compared = $user_stats->get_compared();

    $most_played_faction = $user_stats->get_most_played_faction();
    $least_played_faction = $user_stats->get_least_played_faction();
}


// get the expansions the user has
$expansions = $user_factions->get_expansions(true, false, true);
if ($user_factions->user_has_titan()) {
    array_push($expansions, "Titans Pack");
}
$expansion_list = "";
foreach ($expansions as $exp) {
    $expansion_list .= "<p style='margin-bottom: .15rem; text-align: center;'>{$exp}</p>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
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
                    <li><a href="../graphs/graphs.php">Graphs</a></li>
                    <div class="dropdown-content">
                        <div class='dropdown-link'>&nbsp;<a href="../graphs/single.php">Single Factions</a></div>
                        <div class='dropdown-link'>&nbsp;<a href="../graphs/combo.php">Combos</a></div>
                    </div>
                </div>
                <li><a href="../sudl/sudl.php">SUDL</a></li>
                <li><a href="../download/download_page.php">Data</a></li>
                <li><a href="manage.php">Account</a></li>
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
            Manage Account
        </h1>
        <div class="split">

            <div class="infobox accountbox">
                <h3 style="margin-bottom: 2rem;">
                    Account Info
                </h3>

                <h4 style="margin-bottom: .75rem;">Email: <span class="span-light"> <?php echo $user->get_email(); ?> </span></h4>

                <div class="link-container" style="margin-bottom: 1.25rem;">
                    <a href="change_password_page.php" class="link-account">Change Password</a>
                </div>

                <div class="margin-below">

                    <h4>Total Games Played: 
                        <?php echo $num_games['val']; ?> 
                        <span class="ranking" id="ranking"><?php echo $num_games['rank']; ?></span>
                    </h4>

                </div>
                
                <div class="margin-below">

                    <h4>Most Played: 
                        <?php echo $most_played_faction['faction']; ?> 
                        <span class="ranking">
                            <?php 
                            echo $most_played_faction['val']; 
                            if ($has_games) {
                                echo " games";
                            }
                            ?> 
                        </span>
                    </h4>

                    <h4>Least Played:
                        <?php echo $least_played_faction['faction']; ?> 
                        <span class="ranking">
                            <?php 
                            echo $least_played_faction['val']; 
                            if ($has_games) {
                                echo " games";
                            }
                            ?> 
                        </span>
                    </h4>

                </div>

                <div class="margin-below">

                    <h4>Best Faction:
                        <?php echo $best_faction['faction']; ?> 
                        <span class="ranking">
                            <?php echo $best_faction['val'];
                            if ($has_games) {
                                echo " VP";
                            }
                            ?> 
                        </span>
                    </h4>

                    <h4>Best Compared:
                        <?php echo $compared['best_faction']; ?> 
                        <span class="ranking">
                            <?php 
                            if ($has_games) {
                                echo "+";
                            }
                            echo $compared['best_val']; ?> 
                        </span>
                    </h4>

                </div>

                <div class="margin-below">

                    <h4>Worst Faction:
                        <?php echo $worst_faction['faction']; ?> 
                        <span class="ranking">
                            <?php echo $worst_faction['val']; 
                            if ($has_games) {
                                echo " VP";
                            }
                            ?> 
                        </span>
                    </h4>

                    <h4>Worst Compared:
                        <?php echo $compared['worst_faction']; ?> 
                        <span class="ranking">
                            <?php echo $compared['worst_val']; ?> 
                        </span>
                    </h4>

                </div>

                <div class="link-container" style="margin-top: 1.5rem; margin-bottom: 2rem;">
                    <a href="view_games.php" class="link-account">View All Games</a>
                </div>

                <div class="link-container" style="margin-top: 1rem;">
                    <a href="logout.php" class="link-account">Log Out</a>
                </div>
                
            </div>  

            <div class="infobox accountbox">
                <h3 style="margin-bottom: 2rem;">
                    Expansions
                </h3>

                <?php 
                // handle it if something went wrong with the expansion update
                if (!is_null($_GET['exp_success']) and $_GET['exp_success']=="0") {
                    echo "<p id='error-message'>Something went wrong with the update - please try again! 
                    If the problem persists, shoot me an email with an explanation and screenshots.</p>";
                }

                // checkboxes of expansions
                echo $expansion_list; 
                ?>

                <div class="link-container" style="margin-top: 1rem;" style="margin-top: 1.25rem;">
                    <a href="expansions.php" class="link-account">Edit Expansions</a>
                </div>  

            </div>

        </div>
    </div>
</section>
<script>
let ranking = document.getElementById('ranking').innerHTML;
document.getElementById('ranking').innerHTML = getPrettyRank(ranking, false);
</script>

</body>
</html>