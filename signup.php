<?php
include 'connection.php';
include 'functions.php';

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
    if ($fname == "" || $lname == "" || $email == "" || $mobile == "" || $dob == "" || $pass1 == "" || $pass2 == "" || !isset($_POST['terms'])) {
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
        $query = "INSERT INTO writers (firstname, lastname, email, mobile, dob, passkey) VALUES (?,?,?,?,?,?)";
        $result = $connection->prepare($query);
        $result->bind_param("ssssss", $fname, $lname, $email, $mobile, $dob, $pass);
        if ($result->execute()) {
            $info = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        Registration successful!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
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
            <img src="images/logo.svg" alt="" class="d-inline-block align-text-top">
          </a>
        </div>
      </nav>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-11">
                <div class="row">
                    <div class="col-sm-5">
                        <img class='img-fit mt-sm-3' width='100%' src='images/undraw_Content_creator_re_pt5b.svg'>
                            <h3 class="text-center mt-3">Become a writer</h3>
                            <p class="text-center caption">
                            Lorem ipsum, dolor  bore dolore tempora nam velit reprehenderit molestias quam sed sit maiores consequuntur ipsa?
                            </p>
                    </div>
                    <div class="col-sm-7 p-3">
                        <?php
                            if ($info != "") {
                                echo $info;
                            }
                        ?>
                        <form action="signup.php" method="post" class="mt-sm-2">
                            <div class="row g-2">
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
                                        <input type="text" class="form-control" placeholder="Date of birth" name="dob" onfocus="this.type='date'" onfocusout="this.type='text'">
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
                            <div class="form-group mt-2 p-2 mb-2">
                                <input id="accept-terms" type="checkbox" name="terms" value="terms">
                                <label for="accept-terms">I agree to the <a href="#">terms</a></label>
                            </div>
                            <button name="register" type="submit" class="btn btn-primary w-100 p-2">Create your account</button>
                            <p class="p-2">Already have an account? <a href="login.php">Sign in</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- javascripts  -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
</body>
</html>