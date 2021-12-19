<?php
    if ($selector != "") {
        $p_query = "SELECT comp_ID FROM participants WHERE u_email = '$selector' AND part_status <> 'disqualified'";
        $p_result = $connection->query($p_query);
        if ($p_result) {
            $p_rows = $p_result->num_rows;
            if ($p_rows >= 1) {
                for ($i=0; $i < $p_rows; $i++) { 
                    $p_result->data_seek($i);
                    $p_data = $p_result->fetch_array(MYSQLI_ASSOC);
                    $comp_info = get_comp($connection, $p_data['comp_ID']);
                    if (double_post($connection, $comp_info['tag'], $selector) > 1 || early_pub($connection, $comp_info['start_date'], $comp_info['tag'], $selector) >= 1) {
                        disqualify_participant($connection, $p_data['comp_ID'], $selector);
                    } 
                }
            }
        }
    }
?>