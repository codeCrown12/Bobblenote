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
    <title>Payment</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/general.css">
    <style>
      small{
        font-size: 12px;
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
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card rounded-0 mt-5">
              <div class="card-header bg-white p-3">
                <h5 class="card-title m-0"><i class="far fa-credit-card"></i> Make Payments</h5>
              </div>
              <div class="card-body">
                <div class="row">
                <!-- <div class="col-sm-5">
                      <div class="d-flex justify-content-center">
                        <div class="d-block">
                          <p class="text-center m-0"><img src="images/Card Payment_Outline.svg" alt="" width="300px"></p>
                          <h5 class="text-center">Make Payment</h5>
                          <p class="text-center fst-italic">Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus, vero.</p>
                        </div>
                      </div>
                  </div> -->
                  <div class="col-sm-12">
                      <form action="">
                          <div class="mb-3"><p class="mb-1">Payment Gateway</p><img src="images/1200px-Paystack_Logo.png" width="150px" alt=""></div>
                          <!-- <div class="mb-4"><p class="mb-1">We Accept:</p><img src="images/cards.png" width="300px" alt=""></div> -->
                          <p>(Note:  A 10% fee will be deducted from the total amount deposited)</p>
                          <div class="mb-3">
                            <div class="row">
                              <div class="col-sm-6">
                                <label for="" class="mb-2">Total Amount<br><small>(In Naira '₦')</small></label>
                                <input type="number" class="form-control" placeholder="e.g 5000" id="tot_amt">
                              </div>
                              <div class="col-sm-6">
                                <label for="" class="mb-2">Amount after 10% deduction<br><small>(In Naira '₦')</small></label>
                                <input type="number" class="form-control" readonly placeholder="e.g 4500" id="fin_amt">
                              </div>
                            </div>
                          </div>
                          <div class="mb-3">
                            <label class="mb-2" for="">How many positions are you awarding?<br><small>(Maximum of 5 awardees)</small></label>
                            <input type="number" id="awardees_no" class="form-control" placeholder="E.g 3">
                            <button class="btn btn-default mt-2" id="gen_fields">Specify prizes</button>
                          </div>
                          <p id="gen_inst" style="display: none;">Please input individual prizes of the awardees starting from highest award to lowest. <br><small><strong>Note: </strong>The sum of all the amounts inputed must be equal to your deposit minus the 10% fee.</small></p>
                          <div id="awards_form"></div>
                          <button class="btn btn-success" type="submit" name="btn_pay" id="btn_pay" style="display: none;">Proceed to payment <i class="fas fa-paper-plane"></i></button>
                        </form>
                  </div>
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
    <script>

      function generateElements(){
        let awardees_no = parseInt(document.getElementById("awardees_no").value)
        let main_contain = document.getElementById("awards_form")
        if (isNaN(awardees_no) == false && (awardees_no >= 1 && awardees_no <= 5)) {
            main_contain.innerHTML = ""
            document.getElementById("gen_inst").style = "display: block";
            document.getElementById("btn_pay").style = "display: block";
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
            titleInput.placeholder = 'E.g 5000'

            input_contain.appendChild(titleLabel)
            input_contain.appendChild(titleInput)
          }
        }
        else{
          Swal.fire(
            'Error!',
            'Invalid input',
            'error'
          )
        }
      }

      var gen_fields = document.getElementById("gen_fields")
      gen_fields.addEventListener('click', (e)=>{
        e.preventDefault()
        generateElements()
      })

      var tot_amt = document.getElementById("tot_amt")
      var fin_amt = document.getElementById("fin_amt")
      tot_amt.addEventListener('keyup', ()=>{
        let tot_amt_val = parseInt(tot_amt.value)
        if (isNaN(tot_amt_val) == false && tot_amt.value != "") {
          let fee = (10 * tot_amt_val) / 100
          let fin_amt_val = tot_amt_val - fee
          console.log(fin_amt_val)
          fin_amt.value = fin_amt_val
        }
        else{
          fin_amt.value = ""
        }
      })
    </script>
  </body>
</html>