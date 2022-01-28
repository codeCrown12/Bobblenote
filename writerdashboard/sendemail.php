<?php
session_start();
include '../functions.php';
include '../connection.php';

$selector = "";
if ($_SESSION['w_email'] == "") {
  header("Location: ../login.php");
}
else{
  $selector = $_SESSION['w_email'];
}

//snippet to get details
$details = get_writer_details($connection, $selector);
$fullname = $details['firstname']. " ". $details['lastname'];
$profile_img = $details['profilepic'];
$msg = "";
$rand = rand();
include '../compdefaulterscheck.php';

//get participant email(s)
if (isset($_GET['rec'])) {
    $rec_email = $_GET['rec'];
}

if (isset($_GET['comp_ID'])) {
    $compid = $_GET['comp_ID'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send email</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/slick-loader@1.1.20/slick-loader.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
    <link rel="stylesheet" href="css/general.css">
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
              <a class="nav-link text-white" href="settings.php"><img src="<?php echo "../".$profile_img."?randomurl= $rand" ?>" class="dp-img" alt=""> <?php
                if ($details['account_type'] == "individual") {
                  echo $fullname;
                }
                else echo $details['organization_name'];
                ?></a>
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
              <a class="nav-link active" href="mycompetitions.php"><i class="fas fa-trophy"></i> Competitions</a>
              <a class="nav-link" href="createpost.php"><i class="fas fa-pen-alt"></i> Create post</a>
              <a class="nav-link" href="settings.php"><i class="fas fa-cog"></i> Settings</a>
            </div>
            <div class="navbar-nav ms-auto me-md-5">
                <a class="nav-link" href="logout.php"> <i class="fas fa-power-off"></i> Logout</a>
            </div>
          </div>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title mt-5" id="offcanvasNavbarLabel"><a class="text-dark text-decoration-none" href="settings.php"><img src="<?php echo "../".$profile_img."?randomurl= $rand" ?>" class="dp-img" alt=""> <?php
                if ($details['account_type'] == "individual") {
                  echo $fullname;
                }
                else echo $details['organization_name'];
                ?></a></h5>
              <p type="button" data-bs-dismiss="offcanvas" aria-label="Close"><span class="nav-close">&times;</span></p>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link" href="home.php"> <i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="mycompetitions.php"><i class="fas fa-trophy"></i> Competitions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="createpost.php"><i class="fas fa-pen-alt"></i> Create post</a>
                  </li>
                <li class="nav-item">
                    <a class="nav-link" href="settings.php"><i class="fas fa-cog"></i> Settings</a>
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
      <div class="container">
          <div class="row mt-5 justify-content-center">
              <div class="col-sm-6">
                  <div class="card">
                      <!-- <div class="card-header bg-white">
                        <h5 class="m-0 card-title">Send Email</h5>
                      </div> -->
                      <div class="card-body">
                          <div class="d-flex justify-content-center m-0">
                              <img src="images/Sending emails_Flatline.svg" width="200px" alt="">
                          </div>
                          <h5 class="text-center">Compose Message</h5>
                          <form action="">
                              <input type="hidden" id="compid" value="<?php echo $compid ?>">
                              <div class="form-group mt-3">
                                  <label for="">Recipient</label>
                                  <input value="<?php echo $rec_email ?>" id="rec" readonly type="text" class="form-control mt-1" placeholder="e.g username@example.com">
                              </div>
                              <div class="form-group mt-3">
                                  <label for="">Title/Subject</label>
                                  <input id="sub" type="text" class="form-control mt-1" placeholder="e.g Introduction to test competition">
                              </div>
                              <div class="form-group mt-3">
                                  <label for="" class="mb-1">Message body</label>
                                  <textarea name="" id="body" cols="30" rows="10" placeholder="Message body goes here..." class="form-control"></textarea>
                              </div>
                              <button id="send" class="mt-2 btn btn-success w-100">Send Message <i class="fas fa-paper-plane"></i></button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    <?php include '../footer.php' ?>
      <!-- javascripts  -->
      <script src="../js/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
      <script src="https://cdn.tiny.cloud/1/0h01t537dv5w80phd2kb1873sfhpg9mg6ek7ckr1aly3myzy/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
      <script src="https://unpkg.com/slick-loader@1.1.20/slick-loader.min.js"></script>
      <script>
          tinymce.init({
          selector: 'textarea#body',
          height: 250,
          plugins: [
            'emoticons paste lists'
            ],
            toolbar: 'insertfile undo redo | bold italic | fullpage | bullist | emoticons',
            menubar: ''
       });
       $(document).ready(function(){
           $("#send").click(function(e){
               e.preventDefault();
               SlickLoader.enable();
               SlickLoader.setText("Please wait...");
               tinyMCE.triggerSave();
               var rec = $("#rec").val();
               var sub = $("#sub").val();
               var body = $("#body").val();
               var compid = $("#compid").val();
               $.ajax({
                    type: "post",
                    url: "managepart.php",
                    data: {send: 'send', rec: rec, sub: sub, body: body, comp_ID: compid}
                  }).done(function(msg){
                    SlickLoader.disable();
                    if (msg == "success") {
                        Swal.fire({
                            title: 'Success!',
                            text: "Message sent successfully!",
                            icon: 'success',
                            showCancelButton: false
                            }).then((result) => {
                            if (result.isConfirmed) {
                                location.replace('managecompetition.php?comp_ID='+compid)
                            }
                        })
                    }
                    else{
                        Swal.fire(
                        'Error',
                        msg,
                        'error'
                        )
                    }
                  }).fail(function(msg){
                      console.log(msg)
                  })
           })
       })
      </script>
    </body>
</html>