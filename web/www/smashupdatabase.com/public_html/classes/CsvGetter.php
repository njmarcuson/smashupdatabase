<?php

class CsvGetter {

    public static function get_csv(
        Object $conn,
        User $user = null,
    ) {
       
        // get the email
        $email = is_null($user) ? "" : $user->get_email();

        // get the result
        if ($email == "") {
            $result = self::get_all_result($conn);
        } else {
            $result = self::get_user_result($conn, $email);
        }

        $csv_name = "games.csv";
        $csv_export = "p1f1,p1f2,p1vp,p2f1,p2f2,p2vp,p3f1,p3f2,p3vp,p4f1,p4f2,p4vp,went_first, \n ";
        $field = 13;
        while($row = mysqli_fetch_array($result)) {
            // create line with field values
            for($i = 0; $i < $field; $i++) {
                $val = $row[$i];
                if ($i == 2 or $i == 5 or $i == 8 or $i == 11 or $i == 12) {
                    $val = strval($val);
                }
                $csv_export .= $val . ",";
            }	
            $csv_export = $csv_export . "\n";
        }

        header("Content-type: text/x-csv");
        header("Content-Disposition: attachment; filename=".$csv_name."");
        echo nl2br($csv_export);
        
    }

    private static function get_all_result($conn) {

        $sql = "SELECT p1_f1, p1_f2, p1_vp, p2_f1, p2_f2, p2_vp, p3_f1, p3_f2, p3_vp, p4_f1, p4_f2, p4_vp, went_first
                FROM games";
        $result = $conn->query($sql);
        return $result;

    }

    private static function get_user_result($conn, $email) {

        $prep = "SELECT p1_f1, p1_f2, p1_vp, p2_f1, p2_f2, p2_vp, p3_f1, p3_f2, p3_vp, p4_f1, p4_f2, p4_vp, went_first
                FROM games
                WHERE email = ?";
        $stmt = $conn->prepare($prep);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result();

    }

}

?>