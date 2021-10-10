<?php
include 'connection.php';
include 'functions.php';

if (isset($_POST['search'])) {
    $search = check_string($connection, $_POST['search']);
    $query = "SELECT P_ID, title FROM posts WHERE title LIKE '%$search%' OR tags LIKE '%$search%' OR category LIKE '%$search%'";
    $result = $connection->query($query);
    if ($result) {
        $numrows = $result->num_rows;
        if ($numrows >= 1) {
           for ($i=0; $i < $numrows; $i++) { 
               $result->data_seek($i);
               $data = $result->fetch_array(MYSQLI_ASSOC);
               $pid = base64_encode($data['P_ID']);
               $title = $data['title'];
               if (strlen($title) > 100) {
                  $title = substr($title, 0, 100)."..."; 
               }
               echo "<a href='viewpost.php?pid=$pid' class='list-group-item list-group-item-action'>$title</a>";
           }
        }
        else{
            echo "<a href='#' class='list-group-item list-group-item-action'>No results to show</a>";
        }
    }
    else{
        echo $connection->error;
    }
}
?>