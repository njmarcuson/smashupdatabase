function toggleStats() {

    let gameSwitch = document.getElementById('checkbox');
    
    if (gameSwitch) {
        toggleGameLabels();
    }

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

                toggleIndividualSpan(gameType, stat1, stat2);

            }


        }

    }

}

function toggleIndividualSpan(gameType, stat1, stat2) {

    let span = document.getElementById(gameType + "_" + stat1 + "_" + stat2);

    console.log(stats[gameType][stat1][stat2]);

    let prettyVal = getPrettyVal(
        stats[gameType] != null ? stats[gameType][stat1][stat2] : "NA", 
        stat1, 
        stat2
    );

    span.innerHTML = prettyVal;
}