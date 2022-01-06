<?php
session_start();
include 'connection.php';
include 'functions.php';
require_once 'vendor/autoload.php';

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

if (isset($_POST['comp_id'])) {
    $comp_id = check_string($connection, $_POST['comp_id']);
    $comp_data = get_comp($connection, $comp_id);
    $user_details = get_writer_details($connection, $_SESSION['w_email']);
    if (isset($_SESSION['w_email']) == false || $_SESSION['w_email'] == "") {
        echo "not logged in";
    }
    elseif (check_participant($connection, $_SESSION['w_email'], $comp_id)) {
        echo "already a participant";
    }
    elseif ($user_details['account_type'] == "organization") {
        echo "only individuals can participate";
    }
    else{
        $selector = $_SESSION['w_email'];
        $query = "INSERT INTO participants (u_email, comp_ID) VALUES (?,?)";
        $result = $connection->prepare($query);
        $result->bind_param("ss", $selector, $comp_id);
        if ($result->execute()) {
            $mail->setFrom("support@bobblenote.com", "Bobblenote");
                $mail->addAddress($selector);
                $mail->isHTML(true);
                $mail->Subject = "Competition enrollment notification";
                $mail->Body = "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Competition enrollment notification</title>
                </head>
                <body style='background-color: #f8f9fa;padding-bottom: 7px;padding-top: 7px;'>
                <div class='box' style='border: solid #fff 1px;width: 90%;padding: 12px;margin-left: auto;margin-right: auto;background-color: white;'>
                    <div>
                        <h2 style='font-family: Raleway, sans-serif;'>Competition enrollment notification</h2>
                        <p>This is to notify you that you have successfully enrolled in the <strong> $comp_data[name] </strong>. Further information regarding this competition will be delivered to you by the host of this competition.</p>
                        <small>Note: This is an automated mail please do not reply</small>
                    </div>
                </div>
                </body>
                </html>";
                if ($mail->send()) {
                    echo "success";
                }
                else{
                    echo "error in connection";
                }
        }
        else{
            echo "error in connection";
        }
    }
}
?>