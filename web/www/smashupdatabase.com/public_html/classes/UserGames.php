<?php

class UserGames {

    public static function get_user_table(
        $conn,
        User $user
    ): string {

        $table = "";

        $prep = "SELECT * FROM games WHERE email = ? ORDER BY date_inputted DESC";
        $stmt = $conn->prepare($prep);
        $stmt->bind_param("s", $user->get_email());
        $stmt->execute();
        $result = $stmt->get_result();

        $loop_stuff = self::get_loop_stuff();

        while ($row = mysqli_fetch_assoc($result)) {

            $table .= "<div><tr class='regular-row'>";

            foreach ($loop_stuff as $stuff) {
                
                if ($stuff == "went_first" and $row[$stuff] == 0) {
                    $row[$stuff] = "";
                }
                
                $table .= "<th><div class='thing'>" . $row[$stuff] . "</div></th>";
            }

            $table .= "<th><div class='thing'><a style='color: var(--clr-scheme-1)' href='delete_page.php?game=" . $row['game_id'] . "'>Delete Game</a></div></th>";

            $table .= "</tr></div>";

        }

        return $table;
    }

    public static function get_user_table_single(
        Object $conn,
        User $user,
        string $gameid
    ): string {

        $table = "";

        $prep = "SELECT * FROM games WHERE email = ? AND game_id = ? ORDER BY date_inputted DESC";
        $stmt = $conn->prepare($prep);
        $stmt->bind_param("ss", $user->get_email(), $gameid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);

        $loop_stuff = self::get_loop_stuff();

        $table = "<div><tr class='regular-row'>";
        foreach ($loop_stuff as $stuff) {
            
            if ($stuff == "went_first" and $row[$stuff] == 0) {
                $row[$stuff] = "";
            }
            
            $table .= "<th><div class='thing'>" . $row[$stuff] . "</div></th>";
        }

        $table .= "</tr></div>";

        return $table;

    }



    private static function get_loop_stuff(): array {
        return array(
            "p1_f1", "p1_f2", "p1_vp", 
            "p2_f1", "p2_f2", "p2_vp", 
            "p3_f1", "p3_f2", "p3_vp", 
            "p4_f1", "p4_f2", "p4_vp", 
            "went_first"
        );
    }

}

?>