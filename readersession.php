<?php
session_start();
include 'functions.php';
include 'connection.php';

//Snippet to check if user is logged in
if (isset($_POST['check'])) {
    if (!isset($_SESSION['w_email'])) {
        echo "false";
    }
    else{
        echo "true";
    }
}

//Snippet to check if a post has been liked
if (isset($_POST['pid'])) {
    $email = $_SESSION['w_email'];
    $pid = check_string($connection, $_POST['pid']);
    if (check_likes($connection, $email, $pid)) {
        echo "true";
    }
    else{
        echo "false";
    }
}
?>