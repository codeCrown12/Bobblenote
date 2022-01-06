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

if (isset($_GET['comp_id'])) {
    $comp_id = $_GET['comp_id'];
}

//snippet to get details
$details = get_writer_details($connection, $selector);
$fullname = $details['firstname']. " ". $details['lastname'];
$profile_img = $details['profilepic'];
$msg = "";
$rand = rand();
include '../compdefaulterscheck.php';

//Get competition details
$comp_data = get_comp($connection, $comp_id);

if (isset($_POST['update'])) {
    $start_date = check_string($connection, $_POST['start_date']);
    $end_date = check_string($connection, $_POST['end_date']);
    $tag = check_string($connection, $_POST['tag']);

    if ($start_date == "" || $end_date == "" || $tag == "") {
        $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            All fields are required!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    elseif (tag_exists($connection, $tag) && $tag != $comp_data['tag']) {
        $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        Tag already used! please use another tag
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    elseif (strtotime($start_date) < strtotime(date('m/d/Y'))) {
        $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        Start date must be greater than or equal to today's date!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    elseif (strtotime($end_date) <= strtotime($start_date)) {
        $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        End date must be greater than start date!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    else{
        $query = "UPDATE competitions SET start_date = ?, end_date = ?, tag = ? WHERE comp_ID = $comp_id";
        $result = $connection->prepare($query);
        $result->bind_param("sss", $start_date, $end_date, $tag);
        if ($result->execute()) {
            if(dump_exp_part($connection, $comp_data['comp_ID'])){
                empty_exp_part($connection, $comp_data['comp_ID']);
                header("Location: payment.php?comp_id=$comp_id");
            }
        }
        else{
            $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
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
    <title>Change details</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card rounded-0 mt-4">
              <div class="card-header bg-white p-3">
                <h5 class="card-title m-0"><i class="fas fa-pen-alt"></i> Change Details</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12">
                      <form action="renewcomp.php?comp_id=<?php echo $comp_id?>" method="POST">
                        <?php
                          if ($msg != "") {
                            echo $msg;
                          }
                        ?>
                          <p style="font-size: 14px;"><strong>Note:</strong> Provide details below in order to renew expired competition <a href="#">Learn more</a></p>
                          <div class="mb-3">
                            <div class="row">
                              <div class="col-sm-6">
                                <label for="" class="mb-2">Start Date</label>
                                <input value="<?php echo $comp_data['start_date'] ?>" type="date" name="start_date" class="form-control">
                              </div>
                              <div class="col-sm-6">
                                <label for="" class="mb-2">End Date</label>
                                <input value="<?php echo $comp_data['end_date'] ?>" type="date" name="end_date" class="form-control">
                              </div>
                            </div>
                          </div>
                          <div class="mb-3">
                              <label>Tag</label>
                              <input value="<?php echo $comp_data['tag'] ?>" type="text" name="tag" class="form-control" placeholder="e.g bobblenote">
                          </div>
                          <div class="d-flex"><button class="btn btn-success" type="submit" name="update">Save & Continue <i class="fas fa-check-double"></i></button></div>
                        </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- my navigation bars end here -->
      <?php include '../footer.php' ?>
      
      <script src="../js/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
</body>
</html>