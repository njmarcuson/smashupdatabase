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
            <form action="forgot_password2.php" method="post" class="infobox loginbox">

                <?php
                if ($_GET['bad_email'] == "1") {
                    echo "<h3>Email did not match database</h3>";
                }
                
                if ($_GET['fail'] == "1") {
                    echo "<h3>Something went wrong. Please try again or contact me if the problem persists.</h3>";
                }

                if ($_GET['bad_code'] == "1") {
                    echo "<h3>The code did not what you were most recently emailed.</h3>";
                }

                if ($_GET['bad_password'] == "1") {
                    echo "<h3>Your passwords did not match.</h3>";
                }
                ?>

                <label for="email" class="input-login-label">Email</label>
                <input name="email" id="email" class="input-login" type="email" required />

                <input type="submit" class="submit-button-login" value="Submit" />

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