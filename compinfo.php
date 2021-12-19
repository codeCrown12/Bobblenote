<?php
session_start();
include 'connection.php';
include 'functions.php';

$rand = rand();
$selector = "";
$compid = "";
$comp_data = "";

//Check if user is logged in
if (isset($_SESSION['w_email'])) {
    $selector = $_SESSION['w_email'];
}
//Get user details
$user_details = get_writer_details($connection, $selector);

if (isset($_GET['comp_ID'])) {
    $compid = $_GET['comp_ID'];
}

$query = "SELECT * FROM competitions WHERE comp_ID = $compid";
$result = $connection->query($query);
if ($result) {
    $comp_data = $result->fetch_array(MYSQLI_ASSOC);
}
else{
    die($connection->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/slick-loader@1.1.20/slick-loader.min.css">
    <title><?php echo $comp_data['name'] ?></title>
    <style>
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
    </style>
</head>
<body>
    <!-- Navbar component -->
    <?php include 'header.php'; ?>
    <!-- End of navbar component -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-7 bg-light border p-4">
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="content">
                            <span id="compid" data-id="<?php echo $compid ?>"></span>
                            <div class="d-flex justify-content-center">
                                <div class="comp-logo-img d-flex justify-content-center align-items-center text-light" style="background-color: <?php echo gen_color(rand(0, 3)) ?>;"><?php echo strtoupper(substr($comp_data['name'], 0, 1)) ?></div>
                            </div>
                            <h4 class="text-center"><?php echo $comp_data['name'] ?></h4>

                            <!-- Duration -->
                            <h6 class="mt-5">Duration</h6>
                            <p class="m-0" style="color: #06ad03;"><small><i class="far fa-calendar-check"></i> Ongoing</small></p>
                            <span>[<?php echo $comp_data['start_date'] ?> - <?php echo $comp_data['end_date'] ?>]</span>   

                            <!-- Tag -->
                            <h6 class="mt-3">Tag</h6>
                            <a href="#" class="text-decoration-underline">#<?php echo $comp_data['tag'] ?></a>

                            <!-- Description -->
                            <h6 class="mt-3">Description</h6>
                            <div><?php echo $comp_data['comp_description'] ?></div>
                            
                            <!-- Requirements -->
                            <h6 class="mt-3">Requirements</h6>
                            <div><?php echo $comp_data['requirements'] ?></div>

                            <!-- Rules -->
                            <h6 class="mt-3">Rules</h6>
                            <div><?php echo $comp_data['rules'] ?></div>

                            <button class="btn btn-default mt-5 w-100 p-2 <?php
                                if (check_participant($connection, $selector, $compid)) {
                                    echo "disabled";
                                }
                            ?>" id="join">Join this competition <i class="far fa-thumbs-up"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php' ?>
    <script src="js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="js/jquery.sticky-sidebar.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/general.js"></script>
    <script src="https://unpkg.com/slick-loader@1.1.20/slick-loader.min.js"></script>
    <script>
        $(document).ready(function(){
            var btn_join = $("#join")
            var comp_id = $("#compid").attr("data-id")
            btn_join.click(function(e){
                e.preventDefault()
                SlickLoader.enable();
                SlickLoader.setText("Please wait...");
                $.ajax({
                    type: "post",
                    data: {comp_id: comp_id},
                    url: "joincomp.php"
                }).done(function(msg){
                    SlickLoader.disable();
                    if (msg == "not logged in") {
                        Swal.fire({
                            title: 'Warning!',
                            text: "You are not logged in!",
                            icon: 'warning',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Login'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                location.replace("login.php")
                            }
                        })
                    }
                    else if(msg == "already a participant"){
                        Swal.fire(
                        'Warning!',
                        'You are already a participant!',
                        'warning'
                        )
                    }
                    else if(msg = "success"){
                        Swal.fire({
                            title: 'Success',
                            text: "You have successfully joined this competition!",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'More competitions'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                location.replace("competitions.php")
                            }
                        })
                    }
                    else{
                        Swal.fire(
                        'Error!',
                        'Something went wrong! refresh this page and try again',
                        'success'
                        )
                    }
                }).fail(function(msg){
                    SlickLoader.disable()
                    console.log(msg)
                })
            })
        })
    </script>
</body>
</html>