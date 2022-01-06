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

//Variable declations
$info = "";

if (isset($_POST['register'])) {
    $fname = check_string($connection, $_POST['fname']);
    $lname = check_string($connection, $_POST['lname']);
    $email = check_string($connection, $_POST['email']);
    $mobile = check_string($connection, $_POST['mobile']);
    $dob = check_string($connection, $_POST['dob']);
    $pass1 = check_string($connection, $_POST['pass1']);
    $pass2 = check_string($connection, $_POST['pass2']);
    $acct_type = check_string($connection, $_POST['acct_type']);
    $org_name = check_string($connection, $_POST['orgname']);
    if (($acct_type == "individual" && ($fname == "" || $lname == "")) || ($acct_type == "organization" && ($org_name == ""))  || $email == "" || $mobile == "" || $dob == "" || $pass1 == "" || $pass2 == "") {
        $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        All fields are required!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    elseif (writer_email_exists($connection, $email)) {
        $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        Email is already taken by another writer!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    elseif ($pass1 != $pass2) {
        $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        Passwords do not match!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    else{
        $pass = password_hash($pass1, PASSWORD_DEFAULT);
        $query = "INSERT INTO writers (account_type, organization_name, firstname, lastname, email, mobile, dob, password) VALUES (?,?,?,?,?,?,?,?)";
        $result = $connection->prepare($query);
        $result->bind_param("ssssssss", $acct_type, $org_name, $fname, $lname, $email, $mobile, $dob, $pass);
        if ($result->execute()) {
            $token = upd_token($connection, $email);
            if ($token != false) {
                $mail->setFrom("support@bobblenote.com", "Bobblenote");
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = "Verify Email Addresss";
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
                        <h2 style='font-family: Raleway, sans-serif;'>Verify email address</h2>
                        <p><strong>Welcome Chief $fname</strong>. You're one step away from creating wonderful articles and sharing your knowledge to the world.
                        To complete your registration, please copy the one time token generated below!
                        </p>
                        <br>Your verification token is:
                            <h2>$token</h2>
                    </div>
                </div>
                </body>
                </html>";
                if ($mail->send()) {
                    $msg = "<div class='alert alert-success alert-dismissible fade show mt-2' role='alert'>
                    Mail sent successfully!
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                    $_SESSION['curremail'] = $email;
                    $_SESSION['action'] = "verifyemail";
                    header( "Location: verifytoken.php");
                }
                else{
                    $error = $mail->ErrorInfo;
                    $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
                    $error
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }
            }
        }
        else{
            $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Error in connection!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
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
    <title>Become a writer</title>
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
    <nav class="navbar navbar-light bg-white p-3">
        <div class="container-fluid">
          <a class="navbar-brand ms-lg-5 ms-sm-0" href="index.php">
            <h1>Bobblenote</h1>
          </a>
        </div>
      </nav>
    <div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-sm-11">
                <div class="row">
                    <div class="col-sm-5">
                        <img class='img-fit mt-sm-3' width='100%' src='images/undraw_Content_creator_re_pt5b.svg'>
                            <h3 class="text-center mt-3">Join our community</h3>
                            <p class="text-center caption">
                            ❝ Join our wonderful community of bright minds and access insightful and rich content ❞
                            </p>
                    </div>
                    <div class="col-sm-7 p-3">
                        <?php
                            if ($info != "") {
                                echo $info;
                            }
                        ?>
                        <form action="signup.php" method="post" class="mt-sm-2">
                            <div class="row">
                                <h6 class="mb-1">Select account type</h6>
                                <div class="col">
                                    <div class="form-check">
                                        <label class="form-check-label" for="ind_acct">
                                            Individual Account
                                        </label>
                                        <input class="form-check-input" id="ind_acct" value="individual" checked type="radio" name="acct_type">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <label class="form-check-label" for="org_acct">
                                            Organization Account
                                        </label>
                                        <input class="form-check-input" value="organization" id="org_acct" type="radio" name="acct_type">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mt-3 mb-3" id="org_group" style="display: none;">
                                <input type="text" class="form-control" placeholder="Organization Name" name="orgname">
                            </div>
                            <div class="row g-2 mt-2" id="ind_group">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="First name" name="fname">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Last name" name="lname">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3 mb-3">
                                <input type="text" class="form-control" placeholder="email address" name="email">
                            </div>
                            <div class="row g-2">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="tel" class="form-control" placeholder="Phone number" name="mobile">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" id="dob" class="form-control" placeholder="Date of birth" name="dob" onfocus="this.type='date'" onfocusout="this.type='text'">
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mt-2">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Password" name="pass1">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Confirm password" name="pass2">
                                    </div>
                                </div>
                            </div>
                            <button name="register" type="submit" class="mt-3 mb-3 btn btn-primary w-100 p-2">Create your account</button>
                            <p class="m-0">Already have an account? <a href="login.php" class="text-decoration-underline">Sign in</a></p>
                            <p><small><strong>Note:</strong> By clicking "Create your account" you agree to use our services in accordance with our <a href="#" class="text-decoration-underline">terms and conditions</a></small></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- javascripts  -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    <script>
        //Script to toggle orginazion and individual account forms
        var org_check = document.getElementById("org_acct")
        var ind_check = document.getElementById("ind_acct")

        org_check.addEventListener('click', ()=>{
            document.getElementById("org_group").style = "display: block";
            document.getElementById("ind_group").style = "display: none";
            document.getElementById("dob").setAttribute('placeholder', 'Date founded')
        })
        ind_check.addEventListener('click', ()=>{
            document.getElementById("org_group").style = "display: none";
            document.getElementById("ind_group").style = "display: flex";
            document.getElementById("dob").setAttribute('placeholder', 'Date of birth')
        })
    </script>
</body>
</html>