<?php
/*
This class will get you a random game.
Extends UserFactions so it needs a $conn and a $user
*/

class RandomGame extends UserFactions {

    /*
    the one public function here
    just feed it how many players are playing,
    and get back an array of $num_players*2 unique random factions
    */
    public function get_random_game(
        int $num_players
    ): array {

        $factions = $this->get_factions();
        $game = array();

        // loop through 2 factions per player
        for ($i=0; $i<$num_players*2; $i++) {

            // get the random index and faction
            $index = $this->get_random_index($factions);
            $random_faction = $factions[$index];

            // adjust to Titan as needed
            $random_faction = $this->titan_adjust($random_faction);

            // add the faction to our game
            array_push($game, $random_faction);

            // adjust the faction array
            unset($factions[$index]);
            $factions = array_values($factions);

        }

        return $game;

    }


    /*
    returns the index of the random faction
    */
    private function get_random_index(
        array $factions
    ): int {

        $max = count($factions) - 1;
        $index = rand(0, $max);
        return $index;

    }

    /*
    takes the faction that will potentially be adjusted
    returns {$faction .= " (T)"} if the user has the titan
        pack and the faction has a titan. 
    excludes big in japan
    */
    private function titan_adjust(
        string $faction
    ): string {

        $user_has_titan = $this->user_has_titan();
        $faction_has_titan = $this->faction_has_titan($faction);

        if ($user_has_titan and $faction_has_titan) {
            $faction .= " (T)";
        }
        
        return $faction;

    }

}

?>