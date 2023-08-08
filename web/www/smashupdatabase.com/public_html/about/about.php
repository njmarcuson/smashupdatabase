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
                <li><a href="../account/manage.php">Account</a></li>
                <li><a href="#">About</a></li>
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
            The Smash Up Database
        </h1>
        <div class="split">

            <div class="infobox">
                <h3 style="margin-bottom: 1.5rem;">
                    Contact Me
                </h4>

                <h4 style="margin-bottom: 1rem;">
                    Name: Nathaniel Marcuson
                </h4>
                <h4 style="margin-bottom: 1rem;">
                    Email: smashupdatabase "at" gmail "dot" com
                </h4>
                <h4 style="margin-bottom: 1rem;">
                    Resume: &lt;Resume Link&gt;
                </h4>
                <h4 style="margin-bottom: 1rem;">
                    LinkedIn: &lt;LinkedIn Link&gt;
                </h4>
                <h4 style="margin-bottom: 1rem;">
                    GitHub: &lt;GitHub Link&gt;
                </h4>
                <h4 style="margin-bottom: 1rem;">
                    PayPal Tips: &lt;PayPal Link&gt;
                </h4>
            </div>  

            <div class="infobox infobox--right">
                <h3 style="margin-bottom: 1.5rem;">
                    Credits/Community
                </h3>

                <h4 style="margin-bottom: 1rem;">
                    Smash Up: <a href='https://www.alderac.com/smash-up-home/' target="_blank">Purchase Here</a>
                </h4>
                <h4 style="margin-bottom: 1rem;">
                    Creator: Paul Peterson
                </h4>
                <h4 style="margin-bottom: 1rem;">
                    Company: <a href='https://www.alderac.com/' target="_blank">AEG</a>
                </h4>
                <h4 style="margin-bottom: 1rem;">
                    Cool Youtube Channel: <a href='https://www.youtube.com/c/CrankItUp/featured' target="_blank">Crank It Up</a>
                </h4>
                <h4 style="margin-bottom: 1rem;">
                    Reddit: <a href='https://www.reddit.com/r/smashup' target="_blank">r/smashup</a>
                </h4>
            </div>
        </div>

        <div class="split">

            <div class="infobox">
                <h3 style="margin-bottom: 1.5rem;">
                    Clarifications
                </h4>

                <h4 style="margin-bottom: 1rem;">
                    Why do I need an account to input games?
                </h4>
                <p class="p-proper" style="margin-bottom: 1.5rem;">
                    This is mostly so that you can get personalized stats.
                    This feature will be greatly expanded with the implementation of the Smash Up Data Language, as you'll be able to see which factions you're best/worst with compared to other users.
                    Also, having an account lets you get a random game without needing to re-input your expansions each time.
                    You also need an account for the reason listed below.
                </p>

                <h4 style="margin-bottom: 1rem;">
                    Why do you need my email to create an account?
                </h4>
                <p class="p-proper" style="margin-bottom: 1.5rem;">
                    Don't worry, your email will not be given to anyone. 
                    I require your email so that I can contact you if something seems wrong with your account (like if you input two identical games in a row), and so that you can safely change your password if you forget it.
                    If you still feel uncomfortable giving your email to some random dude, just use a fake email.
                </p>

                <h4 style="margin-bottom: 1rem;">
                    How Did You Make This Website?
                </h4>
                <p class="p-proper" style="margin-bottom: 1.5rem;">
                    PHP, JavaScript, CSS, and MySQL were mostly used.
                    The graphs were made with <a href="#">D3</a>, an amazing JS library.
                    The code is public on my GitHub page, but feel free to contact me if you have any questions about the development of this website.
                </p>

                <h4 style="margin-bottom: 1rem;">
                    Why do list your PayPal?
                </h4>
                <p class="p-proper" style="margin-bottom: 1.5rem;">
                    This website is a "passion project", and I do not plan to make any profit from this.
                    However, any tip is greatly apprecitated, and will never be required to use any SUDB features.
                </p>

                <h4 style="margin-bottom: 1rem;">
                    Why do list your Resume and LinkedIn?
                </h4>
                <p class="p-proper" style="margin-bottom: 1.5rem;">
                    I am currently looking for jobs as a full stack web developer in the Seattle area.
                    Feel free to reach out to me if you are interested. 
                </p>

                <h4 style="margin-bottom: 1rem;">
                    Contacting Me
                </h4>
                <p class="p-proper" style="margin-bottom: 1.5rem;">
                    Feel free to email me if you notice a bug, or are confused about anything.
                    I check that email about once a week.
                </p>

                <h4 style="margin-bottom: 1rem;">
                    What is the SD Stat?
                </h4>
                <p class="p-proper" style="margin-bottom: 1.5rem;">
                    Standard Deviation (SD) essentially measures the volatility of a faction's performance.
                    The higher the SD, the more variance we see in their VP and PFF stats.
                    With that in mind, a faction with a lower SD is ranked above a faction with a higher SD, as I find consistency to be a good faction trait.
                    To see a more detailed explanation about standard deviation, <a href="https://www.dummies.com/education/math/statistics/how-to-interpret-standard-deviation-in-a-statistical-data-set/" target="_blank">click here</a>.
                </p>

                <h4 style="margin-bottom: 1rem;">
                    Smash Up Data Language
                </h4>
                <p class="p-proper" style="margin-bottom: 1.5rem;">
                    Do you want to know which factions pair best with the Dinosaurs in 2-player games?
                    Do you want to know which factions have the biggest drop off in VP between 2- and 3-player games?
                    Do you want to know which factions are best against the Aliens?
                    With these questions (and many more) in mind, I'm developing the Smash Up Data Language to allow users to answer any question they have about Smash Up Data!
                    Which factions are best against the Aliens (an important question) - as simple as typing <span class="code">MEAN(VP) AGAINST(Aliens)</span> into an editor, and - voila! - a list of all factions ranked acccordingly!
                </p>

                <h4 style="margin-bottom: 1rem;">
                    Why a Data Language Instead of Nice Page Like "Single Faction Stats"?
                </h4>
                <p class="p-proper" style="margin-bottom: 1.5rem;">
                    Ideally, I could make a user-friendly interface that wouldn't require any typing.
                    However, my goal is to allow users to answer ANY question about the data they can think of, and a user interface to handle that would be much too complicated for the simple pages of this website.
                    With that being said, my goal is to make this language as simple and easy-to-use as possible, and I will provide thorough documentation with plenty of examples.
                </p>

                <h4 style="margin-bottom: 1rem;">
                    Is "Bear Cavalry" (without the "(T)") Inclusive of Games with Major Ursa?
                </h4>
                <p class="p-proper" style="margin-bottom: 1.5rem;">
                    Bear Cavalry, or any faction that has a titan, does NOT include games with titans when the "(T)" is absent.
                    This does not apply to Big in Japan factions, which are always assumed to be played with titans.
                    The difference in strength of factions with and without titans can be massive - just look at the Ghosts' stats.
                </p>

                <h4 style="margin-bottom: 1rem;">
                    Inputting Who Went First
                </h4>
                <p class="p-proper" style="margin-bottom: 1.5rem;">
                    This is not necessasry to input a game, so don't worry if you don't remember who went first. 
                    I include the option because it could be a useful control for people doing analysis on the data (download data <a href="#">here</a>).
                </p>

                <h4 style="margin-bottom: 1rem;">
                    I've Been Recording Games for Years, and Don't Want to Input Them One-by-One
                </h4>
                <p class="p-proper" style="margin-bottom: 1.5rem;">
                    No worries!
                    Just shoot me an email, and I'll ask you some questions to see whether your data will work for the website.
                    If it does work, I'll ask you to send over the data and I'll upload it myself.
                </p>

            </div>  

        </div>
    </div>
</section>


</body>
</html>