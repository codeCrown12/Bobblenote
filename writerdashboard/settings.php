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
$row = "";
$selector = "";
$msg = "";
$rand = rand();
$allowed_image_extension = array(
  "png",
  "jpg",
  "jpeg"
);

if ($_SESSION['w_email'] == "") {
  header("Location: ../login.php");
}
else{
  $selector = $_SESSION['w_email'];
}

//select writer details from db
$details = get_writer_details($connection, $selector);
$fullname = $details['firstname']. " ". $details['lastname'];
$profile_img = $details['profilepic'];

//function to update details with image
function update_details_wimage($connection, $selector, $fname, $lname, $mobile, $dob, $bio, $dp_img){
  $query = "UPDATE writers SET firstname = ?, lastname = ?, mobile = ?, dob = ?, bio = ?, profilepic = ? 
  WHERE email = '$selector'";
  $result = $connection->prepare($query);
  $result->bind_param("ssssss", $fname, $lname, $mobile, $dob, $bio, $dp_img);
  if (!$result->execute()) {
    return false;
  }
  return true;
}

//function to update details without image
function update_details($connection, $selector, $fname, $lname, $mobile, $dob, $bio){
  $query = "UPDATE writers SET firstname = ?, lastname = ?, mobile = ?, dob = ?, bio = ? 
  WHERE email = '$selector'";
  $result = $connection->prepare($query);
  $result->bind_param("sssss", $fname, $lname, $mobile, $dob, $bio);
  if (!$result->execute()) {
    return false;
  }
  return true;
}


