<?php
    session_start();
    include 'connection.php';
    include 'functions.php';
  
    
    if (isset($_POST['subemail'])) {
        $email = check_string($connection, $_POST['subemail']);
        if ($email == "") {
            echo "Field is required";
        }
        elseif (sub_email_exists($connection, $email)) {
            echo "Email already exists";
        }
        else{
            $query = "INSERT INTO email_list (email) VALUES (?)";
            $result = $connection->prepare($query);
            $result->bind_param("s", $email);
            if ($result->execute()) {
                echo "Subscription successful";
                $_SESSION['curr_user'] = $email;
            }
            else{
                echo "Error in connection";
            }
        }
    }
?>