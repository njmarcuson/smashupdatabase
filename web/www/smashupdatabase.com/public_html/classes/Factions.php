<?php
/*
THIS IS THE GRANDADDY OF ALL CLASSES, BABY

This is the only place in the entire codebase where
the name of the factions actually appear, so this is 
quite an important class.
*/

class Factions {

    /*
    First the fields. This will get us the factions
    and indicate which have titans

    (in the extended UserFactions class, we will construct
    with a User and the master_factions will be edited)
    */

    protected $master_factions = array(

        'base' => array(
            'clean_name' => 'Base Set',
            'factions' => array(
                'Aliens',
                'Dinosaurs',
                'Ninjas',
                'Pirates',
                'Robots',
                'Tricksters',
                'Wizards',
                'Zombies'
            )
        ),
        
        'al9' => array(
            'clean_name' => 'Awesome Level 9000',
            'factions' => array(
                'Bear Cavalry',
                'Ghosts',
                'Killer Plants',
                'Steampunks'
            )
        ),
        
        'cthulhu' => array(
            'clean_name' => 'The Obligatory Ctuhulhu Set',
            'factions' => array(
                'Elder Things',
                'Innsmouth',
                'Minions of Cthulhu',
                'Miskatonic University'
            )
        ),

        'scifi' => array(
            'clean_name' => 'Science Fiction Double Feature',
            'factions' => array(
                'Cyborg Apes',
                'Shapeshifters',
                'Super Spies',
                'Time Travelers'
            )
        ),

        'monster' => array(
            'clean_name' => 'Monster Smash',
            'factions' => array(
                'Giant Ants',
                'Mad Scientists',
                'Vampires',
                'Werewolves'
            )
        ),

        'pretty' => array(
            'clean_name' => 'Pretty Pretty',
            'factions' => array(
                'Fairies',
                'Kitty Cats',
                'Mythic Horses',
                'Princesses'
            )
        ),

        'fault' => array(
            'clean_name' => "It's Your Fault",
            'factions' => array(
                'Dragons',
                'Mythic Greeks',
                'Sharks',
                'Superheroes',
                'Tornados'
            )
        ),

        'cease' => array(
            'clean_name' => 'Cease and Desist',
            'factions' => array(
                'Astroknights',
                'Changerbots',
                'Ignobles',
                'Star Roamers'
            )
        ),

        'thinking' => array(
            'clean_name' => 'What Were We Thinking?',
            'factions' => array(
                'Explorers',
                'Grannies',
                'Rock Stars',
                'Teddy Bears'
            )
        ),

        'japan' => array(
            'clean_name' => 'Big In Japan',
            'factions' => array(
                'Itty Critters',
                'Kaiju',
                'Magical Girls',
                'Mega Troopers'
            )
        ),

        'seventies' => array(
            'clean_name' => 'That 70s Expansion',
            'factions' => array(
                'Disco Dancers',
                'Kung Fu Fighters',
                'Truckers',
                'Vigilantes'
            )
        ),

        'oops' => array(
            'clean_name' => 'Oops, You Did It Again',
            'factions' => array(
                'Ancient Egyptians',
                'Cowboys',
                'Samurai',
                'Vikings'
            )
        ),

        'wt1' => array(
            'clean_name' => 'World Tour: International Incident',
            'factions' => array(
                'Luchadors',
                'Mounties',
                'Musketeers',
                'Sumo Wrestlers'
            )
        ),

        'wt2' => array(
            'clean_name' => 'World Tour: Culture Shock',
            'factions' => array(
                'Anansi Tales',
                'Ancient Incas',
                "Grimms' Fairy Tales",
                'Polynesian Voyagers',
                'Russian Fairy Tales'
            )
        ),

        'munchkin' => array(
            'clean_name' => 'Munchkin',
            'factions' => array(
                'Clerics',
                'Dwarves',
                'Elves',
                'Halflings',
                'Mages',
                'Orcs',
                'Thieves',
                'Warriors'
            )
        ),

        'marvel' => array(
            'clean_name' => 'Marvel',
            'factions' => array(
                'Avengers',
                'Hydra',
                'Kree',
                'Masters of Evil',
                'S.H.I.E.L.D.',
                'Sinister Six',
                'Spider-Verse',
                'Ultimates'
            )
        ),

        'extras' => array(
            'clean_name' => 'Extra Factions',
            'factions' => array(
                'Smash Up All Stars',
                'Geeks',
                'Goblins',
                'Penguins',
                'Sheep'
            ),
            'table_names' => array(
                'allstars',
                'geeks',
                'goblins',
                'penguins',
                'sheep'
            )
        )

    );
    
