<?php
session_start();
include 'connection.php';
include 'functions.php';

if (isset($_POST['pid']) && isset($_POST['prev_val'])) {
    if (isset($_SESSION['w_email']) && $_SESSION['w_email'] != "") {
        $pid = $_POST['pid'];
        $prev_val = $_POST['prev_val'];
        $email = $_SESSION['w_email'];
        $new_val = $prev_val + 1;
        if (!check_likes($connection, $email, $pid)) {
            $query = "INSERT INTO likes (P_ID, email) VALUES (?,?)";
            $result = $connection->prepare($query);
            $result->bind_param("is", $pid, $email);
            if ($result->execute()) {
                if (update_no_of_likes($connection, $pid, $prev_val)) {
                    echo numFormatter($new_val);
                }
                else{
                    echo "Error in connection!";
                }
            }
            else{
                echo "Error in connection!";
            }
        }
    }
    else{
        echo "not logged in";
    }
}
?>