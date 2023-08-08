<?php
session_start();

// redirect to login page if they're not logged in
if ( ! array_key_exists('user', $_SESSION) ) {
    header('Location: login_page.php');
    die();
}

require_once('../general_functions/connection.php');
require_once('../classes/User.php');
require_once('../classes/UserGames.php');

$conn = get_connection();
$user = unserialize($_SESSION['user']);

$table = UserGames::get_user_table($conn, $user);
?>

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
            Your Games
        </h1>
        <?php
        if ($_GET['deletion'] == "1") {
            echo "<h3>The game has been deleted successfully</h3>";
        }
        ?>
        <div class="split">

            <div class="infobox" style="padding:1.5rem .5rem; max-width:100%;">

                <div style="max-height: 40rem; width: 100%; overflow: auto;">
                <table border=1 frame=hsides rules=rows>

                    <tr class="top-row">
                        <th><div class='thing'>p1f1</div></th>
                        <th><div class='thing'>p1f2</div></th>
                        <th><div class='thing'>p1vp</div></th>
                        <th><div class='thing'>p2f1</div></th>
                        <th><div class='thing'>p2f2</div></th>
                        <th><div class='thing'>p2vp</div></th>
                        <th><div class='thing'>p3f1</div></th>
                        <th><div class='thing'>p3f2</div></th>
                        <th><div class='thing'>p3vp</div></th>
                        <th><div class='thing'>p4f1</div></th>
                        <th><div class='thing'>p4f2</div></th>
                        <th><div class='thing'>p4vp</div></th>
                        <th><div class='thing'>went_first</div></th>
                        <th><div class='thing'></div></th>
                    </tr>

                    <div style="overflow: auto;">
                        <?php echo $table; ?>
                    </div>

                </table>
                </div>
                
            </div>  


        </div>
    </div>
</section>


</body>
</html>