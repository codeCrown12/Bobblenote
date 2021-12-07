<?php
session_start();
include 'connection.php';
include 'functions.php';

if (isset($_POST['pid'])) {
    if (isset($_SESSION['w_email']) && $_SESSION['w_email'] != "") {
        $pid = $_POST['pid'];
        $prev_val = $_POST['prev_val'];
        $name = check_string($connection, $_POST['name']);
        $comment = check_string($connection, $_POST['comment']);
        if ($name == "" || $comment == ""){
            echo "All fields are required!";
        }
        else{
            $query = "INSERT INTO comments (P_ID, name, comment_text) VALUES (?,?,?)";
            $result = $connection->prepare($query);
            $result->bind_param("iss", $pid, $name, $comment);
            if ($result->execute()) {
                if (update_no_of_comments($connection, $pid, $prev_val)) {
                    echo "Comment added successfully!";
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