/*
The big kahuna. All it needs is an array of the factions.
*/
function randomize(factions) {

    let numPlayers = +document.getElementById("number_of_players").value;
    let split = document.getElementById("everything_else");

    split.style.display = isNaN(numPlayers) ? 'none' : '';

    randomizeFactions(factions, numPlayers);

    adjustBlocks(numPlayers);

    adjustFirstPlayer(numPlayers);
}

/*
Randomizes all the factions and adjusts the page
*/
function randomizeFactions(factions, numPlayers) {

    let playerFactions = getPlayerFactionsArray();

    for (let i=0; i<numPlayers*2; i++) {

        let playerFaction = playerFactions[i];

        let paragraph = document.getElementById(playerFaction + "_p");
        let input = document.getElementById(playerFaction + "_input");

        let faction = getRandomFaction(factions);

        paragraph.innerHTML = faction;
        input.value = faction;

    }

}

/*
toggles whether 2, 3, or 4 blocks show
*/
function adjustBlocks(numPlayers) {
    let box3 = document.getElementById("box3");
    let box4 = document.getElementById("box4");
    box3.style.display = (numPlayers == 2) ? "none" : "block";
    box4.style.display = (numPlayers <= 3) ? "none" : "block";
}

/*
adjusts the page for who goes first
*/
function adjustFirstPlayer(numPlayers) {

    let span = document.getElementById('first_span');
    let input = document.getElementById('first_input');

    firstPlayer = getRandomInt(numPlayers) + 1

    span.innerHTML = firstPlayer;
    input.value = firstPlayer;

}

/*
gets random faction
deletes the faction from the big array
*/
function getRandomFaction(factions) {
    index = getRandomInt(factions.length);
    faction = factions[index];
    factions.splice(index, 1);
    return faction;
}

function getPlayerFactionsArray() {
    return [
        "p1f1",
        "p1f2",
        "p2f1",
        "p2f2",
        "p3f1",
        "p3f2",
        "p4f1",
        "p4f2",
    ];
}

function getRandomInt(max) {
    return Math.floor(Math.random() * max);
}