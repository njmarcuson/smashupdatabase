// does the d3 graph
// takes in whether it's all data, how many players, and which stats
function doD3(single=true) {

    // clear the graph so we have a blank slate
    clearGraph();

    // change stat2 if it's a single graph
    changeStat2(single);

    // width of screen for multiple things
    let containerWidth = document.getElementById("container").offsetWidth;

    // deal with the toggle thing
    let gameSwitch = document.getElementById('checkbox');
    let allData = "all";
    if (gameSwitch) {

        toggleGameLabels();

        allData = gameSwitch.checked ? "user" : "all";

        yourGames(containerWidth);

    }
    let graphStats = [];

    let factions = getFactionsUsed(single);
    let players = document.getElementById('players').value; 
    let stat1 = document.getElementById('stat1').value; 
    let stat2 = document.getElementById('stat2').value;

    // get the y axis label
    let yLabel;
    if (stat1 == "wp") {
        if (stat2 == "mean") {
            yLabel = "Win Percentage";
        } else if (stat2 == "count") {
            yLabel = "Number of Games";
        } else if (stat2 == "wins") {
            yLabel = "Number of Wins";
        }
    } else if (stat1 == "vp") {
        if (stat2 == "mean") {
            yLabel = "Mean Victory Points";
        } else if (stat2 == "median") {
            yLabel = "Median Victory Points";
        } else if (stat2 == "sd") {
            yLabel = "Victory Points SD";
        }
    } else if (stat1 == "pff") {
        if (stat2 == "mean") {
            yLabel = "Mean PFF";
        } else if (stat2 == "median") {
            yLabel = "Median PFF";
        } else if (stat2 == "sd") {
            yLabel = "PFF SD";
        }
    }

    // get the title
    let title1;
    let title2 = "";

    if (players == "2p") {
        title1 = "2-Player Games";
    } else if (players == "3p") {
        title1 = "3-Player Games";
    } else if (players == "4p") {
        title1 = "4-Player Games";
    } else if (players == "all") {
        title1 = "All-Player Games";
    }

    if (allData == "user") {
        title2 = "for Your Data";
    }

    let title = title1 + " " + title2;

    if (!single) {
        title += " with " + document.getElementById('faction').value;
    }

    // if it's a single stat graph
    let remove = [];
    if (single) {
        let smallKahuna = bigKahuna[allData][players][stat1][stat2];

        for (let f of factions) {
            if (f in smallKahuna) {
                graphStats.push({
                    val: smallKahuna[f]['val'],
                    faction: f
                });
            } else {
                remove.push(f);
            }
        }
    }

    // if it's a combo stat graph
    else {
        for (let f of factions) {
            if (f in bigKahuna && bigKahuna[f] !== null) {
                graphStats.push({
                    val: bigKahuna[f],
                    faction: f
                });
            } else {
                remove.push(f);
            }
        }
    }

    // get rid of the factions we have no data for
    factions = factions.filter(function(value){ 
        return (! remove.includes(value));
    });

    // handle the y-axis range
    let minVal = 100;
    let maxVal = 0;
    for (let f of graphStats) {
        let val = f['val'];
        minVal = (val < minVal) ? val : minVal;
        maxVal = (val > maxVal) ? val : maxVal;
    }

    // y-axis range depends on what stats are used
    if (stat1 == "vp" || stat1 == "pff") {
        maxVal = Math.floor(maxVal) + 1;
        minVal = Math.ceil(minVal) - 1;
    }
    if (stat1 == "pff" && stat2=="median") {
        minVal = -.5;
    }
    if (stat1 == "wp" && stat2 == "mean") {
        maxVal = maxVal + .1;
        minVal = minVal - .1;
    }
    if (stat1 == "wp" && (stat2 == "count" || stat2 == "nwins")) {
        maxVal = maxVal + 10;
        minVal = Math.max(minVal - 10, 0);
    }

    let w = containerWidth < 500 ? containerWidth : containerWidth * .8;
    let barWidth = Math.min((w-20) / (factions.length + 10), 40);

    // graph shit
    var margin = {top: 35, right: 50, bottom: 150, left: 75},
        width = w - margin.left - margin.right,
        height = 450 - margin.top - margin.bottom;

    // make the <svg> withing the div
    var svg = d3.select("#single_graph")
        .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        // translate this svg element to leave some margin.
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    // x scale and axis
    var x = d3.scalePoint()
        .domain(factions)
        .range([0, width])
        .padding([.5]);

    svg.append('g')
        .attr("transform", "translate(0," + height + ")")
        .attr("class", "line")
        .call(d3.axisBottom(x))
        .selectAll("text")	
            .style("text-anchor", "end")
            .attr("dx", "-.8em")
            .attr("dy", ".15em")
            .attr("transform", "rotate(-45)");

    // y scale and axis
    var y = d3.scaleLinear()
            .domain([minVal, maxVal])
            .range([height, 0]);
    svg.append('g')
        .attr("class", "line")
        .call(d3.axisLeft(y));

    // y axis label
    svg.append("text")
        .attr("text-anchor", "middle")
        .attr("x", -125)
        .attr("y", -10)
        .attr("dy", "-2.5em")
        .attr("transform", "rotate(-90)")
        .text(yLabel);

    // title 
    svg.append("text")
        .attr("class", "title")
        .attr("text-anchor", "left")
        .attr("x", 40)             
        .attr("y", -15)
        .text(title);


    // the bars
    let bars = svg.selectAll("bar")
        .data(graphStats)
        .enter()
        .append("rect")
            .attr("class", "graph-bar")
            .attr("id", function(d){ return dealWithSpaces(d.faction) })
            .attr("x", function(d){ return x(d.faction) })
            .attr("y", function(d){ return height; })
            .attr("height", function(d){ return 0; })
            .attr('width', barWidth)
            .attr('stroke', 'black')
            .attr('fill', "rgba(37, 150, 190, .75)")
            .attr("transform", `translate(-${barWidth / 2}, 0)`);

    bars.transition()
        .duration(500)
        .attr("y", function(d){ return y(d.val) })
        .attr("height", function(d){ return height - y(d.val) });
        //.delay(function(d,i){console.log(i) ; return(i*100)})

    bars.on("mouseover", (d) => {
        let id = "#" + dealWithSpaces(d.faction);
        d3.select(id).attr('fill',"rgba(37, 150, 190, 1)");
    })
    .on("mouseout", (d) => {
        let id = "#" + dealWithSpaces(d.faction);
        d3.select(id).attr('fill',"rgba(37, 150, 190, .75)");
    });
}

