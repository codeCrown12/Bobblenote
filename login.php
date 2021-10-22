<?php
session_start();
include 'connection.php';
include 'functions.php';
$errormsg = "";

if(isset($_POST['login'])){
  $email = check_string($connection, $_POST['email']);
  $pass =  check_string($connection, $_POST['passkey']);

  if($email == "" || $pass == ""){
    $errormsg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
    All fields are required!
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  else{
    $query = "SELECT email, password FROM writers WHERE email = '$email' AND active = 'yes'";
    $result = $connection->query($query);
    if (!$result) {
        $errormsg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
        Invalid email or password!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    else{
        $data = $result->fetch_array(MYSQLI_ASSOC);
        $check_pass = password_verify($pass, $data['password']);
        if($check_pass){
            $_SESSION['w_email'] = $email;
            header("location: writerdashboard/home.php");
        }
        else{
            $errormsg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
            Invalid email or password!
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
    <title>Login</title>
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
                        <h4 class="mt-1 text-center">Sign into your account!</h4>
                        <?php
                            if ($errormsg != "") {
                                echo $errormsg;
                            }
                        ?>
                        <form action="login.php" method="POST">
                            <div class="form-outline mb-3 mt-3">
                                <input type="email" name="email" id="formemail" class="form-control form-control-lg" />
                                <label class="form-label" for="formemail">Email address</label>
                              </div>
                              <div class="form-outline mb-3">
                                <i class="fas fa-eye trailing" id="show-pass"></i>
                                <input type="password" name="passkey" id="formpass" class="form-control form-control-lg form-icon-trailing"/>
                                <label class="form-label" for="formpass">Password</label>
                              </div>
                              <button type="submit" name="login" class="btn btn-primary btn-block mb-3" style="font-size: 15px;padding: 12px;">Login</button>
                              <p class="text-center" style="margin-bottom: 0;">
                                  Don't have an account ? <a href="signup.php">Create one</a>
                              </p>
                              <p class="text-center"><a href="#">Forgot password ?</a></p>
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
<script>
    var showpass = document.querySelector("#show-pass")
    var formpass = document.querySelector("#formpass")
    showpass.addEventListener('click', (e)=>{
        if (formpass.type == "password") {
            formpass.type = "text"
            showpass.classList.replace("fa-eye", "fa-eye-slash")
        }
        else{
            formpass.type = "password"
            showpass.classList.replace("fa-eye-slash", "fa-eye")
        }
    })
</script>
</body>
</html>