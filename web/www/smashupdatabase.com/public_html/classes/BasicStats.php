<?php
/**
 * Class for some basic game stats
 */
class BasicStats {

    // returns the total number of games in the database
    public static function get_num_games(
        Object $conn
    ): int {
    
        $sql = "SELECT COUNT(*) AS count FROM games";
        $result = $conn->query($sql);
        $num_game = $result->fetch_assoc()['count'];
        return intval($num_game);

    }

    // returns the number of accounts made
    public static function get_num_users(
        $conn
    ): int {

        $sql = "SELECT COUNT(*) AS count FROM users";
        $result = $conn->query($sql);
        $num_game = $result->fetch_assoc()['count'];
        return intval($num_game);

    }

    // returns an array of num games for user and the rank
    public static function get_num_games_user(
        Object $conn,
        string $email
    ): array {
    
        $sql = "SELECT COUNT(*) AS count, email FROM games GROUP BY email ORDER BY count DESC";
        $result = $conn->query($sql);

        $rank = 0;
        $count = 0;

        while ($row = $result->fetch_assoc()) {
            
            if ($row['email'] == $email) {
                $count = $row['count'];
                break;
            }

            $rank++;
            
        }

        return array(
            "val" => $count,
            "rank" => $rank
        );

    }


}
?>