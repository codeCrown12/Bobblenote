<?php
session_start();
include 'connection.php';
include 'functions.php';

$msg = "";

if (!isset($_SESSION['action'])) {
  header("Location: login.php");
}

if (isset($_POST['tokenbtn'])) {
    $token = check_string($connection, $_POST['token']);
    $dbtoken = getToken($connection, $_SESSION['curremail']);
    if ($token == "") {
         $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
         Field is required!
         <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
     </div>";
    }
    elseif($token != $dbtoken){
        $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
         Invalid token!
         <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
     </div>";
    }
    else{
        if ($_SESSION['action'] == 'updemail') {
            $update_email = upd_writer_email($connection, $_SESSION['curremail'], $_SESSION['newemail']);
            $upd_post_key = upd_post_email($connection, $_SESSION['curremail'], $_SESSION['newemail']);
            $upd_likes_key = upd_likes_email($connection, $_SESSION['curremail'], $_SESSION['newemail']);
            if($update_email == true && $upd_post_key == true && $upd_likes_key == true){
                unset($_SESSION['curremail']);
                unset($_SESSION['newemail']);
                header( "Location: login.php");
            }
            else{
                $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
            Error in connection!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
            }
        }
        elseif($_SESSION['action'] == 'updpass'){
            header( "Location: changepassword.php");
        }
        else{
            $verifyemail = verifynewwriter($connection, $_SESSION['curremail']);
            if ($verifyemail == true) {
                unset($_SESSION['curremail']);
                header( "Location: login.php");
            }
            else{
                $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
            Error in connection!
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
                            <a href="index.php"><h1>Bobblenote</h1></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="mt-1 text-center">Verify token</h4>
                        <p class="text-center">Enter the token that was sent to your email address</p>
                        <?php
                            if ($msg != "") {
                                echo $msg;
                            }
                        ?>
                        <form action="verifytoken.php" method="POST">
                            <div class="form-outline mb-3 mt-3">
                                <input type="text" name="token" id="formtoken" class="form-control form-control-lg" />
                                <label class="form-label" for="formtoken">Verification token</label>
                              </div>
                              <button type="submit" name="tokenbtn" class="btn btn-primary btn-block mb-3" style="font-size: 15px;padding: 12px;">Verify token</button>
                              <p class="text-center">Changed your mind?<a class="text-decoration-underline" href="login.php"> Login</a></p>
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