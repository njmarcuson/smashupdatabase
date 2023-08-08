<?php
/*
the same as Factions
except we delete the expansions/factions from 
$master_factions that the user does not have
*/
class UserFactions extends Factions {

    private bool $user_has_titan;

    public function __construct(
        private $conn,
        private User $user
    ) {
        $user_expansions = $this->get_user_expansions();

        // update shit
        $this->user_has_titan = $user_expansions['titans'] == "1";
        $this->update_master_factions($user_expansions);
    }

    public function user_has_titan() {
        return $this->user_has_titan;
    }

    /* 
    uses sql to get an associative array of all the expansions
    of the user
    */
    private function get_user_expansions(): array {
        // get the prepared sql by looping through and adding 
        // each expansion
        $prep_start = "SELECT ";
        $prep_end = " FROM users WHERE email = '{$this->user->get_email()}'";

        foreach ($this->get_expansions() as $exp) {
            $prep_start .= $exp . ", ";
        }

        $sql = substr($prep_start, 0, -2) . $prep_end;

        // do the sql stuff
        $result = $this->conn->query($sql);
        $row = mysqli_fetch_assoc($result);

        return $row;
    }

    /*
    updates the superclass's $master_factions array to account
    for what the user has and doesn't have
    */
    private function update_master_factions(
        $user_expansions
    ): void {

        foreach ($user_expansions as $exp => $val) {
            if ($val == "0") {

                // either expansion
                unset($this->master_factions[$exp]);

                // or extra faction
                if (($key = array_search($exp, $this->master_factions['extras']['table_names'])) !== false) {
                    unset($this->master_factions['extras']['table_names'][$key]);
                    unset($this->master_factions['extras']['factions'][$key]);
                }
            }
        }
        
    }
}
?>