    private $master_titans = array(

        'pack' => array(
            'Bear Cavalry',
            'Changerbots',
            'Explorers',
            'Fairies',
            'Ghosts',
            'Giant Ants',
            'Ignobles',
            'Innsmouth',
            'Minions of Cthulhu',
            'Pirates',
            'Super Spies',
            'Time Travelers',
            'Tricksters',
            'Vampires',
            'Werewolves',
            'Wizards'
        ),

        'japan' => array(
            'Itty Critters',
            'Kaiju',
            'Magical Girls',
            'Mega Troopers'
        ),
    );

    /*
    @param: $include_titan
        true/false
    returns an array of all the factions in the following order
        1. by expansion
        2. alphabetical
        3. (no titan) before (titan)
    */
    public function get_factions(
        bool $include_titan = false
    ): array {

        // initialize array of factions to return
        $factions = array();

        // loop through all the expansions
        foreach ($this->master_factions as $expansion => $info) {

            $expansion_factions = $info['factions'];

            // loop through all the factions
            foreach ($expansion_factions as $f) {

                array_push($factions, $f);

                // add the (T) if applicable
                if ($include_titan and $this->faction_has_titan($f)) {
                    array_push($factions, "{$f} (T)");
                }

            }

        }

        return $factions;

    }

    /*
    @param $nice
        false: names correspond to SQL column names
        true: names correspond to popular names
    */
    public function get_expansions(
        bool $nice = false,
        bool $include_titans = true,
        bool $include_all_extras = false
    ): array {

        if (! $nice) {
            // get the expansions
            $expansions = array_keys($this->master_factions);

            // remove the "extras"
            $expansions = $this->unset_by_key($expansions, "extras");

            // handle the extras
            if ($include_all_extras) {
                array_push($expansions, "extras");
            } else {
                $expansions = array_merge($expansions, $this->master_factions['extras']['table_names']);
            }
            if ($include_titans) {
                array_push($expansions, 'titans');
            }

            return $expansions;
        }

        // if it's nice, we have to loop through the master_factions
        $nice_expansions = array();
        foreach ($this->master_factions as $expansion => $info) {

            if ($include_all_extras and $expansion == "extras") {
                $nice_expansions = array_merge($nice_expansions, $this->master_factions['extras']['factions']);
                continue;
            }

            array_push($nice_expansions, $info['clean_name']);
        }

        if ($include_titans) {
            array_push($nice_expansions, 'Titans Pack');
        }

        return $nice_expansions;
    }

    /*
    this does the same thing as get factions
    except it merges the titan entries into one
    */
    public function get_factions_merge(): array {

        $factions = $this->get_factions();

        foreach ($factions as $i => $f) {

            if ($this->faction_has_titan($f)) {
                $factions[$i] = $f .= " (T)";
            }

        }

        return $factions;

    }
    
    /*
    returns true if the given faction has a titan
    excludes the big in japan factions
    */
    protected function faction_has_titan(
        string $faction
    ): bool {
        $titan_factions = $this->master_titans['pack'];
        return in_array($faction, $titan_factions);
    }
    
    /*
    @param $a
        the array that we delete from
    @param $delete_value
        the value that we delete
    @returns array
        the new array
    */
    private function unset_by_key(
        array $a,
        $delete_value
    ): array {

        if (($key = array_search($delete_value, $a)) !== false) {
            unset($a[$key]);
        }

        return $a;

    }

