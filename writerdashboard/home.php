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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/home.css">
    <style>
      .error-container{
          display: flex;
          justify-content: center;
      }
    </style>
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
              <a class="nav-link active" href="home.php"><i class="fas fa-home"></i> Home</a>
              <a class="nav-link" href="mycompetitions.php"><i class="fas fa-trophy"></i> Competitions</a>
              <a class="nav-link" href="createpost.php"><i class="fas fa-pen-alt"></i> Create post</a>
              <a class="nav-link" href="settings.php"><i class="fas fa-cog"></i> Settings</a>
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
                  <a class="nav-link active" href="home.php"> <i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="mycompetitions.php"><i class="fas fa-trophy"></i> Competitions</a>
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
      <div class="container mt-5">
          <div class="row">
            <div class="col-sm-8">
                <h5 style="color: #203656;"><i class="fas fa-th-large"></i> Overview</h5>
                <div class="row mt-4">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-content">
                              <div class="stat-icon">
                                <lord-icon
                                src="https://cdn.lordicon.com/wxnxiano.json"
                                trigger="loop"
                                colors="primary:#335fbe,secondary:#335fbe"
                                style="width:70px;height:70px">
                            </lord-icon>
                              </div>
                              <div class="stat">
                                  <h4>
                                    <?php
                                      echo numFormatter(count_published($connection, $selector)); 
                                   ?>
                                   </h4>
                                  <p class="stat-title">Articles</p>
                              </div>
                            </div>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="card">
                            <div class="card-content">
                              <div class="stat-icon">
                                <lord-icon
                                src="https://cdn.lordicon.com/kbtmbyzy.json"
                                trigger="loop"
                                colors="primary:#335fbe,secondary:#335fbe"
                                style="width:70px;height:70px">
                            </lord-icon>
                              </div>
                              <div class="stat">
                                  <h4><?php
                                      echo numFormatter(count_pending($connection, $selector)); 
                                   ?></h4>
                                  <p class="stat-title">Drafts</p>
                              </div>
                            </div>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="card">
                            <div class="card-content">
                              <div class="stat-icon">
                                <lord-icon
                                src="https://cdn.lordicon.com/vixtkkbk.json"
                                trigger="loop"
                                colors="primary:#335fbe,secondary:#335fbe"
                                style="width:70px;height:70px">
                            </lord-icon>
                            </lord-icon>
                              </div>
                              <div class="stat">
                                  <h4><?php
                                      echo numFormatter(count_photos($connection, $selector)); 
                                   ?></h4>
                                  <p class="stat-title">Photos</p>
                              </div>
                            </div>
                        </div>
                      </div>
                </div>
                <h5 class="mt-5 mb-4" style="color: #203656;"><i class="fas fa-clock"></i> Drafts</h5>
                <?php
                    $pen_query = "SELECT P_ID, title, excerpt FROM posts WHERE W_email = '$selector' AND published = 'no'";
                    $pen_result = $connection->query($pen_query);
                    if (!$pen_result) {
                      $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
                      Error in connection!
                      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                    }
                    else{
                      $pen_rows = $pen_result->num_rows;
                      if ($pen_rows >= 1) {
                        for ($i=0; $i < $pen_rows; $i++) { 
                          $pen_result->data_seek($i);
                          $pen_data = $pen_result->fetch_array(MYSQLI_ASSOC);
                          echo "<div class='card mt-3'>
                          <div class='card-body'>
                              <h5>$pen_data[title]</h5>
                              <p>$pen_data[excerpt]...</p>
                              <div class='post-stat'>
                                  <div class=''><p class='stat-item'><a href='editpost.php?pid=$pen_data[P_ID]' class='btn btn-default'>Edit Post <i class='fas fa-pen-square'></i></a></p></div>
                              </div>
                          </div>
                      </div>"; 
                        }
                      }
                      else{
                        echo "
                        <div class='card'>
                          <div class='card-body'>
                          <div class='error-container'>
                          <div class='text-center'>
                          <h6 style='color: #203656;' class='m-0'>No posts drafts here <i class='far fa-meh-blank'></i></h6>
                          </div> 
                        </div>
                          </div>
                        </div>
                        ";
                      }
                    }
                  ?>
                <h5 class="mt-5 mb-4" style="color: #203656;"><i class="fas fa-book"></i> Articles</h5>
                  <?php
                    $pub_query = "SELECT P_ID, title, excerpt, date_created, no_of_likes, no_of_comments FROM posts WHERE W_email = '$selector' AND published = 'yes' ORDER BY P_ID DESC";
                    $pub_result = $connection->query($pub_query);
                    if (!$pub_result) {
                      $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
                      Error in connection!
                      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                    }
                    else{
                      $pub_rows = $pub_result->num_rows;
                      if ($pub_rows >= 1) {
                        for ($i=0; $i < $pub_rows; $i++) { 
                          $pub_result->data_seek($i);
                          $pub_data = $pub_result->fetch_array(MYSQLI_ASSOC);
                          $encpid = base64_encode($pub_data['P_ID']);
                          $date = format_date($pub_data['date_created']);
                          echo "<div class='card mt-3'>
                          <div class='card-body'>
                          <div class='d-flex'><h5>$pub_data[title]</h5> <p style='margin-left:auto;'>$date</p></div>
                              <p>$pub_data[excerpt]...</p>
                              <div class='post-stat'>
                                  <div class='stat-one'>
                                  <p class='stat-item'><i class='fas fa-thumbs-up'></i> $pub_data[no_of_likes] Like(s)</p>
                                  <p class='stat-item'><i class='fas fa-comments'></i> $pub_data[no_of_comments] Comment(s)</p>
                                  </div>
                                  <div class='stat-two'><p class='stat-item'><a href='../viewpost.php?pid=$encpid' target='_blank' class='btn btn-default'>View Post <i class='fas fa-eye'></i></a></p></div>
                              </div>
                          </div>
                      </div>"; 
                        }
                      }
                      else{
                        echo "
                        <div class='card'>
                          <div class='card-body'>
                          <div class='error-container'>
                          <div class='text-center'>
                          <lord-icon
                            src='https://cdn.lordicon.com/tdrtiskw.json'
                            trigger='loop'
                            colors='primary:#335fbe,secondary:#335fbe'
                            style='width:100px;height:100px'>
                          </lord-icon>
                          <h6 style='color: #203656;'>No posts here</h6>
                          <a href='createpost.php' class='btn btn-default mb-3'>Create Post <i class='fas fa-pen-square'></i></a>
                          </div> 
                        </div>
                          </div>
                        </div>
                        ";
                      }
                    }
                  ?>
              </div>
              <div class="col-sm-4">
              <div class="card mt-5">
                <div class="card-header text-center bg-white p-3">
                   <h5 class="card-title m-0 text-dark">Start a competition 🏆!</h5>
                </div>
                <div class="card-body">
                  <p class="text-center">Host article/essay writing competitions on our platform easily and seamlessly !</p>
                  <a style="width: 100%;" href="mycompetitions.php" target="_blank" class="btn btn-dark">Start a competition</a>
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
      <?php include '../footer.php' ?>
      <!-- javascripts  -->
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
</body>
</html>