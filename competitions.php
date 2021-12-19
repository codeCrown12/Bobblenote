<?php
session_start();
include 'connection.php';
include 'functions.php';

$rand = rand();
$selector = "";
$comp_query = "SELECT * FROM competitions WHERE comp_status = 'ongoing' ORDER BY comp_ID DESC";

//Check if user is logged in
if (isset($_SESSION['w_email'])) {
    $selector = $_SESSION['w_email'];
}
//Get user details
$user_details = get_writer_details($connection, $selector);

if (isset($_POST['btn_search'])) {
    $keywrd = check_string($connection, $_POST['keywrd']);
    $comp_query = "SELECT * FROM competitions WHERE name LIKE '%$keywrd%' AND comp_status = 'ongoing' ORDER BY comp_ID DESC";
}

if (isset($_POST['sort_select'])) {
    $sort_select = check_string($connection, $_POST['sort_select']);
    if ($sort_select == "early") {
        $comp_query = "SELECT * FROM competitions WHERE comp_status = 'ongoing' ORDER BY start_date";
    }
    elseif ($sort_select == "late") {
        $comp_query = "SELECT * FROM competitions WHERE comp_status = 'ongoing' ORDER BY start_date DESC";
    }
    elseif ($sort_select == "highest_award") {
        $comp_query = "SELECT * FROM competitions WHERE comp_status = 'ongoing' ORDER BY total_deposit DESC";
    }
    else{
        $comp_query = "SELECT * FROM competitions WHERE comp_status = 'ongoing' ORDER BY comp_ID DESC";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Competitions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .guideline{
            width: 70%;
            margin: auto;
        }
    </style>
</head>
<body>
    <!-- Navbar component -->
    <?php include 'header.php'; ?>
    <!-- End of navbar component -->

    <div class="container-fluid" style="border: 1px solid #e6e6e6;">
        <div class="container">
            <div class="row align-items-center pb-3 pt-3">
                <div class="col-md-5">
                    <form action="competitions.php" method="POST">
                        <div class="d-flex align-items-center">
                            <input autocomplete="off" type="search" name="keywrd" placeholder="Search by competition name..." class="form-control w-75 me-2">
                            <button class="btn btn-default w-25 p-2" type="submit" name="btn_search">Search <i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-8">
                            <form action="competitions.php" method="POST" id="sort_form">
                                <select name="sort_select" class="form-select" id="sort_select">
                                    <option value="">-- Sort competitions by --</option>
                                    <option value="early">Early competitions</option>
                                    <option value="late">Late competitions</option>
                                    <option value="highest_award">Highest awards</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-default p-2 w-100">Start a new competition <i class="fas fa-rocket"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="contents">
                <?php
                        /** Section to select all ongoing competitions **/
                          
                          $comp_result = $connection->query($comp_query);
                          if ($comp_result) {
                            $comp_rows = $comp_result->num_rows;
                            if ($comp_rows >= 1) {
                              for ($i=0; $i < $comp_rows; $i++) { 
                                $comp_result->data_seek($i);
                                $comp_data = $comp_result->fetch_array(MYSQLI_ASSOC);
                      
                      ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex mb-2">
                                <div class="d-block">
                                    <h5 class="card-title m-0"><?php echo $comp_data['name'] ?></h5>
                                    <p class="m-0">
                                        <small style="color: #06ad03;"><i class="far fa-calendar-check"></i> Active</small> - 
                                        <small class="text-muted">Starts on: <?php echo format_date($comp_data['start_date']) ?></small>
                                    </p>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle text-dark" href="#" role="button" id="menu1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menu1">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-share"></i> Share competition</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-bullhorn"></i> Report competition</a></li>
                                    </ul>
                                </div>                              
                            </div>
                            <div><?php echo substr($comp_data['comp_description'], 0, 179) ?>...</div>
                            <a class="btn btn-default" href="compinfo.php?comp_ID=<?php echo $comp_data['comp_ID'] ?>">View more</a>
                        </div>
                    </div>
                    <?php 
                       }
                      }
                      else{
                        echo "<h4 style='color: #203656;' class='text-center'><i style='font-size:50px;' class='fas fa-cat'></i> <br> No competitions!</h4>
                        <h4 class='text-center mt-3'><a href='signup.php' class='btn btn-default'>Start a new competition</a></h4>";
                      }
                    }

                  /** End of section to select all ongoing competitions **/
                      
                      ?>
                </div>
            </div>
            <div class="col-md-6" style="position: relative;">
                <div class="guideline">
                          <div class="d-flex justify-content-center"><p class="text-center m-0"><img width="400px" src="writerDashboard/images/Winners_Outline.svg" alt=""></p></div>
                          <h3 class="text-center">Get started on your competition</h3>
                          <p class="text-center text-muted fst-italic">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab, provident? Non, dolor!</p>
                          <div class="d-flex justify-content-center"><a href="#" class="btn btn-default" target="_blank">Learn More</a></div>
                </div>
            </div>
        </div>
    </div>


    <?php include 'footer.php' ?>
     <!-- canvas menu  -->
     <div class="canvas-menu d-flex align-items-end flex-column">
        <button class="btn-close" aria-label="Close" type="button"></button>

        <div class="logo">
            <img src="images/logo.svg" alt="">
        </div>
        <nav>
            <ul class="vertical-menu">
                <li><a href="index.php">Home</a></li>
                <li>
                    <a href="#">Categories</a>
                    <ul class="submenu">
                    <?php
                        //snippet to select categories
                        $cat_query = "SELECT category FROM categories";
                        $cat_res = $connection->query($cat_query);
                        if ($cat_res) {
                            $cat_numrows = $cat_res->num_rows;
                            if ($cat_numrows >= 1) {
                                for ($i=0; $i < $cat_numrows; $i++) { 
                                    $cat_res->data_seek($i);
                                    $cat_data = $cat_res->fetch_array(MYSQLI_ASSOC);
                                    echo "<li>
                                    <a href='categories.php?cat=$cat_data[category]'>$cat_data[category]</a>
                                    </li>";
                                }
                            }
                        }
                    ?>
                    </ul>
                </li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="login.php">Login</a></li>
                <li>
                    <a href="#" class="btn btn-default text-light">Become a writer</a>
                </li>
            </ul>
        </nav>
    </div>


    <!-- search pop up  -->
    <div class="search-popup">
        <button class="btn-close" aria-label="Close" type="button"></button>

        <div class="search-content">
            <div class="text-center">
                <h3 class="mb-4 mt-0">Press ESC to close</h3>
            </div>

            <form action="" class="d-flex search-form">
                <div class="search-first w-100">
                <input type="search" id="mysearch" placeholder="Search tags, categories, post titles..." aria-label="Search"
                    class="form-control me-2">
                    <div id="res_card" class="card d-none" style="border:1px solid #b4b2b2;max-height: 300px;overflow-y: auto;">
                        <div class="list-group">
                        </div>
                    </div>
                </div>
                    <!-- <button class="search icon-button ms-1">
                        <i class="icon-magnifier"></i>
                    </button> -->
            </form>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="js/jquery.sticky-sidebar.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/general.js"></script>
    <script>
        var sort_select = document.getElementById("sort_select")
        sort_select.addEventListener('change', ()=>{
            var myform = document.getElementById("sort_form")
            myform.submit()
        })
    </script>
</body>
</html>