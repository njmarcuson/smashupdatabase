<?php
/*
Pretty simple stuff.

Construct it with a connection, and call it 
with a User object and an assoc post array
to add a game to the database
*/
class GameAdder {

    // adds a game to the database
    // just takes a post array
    public static function add_game(
        Object $conn,
        User $user,
        array $game
    ): bool {

        $num_players = $game['number_of_players'];

        $prep = self::get_sql($num_players);

        $stmt = $conn->prepare($prep);
    
        // this wouldn't work if i put it in a separate function :(
        // bind the parameters based on how many people were playing
        if ($num_players == 2) {

            $stmt->bind_param("ssississi", $game_id, $email, $went_first,
                $p1f1, $p1f2, $p1vp, $p2f1, $p2f2, $p2vp);

        } elseif ($num_players == 3) {

            $stmt->bind_param("ssissississi", $game_id, $email, $went_first,
                $p1f1, $p1f2, $p1vp, $p2f1, $p2f2, $p2vp,
                $p3f1, $p3f2, $p3vp);

        } elseif ($num_players == 4) {

            $stmt->bind_param("ssississississi", $game_id, $email, $went_first,
                $p1f1, $p1f2, $p1vp, $p2f1, $p2f2, $p2vp,
                $p3f1, $p3f2, $p3vp, $p4f1, $p4f2, $p4vp);

        }

        // laboriously set all the parameters
        $game_id = uniqid("GAME_");
        $email = $user->get_email();
        $went_first = $game['went_first'];
        $p1f1 = $game['p1f1'];
        $p1f2 = $game['p1f2'];
        $p2f1 = $game['p2f1'];
        $p2f2 = $game['p2f2'];
        $p3f1 = $game['p3f1'];
        $p3f2 = $game['p3f2'];
        $p4f1 = $game['p4f1'];
        $p4f2 = $game['p4f2'];
        $p1vp = $game['p1vp'];
        $p2vp = $game['p2vp'];
        $p3vp = $game['p3vp'];
        $p4vp = $game['p4vp'];

        return $stmt->execute();;
    }

    /*
    takes the game array
    returns a nice prepared sql string corresponding 
    to the number of players in the game
    */
    private static function get_sql(
        int $num_players
    ): string {

        $begin_sql = "INSERT INTO games (
            date_inputted,
            game_id,
            email,
            went_first,
            p1_f1,
            p1_f2,
            p1_vp,
            p2_f1,
            p2_f2,
            p2_vp";
        $end_sql = " VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?";

        if ($num_players > 2) {
            $begin_sql .= ",p3_f1, p3_f2, p3_vp";
            $end_sql .= ", ?, ?, ?";
        }

        if ($num_players > 3) {
            $begin_sql .= ",p4_f1, p4_f2, p4_vp";
            $end_sql .= ", ?, ?, ?";
        }

        $begin_sql .= ")";
        $end_sql .= ")";

        return $begin_sql . $end_sql;
        
    }
}
?>