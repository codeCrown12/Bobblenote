<?php
session_start();
include 'functions.php';
include 'connection.php';

//Snippet to check if readers session has been started
if (isset($_POST['check'])) {
    if (!isset($_SESSION['curr_user'])) {
        echo "false";
    }
    else{
        echo "true";
    }
}

//Snippet to create session
if (isset($_POST['v_email'])) {
    $email = check_string($connection, $_POST['v_email']);
    if (sub_email_exists($connection, $email)) {
        $_SESSION['curr_user'] = $email;
        echo "session started";
    }
    else{
        $query = "INSERT INTO email_list (email) VALUES (?)";
            $result = $connection->prepare($query);
            $result->bind_param("s", $email);
            if ($result->execute()) {
                $_SESSION['curr_user'] = $email;
                echo "session started";
            }
            else{
                echo "Error in connection";
            }
    }
}

//Snippet to check if a post has been liked
if (isset($_POST['pid'])) {
    $email = $_SESSION['curr_user'];
    $pid = check_string($connection, $_POST['pid']);
    if (check_likes($connection, $email, $pid)) {
        echo "true";
    }
    else{
        echo "false";
    }
}
?>