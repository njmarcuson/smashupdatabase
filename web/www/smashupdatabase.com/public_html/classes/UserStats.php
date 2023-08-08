<?php

class UserStats extends SingleStats {


    /**
     * get the vp stats and store it as a field
     */
    public function __construct(
        private Object $conn,
        private Factions $factions,
        private string $email
    ) {

        $this->vp_stats = $this->get_all_stats($conn, $factions, $email, true);

    }

    /**
     * Gets the users best faction by mean VP for all games (breaks ties arbitrarily)
     * 
     * returns an array of the faction and the VP to one decimal point
     */
    public function get_best_faction(): array {

        $faction = $this->get_best_rank($this->vp_stats['user']['all']['vp']['mean']);
        return array(
            "faction" => $faction,
            "val" => round($this->vp_stats['user']['all']['vp']['mean'][$faction]['val'], 1)
        );

    }

    /**
     * Gets the users worst faction by mean VP for all games (breaks ties arbitrarily)
     * 
     * returns an array of the faction and the VP to one decimal point
     */
    public function get_worst_faction(): array {

        $faction = $this->get_worst_rank($this->vp_stats['user']['all']['vp']['mean']);

        return array(
            "faction" => $faction,
            "val" => round($this->vp_stats['user']['all']['vp']['mean'][$faction]['val'], 1)
        );

    }

    /**
     * Gets the users most played faction (breaks ties arbitrarily)
     * 
     * returns an arrary of the faction and the number of games
     */
    public function get_most_played_faction(): array {

        $faction = $this->get_best_rank($this->vp_stats['user']['all']['vp']['count']);

        return array(
            "faction" => $faction,
            "val" => $this->vp_stats['user']['all']['vp']['count'][$faction]['val']
        );
    }

    /**
     * Gets the users least played faction (breaks ties arbitrarily)
     * 
     * returns an arrary of the faction and the number of games
     */
    public function get_least_played_faction(): array {

        $faction = $this->get_worst_rank($this->vp_stats['user']['all']['vp']['count']);
        
        return array(
            "faction" => $faction,
            "val" => $this->vp_stats['user']['all']['vp']['count'][$faction]['val']
        );
    }

    /**
     * Gets the best and worst faction compared to everyone
     * 
     */
    public function get_compared(): array {
        
        $best_val = 0;
        $best_faction = "NA";
        $worst_val = 0;
        $worst_faction = "NA";

        foreach ($this->vp_stats['user']['all']['vp']['mean'] as $f => $a) {

            $all_val = $this->vp_stats['all']['all']['vp']['mean'][$f]['val'];
            $compare = $a['val'] - $all_val;

            if ($compare > $best_val) {
                $best_val = $compare;
                $best_faction = $f;
            }

            if ($compare < $worst_val) {
                $worst_val = $compare;
                $worst_faction = $f;
            }

        }

        return array(
            "best_faction" => $best_faction,
            "best_val" => round($best_val, 1),
            "worst_faction" => $worst_faction,
            "worst_val" => round($worst_val, 1)
        );

    }

    private function get_worst_rank(
        array $faction_list
    ): string {

        $worst_faction = "NA";
        $worst_rank = 0;

        foreach ($faction_list as $f => $a) {

            if ($a['rank'] > $worst_rank) {
                $worst_faction = $f;
                $worst_rank = $a['rank'];
            }

        }

        // insurance if we don't find a number 1 ranking
        return $worst_faction;

    }

    // takes in an associative array of the faction list
    // with the faction to vals and ranks
    // returns the faction with the highest rank
    private function get_best_rank(
        array $faction_list
    ) {

        foreach ($faction_list as $f => $a) {

            if ($a['rank'] == 1) {

                return $f;
                
            }
        }

        // insurance if we don't find a number 1 ranking
        return "NA";

    }

    public function has_games(): int {

        $prep = "SELECT COUNT(*) AS count FROM games WHERE email = ?";
        $stmt = $this->conn->prepare($prep);
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
        return $count > 0;

    }
}
?>