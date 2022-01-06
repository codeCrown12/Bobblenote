<?php
    if ($selector != "") {
        //Check for competition participation faults
        $p_query = "SELECT part_ID, comp_ID FROM participants WHERE u_email = '$selector' AND part_status <> 'disqualified'";
        $p_result = $connection->query($p_query);
        if ($p_result) {
            $p_rows = $p_result->num_rows;
            if ($p_rows >= 1) {
                for ($i=0; $i < $p_rows; $i++) { 
                    $p_result->data_seek($i);
                    $p_data = $p_result->fetch_array(MYSQLI_ASSOC);
                    $comp_info = get_comp($connection, $p_data['comp_ID']);
                    if (double_post($connection, $comp_info['tag'], $selector) > 1 || early_pub($connection, $comp_info['start_date'], $comp_info['tag'], $selector) >= 1) {
                        disqualify_participant($connection, $p_data['part_ID']);
                    } 
                }
            }
        }

        //check for expired hosted competitions
        $exp_query = "SELECT comp_ID, end_date FROM competitions WHERE u_email = '$selector'";
        $exp_result = $connection->query($exp_query);
        if ($exp_result) {
            $exp_rows = $exp_result->num_rows;
            if ($exp_rows >= 1) {
                for ($i=0; $i < $exp_rows; $i++) { 
                    $exp_result->data_seek($i);
                    $exp_data = $exp_result->fetch_array(MYSQLI_ASSOC);
                    if (strtotime(date("Y-m-d")) >= strtotime($exp_data['end_date'])) {
                        expire_comp($connection, $exp_data['comp_ID']);
                    }
                }
            }
        }
    }


?>