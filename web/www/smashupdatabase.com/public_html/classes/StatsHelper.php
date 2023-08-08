<?php
/**
 * Just some little helper functions for everything
 * dealing with statistics
 */
trait StatsHelper {

    // takes a row from the sql table 
    // and returns the number of players
    protected static function get_num_players(
        $row
    ): int {

        if ($row['p3_f1'] == "") {
            return 2;
        } elseif ($row['p4_f1'] == "") {
            return 3;
        } else {
            return 4;
        }

    }

    // takes a row from the sql table
    // and returns the maximum score
    protected static function get_max_score(
        $row
    ): int {

        $max_score = max(
            array(
                intval($row['p1_vp']), 
                intval($row['p2_vp']), 
                intval($row['p3_vp']), 
                intval($row['p4_vp']), 
            )
        );

        return $max_score;

    }

    public static function get_sd(
        $arr
    ): float  {

        $num_of_elements = count($arr);
        $variance = 0.0;
          
        // calculating mean using array_sum() method
        $average = array_sum($arr)/$num_of_elements;
          
        foreach($arr as $i) {
            // sum of squares of differences between 
                        // all numbers and means.
            $variance += pow(($i - $average), 2);
        }
          
        return (float)sqrt($variance/$num_of_elements);
    }

    public static function get_median($arr) {

        sort($arr);
        $count = count($arr);
        $middleval = floor(($count-1)/2);

        if ($count % 2) {

            return $arr[$middleval];

        } else {

            $low = $arr[$middleval];
            $high = $arr[$middleval+1];
            return (($low+$high)/2);

        }

    }

    public static function get_rank($arr, $val, $reverse=false): int {

        $counter = 1;

        foreach ($arr as $val_compare) {

            if (!$reverse and $val_compare > $val) {
                $counter++;
            } elseif ($reverse and $val_compare < $val) {
                $counter++;
            }


        }

        return $counter;

    }

    public static function get_equals($arr, $val): bool {

        $counter = 0;

        foreach ($arr as $val_compare) {
            if ($val_compare == $val) {
                $counter++;
            }
        }

        return $counter > 1;
    }

    public static function get_player_with_combo($arr, $f1, $f2): int {

        if (($arr['p1_f1'] == $f1 and $arr['p1_f2'] == $f2) 
            or ($arr['p1_f2'] == $f1 and $arr['p1_f1'] == $f2)) {

            return 1;

        }

        elseif (($arr['p2_f1'] == $f1 and $arr['p2_f2'] == $f2) 
            or ($arr['p2_f2'] == $f1 and $arr['p2_f1'] == $f2)) {

            return 2;

        }

        elseif (($arr['p3_f1'] == $f1 and $arr['p3_f2'] == $f2) 
            or ($arr['p3_f2'] == $f1 and $arr['p3_f1'] == $f2)) {

            return 3;

        }

        elseif (($arr['p4_f1'] == $f1 and $arr['p4_f2'] == $f2) 
            or ($arr['p4_f2'] == $f1 and $arr['p4_f1'] == $f2)) {

            return 4;

        }

        return 0;
    }

}
?>