<?php

// function to sanitize input strings from forms
function check_string($con, $string){
    $string = $con->real_escape_string($string);
    $string = strip_tags($string);
    $string = stripslashes($string);
    return $string;
}

// function to strip spaces from strings
function strip_spaces($str){
    $new_str = preg_replace("/\s+/", "", $str);
    return $new_str;
}

//likes and comments formatter
function numFormatter($num) {
    if($num > 999 && $num < 1000000){
        return round($num/1000, 1).'K'; // convert to K for number from > 1000 < 1 million 
    }else if($num > 1000000){
        return round($num/1000000, 1).'M'; // convert to M for number from > 1 million 
    }else if($num <= 999){
        return $num; // if value < 1000, nothing to do
    }
}

//function to check if writer email already exists in the database
function writer_email_exists($connection, $email){
    $query = "SELECT email FROM writers WHERE email = '$email'";
    $result = $connection->query($query);
    $rows = $result->num_rows;
    if ($rows >= 1) {
        return true;
    }
    return false;
}

//function to check if subscriber email already exists in the database
function sub_email_exists($connection, $email){
    $query = "SELECT email FROM email_list WHERE email = '$email'";
    $result = $connection->query($query);
    $rows = $result->num_rows;
    if ($rows >= 1) {
        return true;
    }
    return false;
}

//function to verify password
function verifypass($connection, $email, $pass){
    $query = "SELECT password FROM writers WHERE email = '$email'";
    $result = $connection->query($query);
    $details = $result->fetch_array(MYSQLI_ASSOC);
    $check_pass = password_verify($pass, $details['password']);
    if($check_pass){
        return true;
    }
return false;  
}

//function to retrieve user-details
function get_writer_details($connection, $email){
    $detail = "";
    $query = "SELECT W_ID, account_type, organization_name, firstname, lastname, email, mobile, dob, bio, profilepic, twitter, instagram, linkedin, token FROM writers WHERE email = '$email'";
    $result = $connection->query($query);
    if (!$result) {
        return "Error in getting details";
    }
    else{
        $detail = $result->fetch_array(MYSQLI_ASSOC);
    }
    return $detail;
}


//function to retrieve post-details
function get_post_details($connection, $p_id){
    $detail = "";
    $query = "SELECT * FROM posts WHERE P_ID = $p_id";
    $result = $connection->query($query);
    if (!$result) {
        return "Error in getting details";
    }
    else{
        $detail = $result->fetch_array(MYSQLI_ASSOC);
    }
    return $detail;
}

//function to format date
function format_date($date_string){
    $date = date_create($date_string);
    $date = date_format($date, "M d Y");
    return $date;
}


//function to generate pin
function gen_pin(){
    $rand_num =  rand(6, 12);
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pin = substr(str_shuffle($permitted_chars), 0, $rand_num);
    return $pin;
}

//function to update db with image
function update_post_wimg($connection, $newimg, $title, $category, $tags_stripped, $content, $excerpt, $published, $pid){
    $date = date("Y-m-d");
    $query = "UPDATE posts SET coverimg = ?, title = ?, category = ?, tags = ?, content = ?, excerpt = ?, published = ?, date_created = ? WHERE P_ID = ?";
    $ins_result = $connection->prepare($query);
    $ins_result->bind_param("ssssssssi", $newimg, $title, $category, $tags_stripped, $content, $excerpt, $published, $date, $pid);
    if ($ins_result->execute()) {
        return true;
    }
    return false;
}

//function to update db without image
function update_post($connection, $title, $category, $tags_stripped, $content, $excerpt, $published, $pid){
    $date = date("Y-m-d");
    $query = "UPDATE posts SET title = ?, category = ?, tags = ?, content = ?, excerpt = ?, published = ?, date_created = ? WHERE P_ID = ?";
    $ins_result = $connection->prepare($query);
    $ins_result->bind_param("sssssssi", $title, $category, $tags_stripped, $content, $excerpt, $published, $date, $pid);
    if ($ins_result->execute()) {
        return true;
    }
    return false;
}

//function to update number of comments
function update_no_of_comments($connection, $pid, $prev_value){
    $new_val = $prev_value + 1;
    $query = "UPDATE posts SET no_of_comments = ? WHERE P_ID = ?";
    $result = $connection->prepare($query);
    $result->bind_param("ii", $new_val, $pid);
    if ($result->execute()) {
        return true;
    }
    return false;
}

//function to update number of likes
function update_no_of_likes($connection, $pid, $prev_value){
    $new_val = $prev_value + 1;
    $query = "UPDATE posts SET no_of_likes = ? WHERE P_ID = ?";
    $result = $connection->prepare($query);
    $result->bind_param("ii", $new_val, $pid);
    if ($result->execute()) {
        return true;
    }
    return false;
}

