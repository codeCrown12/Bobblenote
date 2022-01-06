<?php
error_reporting(0);
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
$errormsg = "";

if(isset($_POST['request'])){
  $email = check_string($connection, $_POST['email']);

  if($email == ""){
    $errormsg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
    All fields are required!
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  elseif (!writer_email_exists($connection, $email)) {
    $errormsg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
    This email is not registered here!
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  else{
    $token = upd_token($connection, $email);
    if ($token != false) {
      $mail->setFrom("support@bobblenote.com", "Bobblenote");
      $mail->addAddress($email);
      $mail->isHTML(true);
      $mail->Subject = "Change Password verification";
      $mail->Body = "<!DOCTYPE html>
      <html lang='en'>
      <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Email verification</title>
      </head>
      <body style='background-color: #f8f9fa;padding-bottom: 7px;padding-top: 7px;'>
      <div class='box' style='border: solid #fff 1px;width: 90%;padding: 12px;margin-left: auto;margin-right: auto;background-color: white;'>
          <div>
              <h2 style='font-family: Raleway, sans-serif;'>Change of password confirmation</h2>
              <p><strong>Hello Chief</strong>. We just received a request from an account with email '$email' to change their password. If this wasn't you, <strong>Do not reply to this email</strong>
              </p>
              <br>Your verification token is:
                <h2>$token</h2>
          </div>
      </div>
      </body>
      </html>";
      if ($mail->send()) {
          unset($_SESSION['w_email']);
          $_SESSION['curremail'] = $email;
          $_SESSION['action'] = "updpass";
          header( "Location: verifytoken.php");
      }
      else{
        $error = $mail->ErrorInfo;
        $errormsg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
          $error
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
      }
    } 
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password</title>
    <!-- Font Awesome -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
    rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
    rel="stylesheet"
    />
    <!-- MDB -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css"
    rel="stylesheet"
    />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header text-center">
                        <div class="card-title">
                            <a href="index.php"><h1>Bobblenote</h1></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="mt-1 text-center">Forgot Password</h4>
                        <p class="text-center">Provide your email address below</p>
                        <?php
                            if ($errormsg != "") {
                                echo $errormsg;
                            }
                        ?>
                        <form action="forgotpass.php" method="POST" autocomplete="off">
                            <div class="form-outline mb-3 mt-3">
                                <input type="email" name="email" id="formemail" class="form-control form-control-lg" />
                                <label class="form-label" for="formemail">Email address</label>
                              </div>
                              <button type="submit" name="request" class="btn btn-primary btn-block mb-3" style="font-size: 15px;padding: 12px;">Request reset</button>
                              <p class="text-center">Remember your password ?<a class="text-decoration-underline" href="login.php"> Login</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
    <!-- javascripts  -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
</body>
</html>