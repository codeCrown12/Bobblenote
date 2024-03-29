<?php
session_start();
include '../functions.php';
include '../connection.php';

$selector = "";
$msg = "";
$pay_success = "";

//Snippet to show logged in user details
if ($_SESSION['w_email'] == "") {
  header("Location: ../login.php");
}
else{
  $selector = $_SESSION['w_email'];
}
include '../compdefaulterscheck.php';
if (isset($_GET['payment_success'])) {
  $pay_success = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  Payment completed successfully! click <span class='text-decoration-underline'>'Competitions'</span> tab to manage competitions.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}


$details = get_writer_details($connection, $selector);
$fullname = $details['firstname']. " ". $details['lastname'];
$org_name = $details['organization_name'];
$profile_img = $details['profilepic'];
$msg = "";
$rand = rand();

//snippet to create competitions
$name = "";
$tag = "";
$description = "";
$requirements = "";
$rules = "";
$start_date = "";
$end_date = "";

//Logic to create competition
if (isset($_POST['create_comp'])) {
  $name = check_string($connection, $_POST['name']);
  $tag = strtolower(check_string($connection, $_POST['tag']));
  $description = $_POST['desc'];
  $requirements = $_POST['req'];
  $rules = $_POST['rules'];
  $start_date = check_string($connection, $_POST['start_date']);
  $end_date = check_string($connection, $_POST['end_date']);
  $status = "pending";
  

  if ($name == "" || $tag == "" || $description == "" || $requirements == "" || $rules == "" || $start_date == "" || $end_date == "") {
    $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    All fields are required!
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  elseif (tag_exists($connection, $tag)) {
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
    $start_date = date_format(date_create($start_date), 'Y-m-d');
    $end_date = date_format(date_create($end_date), 'Y-m-d');
    $query = "INSERT INTO competitions (name, tag, comp_description, requirements, rules, start_date, end_date, u_email, comp_status) VALUES (?,?,?,?,?,?,?,?,?)";
    $result = $connection->prepare($query);
    $result->bind_param("sssssssss", $name, $tag, $description, $requirements, $rules, $start_date, $end_date, $selector, $status);
    if ($result->execute()) {
      $insert_id = $result->insert_id;
      header("Location: payment.php?comp_id=$insert_id");
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
    <title>My competitions</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/general.css">
    <style>
      small{
        font-size: 12px;
      }

.comp-item{
  display: flex;
  justify-content: center;
}
.comp-logo{
  margin-right: 10px;
}
.comp-logo-img{
  width: 80px;
  border-radius: 50%;
  /* border: 1px solid #ccc; */
  background-color: #02b50b;
  height: 80px; 
  width: 80px; 
  font-size: 40px; 
  font-weight: bold;
}
.comp-txts{
  display: flex;
  align-items: center;
  border-bottom: 1px solid #dee2e6;
}
.comp-info{
  width: 85%;
  margin-right: 10px;
}
.comp-date{
  font-size: 13px;
}
.comp-desc{
  font-size: 90%;
}
@media screen and (max-width: 700px) {
  .comp-txts{
    display: block;
  }
  .comp-info{
    width: 100%;
  }
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
              <a class="nav-link text-white" href="settings.php"><img src="<?php echo "../".$profile_img."?randomurl= $rand" ?>" class="dp-img" alt=""> <?php
                if ($details['account_type'] == "individual") {
                  echo $fullname;
                }
                else echo $org_name;
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
              <h5 class="offcanvas-title mt-5" id="offcanvasNavbarLabel"><a class="text-dark text-decoration-none" href="settings.php"><img src="<?php echo "../".$profile_img."?randomurl= $rand" ?>" class="dp-img" alt=""> 
              <?php
                if ($details['account_type'] == "individual") {
                  echo $fullname;
                }
                else echo $org_name;
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
        <div class="row justify-content-center">
          <div class="col-md-9 mt-5">
            <!-- <h4 class="mt-5"><i class="fas fa-trophy"></i> Manage Competitions</h4> -->
            <?php
              if ($pay_success != "") {
                echo $pay_success;
              }
            ?>
            <div class="card rounded-0">
                <div class="card-header bg-white p-3">
                  <h5 class="card-title m-0"><i class="fas fa-trophy"></i> Competitions</h5>
                </div>
                <div class="card-body">
                  <!-- Tab links -->
                  <div class="tab">
                      <button class="tablinks active-tab" onclick="viewSetting(event, 'start-comp')">Start Competition</button>
                      <button class="tablinks" onclick="viewSetting(event, 'enrollments')">Enrollments</button>
                      <button class="tablinks" onclick="viewSetting(event, 'organized')">Competitions</button>
                      <button class="tablinks" onclick="viewSetting(event, 'win_history')">Award history</button>
                  </div>
                          
                   <!-- Tab content -->
                   
                   <!-- Create competitions -->
                   <div id="start-comp" class="tabcontent" style="display: block;">
                    <!-- <h5 class="mt-4">Create competition</h5> -->
                    <div class="row mt-3">
                    <div class="col-sm-5">
                        <div class="guidelines">
                          <div class="d-flex justify-content-center"><p class="text-center m-0"><img width="400px" src="images/Winners_Outline.svg" alt=""></p></div>
                          <h3 class="text-center">Get started on your competition</h3>
                          <p class="text-center text-muted fst-italic">Learn more about how competitions work on Bobblenote by clicking the button below</p>
                          <div class="d-flex justify-content-center"><a href="../compguide.php" class="btn btn-default" target="_blank">Learn More</a></div>
                        </div>
                      </div>
                      <div class="col-sm-7">
                        <?php
                          if ($msg != "") {
                            echo $msg;
                          }
                        ?>
                        <form action="mycompetitions.php" method="POST">
                          <div class="mb-3">
                            <label for="" class="mb-2">Competition Name</label>
                            <input type="text" autocomplete="off" class="form-control" value="<?php echo $name ?>" name="name" placeholder="e.g Bobblenote competition">
                          </div>
                          <div class="mb-3">
                            <label for="" class="mb-2">Tag</small></label>
                            <input type="text" autocomplete="off" class="form-control" value="<?php echo $tag?>" name="tag" placeholder="e.g Bobblenote">
                          </div>
                          <div class="mb-3">
                            <label for="" class="mb-2">Description</label>
                            <textarea id="desc" name="desc" class="form-control" value="<?php echo $description ?>"></textarea>
                          </div>
                          <div class="mb-3">
                            <label for="" class="mb-2">Requirements<br><small>(Should be in a list format)</small></label>
                            <textarea id="req" name="req" class="form-control" value="<?php echo $requirements ?>"></textarea>
                          </div>
                          <div class="mb-3">
                            <label for="" class="mb-2">Rules<br><small>(Should be in a list format)</small></label>
                            <textarea id="rules" name="rules" class="form-control" value="<?php echo $rules ?>"></textarea>
                          </div>
                          <div class="row">
                            <div class="col-6">
                              <label for="">Start Date</label>
                              <input type="date" name="start_date" class="form-control" value="<?php echo $start_date ?>">
                            </div>
                            <div class="col-6">
                              <label for="">End Date</label>
                              <input type="date" name="end_date" class="form-control" value="<?php echo $end_date ?>">
                            </div>
                          </div>
                          <button type="submit" name="create_comp" class="btn btn-default mt-3 w-100 btn-sm">Create competition</button>
                      </form>
                      </div>
                    </div>
                  </div>

                   <!--My Enrollments -->
                  <div id="enrollments" class="tabcontent">
                    <div class="mt-4">
                    <?php
                      $en_query = "SELECT * FROM participants WHERE u_email = '$selector'";
                      $en_result = $connection->query($en_query);
                      if ($en_result) {
                        $en_rows = $en_result->num_rows;
                        if ($en_rows >= 1) {
                          for ($i=0; $i < $en_rows; $i++) { 
                            $en_result->data_seek($i);
                            $en_data = $en_result->fetch_array(MYSQLI_ASSOC);
                            $en_comp_data = get_comp($connection, $en_data['comp_ID']);
                        
                    ?>
                    <div class="comp-item mb-3">
                          <div class="comp-logo">
                            <div class="comp-logo-img d-flex justify-content-center align-items-center text-light" style="background-color: <?php echo gen_color(rand(0, 5)) ?>;"><?php echo substr($en_comp_data['name'], 0, 1) ?></div>
                          </div>
                          <div class="comp-txts">
                            <div class="comp-info">
                              <h6 class="m-0"><?php echo $en_comp_data['name'] ?></h6>
                              <?php
                                if ($en_data['part_status'] == "verified") {
                              ?>
                              <small style="color: #06ad03;"><i class="fas fa-check-double"></i> <?php echo $en_data['part_status'] ?></small> - 
                              <?php 
                                }
                                elseif ($en_data['part_status'] == "disqualified") {
                                  
                              ?>
                              <small style="color: #ed1811;"><i class="fas fa-times"></i> <?php echo $en_data['part_status'] ?></small> - 
                              <?php
                            }
                            else{
                              ?>
                              <small style="color: #d4b102;"><i class="fas fa-clock"></i> <?php echo $en_data['part_status'] ?></small> -
                            <?php                            
                            }
                            ?>
                              <small class="text-muted comp-date">Joined on: <?php echo format_date($en_data['date_joined']) ?></small>
                              <div class="mt-1 comp-desc mb-1"><?php echo substr($en_comp_data['comp_description'], 0, 139) ?>...</div>
                            </div>
                            <div class="comp-action">
                              <a href="../compinfo.php?comp_ID=<?php echo $en_data['comp_ID'] ?>" class="btn btn-default btn-sm">View Info</a>
                            </div>
                          </div>
                        </div>
                        <?php
                        }
                      }
                      else{
                        ?>
                         <div class="d-flex justify-content-center">
                      <div class="d-block">
                        <p class="text-center m-0"><img src="images/Winner _Outline.svg" width="250px" alt=""></p>
                        <p class="text-center m-1">
                          You've not enrolled in any competitions!
                        </p>
                        <p class="text-center"><a href="../competitions.php" class="btn btn-default btn-sm text-center">Search competitions</a></p>
                      </div>
                    </div>
                    <?php
                  
                }
              }
                  ?>
                    </div>
                  </div>
      

                  <!--Award History -->
                  <div class="tabcontent" id="win_history">
                    <?php
                        /** -------- Logic to select Award history from db --------- **/

                        $award_query = "SELECT award_ID, comp_name, u_email, position, amount, date FROM awards WHERE u_email = '$selector'";
                        $award_result = $connection->query($award_query);
                        if ($award_result) {
                          $award_rows = $award_result->num_rows;
                          if ($award_rows >= 1) {
                    ?>
                    <div class="table-responsive mt-3">
                            <table class="table table-striped table-hover" id="example" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>#BOBAward_ID</th>
                                        <th>Competition_Name</th>
                                        <th>Prize/Amount</th>
                                        <th>Position</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                      /** -------- Logic to select Award history from db --------- **/
                                          for ($i=0; $i < $award_rows; $i++) { 
                                            $award_result->data_seek($i);
                                            $award_data = $award_result->fetch_array(MYSQLI_ASSOC);
                                            if ($award_data['position'] == '1') {
                                                $position = "First";
                                            }
                                            elseif ($award_data['position'] == '2') {
                                                $position = "Second";
                                            }
                                            elseif ($award_data['position'] == '3') {
                                                $position = "Third";
                                            }
                                            elseif ($award_data['position'] == '4') {
                                                $position = "Fourth";
                                            }
                                            elseif ($award_data['position'] == '5') {
                                                $position = "Fifth";
                                            }

                                    ?>
                                    <tr>
                                        <td><?php echo "#BOB-".$award_data['award_ID'] ?></td>
                                        <td><?php echo $award_data['comp_name']?></td>
                                        <td><?php echo "NGN ".number_format($award_data['amount']) ?></td>
                                        <td><?php echo $position?></td>
                                        <td><?php echo $award_data['date']?></td>
                                    </tr>
                                        <?php
                                        }
                                      }
                                      else{
                                        ?>
                                        <div class="d-flex justify-content-center">
                                          <div class="d-block">
                                            <p class="text-center m-0"><img src="images/Winner _Outline.svg" width="250px" alt=""></p>
                                            <p class="text-center m-1">
                                              Competitions you are awarded for will appear here!
                                            </p>
                                            <p class="text-center"><a href="../competitions.php" class="btn btn-default btn-sm text-center">Search competitions</a></p>
                                          </div>
                                        </div>
                                        <?php
                                      }
                                    }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                  </div>

                  <!--My organized Competitions -->
                  <div id="organized" class="tabcontent">
                    <div class="mt-4">
                      <?php
                        /** Section to select all hosted competitions **/
                          $hosted_query = "SELECT * FROM competitions WHERE u_email = '$selector' ORDER BY comp_ID DESC";
                          $hosted_result = $connection->query($hosted_query);
                          if ($hosted_result) {
                            $hosted_rows = $hosted_result->num_rows;
                            if ($hosted_rows >= 1) {
                              for ($i=0; $i < $hosted_rows; $i++) { 
                                $hosted_result->data_seek($i);
                                $hosted_data = $hosted_result->fetch_array(MYSQLI_ASSOC);
                      
                      ?>
                      <div class="comp-item mb-3">
                          <div class="comp-logo">
                            <div class="comp-logo-img d-flex justify-content-center align-items-center text-light" style="background-color: <?php echo gen_color(rand(0, 5)) ?>;"><?php echo substr($hosted_data['name'], 0, 1) ?></div>
                          </div>
                          <div class="comp-txts">
                            <div class="comp-info">
                              <h6 class="m-0"><?php echo $hosted_data['name'] ?></h6>
                              <?php
                                if ($hosted_data['comp_status'] == "ongoing") {
                              ?>
                              <small style="color: #06ad03;"><i class="far fa-calendar-check"></i> <?php echo $hosted_data['comp_status'] ?></small> - 
                              <?php 
                                }
                                elseif ($hosted_data['comp_status'] == "expired") {
                                  
                              ?>
                              <small style="color: #ed1811;"><i class="far fa-calendar-times"></i> <?php echo $hosted_data['comp_status'] ?></small> - 
                              <?php
                            }
                              ?>
                              <small class="text-muted comp-date">Created on: <?php echo format_date($hosted_data['date_created']) ?></small>
                              <div class="mt-1 comp-desc mb-1"><?php echo substr($hosted_data['comp_description'], 0, 139) ?>...</div>
                            </div>
                            <div class="comp-action">
                              <a href="managecompetition.php?comp_ID=<?php echo $hosted_data['comp_ID'] ?>" class="btn btn-default btn-sm">Manage</a>
                            </div>
                          </div>
                      </div>

                      <?php 
                       }
                      }
                      else{
                      ?>
                      <div class="d-flex justify-content-center">
                      <div class="d-block">
                        <p class="text-center m-0">
                          <img src="images/Creative Process_Outline.svg" width="200px" alt="">
                        </p> 
                        <p class="text-center m-1">
                          You've not organized any competitions!
                        </p>
                        <p class="text-center"><a href="mycompetitions.php" class="btn btn-default btn-sm text-center">Create competitions</a></p>
                      </div>
                    </div>
                      <?php
                        
                      }
                    }
                    else echo "King";

                  /** End of section to select all hosted competitions **/
                      
                      ?>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <!-- <div class="col-md-4">

          </div> -->
        </div>
      </div>
      <?php include '../footer.php' ?>
        <!-- javascripts  -->
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