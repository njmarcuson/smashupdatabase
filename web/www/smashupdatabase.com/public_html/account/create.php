<?php
session_start();

require_once('../general_functions/connection.php');
require_once('../classes/Factions.php');
require_once('../classes/User.php');

$conn = get_connection();

$factions = new Factions();
$expansions = $factions->get_expansions(false, true, false);

// work on making the statement
$prep_start = "INSERT INTO users (email, password, date_created";
$prep_end = "VALUES (?, ?, NOW()";

foreach ($expansions as $exp) {

    $prep_start .= ", {$exp}";

    // if we have the expansion, do TRUE
    // if not, FALSE
    if (array_key_exists($exp, $_POST)) {
        $prep_end .= ", TRUE";
    } else {
        $prep_end .= ", FALSE";
    }

}

$prep = $prep_start . ") " . $prep_end . ")";

$stmt = $conn->prepare($prep);
$stmt->bind_param("ss", $_POST['email'], $_POST['password']);

if ( $stmt->execute() ) {

    $user = new User($conn, $_POST['email'], $_POST['password']);
    $_SESSION['user'] = serialize($user);

    header('Location: manage.php');
    die();
}
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
            Login
        </h1>
        <div class="split">
            <div class="infobox loginbox" style="padding: 3rem;">

                <h3 style="margin-bottom: 3rem;">
                    Account creation failed
                </h3>

                <div class="link-container">
                    <a href="login_page.php" class="link-login">Log In</a>
                </div>

                <div class="link-container">
                    <a href="create_page.php" class="link-login">Create Account</a>
                </div>
                
                <div class="link-container">
                    <a href="forgot_password.php" class="link-login">Forgot Password</a>
                </div>

            </form>  
        </div>
    </div>
</section>


</body>
</html>