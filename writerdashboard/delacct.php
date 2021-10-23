<?php
session_start();
include '../functions.php';
include '../connection.php';
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

if (isset($_POST['password'])) {
    $pass = check_string($connection, $_POST['password']); 
    $email = $_SESSION['w_email'];
    $checkpass = verifypass($connection, $email, $pass);
    if ($checkpass == true) {
        $query = "UPDATE writers SET active = 'no' WHERE email = ?";
        $result = $connection->prepare($query);
        $result->bind_param("s", $email);
        if ($result->execute()) {
            $mail->setFrom("support@bobblenote.com", "Bobblenote");
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = "Delete account notification";
                $mail->Body = "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Delete account notification</title>
                </head>
                <body style='background-color: #f8f9fa;padding-bottom: 7px;padding-top: 7px;'>
                <div class='box' style='border: solid #fff 1px;width: 90%;padding: 12px;margin-left: auto;margin-right: auto;background-color: white;'>
                    <div>
                        <h2 style='font-family: Raleway, sans-serif;'>Delete account notification</h2>
                        <p>Your account has been deleted successfully! If this was done in error, contact us via our contact us page. 👍</p>
                    </div>
                </div>
                </body>
                </html>";
                if ($mail->send()) {
                    echo "success";
                    unset($_SESSION['w_email']);
                }
                else{
                    echo "Error in connection";
                }
        }
        else{
            echo $result->error;
        }
    }
    else{
        echo "Invalid password";
    }
}
?>