//code to update user details
if (isset($_POST['save'])) {
  $fname = check_string($connection, $_POST['fname']);
  $lname = check_string($connection, $_POST['lname']);
  $mobile = check_string($connection, $_POST['mobile']);
  $dob = check_string($connection, $_POST['dob']);
  $bio = $_POST['bio'];

  // Get image file extension
  $file_extension = pathinfo($_FILES["dp-img"]["name"], PATHINFO_EXTENSION);

  if ($fname == "" || $lname == "" || $mobile == "" || $dob == "" || $bio == "") {
        $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
          All fields are required!
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
         </div>";
  }
  //if image is changed code block
  elseif (file_exists($_FILES['dp-img']['tmp_name'])) {
      if (!in_array($file_extension, $allowed_image_extension)) {
        $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
        Upload only valid image. Only PNG and JPEG formats are allowed!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    else{
        $newimg = "images/other/".$selector.".png";
        $update_wimg = update_details_wimage($connection, $selector, $fname, $lname, $mobile, $dob, $bio, $newimg);
        if ($update_wimg) {
            move_uploaded_file($_FILES['dp-img']['tmp_name'], "../".$newimg);
            $msg = "<div class='alert alert-success alert-dismissible fade show mt-2' role='alert'>
            Profile update successful!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
          header("Refresh: 1");
        }
        else{
          $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
          Error in connection!
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        }
    }
  }
  //if image is not changed code block
  else{
    $update = update_details($connection, $selector, $fname, $lname, $mobile, $dob, $bio);
    if($update){
      $msg = "<div class='alert alert-success alert-dismissible fade show mt-2' role='alert'>
      Profile update successful!
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    header("Refresh: 1");
    }
  }
}

//update socials
if (isset($_POST['upd_social'])) {
  $fb = check_string($connection, $_POST['facebook']);
  $ig = check_string($connection, $_POST['instagram']);
  $twt = check_string($connection, $_POST['twitter']);
  $lin = check_string($connection, $_POST['linkedin']);

  $query = "UPDATE writers SET facebook = ?, instagram = ?, twitter = ?, linkedin = ? WHERE email = '$selector'";
  $result = $connection->prepare($query);
  $result->bind_param("ssss", $fb, $ig, $twt, $lin);
  if (!$result->execute()) {
    $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
          Error in connection!
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
  }
  else{
    header("Refresh: 1");
    $msg = "<div class='alert alert-success alert-dismissible fade show mt-2' role='alert'>
      Socials updated successfully!
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
  }
}

//Logic to change email address
if(isset($_POST['upd_email'])){
  $newemail = check_string($connection, $_POST['newemail']);
  if ($newemail == "") {
    $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
          Field is required!
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
  }
  else{
    $token = upd_token($connection, $selector);
    if ($token != false) {
      $mail->setFrom("support@bobblenote.com", "Bobblenote");
      $mail->addAddress($newemail);
      $mail->isHTML(true);
      $mail->Subject = "Change email address";
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
              <h2 style='font-family: Raleway, sans-serif;'>Change of email confirmation</h2>
              <p><strong>Hello Chief</strong>. We just received a request from an account with email '$selector' to change their email. If this wasn't you, <strong>Do not reply to this email</strong>
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
          unset($_SESSION['w_email']);
          $_SESSION['newemail'] = $newemail;
          $_SESSION['curremail'] = $selector;
          $_SESSION['action'] = "updemail";
          header( "Refresh:1; url=../verifytoken.php", true, 303);
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
}

//Logic to update password
if(isset($_POST['updpass'])){
  $pass1 = check_string($connection, $_POST['currpass']);
  $pass2 = check_string($connection, $_POST['currpass1']);
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
  elseif (verifypass($connection, $selector, $pass2) == false) {
    $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
         Incorrect password entered!
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
  }
  else{
    $token = upd_token($connection, $selector);
    if ($token != false) {
      $mail->setFrom("support@bobblenote.com", "Bobblenote");
      $mail->addAddress($selector);
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
              <p><strong>Hello Chief</strong>. We just received a request from an account with email '$selector' to change their password. If this wasn't you, <strong>Do not reply to this email</strong>
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
          unset($_SESSION['w_email']);
          $_SESSION['curremail'] = $selector;
          $_SESSION['action'] = "updpass";
          header( "Refresh:1; url=../verifytoken.php", true, 303);
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
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/settings.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/slick-loader@1.1.20/slick-loader.min.css">
</head>
<body>
    <!-- my navigation bars start here -->
    <nav class="navbar navbar-expand-lg navbar-dark nav-one">
      <div class="container-fluid">
        <a class="navbar-brand ms-md-5 text-white" href="../index.php">Bobblenote</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav ms-auto" style="margin-right: 25px;">
              <li class="nav-item">
              <a class="nav-link text-white" href="settings.php"><img src="<?php echo "../".$profile_img."?randomurl= $rand" ?>" class="dp-img" alt=""> <?php echo $fullname ?></a>
              </li>
          </ul>
        </div>
      </div>
    </nav>
    <nav class="navbar navbar-light navbar-expand-lg bg-white">
        <div class="container-fluid">
          <div class="collapse navbar-collapse">
            <div class="navbar-nav ms-md-5">
              <a class="nav-link" href="home.php"><i class="fas fa-home"></i> Home</a>
              <a class="nav-link" href="mycompetitions.php"><i class="fas fa-trophy"></i> Competitions</a>
              <a class="nav-link" href="createpost.php"><i class="fas fa-pen-alt"></i> Create post</a>
              <a class="nav-link active" href="settings.php"><i class="fas fa-cog"></i> Settings</a>
            </div>
            <div class="navbar-nav ms-auto me-md-5">
                <a class="nav-link" href="logout.php"> <i class="fas fa-power-off"></i> Logout</a>
            </div>
          </div>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title mt-5" id="offcanvasNavbarLabel"><a class="text-dark text-decoration-none" href="settings.php"><img src="<?php echo "../".$profile_img."?randomurl= $rand" ?>" class="dp-img" alt=""> <?php echo $fullname ?></a></h5>
              <p type="button" data-bs-dismiss="offcanvas" aria-label="Close"><span class="nav-close">&times;</span></p>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link" href="home.php"> <i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="mycompetitions.php"><i class="fas fa-trophy"></i> Competitions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="createpost.php"><i class="fas fa-pen-alt"></i> Create post</a>
                  </li>
                <li class="nav-item">
                    <a class="nav-link active" href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fas fa-power-off"></i> Logout</a>
                  </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
      <!-- my navigation bars end here -->
      <div class="container mt-5">
          <div class="row justify-content-center">
              <div class="col-sm-8">
                <?php
                  if ($msg != "") {
                    echo $msg;
                  }
                ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="p-content">
                            <div class="p-img">
                                <img src="<?php echo "../".$profile_img."?randomurl= $rand" ?>" class="dp-img-lg" alt="">
                            </div>
                            <div class="p-details">
                                <h5><?php echo $fullname ?></h5>
                                <p><?php echo $details['bio'] ?></p>
                                <button class="btn btn-default" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-pen-square"></i> Edit profile</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <h5>Security settings <i class="fas fa-lock"></i></h5> -->
                <div class="card mt-3">
                  <div class="card-header bg-white">
                    <div class="card-title">
                      <h5>Security <i class="fas fa-lock"></i></h5>
                    </div>
                  </div>
                    <div class="card-body">
                        <!-- Tab links -->
                        <div class="tab">
                            <button class="tablinks active-tab" onclick="viewSetting(event, 'email')">Change email</button>
                            <button class="tablinks" onclick="viewSetting(event, 'password')">Change password</button>
                        </div>
                        
                        <!-- Tab content -->
                        <div id="email" class="tabcontent" style="display: block;">
                          <p class="mt-3">Note: Email will not be changed until you verify your new email address</p>
                          <form action="settings.php" method="POST" class="mt-3">
                            <div class="form-group">
                              <input name="newemail" type="text" class="form-control" placeholder="Enter new email">
                            </div>
                            <div class="form-group mt-3">
                              <button class="btn btn-default" name="upd_email">Update email</button>
                            </div>
                          </form>
                        </div>
                        
                        <div id="password" class="tabcontent">
                          <p class="mt-3">Note: Password will not be changed until it's been verified via email</p>
                          <form action="settings.php" method="POST" class="mt-3">
                            <div class="form-group">
                              <input type="password" name="currpass" class="form-control" placeholder="Current password">
                            </div>
                            <div class="form-group mt-3">
                              <input type="password" name="currpass1" class="form-control" placeholder="Confirm current password">
                            </div>
                            <div class="form-group mt-3">
                              <button class="btn btn-default" type="submit" name="updpass">Update password</button>
                            </div>
                          </form>
                        </div>
                
                    </div>
                </div>
                <div class="card mt-3">
                  <div class="card-header bg-white">
                    <div class="card-title">
                      <h5>Social media <i class="fas fa-hashtag"></i></h5>
                    </div>
                  </div>
                  <div class="card-body">
                  <p class="mt-3">Tip: Add links to your social media accounts so that your readers can follow your content.</p>
                          <form action="settings.php" method="POST" class="mt-3">
                            <div class="form-group">
                              <label for="">Twitter profile link</label>
                              <input name="twitter" type="text" value="<?php echo $details['twitter'] ?>" class="form-control" placeholder="Twitter">
                            </div>
                            <div class="form-group mt-3">
                            <label for="">Instagram profile link</label>
                              <input name="instagram" type="text" value="<?php echo $details['instagram'] ?>" class="form-control" placeholder="instagram">
                            </div>
                            <div class="form-group mt-3">
                            <label for="">Facebook profile link</label>
                              <input name="facebook" type="text" value="<?php echo $details['facebook'] ?>" class="form-control" placeholder="Facebook">
                            </div>
                            <div class="form-group mt-3">
                            <label for="">Linkedin profile link</label>
                              <input name="linkedin" type="text" value="<?php echo $details['linkedin'] ?>" class="form-control" placeholder="Linkedin">
                            </div>
                            <div class="form-group mt-3">
                              <button name="upd_social" class="btn btn-default">Update social links</button>
                            </div>
                          </form>
                  </div>
                </div>
                <div class="card mt-3">
                  <div class="card-header bg-white">
                    <div class="card-title">
                      <h5>Danger zone <i class="fas fa-skull"></i></h5>
                    </div>
                  </div>
                  <div class="card-body">
                    <h6 class="text-dark">Delete Account</h6>
                    <p>Warning! Deleting your account will prevent you from having access to our sweet features!</p>
                    <div class="del-acct">
                      <button id="delacct" class="btn btn-outline-danger">Delete account <i class="fas fa-skull"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
              <div class="card">
                <div class="card-header text-center bg-white p-3">
                   <h5 class="card-title m-0 text-dark">Start a competition 🏆!</h5>
                </div>
                <div class="card-body">
                  <p class="text-center text-dark">Host article/essay writing competitions on our platform easily and seamlessly !</p>
                  <a style="width: 100%;" href="writerdashboard/mycompetitions.php" target="_blank" class="btn btn-dark">Start a competition</a>
                </div>
              </div>
                <div class="card mt-3">
                  <div class="card-header text-center bg-white">
                  <a href="https://www.crowndidactic.com" target="_blank">
                  <img src="../images/crownEdLogo.png" style="object-fit: cover;" width="80%" alt="">
                  </a>
                  </div>
                  <div class="card-body">
                  <p class="text-center">Advertise your school with crowndidactic. Sign up! for <strong>free</strong> and enjoy our sweet features.</p>
                  <a style="width: 100%;" href="https://www.crowndidactic.com/register" target="_blank" class="btn btn-default">Sign up</a>  
                </div>
              </div>
              </div>
          </div>
      </div>
      <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-pen-square"></i> Edit profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">
            <form action="settings.php" method="POST" enctype="multipart/form-data">
              <div class="img-div mt-1 mb-3" style="display: flex; justify-content: center;">
                <div class="img-cover">
                  <img id="img-prev" src="<?php echo "../".$profile_img ?>?randomurl=<?php $rand ?>" class="dp-img-lg" alt="">
                  <div class='overlay' onclick="open_file()">
                    <p class="p-camera"><i class="fas fa-camera ic-camera"></i></p>
                    <input type="file" hidden id="input_file" name="dp-img" accept="image/*">
                  </div>
                </div>
              </div>
              <h6 class="mb-2">General information</h6>
              <div class="row g-2">
                <div class="col">
                  <label for="">First Name</label>
                  <input name="fname" type="text" class="form-control" value="<?php echo $details['firstname'] ?>" placeholder="First name">
                </div>
                <div class="col">
                  <label for="">Last Name</label>
                  <input name="lname" type="text" value="<?php echo $details['lastname'] ?>" class="form-control" placeholder="Last name">
                </div>
              </div>
                <div class="row mt-1 g-2">
                  <div class="col">
                    <label for="">Mobile</label>
                    <input name="mobile" type="tel" value="<?php echo $details['mobile'] ?>" class="form-control" placeholder="Phone number">
                  </div>
                  <div class="col">
                    <label for="">Date of birth</label>
                    <input name="dob" type="text" value="<?php echo $details['dob'] ?>" class="form-control" placeholder="Date of birth" aria-label="Date of birth" onfocus="this.type='date'" onfocusout="this.type='text'">
                  </div>
                </div>
                <div class="form-group mt-3">
                  <label for="">Bio</label>
                  <textarea name="bio" id="bios" cols="30" rows="5" class="form-control" placeholder="Edit bio"><?php echo $details['bio'] ?></textarea>
                </div>
                <button name="save" type="submit" class="btn btn-default mt-2">Save changes</button>
                </form>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
               </div>
      </div>
    </div>
  </div>
  <?php include '../footer.php' ?>
        <!-- javascripts  -->
        <script src="../js/jquery.min.js"></script>
        <script src="https://cdn.tiny.cloud/1/0h01t537dv5w80phd2kb1873sfhpg9mg6ek7ckr1aly3myzy/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/slick-loader@1.1.20/slick-loader.min.js"></script>
        <script src="js/general.js"></script>
    <script>

$(document).ready(function(){
            $("#delacct").click(function(e){
              e.preventDefault()
                Swal.fire({
                  title: 'Are you sure?',
                  icon: 'warning',
                  html: `<small>Deleting your account will remove all your personal data and this action is irreversible.</small><input type="password" id="password" class="swal2-input mb-1" placeholder="Enter password...">`,
                  confirmButtonText: 'Verify password',
                  focusConfirm: false,
                  preConfirm: () => {
                    const password = Swal.getPopup().querySelector('#password').value
                    if (!password) {
                      Swal.showValidationMessage(`Please enter password`)
                    }
                    return {password: password}
                  }
                }).then((result) => {
                  if (result.isConfirmed) {
                    SlickLoader.enable();
                    SlickLoader.setText("Please wait...");
                    password = result.value.password
                    $.ajax({
                      type: 'POST',
                      url: 'delacct.php',
                      data: {password: password}
                    }).done(function(msg){
                        if (msg == "success") {
                          SlickLoader.disable()
                          Swal.fire({
                          title: 'Success!',
                          text: "Account deleted successfully!",
                          icon: 'success',
                          showCancelButton: false
                          }).then((result) => {
                            if (result.isConfirmed) {
                              location.reload()
                            }
                          })
                        }
                        else{
                          SlickLoader.disable()
                          Swal.fire(
                          'Error!',
                          msg,
                          'error'
                          )
                        }
                        }).fail(function(){
                          SlickLoader.disable()
                          Swal.fire(
                            'Error!',
                            'Error in connection',
                            'error'
                          )
                      })
                  } 
                  else{
                    SlickLoader.disable()
                  }                  
                });
            })
          })

        //function to open file on overlay click
        function open_file(){
          document.getElementById('input_file').click();
        }

        //code to select and preview image
        const imgselector = document.querySelector("#input_file")
        const imgpreview = document.querySelector("#img-prev")

        imgselector.addEventListener('change', function(){
            getImgData()
        })

        function getImgData() {
            const files = imgselector.files[0];
            if (files) {
                const fileReader = new FileReader();
                fileReader.readAsDataURL(files);
                fileReader.addEventListener("load",  function () {
                    imgpreview.setAttribute('src', this.result)
                });    
            }
        }

        //code to initialize tinymce editor
        tinymce.init({
          selector: 'textarea#bios',
          height: 170,
          plugins: [
            'emoticons paste'
            ],
            toolbar: 'insertfile undo redo | bold italic | fullpage | emoticons',
            menubar: ''
       });
    </script>
</body>
</html>