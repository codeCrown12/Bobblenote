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

if (isset($_GET['comp_ID'])) {
  $compid = $_GET['comp_ID'];
}
//Get competition details
$comp_data = get_comp($connection, $compid);

//Snippet to edit competition details
$msg = "";
if (isset($_POST['save'])) {
  $name = check_string($connection, $_POST['name']);
  $desc = $_POST['desc'];
  $rules = $_POST['rules'];
  $req = $_POST['req'];

  if ($name == "" || $desc == "" || $rules == "" || $req == "") {
    $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    All fields are required!
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  else{
    $query = "UPDATE competitions SET name = ?, comp_description = ?, requirements = ?, rules = ? WHERE comp_ID = ?";
    $result = $connection->prepare($query);
    $result->bind_param("ssssi", $name, $desc, $req, $rules, $compid);
    if ($result->execute()) {
      $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      Details updated successfully!
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
      header("Refresh: 1");
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
    <title>Manage competition</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/slick-loader@1.1.20/slick-loader.min.css">
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
        <!-- Expired competition notice -->
        <?php
          if ($comp_data['comp_status'] == "expired") {
        ?>
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
          <?php
            }
            //Dispqlay error messages
            if ($msg != "") {
              echo $msg;
            }
          ?>
          <div class="row">
              <div class="col-md-7">
                  <!-- <h4 class="">Penactive Competition</h4> -->
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="card">
                      <div class="card-body d-flex align-items-center">
                          <div>
                            <h4><?php echo numFormatter(count_part($connection, $compid, "verified")); ?></h4>
                            <p class="mb-0">Verified</p>
                          </div>
                          <div class="ms-auto" style="width: fit-content;">
                            <lord-icon
                                src="https://cdn.lordicon.com/uuxlmlza.json"
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
                          <h4><?php echo numFormatter(count_part($connection, $compid, "pending")); ?></h4>
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
                          <h4><?php echo numFormatter(count_part($connection, $compid, "disqualified")); ?></h4>
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
                      <h6 class="card-title m-0"><i class="fas fa-stream"></i> All Activity</h6>
                    </div>
                    <div class="card-body">
                      <!-- Tab links -->
                        <div class="tab mb-4">
                            <button class="tablinks active-tab" onclick="viewSetting(event, 'pending')">Pending <i class="far fa-clock"></i></button>
                            <button class="tablinks" onclick="viewSetting(event, 'accepted')">Verified <i class="fas fa-check-double"></i></button>
                            <button class="tablinks" onclick="viewSetting(event, 'disqualified')">Disqualified <i class="fas fa-trash-alt"></i></button>
                            <button class="tablinks" onclick="viewSetting(event, 'leaderboard')">LeaderBoard <i class="fas fa-trophy"></i></button>
                        </div>

                        <!-- Verified participants tab-->
                        <div id="accepted" class="tabcontent">
                          <?php
                              //Snippet to select all verified participants
                              $v_query = "SELECT part_ID, u_email, date_joined FROM participants WHERE comp_ID = $compid AND part_status = 'verified'";
                              $v_result = $connection->query($v_query);
                              if ($v_result) {
                                $v_rows = $v_result->num_rows;
                                if ($v_rows >= 1) {
                          ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Date</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    for ($i=0; $i < $v_rows; $i++) {
                                        $v_result->data_seek($i);
                                        $v_data = $v_result->fetch_array(MYSQLI_ASSOC); 
                                        //Full details of the participant
                                        $u_details = get_writer_details($connection, $v_data['u_email']);
                                  ?>
                                    <tr>
                                        <td><?php echo $u_details['firstname']." ".$u_details['lastname'] ?></td>
                                        <td><?php echo $v_data['u_email'] ?></td>
                                        <td><?php echo $v_data['date_joined'] ?></td>
                                        <td><a href="javascript:void(0)" data-id="<?php echo $v_data['part_ID'] ?>" class="btn btn-sm btn-danger disq" title="Disqualify"><i class="fas fa-trash-alt"></i></a></td>
                                        <td><a href="sendemail.php?rec=<?php echo $v_data['u_email'] ?>&comp_ID=<?php echo $compid ?>" class="btn btn-sm btn-success" title="send email"><i class="far fa-envelope"></i></a></td>
                                    </tr>
                                  <?php
                                    }
                                  ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                          }
                          else{
                        ?>
                        <div class="d-flex justify-content-center mb-5 mt-3">
                          <div>
                            <img src="images/Waiting_Outline.svg" alt="" width="200px">
                            <p class="text-center m-0" style="font-size: 16px;">No verified participants</p>
                            <div class="d-flex justify-content-center"><button class="btn btn-sm btn-default mt-2">Share competition <i class="fas fa-share"></i></button></div>
                          </div>
                        </div>
                        <?php
                        }
                      }
                        ?>
                        </div>

                        <!-- Disqualified participants tab  -->
                        <div id="disqualified" class="tabcontent">
                        <?php
                              //Snippet to select all disqualified participants
                              $d_query = "SELECT u_email, date_joined FROM participants WHERE comp_ID = $compid AND part_status = 'disqualified'";
                              $d_result = $connection->query($d_query);
                              if ($d_result) {
                                $d_rows = $d_result->num_rows;
                                if ($d_rows >= 1) {
                          ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example2">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Date</th>
                                        <!-- <th></th> -->
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    for ($i=0; $i < $d_rows; $i++) {
                                        $d_result->data_seek($i);
                                        $d_data = $d_result->fetch_array(MYSQLI_ASSOC); 
                                        //Full details of the participant
                                        $u_details = get_writer_details($connection, $d_data['u_email']);
                                  ?>
                                    <tr>
                                        <td><?php echo $u_details['firstname']." ".$u_details['lastname'] ?></td>
                                        <td><?php echo $d_data['u_email'] ?></td>
                                        <td><?php echo $d_data['date_joined'] ?></td>
                                        <!-- <td><a href="#" class="btn btn-sm btn-default" title="Accept"><i class="fas fa-trash-restore-alt"></i></a></td> -->
                                        <td><a href="sendemail.php?rec=<?php echo $d_data['u_email'] ?>&comp_ID=<?php echo $compid ?>" class="btn btn-sm btn-success" title="send email"><i class="far fa-envelope"></i></a></td>
                                    </tr>
                                        <?php
                                        } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                          }
                          else{
                        ?>
                        <div class="d-flex justify-content-center mb-5 mt-3">
                          <div>
                            <img src="images/Waiting_Outline.svg" alt="" width="200px">
                            <p class="text-center m-0" style="font-size: 16px;">No disqualified participants</p>
                            <div class="d-flex justify-content-center"><button class="btn btn-sm btn-default mt-2">Share competition <i class="fas fa-share"></i></button></div>
                          </div>
                        </div>
                        <?php
                        }
                      }
                        ?>
                        </div>    

                        <!-- Pending participants -->
                        <div id="pending" class="tabcontent" style="display: block;">
                        <?php
                              //Snippet to select all pending participants
                              $p_query = "SELECT part_ID, u_email, date_joined FROM participants WHERE comp_ID = $compid AND part_status = 'pending'";
                              $p_result = $connection->query($p_query);
                              if ($p_result) {
                                $p_rows = $p_result->num_rows;
                                if ($p_rows >= 1) {
                          ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example1">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    for ($i=0; $i < $p_rows; $i++) {
                                        $p_result->data_seek($i);
                                        $p_data = $p_result->fetch_array(MYSQLI_ASSOC); 
                                        //Full details of the participant
                                        $u_details = get_writer_details($connection, $p_data['u_email']);
                                  ?>
                                    <tr>
                                        <td><?php echo $u_details['firstname']." ".$u_details['lastname'] ?></td>
                                        <td><?php echo $p_data['u_email'] ?></td>
                                        <td><a href="javascript:void(0)" data-id="<?php echo $p_data['part_ID'] ?>" class="btn btn-sm btn-success verify" title="Verify participant">verify <i class="fas fa-check-double"></i></a></td>
                                        <td><a href="sendemail.php?rec=<?php echo $p_data['u_email'] ?>&comp_ID=<?php echo $compid ?>" class="btn btn-sm btn-success" title="send email"><i class="far fa-envelope"></i></a></td>
                                    </tr>
                                        <?php
                                        } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                          }
                          else{
                        ?>
                        <div class="d-flex justify-content-center mb-5 mt-3">
                          <div>
                            <img src="images/Waiting_Outline.svg" alt="" width="200px">
                            <p class="text-center m-0" style="font-size: 16px;">No pending participants</p>
                            <div class="d-flex justify-content-center"><button class="btn btn-default btn-sm mt-2">Share competition <i class="fas fa-share"></i></button></div>
                          </div>
                        </div>
                        <?php
                        }
                      }
                        ?>
                        </div>   

                        <!-- Competition leaderboad -->
                        <div id="leaderboard" class="tabcontent">
                        <?php
                                  //Snippet to generate leaderboard
                                  $l_query = "SELECT participants.u_email, posts.P_ID, posts.no_of_likes 
                                  FROM participants INNER JOIN posts ON participants.u_email = posts.W_email WHERE participants.comp_ID = $compid AND participants.part_status = 'verified' AND posts.published = 'yes' AND posts.tags LIKE '%$comp_data[tag]%' 
                                  ORDER BY posts.no_of_likes DESC";
                                  $l_result = $connection->query($l_query);
                                  if ($l_result) {
                                    $l_rows = $l_result->num_rows;
                                    echo "<input type='hidden' id='lead_count' value='$l_rows'>";
                                    if ($l_rows >= 1) {
                        ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example3">
                                <thead>
                                    <tr>
                                        <th>NB</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Votes</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                for ($i=0; $i < $l_rows; $i++) {
                                        $l_result->data_seek($i);
                                        $l_data = $l_result->fetch_array(MYSQLI_ASSOC); 
                                        //Full details of the participant
                                        $u_details = get_writer_details($connection, $l_data['u_email']);
                                  ?>
                                    <tr>
                                        <td><?php echo $i + 1 ?></td>
                                        <td><?php echo $u_details['firstname']." ".$u_details['lastname'] ?></td>
                                        <td><?php echo $l_data['u_email'] ?></td>
                                        <td><?php echo $l_data['no_of_likes'] ?></td>
                                        <td><a target="_blank" href="../viewpost.php?pid=<?php echo base64_encode($l_data['P_ID']) ?>" title="View post">View article</a></td>
                                    </tr>
                                        <?php
                                        } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                          }
                          else{
                        ?>
                        <div class="d-flex justify-content-center mb-5 mt-3">
                          <div>
                            <img src="images/Content creation_Monochromatic.svg" alt="" width="200px">
                            <p class="text-center m-0" style="font-size: 16px;">No Articles here yet</p>
                            <div class="d-flex justify-content-center"><button class="btn btn-default btn-sm mt-2">Share competition <i class="fas fa-share"></i></button></div>
                          </div>
                        </div>
                        <?php
                        }
                      }
                        ?>
                        </div>


                        </div>  
                        <div class="card-footer bg-white">
                          <a href="sendemail.php?rec=verified&comp_ID=<?php echo $compid ?>" class="btn btn-dark btn-sm <?php if(count_part($connection, $compid, "verified") < 1) echo "disabled" ?>" title="Email all verified">Verified <i class="far fa-envelope"></i></a>
                          <a href="sendemail.php?rec=pending&comp_ID=<?php echo $compid ?>" class="btn btn-dark btn-sm <?php if(count_part($connection, $compid, "pending") < 1) echo "disabled" ?>" title="Email all pending">Pending <i class="far fa-envelope"></i></a>
                          <a href="sendemail.php?rec=disqualified&comp_ID=<?php echo $compid ?>" class="btn btn-dark btn-sm <?php if(count_part($connection, $compid, "disqualified") < 1) echo "disabled" ?>" title="Email all disqualified">Disqualified <i class="far fa-envelope"></i></a>
                          <button id="verifyall" data-compid="<?php echo $compid ?>" class="btn btn-default btn-sm <?php if(count_part($connection, $compid, "pending") < 1) echo "disabled" ?>">Verify all <i class="fas fa-check-double"></i></button>
                          <button class="btn btn-success btn-sm <?php if($comp_data['comp_status'] != "expired") echo "disabled" ?>" data-bs-toggle="modal" data-bs-target="#awards">Request payout</button>
                        </div>
                  </div>
              </div>
              <div class="col-md-5">
                  <div class="card" style="font-size: 14px;">
                      <div class="card-header p-3 bg-white d-flex align-items-center">
                          <h5 class="card-title m-0">Details</h5>
                          <button class="btn btn-default ms-auto btn-sm" data-bs-toggle="modal" data-bs-target="#details">Edit Details</button>
                      </div>
                    <div class="card-body">
                        <div class="name">
                            <h6>Competition Name</h6>
                            <p class="text-dark">
                                <?php echo $comp_data['name'] ?>
                            </p>
                        </div>
                        <div class="amount">
                          <h6>Total Deposit</h6>
                          <p>₦ <?php echo number_format($comp_data['total_deposit'])?></p>
                          <span id="deposit" class="d-none" data-amount="<?php echo $comp_data['total_deposit'] ?>"></span>
                        </div>
                        <div class="description">
                          <h6>Description</h6>
                          <?php echo $comp_data['comp_description'] ?>
                        </div>
                            <div class="requirements">
                                <h6>Requirements</h6>
                               <?php echo $comp_data['requirements'] ?>
                            </div>
                            <div class="rules">
                              <h6>Rules</h6>
                              <?php echo $comp_data['rules'] ?>
                            </div>
                            <div class="duration">
                                <h6>Duration</h6>
                                <p><?php echo format_date($comp_data['start_date'])." - ".format_date($comp_data['end_date']) ?></p>
                            </div>
                            <div class="tage">
                                <h6>Tag</h6>
                                <p><span style="font-weight: bold;"><a href="../categories.php?tag=<?php echo $comp_data['tag'] ?>"><?php echo "#".$comp_data['tag']?></a></span></p>
                            </div>
                    </div>
                  </div>
              </div>
              <!-- Edit details modal form -->
              <div class="modal fade" id="details" tabindex="-1" aria-labelledby="detailsLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action="managecompetition.php?comp_ID=<?php echo $compid ?>" method="POST">
                        <div class="mb-3">
                          <label for="" class="mb-2">Competition Name</label>
                          <input type="text" value="<?php echo $comp_data['name'] ?>" name="name" class="form-control" placeholder="e.g Penactive competition">
                        </div>
                        <div class="mb-3">
                          <label for="" class="mb-2">Description</label>
                          <textarea name="desc" id="desc" class="form-control"><?php echo $comp_data['comp_description'] ?></textarea>
                        </div>
                        <div class="mb-3">
                          <label for="" class="mb-2">Requirements<br><small>(Should be in a list format)</small></label>
                          <textarea name="req" id="req" class="form-control"><?php echo $comp_data['requirements'] ?></textarea>
                        </div>
                        <div class="mb-3">
                          <label for="" class="mb-2">Rules<br><small>(Should be in a list format)</small></label>
                          <textarea name="rules" id="rules" class="form-control"><?php echo $comp_data['rules'] ?></textarea>
                        </div>
                        <button class="btn btn-default btn-sm w-100" name="save" type="submit">Save Changes</button>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Award participants form -->
              <div class="modal fade" id="awards" tabindex="-1" aria-labelledby="awardsLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Request payout</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                          <label class="mb-2" for="">How many positions are you awarding?<br><small>(Maximum of 5 awardees)</small></label>
                          <input type="number" id="awardees_no" class="form-control" placeholder="E.g 3">
                          <button class="btn btn-default mt-2 btn-sm" id="gen_fields">Specify prizes</button>
                        </div>
                        <p id="gen_inst" style="display: none;">Please input individual prizes of the awardees starting from highest award to lowest. <br><small><strong>Note: </strong>The sum of all the amounts inputed must <strong>not</strong> be greater than your total deposit.</small></p>
                        <div id="awards_form"></div>
                        <button id="btn_req" data-compid="<?php echo $compid ?>" data-tag="<?php echo $comp_data['tag'] ?>" style="display: none;" class="btn btn-success btn-sm w-100">Request Payout <i class="fas fa-paper-plane"></i></button>
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
    <script src="https://unpkg.com/slick-loader@1.1.20/slick-loader.min.js"></script>
    <script src="js/general.js"></script>
    <script>
      function generateElements(){
        let awardees_no = parseInt(document.getElementById("awardees_no").value)
        let main_contain = document.getElementById("awards_form")
        let comp_count = parseInt(document.getElementById("lead_count").value)
        if (isNaN(awardees_no) == true) {
          Swal.fire(
            'Invalid input!',
            'Input must be a number',
            'error'
          )
        }
        else if(awardees_no < 1){
          Swal.fire(
            'Invalid input!',
            'Input must be greater than 1',
            'error'
          )
        }
        else if(awardees_no > 5){
          Swal.fire(
            'Invalid input!',
            'Input must not be greater than 5',
            'error'
          )
        }
        else if(awardees_no > comp_count){
          Swal.fire(
            'Invalid input!',
            'Input greater than total participants in leaderboard',
            'error'
          )
        }
        else{
            main_contain.innerHTML = ""
            document.getElementById("gen_inst").style = "display: block";
            document.getElementById("btn_req").style = "display: block";
            for (let i = 0; i < awardees_no; i++) {
            
            //create div to hold the input fields
            let input_contain = document.createElement('div')
            input_contain.classList.add('mb-3')
            main_contain.appendChild(input_contain)

            //Create label for input field
            let titleLabel = document.createElement('label')
            let count = i + 1
            titleLabel.textContent = 'Position '+count
            titleLabel.classList.add('mb-2')

            //Create input field
            let titleInput = document.createElement('input')
            titleInput.type = "number"
            titleInput.name = "position"+i
            titleInput.classList.add('form-control')
            titleInput.setAttribute('id', "position"+i)
            titleInput.placeholder = 'E.g 5000'

            input_contain.appendChild(titleLabel)
            input_contain.appendChild(titleInput)
          }
        }
      }

      var gen_fields = document.getElementById("gen_fields")
      gen_fields.addEventListener('click', (e)=>{
        e.preventDefault()
        generateElements()
      })

      //JQuery Logic
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example1').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            //Snippet to disqualify participant
            $("#example").on('click', '.disq', function(e){
              e.preventDefault()
              var parent = $(this).parent('td').parent('tr')
              var pid = $(this).attr('data-id');
              Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, continue!'
              }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    type: "post",
                    url: "managepart.php",
                    data: {part_ID: pid, type: "disq"}
                  }).done(function(msg) {
                      if (msg == "success") {
                        parent.fadeOut('slow')
                        Swal.fire({
                          title: 'Success!',
                          text: "Diqualified successfully!",
                          icon: 'success',
                          showCancelButton: false
                          }).then((result) => {
                          if (result.isConfirmed) {
                              location.reload()
                          }
                        })
                      }
                  }).fail(function(msg){
                    console.log(msg)
                  })
                }
              })     
            })

            //Snippets to verify pending participant
            $("#example1").on('click', '.verify', function(e){
              e.preventDefault()
              var parent = $(this).parent('td').parent('tr')
              var pid = $(this).attr('data-id');
              Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, continue!'
              }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    type: "post",
                    url: "managepart.php",
                    data: {part_ID: pid, type: "verify"}
                  }).done(function(msg) {
                      if (msg == "success") {
                        parent.fadeOut('slow')
                        Swal.fire({
                          title: 'Success!',
                          text: "Verified successfully!",
                          icon: 'success',
                          showCancelButton: false
                          }).then((result) => {
                          if (result.isConfirmed) {
                              location.reload()
                          }
                        })
                      }
                  }).fail(function(msg){
                    console.log(msg)
                  })
                }
              })     
            })

            //Snippet to verify all pending participants at once
            $("#verifyall").click(function(e){
              e.preventDefault()
              var compid = $(this).attr('data-compid');
              Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, continue!'
              }).then((result) => {
                if (result.isConfirmed) {
                  SlickLoader.enable();
                  SlickLoader.setText("Please wait...");
                  $.ajax({
                    type: "post",
                    url: "managepart.php",
                    data: {comp_ID: compid, verify_all: 'v_all'}
                  }).done(function(msg) {
                      SlickLoader.disable();
                      if (msg == "success") {
                        Swal.fire({
                          title: 'Success!',
                          text: "Verified successfully!",
                          icon: 'success',
                          showCancelButton: false
                          }).then((result) => {
                          if (result.isConfirmed) {
                              location.reload()
                          }
                        })
                      }
                  }).fail(function(msg){
                    console.log(msg)
                  })
                }
              })     
            })

            //Snippet to request payout
            $("#btn_req").click(function(e){
              e.preventDefault()
              var awardees_no = $("#awardees_no").val();
              var amounts = [];
              var deposit = parseInt($("#deposit").attr('data-amount'))
              var sum = 0;
              var compid = $(this).attr('data-compid');
              var tag = $(this).attr('data-tag');
              for (let i = 0; i < awardees_no; i++) {
                let amount = parseInt($("#position"+i).val()) || 0;
                amounts.push(amount); 
              }
              for (let i = 0; i < amounts.length; i++) {
                sum += amounts[i];       
              }
              if (sum > deposit) {
                  Swal.fire(
                    'Invalid total',
                    'total must not be greater than deposit amount!',
                    'error'
                  )
              }
              else if(amounts.includes(0)){
                  Swal.fire(
                    'Error',
                    'All fields are required',
                    'error'
                  )
              }
              else{
                SlickLoader.enable();
                SlickLoader.setText("Please wait...");
                $.ajax({
                  type: "post",
                  url: "managepart.php",
                  data: {awardees: awardees_no, amounts: amounts.toString(), compID: compid, comp_tag: tag}
                }).done(function(msg){
                    SlickLoader.disable();
                    if (msg == "success") {
                      Swal.fire({
                      title: 'Success!',
                      text: "Payout request sent successfully!",
                      icon: 'success',
                      showCancelButton: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                          location.reload()
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
              }
            })

        });


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