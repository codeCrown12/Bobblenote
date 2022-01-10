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
include 'compdefaulterscheck.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
    <style>
        .team-socials a{
            color: #000;
            font-size: 20px;
        }
        img{
            object-fit: cover;
        }
        .side-img{
            /* border: 1px solid black; */
            width: 65%;
        }
        .section-body{
            font-size: 17px;
        }
        @media screen and (max-width: 700px){
            .side-img{
                width: 100%;
            }
        }
    </style>
</head>
<body>
     <!-- Navbar component -->
     <?php include 'header.php'; ?>
    <!-- End of navbar component -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-6">
                <div>
                    <h2>About Bobblenote</h2>
                    <p class="section-body">We create a space where individuals of various fields of study, different mindsets and thinking come to find content that reshapes expands their thinking. Here experts and up-and-comers alike delve into the core of any subject, bringing fresh perspectives to the body of knowledge.</p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="d-flex justify-content-center">
                    <img src="images/Content creation_Outline.svg" alt="" class="side-img">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 order-sm-last order-md-first">
                <div>
                    <img src="images/Startup_Outline.svg" alt="" class="side-img">
                </div>
            </div>
            <div class="col-sm-6 order-sm-first order-md-last">
                <div>
                    <h2>Avenue for growth for african writers 🖤</h2>
                    <p class="section-body">We are a platform proudly built by Africans for Africans dedicated to providing growth to content creators all over Africa. We serve as a pedestal for bringing both new and experienced content creators in Africa into the global spot light. And most of all we are passionate about the growth of Africa in general.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div>
                    <h2>Rewards for contributions to the body of knowledge</h2>
                    <p class="section-body">Bobblenote also allows it's users (individuals and companies) to host article/content writing competitions and reward winners with monetary prizes. This serves as a means of rewarding exceptional content creators for their contribution to the body of knowledge.</p>
                </div>
            </div>
            <div class="col-sm-6">
                <img src="images/Coins_Outline.svg" alt="" class="side-img">
            </div>
        </div>
    </div>
    <div class="container-fluid bg-light p-2 mt-5" style="border-top: 1px solid #e6e6e6;border-bottom: 1px solid #e6e6e6;">
        <div class="container">
            <h2 class="text-center mt-2 mb-0">Meet The Team</h2>
            <p class="text-center text-muted m-0">
                Let's meet Bobblenote's awesome team members
            </p>
            <div class="row mt-4 justify-content-center">
                <div class="col-sm-3">
                    <div class="card rounded-0 mb-4">
                        <img src="images/simon_image.jpg" height="250px" class="card-img-top rounded-0 w-100" alt="...">
                        <div class="card-body p-2">
                            <h6 class="card-title mt-1 mb-1">Simon Dickson</h6>
                            <p class="m-0">Front end Developer</p>
                            <div class="team-socials">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card rounded-0 mb-4">
                        <img src="images/king_image.jpg" height="250px" class="card-img-top rounded-0 w-100" alt="...">
                        <div class="card-body p-2">
                            <h6 class="card-title mt-1 mb-1">King Jacob</h6>
                            <p class="m-0">Back end Developer</p>
                            <div class="team-socials">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card rounded-0 mb-4">
                        <img src="images/cruz_image.jpg" height="250px" class="card-img-top rounded-0 w-100" alt="...">
                        <div class="card-body p-2">
                            <h6 class="card-title mt-1 mb-1">Onyeka Ikedinobi</h6>
                            <p class="m-0">Front end Developer</p>
                            <div class="team-socials">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-sm-3">
                    <div class="card rounded-0 mb-4">
                        <img src="images/posts/insp-1.jpg" class="card-img-top rounded-0 w-100" alt="...">
                        <div class="card-body p-2">
                            <h6 class="card-title mt-1 mb-1">John Doe</h6>
                            <p class="m-0">Writer</p>
                            <div class="team-socials">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-telegram"></i></a>
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <h6 class="text-center">Our Mission</h6>
                    <p class="text-center text-muted" style="font-style: italic; font-size: 15px;">
                    ❝ To make knowledge and insightful content available to everyone and to reward the creators of such content ❞
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php' ?>
     <!-- canvas menu  -->
     <div class="canvas-menu d-flex align-items-end flex-column">
        <button class="btn-close" aria-label="Close" type="button"></button>

        <div class="logo">
            <h1 style="font-family: 'Poetsen One', sans-serif;">Bobblenote</h1>
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
                <li><a href="competitions.php">Competitions</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php
                    if ($selector == "") {
                ?>
                <li><a href="login.php">Login</a></li>
                <li>
                    <a href="#" class="btn btn-default text-light">Sign up</a>
                </li>
                <?php
                    }
                ?>
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
</body>
</html>