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
    $query = "SELECT W_ID, firstname, lastname, email, mobile, dob, bio, profilepic, twitter, facebook, instagram, linkedin, token FROM writers WHERE email = '$email'";
    $result = $connection->query($query);
    if (!$result) {
        return "Error in getting details";
    }
    else{
        $detail = $result->fetch_array(MYSQLI_ASSOC);
    }
    return $detail;
}

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

//Function to update writer email
function upd_writer_email($connection, $email, $newemail){
    $query = "UPDATE writers SET email = ? WHERE email = '$email'";
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

//function to count published posts
function count_photos($connection, $email){
    $query = "SELECT COUNT(*) AS total FROM gallery WHERE w_email = '$email'";
    $result = $connection->query($query);
    if ($result) {
        $data = $result->fetch_array(MYSQLI_ASSOC);
        return $data['total'];
    }
    else{
        return "Error";
    }
}
?>