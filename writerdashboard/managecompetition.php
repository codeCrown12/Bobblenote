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
    <title>Manage competition</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/general.css">
    <style>
      small{
        font-size: 12px;
      }
      table{
          font-size: 13px;
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
              <h5 class="offcanvas-title mt-5" id="offcanvasNavbarLabel"><a class="text-dark text-decoration-none" href="settings.php"><img src="<?php echo "../".$profile_img."?randomurl= $rand" ?>" class="dp-img" alt=""> <?php echo $fullname ?></a></h5>
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
          <div class="row">
              <div class="col-md-7">
                  <!-- <h4 class="">Penactive Competition</h4> -->
                  <div class="card mt-5">
                    <div class="card-header p-3 bg-white">
                        <h5 class="m-0">Participants</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        for ($i=0; $i < 10; $i++) {
                                            ?>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td><small style="color: #06ad03;"><i class="fas fa-check-double"></i> Confirmed</small></td>
                                        <td><a href="#" class="btn btn-sm btn-danger" title="Disqualify"><i class="fas fa-trash-alt"></i></a></td>
                                        <td><a href="#" class="btn btn-sm btn-success" title="send email"><i class="far fa-envelope"></i></a></td>
                                    </tr>
                                        <?php
                                        } ?>
                                </tbody>
                            </table>
                        </div>
                        </div>  
                        <div class="card-footer bg-white">
                            <a href="#" class="btn btn-success">Email all confirmed</a>
                            <a href="#" class="btn btn-primary">Email all pending</a>
                            <a href="#" class="btn btn-default">See winners</a>
                        </div>
                  </div>
              </div>
              <div class="col-md-5">
                  <div class="card mt-5">
                      <div class="card-header p-3 bg-white d-flex align-items-center">
                          <h5 class="card-title m-0">Details</h5>
                          <button class="btn btn-default ms-auto" data-bs-toggle="modal" data-bs-target="#details">Edit Details</button>
                      </div>
                    <div class="card-body">
                        <div class="name">
                            <h6>Competition Name</h6>
                            <p class="text-dark">
                                Penactive Competition
                            </p>
                        </div>
                    <div class="description">
                                <h6>Description</h6>
                                <p>Lorem sicing elit. Excepturi fuga libero eaque voluptas reprehenderit non repellendus deleniti ipsa asperiores quos nisi, placeat blanditiis explicabo cumque? Autem in eveniet neque enim.</p>
                            </div>
                            <div class="requirements">
                                <h6>Requirements</h6>
                                <ul>
                                    <li>Must be at least 18 years of age</li>
                                    <li>Only one article per applicant is allowed</li>
                                    <li>Lorem ipsum dolor sit amet consectetur ad</li>
                                </ul>
                            </div>
                            <div class="rules">
                            <h6>Rules</h6>
                                <ul>
                                    <li>Must be at least 18 years of age</li>
                                    <li>Only one article per applicant is allowed</li>
                                    <li>Lorem ipsum dolor sit amet consectetur ad</li>
                                </ul>
                            </div>
                            <div class="awards">
                                <h6>Awards</h6>
                                <ul>
                                    <li>Position 1 prize: $200,000</li>
                                    <li>Position 2 prize: $150,000</li>
                                    <li>Position 3 prize: $100,000</li>
                                    <li>Position 4 prize: $95,000</li>
                                    <li>Position 5 prize: $90,000</li>
                                </ul>
                            </div>
                            <div class="duration">
                                <h6>Duration</h6>
                                <p>Sep 26 2021 - February 26 2022</p>
                            </div>
                            <div class="tage">
                                <h6>Tag</h6>
                                <p><span style="font-weight: bold;"><a href="#">#penactive</a></span></p>
                            </div>
                    </div>
                  </div>
              </div>
              <!-- Scrollable modal -->
              <div class="modal fade" id="details" tabindex="-1" aria-labelledby="detailsLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      ...
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </div>
    <?php include '../footer.php' ?>
      
    <script src="../js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
</body>
</html>