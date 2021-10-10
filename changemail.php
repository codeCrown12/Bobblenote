<?php
session_start();
include 'connection.php';
include 'functions.php';

$email = "";
$newemail = "";
$msg = "";

if (isset($_GET['wkey']) && isset($_GET['nwkey'])) {
  $email = base64_decode($_GET['wkey']);
  $newemail = base64_decode($_GET['nwkey']);  
  $_SESSION['nmail'] = $newemail;
  $_SESSION['mail'] = $email;
}

if (isset($_POST['tokenbtn'])) {
   $token = check_string($connection, $_POST['token']);
   if ($token == "") {
        $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
        Field is required!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify token</title>
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
                            <a href="index.php"><img src="images/logo.svg" alt=""></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="mt-1 text-center">Change email address</h4>
                        <p class="text-center"><span><strong>Tip:</strong> Enter the token we sent to your new email in order to change it.</span></p>
                        <?php
                            if ($msg != "") {
                                echo $msg;
                            }
                        ?>
                        <form action="changemail.php" method="POST">
                            <div class="form-outline mb-3 mt-3">
                                <input type="text" name="token" id="formtoken" class="form-control form-control-lg" />
                                <label class="form-label" for="formtoken">Verification token</label>
                              </div>
                              <button type="submit" name="tokenbtn" class="btn btn-primary btn-block mb-3" style="font-size: 15px;padding: 12px;">Verify token</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MDB -->
<script
type="text/javascript"
src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"
></script>
<!-- javascripts  -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
</body>
</html>