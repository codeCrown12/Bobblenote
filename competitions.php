<?php
session_start();
include 'connection.php';
include 'functions.php';

$rand = rand();
$selector = "";

//Check if user is logged in
if (isset($_SESSION['w_email'])) {
    $selector = $_SESSION['w_email'];
}
//Get user details
$user_details = get_writer_details($connection, $selector);
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
                    <form action="">
                        <div class="">
                            <input type="search" placeholder="Search by competition name..." class="form-control">
                        </div>
                    </form>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-8">
                            <select name="" class="form-select" id="">
                                <option value="">-- Sort competitions by --</option>
                                <option value="">Latest (newly added)</option>
                                <option value="">Highest awards</option>
                            </select>
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
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Hello there!</strong> Learn more about competitions and our rules <a href="#" class="text-decoration-underline">Here</a>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="contents">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex mb-2">
                                <div class="d-block">
                                    <h5 class="card-title m-0">Penactive Competition</h5>
                                    <p class="m-0">
                                        <small style="color: #06ad03;"><i class="far fa-calendar-check"></i> Ongoing</small> - 
                                        <small class="text-muted">Started on: Sep 26 2021</small>
                                    </p>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle text-dark" href="#" role="button" id="menu1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menu1">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-bookmark"></i> Save competition</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-bullhorn"></i> Report competition</a></li>
                                    </ul>
                                </div>                              
                            </div>
                            <p>Lorem ipsum dolo,erspiciatis blanditiis sint voluptatum autem beatae dignissimos perferendis reprehenderit. Hic doloribus nisi fugiat perspiciatis nam quo voluptatibus a, sed optio...</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="position: relative;">
                <div class="description" style="position: sticky; top: 70px;">
                    <div class="card w-100">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title me-2">
                                    Penactive competition
                                </h5>
                                <button href="#" class="btn btn-default ms-auto">Join now</button>
                            </div>
                        </div>
                        <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                            <h6>Organizer</h6>
                            <div class="user mb-3">
                                <ul class="list-inline" style="list-style-type: square !important;">
                                    <li class="list-inline-item"><a href="#" target="_blank"><img class="user-img" src="images/other/default_dp.svg" alt=""></a></li>
                                    <li class="list-inline-item"><a href="#" target="_blank" class="text-dark"><small>Penactive group</small></a></li>
                                </ul>    
                            </div>
                            <div class="description">
                                <h6>Description</h6>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi fuga libero eaque voluptas reprehenderit non repellendus deleniti ipsa asperiores quos nisi, placeat blanditiis explicabo cumque? Autem in eveniet neque enim.</p>
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
                                <p><span style="color: #0044b3; font-weight: bold;">#penactive</span><br> <span>(Note: Please include this tag (without the '#' symbol) in the tags section when creating article you're writing for this competition)</span></p>
                            </div>
                        </div>
                    </div>
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
        
    </script>
</body>
</html>