    /*
    gives you a big string of all the factions as would be
    used inside of a select operator
    does not include the first null opti
    */
    public function get_faction_options(
        bool $include_titan = false,
        bool $alphabet_order = false,
        ?string $faction = ""
    ): string {

        $factions = $this->get_factions($include_titan);

        if ($alphabet_order) { sort($factions); }

        $option_string = "";
        foreach ($factions as $f) {

            $selected = ($f == $faction) ? "selected='selected'" : "";

            $option_string .= 
                "<option value='{$f}' {$selected}>" .
                $f .
                "</option>";

        }

        return $option_string;
    }

    /**
     * gets you a nice checkbox list of the expansions
     */
    public function get_expansions_checkboxes(
        ?array $expansions_owned = array(),
        bool $compress_extras = false,
        string $change_string = ""
    ): string {

        $expansions_nice = $this->get_expansions(true, true, true);
        $expansions_not_nice = $this->get_expansions(false);

        $checkboxes = "";
        for ($i=0; $i<count($expansions_nice); $i++) {

            $exp_nice = $expansions_nice[$i];
            $exp_not_nice = $expansions_not_nice[$i];

            if ($compress_extras && (in_array($exp_nice, $this->master_factions['extras']['factions']) || $exp_nice == "Titans Pack")) {
                continue;
            }

            $checked = (in_array($exp_nice, $expansions_owned) or in_array($exp_not_nice, $expansions_owned)) ? "checked" : "";

            $checkboxes .= "
                <label class='create-checkbox-label' for='{$exp_not_nice}'>
                <input class='create-checkbox' type='checkbox' id='{$exp_not_nice}' name='{$exp_not_nice}' value='{$exp_not_nice}' {$checked} {$change_string}>
                {$exp_nice}
                </label>
            ";
            
        }

        if ($compress_extras) {
            $checkboxes .= "
                <label class='create-checkbox-label' for='extras'>
                <input class='create-checkbox' type='checkbox' id='extras' name='extras' value='extras' {$change_string}>
                Extras
                </label>
            ";
        }

        return $checkboxes;

    }

    public function get_faction_checkboxes(): string {

        $factions = $this->get_factions(true);

        $checkboxes = "<div class='expansion-group'>";
        foreach ($factions as $f) {

            $expansion = $this->get_factions_expansion($f);
            $expansion_nice = $this->master_factions[$expansion]['clean_name'];

            if ($this->master_factions[$expansion]['factions'][0] == $f) {
                $checkboxes .= "</div>
                <br>
                <div class='{$expansion_nice}'>
                <label class='graph-checkbox-label-expansion' for='{$expansion_nice}'>
                <input class='graph-checkbox-expansion' type='checkbox' id='{$expansion_nice}' name='{$expansion_nice}' value='{$expansion_nice}'>
                {$expansion_nice}
                </label>";
            }

            $checkboxes .= "
                <label class='graph-checkbox-label' for='{$f}'>
                <input class='graph-checkbox' type='checkbox' id='{$f}' name='{$f}' value='{$f}'>
                {$f}
                </label>
            ";
            
        }

        return $checkboxes . "</div>";
    }

    private function get_factions_expansion($f) {

        foreach ($this->master_factions as $ugly => $exp) {
            if (in_array($this->detitanize($f), $exp['factions'])) {
                return $ugly;
            }
        }

    }

    private function detitanize($f): string {
        if (str_contains($f, " (T)")) {
            $f = substr($f, 0, -4);
        }
        return $f;
    }

    /**
     * use this function to get an array of 
     * each expansion (nice, no titans) mapped to 
     * each faction (with titan)
     */
    public function get_expansions_to_factions(): array {

        $a = array();
        // loop through each expansion
        foreach ($this->master_factions as $e => $info) {

            $fs = array();

            // add each faction in expansion to array
            foreach ($info['factions'] as $f) {

                array_push($fs, $f);

                // handle titans
                if (in_array($f, $this->master_titans['pack'])) {
                    array_push($fs, "{$f} (T)");
                }

            }

            $a[$e] = $fs;
        }

        return $a;

    }
}
?>