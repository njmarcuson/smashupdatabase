function getPrettyRank(rank, tie) {

    if (rank == "NA" || !rank) {
        return "";
    }

    lastDigit = rank % 10;
    last2Digits = rank % 100;
    rank = rank.toString();

    if (lastDigit == 1 && last2Digits != 11) {
        rank += "st";
    } else if (lastDigit == 2) {
        rank += "nd";
    } else if (lastDigit == 3 && (last2Digits != 13 || last2Digits != 12 || last2Digits != 11)) {
        rank += "rd";
    } else {
        rank += "th";
    }

    if (tie) {
        rank = "T-" + rank;
    }

    return rank;

}

function getPrettyVal(val, stat1, stat2) {


    if (val == "NA" || val == null) {
        return "NA";
    }

    else if (stat1 == "wp" && stat2 == "mean") {
        return (val*100).toFixed(1).toString() + "%";
    } 

    else if (stat2 == "mean" || stat2 == "sd") {
        return val.toFixed(1);
    }

    return val;

}

function toggleGameLabels() {

    let userGames = document.getElementById('checkbox').checked;

    document.getElementById('all_games').style.color = (userGames) ? "#4d6366" : "#000000";
    document.getElementById('your_games').style.color = (userGames) ? "#000000" : "#4d6366";
}