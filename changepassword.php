<?php
session_start();
include 'connection.php';
include 'functions.php';

$msg = "";

if (!isset($_SESSION['action'])) {
  header("Location: login.php");
}

if (isset($_POST['changepass'])) {
    $pass1 = check_string($connection, $_POST['newpass']);
    $pass2 = check_string($connection, $_POST['newpass1']);
    if ($pass1 == "" || $pass2 == "") {
        $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
            Fields are required!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    elseif ($pass1 != $pass2) {
        $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
            Passwords do not match!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    else{
        $pass = password_hash($pass1, PASSWORD_DEFAULT);
        $email = $_SESSION['curremail'];
        if(upd_writer_pas($connection, $email, $pass)){
            header("Location: login.php");
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
                        <h4 class="mt-1 text-center">Change password</h4>
                        <p class="text-center">Enter a new password for your account</p>
                        <?php
                            if ($msg != "") {
                                echo $msg;
                            }
                        ?>
                        <form action="changepassword.php" method="POST">
                            <div class="form-outline mb-3 mt-3">
                                <input type="password" name="newpass" id="formtoken" class="form-control form-control-lg" />
                                <label class="form-label" for="formtoken">Enter new password</label>
                              </div>
                              <div class="form-outline mb-3 mt-3">
                                <input type="password" name="newpass1" id="formtoken" class="form-control form-control-lg" />
                                <label class="form-label" for="formtoken">Confirm new password</label>
                              </div>
                              <button type="submit" name="changepass" class="btn btn-primary btn-block mb-3" style="font-size: 15px;padding: 12px;">Change password</button>
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