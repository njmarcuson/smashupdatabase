<?php
session_start();

require_once('../general_functions/connection.php');

$conn = get_connection();

// validate whether they have sent a valid email
// send them baccck if the don't
$prep = "SELECT COUNT(*) AS count FROM users WHERE email = ?";
$stmt = $conn->prepare($prep);
$stmt->bind_param("s", $_POST['email']);
$stmt->execute();
$result = $stmt->get_result();
if ( ! $result->fetch_assoc()['count'] ) {
    header('Location: forgot_password.php?bad_email=1');
    die();
}

// get the unique code to send them
$code = substr(md5(uniqid(mt_rand(), true)), 0, 8);
$_SESSION['code'] = $code;
$_SESSION['email'] = $_POST['email'];

// mail the code
mail(
    $_POST['email'], 
    "SUBD Password Change Code",
    "Code: {$code}\n\nDO NOT REPLY",
    $headers  = "From: Smash Up Database <smashupdatabase@gmail.com>"
);
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
            Forgot Password
        </h1>
        <div class="split">
            <form action="forgot_password3.php" method="post" class="infobox loginbox">

                <h3>
                    Do Not Refresh This Page! 
                </h3>

                <label for="code" class="input-login-label">Code You Have Been Emailed</label>
                <input name="code" id="code" class="input-login" required />

                <label for="password" class="input-login-label">New Password</label>
                <input name="password" id="password" class="input-login" type="password" required />

                <label for="repeat_password" class="input-login-label">Repeat New Password</label>
                <input name="repeat_password" id="repeat_password" class="input-login" type="password" required />

                <input type="submit" class="submit-button-login" value="Update" />

                <div class="link-container">
                    <a href="login_page.php" class="link-login">Log In</a>
                </div>
                
                <div class="link-container">
                    <a href="create_page.php" class="link-login">Create Account</a>
                </div>
                

            </form>  
        </div>
    </div>
</section>


</body>
</html>