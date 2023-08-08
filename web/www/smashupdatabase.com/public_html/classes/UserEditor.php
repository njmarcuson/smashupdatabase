<?php
/**
 * This class will let you edit an acccount
 * in primarily 2 ways: changing password and
 * editing expansions
 */
class UserEditor {

    public function __construct(
        private User $user,
        private Object $conn
    ) {}

    /**
     * Takes in the new password, and changes it
     * Returns true if succcessful, false o/w
     */
    public function change_password(
        string $password
    ): bool {

        $prep = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $this->conn->prepare($prep);
        $stmt->bind_param("ss", $password, $this->user->get_email());
        return $stmt->execute();

    }

    /**
     * takes in an array of the expansions the user has
     * and an array of all expansions
     * updates the user in the table
     * 
     * returns true if executed
     */
    public function update_expansions(
        array $user_expansions,
        array $all_expansions
    ): bool {

        $prep = $this->get_sql_update_expansions($user_expansions, $all_expansions);
        $stmt = $this->conn->prepare($prep);
        $stmt->bind_param("s", $this->user->get_email());
        return $stmt->execute();

    }

    private function get_sql_update_expansions(
        array $user_expansions,
        array $all_expansions
    ): string {

        $prep = "UPDATE users SET ";

        // check whether the user has each expansions
        foreach ($all_expansions as $exp) {
            $val = in_array($exp, $user_expansions) ? "TRUE" : "FALSE";
            $prep .= $exp .  " = " . $val . ", ";
        }

        $prep = substr($prep, 0, -2) . " WHERE email = ?";
        return $prep;

    }
}
?>