//function to remove like
function rem_like($connection, $pid, $prev_value){
    $new_val = $prev_value - 1;
    $query = "UPDATE posts SET no_of_likes = ? WHERE P_ID = ?";
    $result = $connection->prepare($query);
    $result->bind_param("ii", $new_val, $pid);
    if ($result->execute()) {
        return true;
    }
    return false;
}

//function to check duplicate likes
function check_likes($connection, $email, $pid){
    $query = "SELECT * FROM likes WHERE email = '$email' AND P_ID = $pid";
    $result = $connection->query($query);
    $rows = $result->num_rows;
    if ($rows >= 1) {
        return true;
    }
    return false;
}

//function to update token
function upd_token($connection, $email){
    $token = gen_pin();
    $query = "UPDATE writers SET token = ? WHERE email = '$email'";
    $result = $connection->prepare($query);
    $result->bind_param("s", $token);
    if (!$result->execute()) {
       return false;
    }
    return $token;
}

//Function to get token
function getToken($connection, $email){
    $query = "SELECT token FROM writers WHERE email = '$email'";
    $result = $connection->query($query);
    if (!$result) {
        return "Error in getting details";
    }
    else{
        $detail = $result->fetch_array(MYSQLI_ASSOC);
    }
    return $detail['token'];
}

//Function to verify new writer email address
function verifynewwriter($connection, $email){
    $query = "UPDATE writers SET email_verified = 'yes' WHERE email = '$email'";
    $result = $connection->prepare($query);
    $result->bind_param("s", $email);
    if (!$result->execute()) {
       return false;
    }
    return true;
}

//Function to update writer email_key
function upd_writer_email($connection, $email, $newemail){
    $query = "UPDATE writers SET email = ? WHERE email = '$email'";
    $result = $connection->prepare($query);
    $result->bind_param("s", $newemail);
    if (!$result->execute()) {
       return false;
    }
    return true;
}

//function to update posts email_key
function upd_post_email($connection, $email, $newemail){
    $query = "UPDATE writers SET W_email = ? WHERE email = '$email'";
    $result = $connection->prepare($query);
    $result->bind_param("s", $newemail);
    if (!$result->execute()) {
       return false;
    }
    return true;
}

//function to update likes email_key
function upd_likes_email($connection, $email, $newemail){
    $query = "UPDATE likes SET email = ? WHERE email = '$email'";
    $result = $connection->prepare($query);
    $result->bind_param("s", $newemail);
    if (!$result->execute()) {
       return false;
    }
    return true;
}

//Function to update writer password
function upd_writer_pas($connection, $email, $pass){
    $query = "UPDATE writers SET password = ? WHERE email = '$email'";
    $result = $connection->prepare($query);
    $result->bind_param("s", $pass);
    if (!$result->execute()) {
       return false;
    }
    return true;
}

//function to count pending posts
function count_pending($connection, $email){
    $query = "SELECT COUNT(*) AS total FROM posts WHERE W_email = '$email' AND published = 'no'";
    $result = $connection->query($query);
    if ($result) {
        $data = $result->fetch_array(MYSQLI_ASSOC);
        return $data['total'];
    }
    else{
        return "Error";
    }
}

//function to count published posts
function count_published($connection, $email){
    $query = "SELECT COUNT(*) AS total FROM posts WHERE W_email = '$email' AND published = 'yes'";
    $result = $connection->query($query);
    if ($result) {
        $data = $result->fetch_array(MYSQLI_ASSOC);
        return $data['total'];
    }
    else{
        return "Error";
    }
}

//function to add transaction
function add_transaction($connection, $amount, $type, $credit, $debit, $narration){
    $query = "INSERT INTO transactions (type, credit, debit, amount, narration) VALUES (?,?,?,?,?)";
    $result = $connection->prepare($query);
    $result->bind_param("sssis", $type, $credit, $debit, $amount, $narration);
    if ($result->execute()) {
        return true;
    }
    return false;
}

//function to check if tag exists
function tag_exists($connection, $tag){
    $query = "SELECT tag FROM competitions WHERE tag = '$tag'";
    $result = $connection->query($query);
    $rows = $result->num_rows;
    if ($rows >= 1) {
        return true;
    }
    return false;
}

//function to generate color
function gen_color($num){
    $colors_arr = array("#d4243b", "#1a30d9", "#0475cc", "#333336", "#de00bd", "#02aba0");
    return $colors_arr[$num];
}

//function to prevent double participation
function check_participant($connection, $u_email, $comp_id){
    $query = "SELECT * FROM participants WHERE u_email = '$u_email' AND comp_ID = '$comp_id'";
    $result = $connection->query($query);
    $rows = $result->num_rows;
    if ($rows >= 1) {
        return true;
    }
    return false;
}

