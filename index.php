<?php
session_start();
include 'connection.php';
include 'functions.php';
$rand = rand();
$selector = "";

//Check if user is logged in and get user details
if (isset($_SESSION['w_email'])) {
    $selector = $_SESSION['w_email'];
}
$user_details = get_writer_details($connection, $selector);
include 'compdefaulterscheck.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
</head>

<body>
    <div class="site-wrapper">
        <div class="main-overlay"></div>
            <!-- Navbar component -->
        <?php include 'header.php'; ?>
        <!-- End of navbar component -->
        <!-- section starts  -->
        <section id="hero">
            <div class="container-xl">
                <div class="row gy-4">
                    <div class="col-lg-8">
                        <?php
                            $car_rows = 0;
                            $car_query = "SELECT P_ID, coverimg, title, date_created FROM posts WHERE published = 'yes' ORDER BY date_created DESC LIMIT 3";
                            $car_res = $connection->query($car_query);
                            if ($car_res) {
                                $car_rows = $car_res->num_rows;
                            }
                        ?>
                    <div id="carouselExampleCaptions" style="border-radius: 10px;" class="carousel slide mt-3" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <?php
                                for ($i=0; $i < $car_rows; $i++) {
                            ?>
                            <?php
                                if ($i == 0) {
                            ?>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $i ?>" class="active" aria-current="true" aria-label="Slide <?php echo $i ?>"></button>
                            <?php } 
                                else{
                            ?>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $i ?>" aria-label="Slide <?php echo $i ?>"></button>
                            <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="carousel-inner">
                            <?php
                                for ($i=0; $i < $car_rows; $i++) {
                                    $car_res->data_seek($i);
                                    $car_data = $car_res->fetch_array(MYSQLI_ASSOC); 
                                ?>
                            <?php
                                if ($i == 0) {
                                    ?>    
                            <div class="carousel-item active">
                                <div class="carimg-cover">
                                    <img src="<?php echo $car_data['coverimg'] ?>" class="d-block w-100 car-img" alt="...">
                                    <div class='overlay'>
                                    <div class="carousel-caption d-md-block text-left">
                                        <small class="car-date"><?php echo format_date($car_data['date_created']) ?></small>
                                        <a href="viewpost.php?pid=<?php echo base64_encode($car_data['P_ID']) ?>" class="car-title"><h3><?php echo $car_data['title'] ?></h3></a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                                else{
                            ?>
                            <div class="carousel-item">
                                <div class="carimg-cover">
                                    <img src="<?php echo $car_data['coverimg'] ?>" class="d-block w-100 car-img" alt="...">
                                    <div class='overlay'>
                                    <div class="carousel-caption d-md-block text-left">
                                        <small class="car-date"><?php echo format_date($car_data['date_created']) ?></small>
                                        <a href="viewpost.php?pid=<?php echo base64_encode($car_data['P_ID']) ?>" class="car-title"><h3><?php echo $car_data['title'] ?></h3></a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <?php
                            if ($selector == "") {
                                ?>
                        <div class="card mt-3">
                            <div class="card-header text-center bg-white">
                            <h5>Become a writer ✍️!</h5>
                            </div>
                            <div class="card-body">
                            <p class="text-center text-dark">Join one of the fastest rising content sharing platforms in Africa!</p>
                             <a style="width: 100%;" href="signup.php" target="_blank" class="btn btn-default">Create an account</a>
                          </div>
                        </div>
                        <?php
                            }
                            else{
                        ?>
                        <div class="card mt-3">
                            <div class="card-header text-center bg-white">
                            <h5>Start a competition 🏆!</h5>
                            </div>
                            <div class="card-body">
                            <p class="text-center text-dark">Host article/essay writing competitions on our platform easily and seamlessly !</p>
                             <a style="width: 100%;" href="writerdashboard/mycompetitions.php" target="_blank" class="btn btn-default">Start a competition</a>
                          </div>
                        </div>
                        <?php
                            }
                        ?>
                        <div class="card mt-3">
                            <div class="card-header text-center bg-white">
                            <a href="https://www.crowndidactic.com" target="_blank">
                            <img src="images/crownEdLogo.png" style="object-fit: cover;" width="80%" alt="">
                            </a>
                            </div>
                            <div class="card-body">
                            <p class="text-center text-dark">Advertise your school with crowndidactic. Sign up! for <strong>free</strong> and enjoy our sweet features.</p>
                            <a style="width: 100%;" href="https://www.crowndidactic.com/register" target="_blank" class="btn btn-dark">Sign up</a>  
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- main content  -->
        
        <section class="main-content">
            <div class="container-xl">   
                <!-- Trending articles section -->
                <div class="section-header">
                    <h5 class="section-title"><i class="far fa-chart-bar"></i> Trending</h5>
                </div>    
                <div class="row">
                    <div class="col-lg-8">
                    <div class="row">
                    <?php
                        $t_query = "SELECT P_ID, coverimg, W_email, title, category, excerpt, date_created FROM posts WHERE published = 'yes' ORDER BY no_of_likes DESC LIMIT 4";
                        $t_res = $connection->query($t_query);
                        if ($t_res) {
                            $t_numrows = $t_res->num_rows;
                            if ($t_numrows >= 1) {
                               for ($i=0; $i < $t_numrows; $i++) { 
                                   $t_res->data_seek($i);
                                   $t_data = $t_res->fetch_array(MYSQLI_ASSOC);
                                   $w_details = get_writer_details($connection, $t_data['W_email']);
                    ?>
                            <div class="col-sm-6 mb-3">
                                <div class="post">
                                    <a href="viewpost.php?pid=<?php echo base64_encode($t_data['P_ID']) ?>"><img decoding="async" class="ipost-img" src="<?php echo $t_data['coverimg']."?randomurl=$rand" ?>" alt=""></a>
                                    <div class="user mt-2">
                                        <ul class="list-inline" style="list-style-type: square !important;">
                                            <li class="list-inline-item"><a href="profile.php?wid=<?php echo base64_encode($w_details['email']) ?>"><img class="user-img" src="<?php echo $w_details['profilepic']."?randomurl=$rand" ?>" alt=""></a></li>
                                            <li class="list-inline-item"><a href="profile.php?wid=<?php echo base64_encode($w_details['email']) ?>"><small><?php echo "@".substr($w_details['firstname'], 0, 1).".".$w_details['lastname'] ?></small></a></li>
                                            <li class="list-inline-item"><a href="categories.php?cat=<?php echo $t_data['category'] ?>"><small>#<?php echo $t_data['category'] ?></small></a></li>
                                            <li class="list-inline-item"><small class="text-muted"><?php echo format_date($t_data['date_created']) ?></small></li>
                                        </ul>    
                                    </div>
                                    <h5 class="post-title mb-2 mt-1">
                                            <a href="viewpost.php?pid=<?php echo base64_encode($t_data['P_ID']) ?>">
                                            <?php 
                                            if (strlen($t_data['title']) > 50) {
                                                echo substr($t_data['title'], 0, 50)."...";
                                            }
                                            else echo $t_data['title'] ?></a>
                                    </h5>
                                    
                                </div>
                            </div>
                            <?php
                                }
                            }
                            else{
                                echo "<div class='col-sm-6 justify-content-center align-items-center'>
                                <div class='d-flex justify-content-center align-items-center'>
                                <lord-icon
                                    src='https://cdn.lordicon.com/tdrtiskw.json'
                                    trigger='loop'
                                    colors='primary:#335fbe,secondary:#335fbe'
                                    style='width:100px;height:100px'>
                                </lord-icon>
                                <h6 style='color: #203656;'>No posts here</h6>
                                <a href='signup.php' class='btn btn-default'>Become a writer</a>
                                </div>
                                </div>";
                            }
                        }
                            ?>
                            
                        </div>
                        <!-- End of trending articles section -->

                        <!-- All articles section -->
                        <div class="section-header mt-5">
                            <h5 class="section-title"><i class="fas fa-stream"></i> Explore</h5>
                        </div>
                        <div class="row">
                        <?php
                        $l_query = "SELECT P_ID, coverimg, W_email, title, category, excerpt, date_created FROM posts WHERE published = 'yes' ORDER BY date_created DESC LIMIT 20";
                        $l_res = $connection->query($l_query);
                        if ($l_res) {
                            $l_numrows = $l_res->num_rows;
                            if ($l_numrows >= 1) {
                               for ($i=0; $i < $l_numrows; $i++) { 
                                   $l_res->data_seek($i);
                                   $l_data = $l_res->fetch_array(MYSQLI_ASSOC);
                                   $pw_details = get_writer_details($connection, $l_data['W_email']);
                            ?>
                                <div class="hor-post mb-4">
                                    <div class="p-img">
                                    <a href="viewpost.php?pid=<?php echo base64_encode($l_data['P_ID']) ?>"><img class="ipost-img" src="<?php echo $l_data['coverimg']."?randomurl=$rand" ?>" alt=""></a>
                                        </div>
                                            <div class="p-details">
                                        <div class="user mt-2">
                                            <ul class="meta list-inline">
                                            <li class="list-inline-item"><a href="profile.php?wid=<?php echo base64_encode($pw_details['email']) ?>"><img class="user-img" src="<?php echo $pw_details['profilepic']."?randomurl=$rand" ?>" alt=""></a></li>
                                            <li class="list-inline-item"><a href="profile.php?wid=<?php echo base64_encode($pw_details['email']) ?>"><small><?php echo substr($pw_details['firstname'], 0, 1).". ".$pw_details['lastname'] ?></small></a></li>
                                            <li class="list-inline-item"><a href="categories.php?cat=<?php echo $l_data['category'] ?>"><small>#<?php echo $l_data['category'] ?></small></a></li>
                                            <li class="list-inline-item"><small class="text-muted"><?php echo format_date($l_data['date_created']) ?></small></li>
                                            </ul>    
                                        </div>
                                        <h5 class="post-title mb-2">
                                        <a href="viewpost.php?pid=<?php echo base64_encode($l_data['P_ID']) ?>">
                                        <?php 
                                            if (strlen($l_data['title']) > 60) {
                                                echo substr($l_data['title'], 0, 60)."...";
                                            }
                                            else echo $l_data['title'] ?>
                                        </a>
                                        </h5>
                                        <p class="excerpt mb-0 text-muted">
                                        <?php echo substr($l_data['excerpt'], 0, 80)."..." ?>
                                        </p>
                                    </div>
                            </div>
                            <?php
                                }
                                if ($l_numrows >= 20) {
                                     echo "<a href='categories.php?gen=latest' class='text-decoration-underline'>View more &rsaquo;&rsaquo;</a>";   
                                }                               
                            }
                            else{
                                echo "<div class='col-sm-6 justify-content-center align-items-center'>
                                <div class='d-flex justify-content-center align-items-center'>
                                <lord-icon
                                    src='https://cdn.lordicon.com/tdrtiskw.json'
                                    trigger='loop'
                                    colors='primary:#335fbe,secondary:#335fbe'
                                    style='width:100px;height:100px'>
                                </lord-icon>
                                <h6 style='color: #203656;'>No posts here</h6>
                                <a href='signup.php' class='btn btn-default'>Become a writer</a>
                                </div>
                                </div>";
                            }
                        }
                            ?>
                            
                        </div>
                         <!--End of all articles section  -->
                    </div>

                    
                    <!-- right part starts from here  -->
                    <div class="col-lg-4">
                            <div class="widget rounded">
                                <div class="widget-header text-center">
                                    <h3 class="widget-title">Newsletter</h3>
                                </div>
                                <div class="widget-content">
                                    <span class="newsletter-headline text-center mb-3">Join 100,000 subscribers</span>
                                        <div class="mb-2">
                                            <input type="email" id="sub-email" class="form-control w-100 text-center"
                                                placeholder="Email address...">
                                        </div>
                                        <button class="btn btn-default btn-full" id="sub-btn">Subscribe</button>
                                    <span class="newsletter-privacy text-center mt-3">
                                        By subscribing, you agree to our <a class="text-decoration-underline" href="termsofservice.php">Privacy policy</a>
                                    </span>
                                </div>
                            </div>
                            <div class="widget rounded">
                                <div class="widget-header text-center">
                                    <h3 class="widget-title">Tag Clouds</h3>
                                </div>
                                <div class="widget-content">
                                    <a href="categories.php?tag=softwar" class="tag">#Software</a>
                                    <a href="categories.php?tag=fashion" class="tag">#Fashion</a>
                                    <a href="categories.php?tag=finance" class="tag">#Finance</a>
                                    <a href="categories.php?tag=business" class="tag">#business</a>
                                    <a href="categories.php?tag=tech" class="tag">#tech</a>
                                    <a href="categories.php?tag=AI" class="tag">#AI</a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include 'footer.php' ?>
    </div>


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

    <!-- javascripts  -->
    <script src="js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="js/jquery.sticky-sidebar.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/general.js"></script>
</body>

</html>