function getFactionsUsed(single) {

    if (!single) {
        return factionsUsed;
    }

    let factions = [];
    let expansions = document.getElementsByClassName('create-checkbox');

    for (let i = 0; i < expansions.length; i++) {

        let checkbox = expansions[i];

        if (checkbox.checked) {
            factions = factions.concat(expsToFactions[checkbox.name]);
        }

    }

    return factions;

}

function clearGraph() {

    let graphDiv = document.getElementById('single_graph');
    graphDiv.innerHTML = "";

}

function dealWithSpaces(faction) {
    return faction.replace(/ /g,"_").replace(/[{()}]/g, '');
}

function changeStat2(single) {
    let stat1 = document.getElementById('stat1').value;
    let stat2 = document.getElementById('stat2');

    oldStat1 = oldStats.stat1;

    if (stat1 == "wp" && oldStat1 != "wp") {
        stat2.innerHTML = "<option value='mean'>Win Percentage</option>" +
                         "<option value='nwins'>Number of Wins</option>" + 
                            "<option value='count'>Number of Games</option>";
    } else if ((stat1 == "vp" || stat1 == "pff") && (oldStat1 != "vp" && oldStat1 != "pff")) {
        stat2.innerHTML = "<option value='mean'>Mean</option>" +
                         "<option value='median'>Median</option>" + 
                            "<option value='sd'>SD</option>";
    }

    oldStats.stat1 = stat1;

    if (!single) {
        stat2.value = stat2PHP;
    }

}

function yourGames(containerWidth) {
    // deal with the "your games" bug
    document.getElementById('your_games').innerHTML = (containerWidth < 380) ? "&nbsp;&nbsp; Yours" : "&nbsp;&nbsp; Your Games";
}