//function to get competition details
function get_comp($connection, $comp_id){
    $comp_data = "";
    $query = "SELECT * FROM competitions WHERE comp_ID = $comp_id";
    $result = $connection->query($query);
    if ($result) {
        $comp_data = $result->fetch_array(MYSQLI_ASSOC);
        return $comp_data;
    }
    else{
        return "error in getting details";
    }
}

//Function to prevent more than one post per competition
function double_post($connection, $tag, $u_email){
    $query = "SELECT COUNT(*) AS total FROM posts WHERE tags LIKE '%$tag%' AND W_email = '$u_email' AND published = 'yes'";
    $result = $connection->query($query);
    if ($result) {
        $data = $result->fetch_array(MYSQLI_ASSOC);
        return $data['total'];
    }
    return false;
}

//Function to prevent early publishing befor competition start date
function early_pub($connection, $start_date, $tag, $u_email){
    $query = "SELECT COUNT(*) AS total FROM posts WHERE W_email = '$u_email' AND tags LIKE '%$tag%' AND date_created < '$start_date' AND published = 'yes'";
    $result = $connection->query($query);
    if ($result) {
        $data = $result->fetch_array(MYSQLI_ASSOC);
        return $data['total'];
    }
    return false;
}

//Function to disqualify participant
function disqualify_participant($connection, $part_id){
    $query = "UPDATE participants SET part_status = 'disqualified' WHERE part_ID = $part_id";
    $result = $connection->query($query);
    if ($result) {
        return true;
    }
    return false;
}

function expire_comp($connection, $comp_id){
    $query = "UPDATE competitions SET comp_status = 'expired' WHERE comp_ID = $comp_id";
    $result = $connection->query($query);
    if ($result) {
        return true;
    }
    return false;
}

//function to count hosted competition
function count_comp($connection, $email){
    $query = "SELECT COUNT(*) AS total FROM competitions WHERE u_email = '$email'";
    $result = $connection->query($query);
    if ($result) {
        $data = $result->fetch_array(MYSQLI_ASSOC);
        return $data['total'];
    }
    else{
        return "Error";
    }
}

//function to count pending participants for a competition
function count_part($connection, $comp_id, $type){
    if ($type == "pending") {
        $query = "SELECT COUNT(*) AS total FROM participants WHERE comp_ID = $comp_id AND part_status = 'pending'";
    }
    elseif ($type == "verified") {
        $query = "SELECT COUNT(*) AS total FROM participants WHERE comp_ID = $comp_id AND part_status = 'verified'";
    }
    elseif ($type == "disqualified") {
        $query = "SELECT COUNT(*) AS total FROM participants WHERE comp_ID = $comp_id AND part_status = 'disqualified'";
    }
    $result = $connection->query($query);
    if ($result) {
        $data = $result->fetch_array(MYSQLI_ASSOC);
        return $data['total'];
    }
    else{
        return "Error";
    }
}

//Dump participants
function dump_exp_part($connection, $comp_id){
    $query = "INSERT INTO participants_dump SELECT * FROM participants WHERE comp_ID = $comp_id";
    $result = $connection->query($query);
    if ($result) {
        return true;
    }
    return false;
}

//Empty expired competitions participants
function empty_exp_part($connection, $comp_id){
    $query = "DELETE FROM participants WHERE comp_ID = $comp_id";
    $result = $connection->query($query);
    if ($result) {
        return true;
    }
    return false;
}

//Function to get total number of pages
function total_page_no($connection, $query, $total_records_per_page){
    $result = $connection->query($query);
    if ($result) {
        $numrows = $result->num_rows;
        if ($numrows >= 1) {
            $total_records = $result->fetch_array(MYSQLI_ASSOC);
            $total_records = $total_records['total_records'];
            $total_no_of_pages = ceil($total_records / $total_records_per_page);       
            return $total_no_of_pages;
        }
        else return 0;
    }
    else return 0;
}


//Function to add to winner to hall of fame
function addToAwards($connection, $comp_name, $comp_id, $email, $position, $amount){
    $query = "INSERT INTO awards (comp_ID, comp_name, u_email, position, amount) VALUES (?,?,?,?,?)";
    $result = $connection->prepare($query);
    $result->bind_param("issii", $comp_id, $comp_name, $email, $position, $amount);
    if (!$result->execute()) {
       return false;
    }
    return true;
}

//Function to update payment request status
function update_request_status($connection, $comp_id){
    $query = "UPDATE competitions SET payout_requested = 'true' WHERE comp_ID = ?";
    $result = $connection->prepare($query);
    $result->bind_param("i", $comp_id);
    if (!$result->execute()) {
       return false;
    }
    return true;
}
?>