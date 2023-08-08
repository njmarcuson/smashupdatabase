/*
This will change how many toggle boxes are displayed
*/
function toggleBoxes() {
    // initialize some values
    let numPlayers = getNumPlayers();
    let container = document.getElementById("input_container");
    let box3 = document.getElementById("box3");
    let box4 = document.getElementById("box4");
    let p3First = document.getElementById("player3_first");
    let p4First = document.getElementById("player4_first");
    
    // hide the whole container if there are no players
    container.style.display = (numPlayers == "null") ? "none" : "block";

    // toggle the 3rd and 4th boxes
    box3.style.display = (numPlayers == 2) ? "none" : "block";
    box4.style.display = (numPlayers <= 3) ? "none" : "block";

    // toggle the went first
    p3First.style.display = (numPlayers == 2) ? "none" : "block";
    p4First.style.display = (numPlayers <= 3) ? "none" : "block";
}

/*
this will change the opacity and disabledness of the Submit button
*/
function toggleButton() {
    let numPlayers = getNumPlayers();

    let filledIn = isReady(numPlayers);
    let validVp = isValidVp(numPlayers);

    let toggle = filledIn && validVp;

    let button = document.getElementById('submit_button')
    button.disabled = !toggle;
    button.style.opacity = (toggle) ? .9 : .5;
}



/*************************************************
below here are some really simple helper functions
*************************************************/



function getNumPlayers() {
    return document.getElementById("number_of_players").value;
}

function isReady(numPlayers) {
    let ready = true;
    for (let i=1; i<=numPlayers; i++) {
        ready = ready && isPlayerReady(i);
    }
    return ready;
}

function isPlayerReady(player) {
    let p = "p" + player;
    let f1 = document.getElementById(p + "f1").value;
    let f2 = document.getElementById(p + "f2").value;
    let vp = document.getElementById(p + "vp").value;
    return (f1 != "null") && (f2 != "null") && (vp != "null");
}

function isValidVp(numPlayers) {
    let vp_array = getVpArray(numPlayers);

    let max = Math.max(...vp_array);
    return !duplicateMax(vp_array) && max >= 15;
}

function getVpArray(numPlayers) {
    let vp_array = [
        document.getElementById("p1vp").value,
        document.getElementById("p2vp").value
    ]
    
    if (numPlayers > 2) {
        vp_array.push(document.getElementById("p3vp").value)
    }
    if (numPlayers > 3) {
        vp_array.push(document.getElementById("p4vp").value)
    }

    return vp_array;
}

// true if there's more than one maximum in the given array
function duplicateMax(vp_array) {
    let max = Math.max(...vp_array);
    let counts = 0;
    for (let vp of vp_array) {
        if (max == vp) {
            counts++;
        }
    }
    return counts > 1;
}