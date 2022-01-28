<?php
session_start();
include '../connection.php';
include '../functions.php';
require_once '../vendor/autoload.php';

//Mailer script
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();

$mail->isSMTP();
$mail->Host = 'mail.bobblenote.com';
$mail->SMTPAuth = true;
$mail->Username = 'support@bobblenote.com'; 
$mail->Password = 'Pm+b1V&%R4)f';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;


//Snippet to disqualify participant
if(isset($_POST['part_ID']) && $_POST['type'] == "disq"){
    $part_id = $_POST['part_ID'];
    $query = "UPDATE participants SET part_status = 'disqualified' WHERE part_ID = $part_id";
    $result = $connection->query($query);
    if ($result) {
        echo "success";
    }
    else{
        echo "error";
    }
}

//Snippet to verify pending participant
if (isset($_POST['part_ID']) && $_POST['type'] == "verify") {
    $part_id = $_POST['part_ID'];
    $date = date("Y-m-d");
    $query = "UPDATE participants SET part_status = 'verified', date_joined = '$date' WHERE part_ID = $part_id";
    $result = $connection->query($query);
    if ($result) {
        echo "success";
    }
    else{
        echo "error";
    }
}

//snippet to send email to participants
if (isset($_POST['send'])) {
   $errmsg = "";
   $rec = check_string($connection, $_POST['rec']);
   $sub = check_string($connection, $_POST['sub']);
   $body = $_POST['body'];
   $compid = $_POST['comp_ID'];
   $comp_info = get_comp($connection, $compid);
   if ($rec == "" || $sub == "" || $body == "") {
       echo "All fields are required";
   }
   else{
        if ($rec == "verified" || $rec == "disqualified" || $rec == "pending") {
            $query = "SELECT u_email FROM participants WHERE part_status = '$rec' AND comp_ID = $compid";
            $result = $connection->query($query);
            if ($result) {
                $num_rows = $result->num_rows;
                if ($num_rows >= 1) {
                    for ($i=0; $i < $num_rows; $i++) { 
                        $result->data_seek($i);
                        $data = $result->fetch_array(MYSQLI_ASSOC);
                        $mail->addBCC($data['u_email']);
                    }
                }
            }
        }
        else $mail->addBCC($rec);
        $mail->setFrom($_SESSION['w_email'], $comp_info['name']);
        $mail->isHTML(true);
        $mail->Subject = $sub;
        $mail->Body = $body;
        if ($mail->send()) {
            echo "success";
        }
        else{
            echo "Error in connection";
        }
   }
}

//Snippet to verify all pending participants at once
if (isset($_POST['verify_all'])) {
    $comp_id = $_POST['comp_ID'];
    $date = date("Y-m-d");
    $query = "UPDATE participants SET part_status = 'verified', date_joined = '$date' WHERE comp_ID = $comp_id";
    $result = $connection->query($query);
    if ($result) {
        echo "success";
    }
    else{
        echo "error";
    }
}

//Snippet to delete drafts
if (isset($_POST['draft_ID'])) {
    $draft_id = $_POST['draft_ID'];
    $query = "DELETE FROM posts WHERE P_ID = $draft_id";
    $result = $connection->query($query);
    if ($result) {
        echo "success";
    }
    else{
        echo "error";
    }
}

//snippet to request payout to winners
if (isset($_POST['awardees'])) {
    $amounts = explode(',', $_POST['amounts']);
    $emails = explode(',', $_POST['emails']);
    $awards_no = $_POST['awardees'];
    $compid = $_POST['compID'];
    $body = "";
    $comp_details = get_comp($connection, $compid);
    if ($comp_details['payout_requested'] == "true") {
        echo "Payout requested already";
    }
    else{
        for ($i=0; $i < $awards_no; $i++) { 
            $u_details = get_writer_details($connection, $emails[$i]);
            $position = $i + 1;
            addToAwards($connection, $comp_details['name'], $compid, $emails[$i], $position, $amounts[$i]);
            $body .= "
                <p>
                    <h3>Position $position</h3>
                    First name: $u_details[firstname] <br>
                    Last name: $u_details[lastname] <br>
                    Email address: $u_details[email] <br>
                    Award amount: ₦ $amounts[$i]    
                </p>";
        }
    
        $mail->addAddress("kingsjacobfrancis@gmail.com");
        $mail->setFrom("support@bobblenote.com", "Bobblenote");
        $mail->isHTML(true);
        $mail->Subject = "Request for competition payout";
        $mail->Body = "<h2>Request for payment for $comp_details[name] winners</h2>".$body;
        if ($mail->send()) {
            if (update_request_status($connection, $compid)) {
                echo "success";
            }
        }
        else{
            echo "Error in connection";
        }
    }
      
 }
?>