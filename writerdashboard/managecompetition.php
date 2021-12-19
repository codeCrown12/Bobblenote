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
include '../compdefaulterscheck.php';
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
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
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
      <div class="container mt-5">
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-warning" role="alert">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
              </svg>
                <strong>Notice!</strong> This competition has expired/concluded and can no longer be seen by prospective participants. Please <a href="#" class="text-decoration-underline">Renew!</a>
              </div>
            </div>
          </div>
          <div class="row">
              <div class="col-md-7">
                  <!-- <h4 class="">Penactive Competition</h4> -->
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="card">
                      <div class="card-body d-flex align-items-center">
                          <div>
                            <h4>175</h4>
                            <p class="mb-0">Verified</p>
                          </div>
                          <div class="ms-auto" style="width: fit-content;">
                            <lord-icon
                                src="https://cdn.lordicon.com/imamsnbq.json"
                                trigger="loop"
                                colors="primary:#335fbe,secondary:#335fbe"
                                style="width:60px;height:60px">
                            </lord-icon>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                          <div>
                            <h4>55</h4>
                            <p class="mb-0">Pending</p>
                          </div>
                          <div class="ms-auto" style="width: fit-content;">
                            <lord-icon
                                src="https://cdn.lordicon.com/kbtmbyzy.json"
                                trigger="loop"
                                colors="primary:#335fbe,secondary:#335fbe"
                                style="width:60px;height:60px">
                            </lord-icon>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                          <div>
                            <h4>15</h4>
                            <p class="mb-0">Disqualified</p>
                          </div>
                          <div class="ms-auto" style="width: fit-content;">
                            <lord-icon
                                src="https://cdn.lordicon.com/gsqxdxog.json"
                                trigger="loop"
                                colors="primary:#335fbe,secondary:#335fbe"
                                style="width:60px;height:60px">
                            </lord-icon>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card mt-3">
                    <div class="card-header p-3 bg-white">
                        <h5 class="m-0">Participants</h5>
                    </div>
                    <div class="card-body">
                      <!-- Tab links -->
                        <div class="tab mb-4">
                            <button class="tablinks active-tab" onclick="viewSetting(event, 'pending')">Pending <i class="far fa-clock"></i></button>
                            <button class="tablinks" onclick="viewSetting(event, 'accepted')">Verified <i class="fas fa-check-double"></i></button>
                            <button class="tablinks" onclick="viewSetting(event, 'disqualified')">Disqualified <i class="fas fa-trash-alt"></i></button>
                            <button class="tablinks" onclick="viewSetting(event, 'leaderboard')">LeaderBoard <i class="fas fa-trophy"></i></button>
                        </div>
                        <div id="accepted" class="tabcontent">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Join date</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        for ($i=0; $i < 10; $i++) {
                                            ?>
                                    <tr>
                                        <td>King</td>
                                        <td>Jacob</td>
                                        <td>kingsjacobfrancis@gmail.com</td>
                                        <td>2011-04-25</td>
                                        <td><a href="#" class="btn btn-sm btn-danger" title="Disqualify"><i class="fas fa-trash-alt"></i></a></td>
                                        <td><a href="#" class="btn btn-sm btn-success" title="send email"><i class="far fa-envelope"></i></a></td>
                                    </tr>
                                        <?php
                                        } ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                        <div id="disqualified" class="tabcontent">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example2">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Join date</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        for ($i=0; $i < 10; $i++) {
                                            ?>
                                    <tr>
                                        <td>King</td>
                                        <td>Jacob</td>
                                        <td>kingsjacobfrancis@gmail.com</td>
                                        <td>2011-04-25</td>
                                        <td><a href="#" class="btn btn-sm btn-default" title="Accept"><i class="fas fa-trash-restore-alt"></i></a></td>
                                        <td><a href="#" class="btn btn-sm btn-success" title="send email"><i class="far fa-envelope"></i></a></td>
                                    </tr>
                                        <?php
                                        } ?>
                                </tbody>
                            </table>
                        </div>
                        </div>      
                        <div id="pending" class="tabcontent" style="display: block;">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example1">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <!-- <th>Join date</th> -->
                                        <th></th>
                                        <!-- <th></th> -->
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        for ($i=0; $i < 10; $i++) {
                                            ?>
                                    <tr>
                                        <td>King</td>
                                        <td>Jacob</td>
                                        <td>kingsjacobfrancis@gmail.com</td>
                                        <!-- <td>2011-04-25</td> -->
                                        <td><a href="#" class="btn btn-sm btn-default" title="Confirm">verify</a></td>
                                        <!-- <td><a href="#" class="btn btn-sm btn-danger" title="Disqualify"><i class="fas fa-trash-alt"></i></a></td> -->
                                        <td><a href="#" class="btn btn-sm btn-success" title="send email"><i class="far fa-envelope"></i></a></td>
                                    </tr>
                                        <?php
                                        } ?>
                                </tbody>
                            </table>
                        </div>
                        </div>   

                        <div id="leaderboard" class="tabcontent">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example3">
                                <thead>
                                    <tr>
                                        <th>NB</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Votes</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        for ($i=0; $i < 10; $i++) {
                                            ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td>King</td>
                                        <td>Jacob</td>
                                        <td>kingsjacobfrancis@gmail.com</td>
                                        <td>100</td>
                                        <td><a href="#" title="View post">View article</a></td>
                                    </tr>
                                        <?php
                                        } ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                        </div>  
                        <div class="card-footer bg-white">
                            <a href="#" class="btn btn-success" title="Email all verified"><i class="far fa-envelope"></i> Verified</a>
                            <a href="#" class="btn btn-warning" title="Email all pending"><i class="far fa-envelope"></i> Pending</a>
                            <a href="#" class="btn btn-default">Verify all</a>
                            <a href="#" class="btn btn-success disabled">Request payout <i class="fas fa-paper-plane"></i></a>
                        </div>
                  </div>
              </div>
              <div class="col-md-5">
                  <div class="card" style="font-size: 14px;">
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
                        <div class="amount">
                          <h6>Total Deposit</h6>
                          <p>₦ 50000</p>
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
                      <h5 class="modal-title" id="exampleModalLabel">Edit Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action="">
                        <div class="mb-3">
                          <label for="" class="mb-2">Competition Name</label>
                          <input type="text" class="form-control" placeholder="e.g Penactive competition">
                        </div>
                        <div class="mb-3">
                          <label for="" class="mb-2">Description</label>
                          <textarea name="" id="desc" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                          <label for="" class="mb-2">Requirements<br><small>(Should be in a list format)</small></label>
                          <textarea name="" id="req" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                          <label for="" class="mb-2">Rules<br><small>(Should be in a list format)</small></label>
                          <textarea name="" id="rules" class="form-control"></textarea>
                        </div>
                        <button class="btn btn-default">Save changes</button>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    <script src="https://cdn.tiny.cloud/1/0h01t537dv5w80phd2kb1873sfhpg9mg6ek7ckr1aly3myzy/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="js/general.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example1').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
        } );
        tinymce.init({
          selector: 'textarea#desc',
          height: 170,
          plugins: [
            'emoticons paste'
            ],
            toolbar: 'insertfile undo redo | bold italic | fullpage | emoticons',
            menubar: ''
       });
       tinymce.init({
          selector: 'textarea#req',
          height: 170,
          plugins: [
            'emoticons paste lists'
            ],
            toolbar: 'insertfile undo redo | bold italic | fullpage | bullist | emoticons',
            menubar: ''
       });
       tinymce.init({
          selector: 'textarea#rules',
          height: 170,
          plugins: [
            'emoticons paste lists'
            ],
            toolbar: 'insertfile undo redo | bold italic | fullpage | bullist | emoticons',
            menubar: ''
       });
    </script>
</body>
</html>