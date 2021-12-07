<?php
include '../connection.php';
 //Autosave back end logic
 if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $content = $_POST['content'];
    $query = "UPDATE posts SET content = ? WHERE P_ID = ?";
    $result = $connection->prepare($query);
    $result->bind_param("si", $content, $post_id);
    if ($result->execute()) {
        echo "success";
    }
    else echo "Error";
}
?>