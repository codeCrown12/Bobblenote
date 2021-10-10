<?php
session_start();
include 'connection.php';
include 'functions.php';

if (isset($_POST['pid']) && isset($_POST['prev_val'])) {
    $pid = $_POST['pid'];
    $prev_val = $_POST['prev_val'];
    $email = $_SESSION['curr_user'];
    $new_val = $prev_val - 1;
    if (check_likes($connection, $email, $pid)) {
        $query = "DELETE FROM likes WHERE email = ? AND P_ID = ?";
        $result = $connection->prepare($query);
        $result->bind_param("si", $email, $pid);
        if ($result->execute()) {
            if (rem_like($connection, $pid, $prev_val)) {
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
?>