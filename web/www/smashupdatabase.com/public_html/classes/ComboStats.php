<?php
/**
 * use this to get stats/rankings for a single combo
 */
class ComboStats {

    use StatsHelper;

    /**
     * This gets the goods for the given $f1-$f2 faction combo
     * 
     * If the email is given, we get stats for only that user
     * If left null, we get all stats
     */
    public static function get_combo_stats(
        Object $conn,
        string $f1,
        string $f2,
        string $email = ""
    ): array {

        $a = self::get_values($conn, $f1, $f2, $email);

        $a = self::convert_to_stats($a);

        return $a;

    }

    private static function get_values(
        Object $conn,
        string $f1,
        string $f2,
        string $email = ""
    ): array {

        // initialize our values array
        $a = array_fill_keys(array("vals"), array());
        $a = array_fill_keys(array("vp", "wp", "pff"), $a);
        $a = array_fill_keys(array("all", "2p", "3p", "4p"), $a);

        // get the sql ready
        $prep = "SELECT * 
                 FROM games 
                 WHERE ((p1_f1 = ? AND p1_f2 = ?)
                    OR (p1_f2 = ? AND p1_f1 = ?)
                    OR (p2_f1 = ? AND p2_f2 = ?)
                    OR (p2_f2 = ? AND p2_f1 = ?)
                    OR (p3_f1 = ? AND p3_f2 = ?)
                    OR (p3_f2 = ? AND p3_f1 = ?)
                    OR (p4_f1 = ? AND p4_f2 = ?)
                    OR (p4_f2 = ? AND p4_f1 = ?))";

        if ($email != "") {
            $prep .= " AND email = ?";
        }

        // prepare it
        $stmt = $conn->prepare($prep);

        // bind parameters (i hate this)
        if ($email == "") {
            $stmt->bind_param("ssssssssssssssss", $f1, $f2, $f1, $f2, $f1, $f2, $f1, $f2, $f1, $f2, $f1, $f2, $f1, $f2, $f1, $f2);
        } else {
            $stmt->bind_param("sssssssssssssssss", $f1, $f2, $f1, $f2, $f1, $f2, $f1, $f2, $f1, $f2, $f1, $f2, $f1, $f2, $f1, $f2, $email);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_array()) {

            // get some basic info about the game
            $num_players = self::get_num_players($row);
            $max_score = self::get_max_score($row);
            $player = self::get_player_with_combo($row, $f1, $f2);

            // get the important stats
            $vp = $row["p{$player}_vp"];
            $pff = $max_score - $vp;
            $win = intval($pff == 0);

            // put the imporant stats into the array
            array_push($a["{$num_players}p"]['vp']['vals'], $vp);
            array_push($a["{$num_players}p"]['pff']['vals'], $pff);
            array_push($a["{$num_players}p"]['wp']['vals'], $win);

        }

        return $a;

    }

    /**
     * turns the vals we have into stats
     */
    private static function convert_to_stats(array $a): array {

        foreach ($a as $players => $layer1) {

            foreach ($layer1 as $stats1 => $s) {

                if ($players == "all") {
                    $s = array_merge(
                        $a['2p'][$stats1]['vals'],
                        $a['3p'][$stats1]['vals'],
                        $a['4p'][$stats1]['vals'],
                    );
                } else {
                    $s = $s['vals'];
                }

                $l = count($s);

                if ($l == 0) {
                    continue;
                }

                // mean goes into everything
                $a[$players][$stats1]['mean'] = round(array_sum($s) / $l, 3);

                // put the sd and median only if we're on pff or vp
                if ($stats1 == "pff" or $stats1 == "vp") {
                    $a[$players][$stats1]['sd'] = round(self::get_sd($s), 3);
                    $a[$players][$stats1]['median'] = round(self::get_median($s), 3);
                }

                // put the number of wins and count only if we're on wp
                if ($stats1 == "wp") {
                    $a[$players][$stats1]['nwins'] = array_sum($s);
                    $a[$players][$stats1]['count'] = round($l, 3);
                }

            }

        }

        return $a;

    }

}
?>