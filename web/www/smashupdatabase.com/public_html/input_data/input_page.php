<?php
session_start();

// redirect to login page if they're not logged in
if ( ! array_key_exists('user', $_SESSION) ) {
    header('Location: ../account/login_page.php?from=input_page');
    die();
}

require_once('../general_functions/connection.php');
require_once('../classes/Factions.php');
require_once('../classes/User.php');
require_once('../classes/UserFactions.php');

$conn = get_connection();

$email = "njmarcuson@gmail.com";
$password = "asdf";

$user = unserialize($_SESSION['user']);

$selected2 = ($_GET['number_of_players'] == "2") ? "selected='selected'" : "";
$selected3 = ($_GET['number_of_players'] == "3") ? "selected='selected'" : "";
$selected4 = ($_GET['number_of_players'] == "4") ? "selected='selected'" : "";

$user_factions = new UserFactions($conn, $user);
$faction_options_p1f1 = $user_factions->get_faction_options(true, true, $_GET['p1f1']);
$faction_options_p1f2 = $user_factions->get_faction_options(true, true, $_GET['p1f2']);
$faction_options_p2f1 = $user_factions->get_faction_options(true, true, $_GET['p2f1']);
$faction_options_p2f2 = $user_factions->get_faction_options(true, true, $_GET['p2f2']);
$faction_options_p3f1 = $user_factions->get_faction_options(true, true, $_GET['p3f1']);
$faction_options_p3f2 = $user_factions->get_faction_options(true, true, $_GET['p3f2']);
$faction_options_p4f1 = $user_factions->get_faction_options(true, true, $_GET['p4f1']);
$faction_options_p4f2 = $user_factions->get_faction_options(true, true, $_GET['p4f2']);

$vps = range(0,25);
$vp_options = "<option value='null'>Select</option>";
foreach ($vps as $vp) {
    $vp_options .= "<option value='{$vp}'>{$vp}</option>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="input_scripts.js"></script>
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
                <li><a href="#">Input Data</a></li>
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
    
    <form action="input_data.php" method="post">

        <div class="container">
            <h3>
                How many players?
            </h3>

            <select name="number_of_players" id="number_of_players" onchange="toggleBoxes(); toggleButton();">
                <option value="null">Select</option>
                <option value="2" <?php echo $selected2; ?>>2</option>
                <option value="3" <?php echo $selected3; ?>>3</option>
                <option value="4" <?php echo $selected4; ?>>4</option>
            </select>
        </div>

        <div class="container" style="display:none;" id="input_container">
            <div class="split" style="margin-bottom: 1em;">
                <div class="infobox infobox--left">
                    <h3 class="subtitle">
                        Player 1
                    </h3>
                    <h4>
                        Factions
                    </h4>
                    <center>
                    <div class="select_factions">
                        <select name="p1f1" id="p1f1" onchange="toggleButton();">
                            <option value="null">Select</option>
                            <?php echo $faction_options_p1f1; ?>
                        </select>
                        <select name="p1f2" id="p1f2" onchange="toggleButton();">
                            <option value="null">Select</option>
                            <?php echo $faction_options_p1f2; ?>
                        </select>
                    </div>
                    </center>
                    <h4>
                        Victory Points
                    </h4>
                    <select name="p1vp" id="p1vp" onchange="toggleButton();">
                        <?php echo $vp_options; ?>
                    </select>
                </div>  

                <div class="infobox infobox--left">
                    <h3 class="subtitle">
                        Player 2
                    </h3>
                    <h4>
                        Factions
                    </h4>
                    <center>
                    <div class="select_factions">
                        <select name="p2f1" id="p2f1" onchange="toggleButton();">
                            <option value="null">Select</option>
                            <?php echo $faction_options_p2f1; ?>
                        </select>
                        <select name="p2f2" id="p2f2" onchange="toggleButton();">
                            <option value="null">Select</option>
                            <?php echo $faction_options_p2f2; ?>
                        </select>
                    </div>
                    </center>
                    <h4>
                        Victory Points
                    </h4>
                    <select name="p2vp" id="p2vp" onchange="toggleButton();">
                        <?php echo $vp_options; ?>
                    </select>
                </div>  

                <div class="infobox infobox--left" id="box3">
                    <h3 class="subtitle">
                        Player 3
                    </h3>
                    <h4>
                        Factions
                    </h4>
                    <center>
                    <div class="select_factions">
                        <select name="p3f1" id="p3f1" onchange="toggleButton();">
                            <option value="null">Select</option>
                            <?php echo $faction_options_p3f1; ?>
                        </select>
                        <select name="p3f2" id="p3f2" onchange="toggleButton();">
                            <option value="null">Select</option>
                            <?php echo $faction_options_p3f2; ?>
                        </select>
                    </div>
                    </center>
                    <h4>
                        Victory Points
                    </h4>
                    <select name="p3vp" id="p3vp" onchange="toggleButton();">
                        <?php echo $vp_options; ?>
                    </select>
                </div>  

                <div class="infobox infobox--left" id="box4">
                    <h3 class="subtitle">
                        Player 4
                    </h3>
                    <h4>
                        Factions
                    </h4>
                    <center>
                    <div class="select_factions">
                        <select name="p4f1" id="p4f1" onchange="toggleButton();">
                            <option value="null">Select</option>
                            <?php echo $faction_options_p4f1; ?>
                        </select>
                        <select name="p4f2" id="p4f2" onchange="toggleButton();">
                            <option value="null">Select</option>
                            <?php echo $faction_options_p4f2; ?>
                        </select>
                    </div>
                    </center>
                    <h4>
                        Victory Points
                    </h4>
                    <select name="p4vp" id="p4vp" onchange="toggleButton();">
                        <?php echo $vp_options; ?>
                    </select>
                </div>  
            </div>

            <h3>
                Who Went First?
            </h3>

            <select name="went_first" id="went_first" style="margin-bottom: 2em;">
                <option value="null">Select</option>
                <option value="1">Player 1</option>
                <option value="2">Player 2</option>
                <option value="3" id="player3_first">Player 3</option>
                <option value="4" id="player4_first">Player 4</option>
            </select>

            <center>
                <input type="submit" id="submit_button" class="submit_button_off submit_button" value="Submit" disabled>
            </center>
        </div>
    </form>
</section>

<script>
toggleBoxes();
</script>

</body>
</html>