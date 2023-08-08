function toggleStats() {

    let faction = document.getElementById('faction').value;
    let gameSwitch = document.getElementById('checkbox');

    if (gameSwitch) {
        toggleGameLabels();
    }


    let statsContainer = document.getElementById('stats_container');
    statsContainer.style.display = (faction == "null") ? "none" : "block";

    if (faction == "null") {
        return;
    }

    let allType = ( ! gameSwitch || ! gameSwitch.checked) ? "all" : "user";

    let gameTypes = ['all', '2p', '3p', '4p'];
    let stats1 = ['wp', 'vp', 'pff'];
    let stats2 = ['nwins', 'mean', 'median', 'sd', 'count'];

    
    for (let gameType of gameTypes) {
        
        for (let stat1 of stats1) {

            for (let stat2 of stats2) {

                // make sure we don't do a stat that's not there
                if ((stat1 == 'wp' && (stat2 == "median" || stat2 == "sd"))
                    || (stat1 != 'wp' && (stat2 == "nwins" || stat2 == "count"))) 
                {
                    continue;
                }

                toggleIndividualSpan(allType, gameType, stat1, stat2, faction);

            }


        }

    }

}

function toggleIndividualSpan(allType, gameType, stat1, stat2, faction) {

    let span = document.getElementById(gameType + "_" + stat1 + "_" + stat2);
    let rankSpan = document.getElementById(gameType + "_" + stat1 + "_" + stat2 + "_rank");

    let factionStats = (stats[allType][gameType][stat1][stat2]) == null ?
                        "NA" : stats[allType][gameType][stat1][stat2][faction];

    let prettyVal = getPrettyVal(
        factionStats != null ? factionStats['val'] : "NA", 
        stat1, 
        stat2
    );

    let prettyRank = getPrettyRank(
        factionStats ? factionStats['rank'] : "NA", 
        factionStats ? factionStats['tie'] : "NA"
    );

    span.innerHTML = prettyVal;
    rankSpan.innerHTML = prettyRank;

}