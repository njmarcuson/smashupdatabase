<?php
/**
 * used to get the important stats for any list 
 * of factions. These include VP, PFF, and WIN%
 * 
 * $a always references the ArrayObject that stores everything
 */

class SingleStats {

    use StatsHelper;

    public function get_all_stats(
        Object $conn,
        Factions $factions,
        string $email,
        bool $vp_only = false
    ): array {

        // stats ArrayObject to fill in
        $a = $this->get_stats_array($factions->get_factions(true), $email, $vp_only);

        // fill it in with values
        $this->add_vals($a, $conn, $email, $vp_only);

        // convert the values to statistics
        $this->convert_to_stats($a, $vp_only);

        // get the rankings for each statistic
        $this->add_rankings($a);

        return $a->getArrayCopy();

    }


    /**
     * Gets the VP, PFF, and WIN for
     * each and every game and puts it into
     * out $a
     */
    private function add_vals(
        ArrayObject $a,
        Object $conn,
        string $email,
        $vp_only
    ) {

        // loop through each and every game... 
        $result = $conn->query("SELECT * FROM games");
        $game = 0;
        while ($row = mysqli_fetch_assoc($result)) {

            // get some basic info about the game
            $num_players = $this->get_num_players($row);
            $max_score = $this->get_max_score($row);

            // true if our special little user inputted this game
            $user_game = $row['email'] == $email;

            // loop through each player in the game
            for ($p=1; $p<=$num_players; $p++) {

                // get their factions
                $faction_vals = array(
                    'f1' => $row["p{$p}_f1"],
                    'f2' => $row["p{$p}_f2"]
                );

                // get their stats
                $stat_vals = array('vp' => intval($row["p{$p}_vp"]));
                if (!$vp_only) {
                    $stat_vals['pff'] = $max_score - $stat_vals['vp'];
                    $stat_vals['wp'] = intval($stat_vals['pff'] == 0);
                }

                $this->add_stats($a, $faction_vals, $stat_vals, $num_players, $user_game);
            }

        }

    }

    /**
     * uses the Big Array, when all the vals are in
     * This converts all the vals to stats:
     *      mean, median, count, sd
     */
    private function convert_to_stats(
        ArrayObject $a,
        bool $vp_only = false
    ) {

        // $type: [all, user]
        foreach ($a as $type => $layer1) {

            // $players: [2p, 3p, 4p, all]
            foreach ($layer1 as $players => $layer2) {

                // $stats1: [vp, pff, wp]
                foreach ($layer2 as $stats1 => $layer3) {

                    // $f: [Aliens, ..., Zombies] 
                    // $s: if $stats1 == vp:
                    //          [15, 12, 10, 17, ...]
                    //      etc.
                    foreach ($layer3['vals'] as $f => $s) {

                        // merge the games if we're at "all"
                        if ($players == "all") {
                            $s = array_merge(
                                $layer1['2p'][$stats1]['vals'][$f],
                                $layer1['3p'][$stats1]['vals'][$f],
                                $layer1['4p'][$stats1]['vals'][$f]
                            );
                        }

                        $l = count($s);

                        if ($l == 0) {
                            continue;
                        }

                        // mean goes into everything
                        $a[$type][$players][$stats1]['mean'][$f] = round(array_sum($s) / $l, 3);

                        // put the sd and median only if we're on pff or vp
                        if ($stats1 == "pff" or $stats1 == "vp") {
                            $a[$type][$players][$stats1]['sd'][$f] = round($this->get_sd($s), 3);
                            $a[$type][$players][$stats1]['median'][$f] = round($this->get_median($s), 3);
                        }

                        // put the number of wins and count only if we're on wp
                        if ($stats1 == "wp") {
                            $a[$type][$players][$stats1]['nwins'][$f] = array_sum($s);
                            $a[$type][$players][$stats1]['count'][$f] = round($l, 3);
                        }

                        // if vp only, we should put the count in too
                        if ($vp_only) {
                            $a[$type][$players][$stats1]['count'][$f] = round($l, 3);
                        }

                    }

                    // the vals are now useless; save some memory
                    unset($a[$type][$players][$stats1]['vals']);

                }

            }

        }

    }

    /**
     * Takes the big array when all the stats are 
     * already done. Adds rankings to the stats.
     */
    private function add_rankings(
        ArrayObject $a
    ) {

        // $type: [all, user]
        foreach ($a as $type => $layer1) {

            // $players: [2p, 3p, 4p, all]
            foreach ($layer1 as $players => $layer2) {

                // $stats1: [vp, pff, wp]
                foreach ($layer2 as $stats1 => $layer3) {

                    // $stats2: [mean, sd, median, count]
                    foreach ($layer3 as $stats2 => $factions) {
                        
                        // $f: [Aliens, ..., Zombies] 
                        // $val: 14; 0; 2.33; etc.
                        foreach ($factions as $f => $val) {

                            $reverse = ($stats1 == "pff") || ($stats2 == "sd");
                            $rank = $this->get_rank($factions, $val, $reverse);
                            $tie = intval($this->get_equals($factions, $val));

                            $a[$type][$players][$stats1][$stats2][$f] = array(
                                "val" => $val,
                                "rank" => $rank,
                                "tie" => $tie
                            );

                        }

                    }

                }

            }

        }


    }

    
    private function add_stats(
        ArrayObject $a,
        array $faction_vals,
        array $stat_vals,
        $num_players,
        $user_game
    ) {

        // loop through each faction
        foreach ($faction_vals as $f) {

            // loop through each stat
            foreach ($stat_vals as $s => $val) {

                

                // always put the stat in all
                array_push(
                    $a["all"]["{$num_players}p"][$s]['vals'][$f],
                    $val
                );

                // put the stat in user if necessary
                if ($user_game) {

                    array_push(
                        $a["user"]["{$num_players}p"][$s]['vals'][$f],
                        $val
                    );

                }

            }

        }

    }

    /**
     * Gets the empty array to fill all the stats into
     * 
     * Hierarchy is as follows
     *          [all, user] 
     *         [2p, 3p, 4p, all] 
     *          [vp, pff, wp] 
     *         [vals (, mean, median, mode, sd, count)] 
     *          [factions]
     *          [null]
     */
    private function get_stats_array(
        $faction_array,
        string $email,
        bool $vp_only
    ): object {

        // get the keys for the big kahuna
        $mode = array("all");
        
        if ($email != "") {
            array_push($mode, "user");
        }

        $players = array("2p", "3p", "4p", "all");
        $stats1 = ($vp_only) ? array("vp") : array("vp", "pff", "wp");
        $stats2 = array("vals");
       
        // use the keys to make the big kahuna
        $a = array_fill_keys($faction_array, array());
        $a = array_fill_keys($stats2, $a);
        $a = array_fill_keys($stats1, $a);
        $a = array_fill_keys($players, $a);
        $a = array_fill_keys($mode, $a);

        // convert the big kahuna into an object
        $a = new ArrayObject($a);
        return $a;

    }

}

?>