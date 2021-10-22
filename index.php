<?php
include 'connection.php';
include 'functions.php';
$rand = rand();
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
</head>

<body>
    <div class="site-wrapper">
        <div class="main-overlay"></div>
        <header class="header-default">
            <nav class="navbar navbar-expand-lg">
                <div class="container-xl">
                    <!-- logo  -->
                    <a href="index.php" class="navbar-brand">
                        <img src="images/logo.svg" alt="">
                    </a>

                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a href="index.html" class="nav-link">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle">Categories</a>
                                <ul class="dropdown-menu">
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
                                                  <a href='categories.php?cat=$cat_data[category]' class='dropdown-item'>$cat_data[category]</a>
                                                    </li>";
                                               }
                                            }
                                        }
                                    ?>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Contact</a>
                            </li>
                            
                        </ul>
                        <!-- <img src="images/moon.png" id="icon"> -->
                    </div>

                    <!-- right side of header  -->
                    <div class="header-right">
                        <!-- buttons  -->
                        <div class="header-buttons">
                            <a href="login.php" class="btn btn-default btn-write">Login</a>
                            <a href="signup.php" class="btn btn-default btn-write">Become a writer</a>
                            <button class="search icon-button">
                            <i class="icon-magnifier"></i>
                        </button>
                        <button class="burger-menu icon-button">
                            <span class="burger-icon"></span>
                        </button>
                        </div>
                    </div>
                </div>
            </nav>


        </header>



        <!-- section starts  -->
        <section id="hero">
            <div class="container-xl">
                <div class="row gy-4">
                    <div class="col-lg-8">
                    <div id="carouselExampleCaptions" style="border-radius: 10px;" class="carousel slide mt-3" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="carimg-cover">
                                    <img src="images/posts/featured-lg.jpg" class="d-block w-100 car-img" alt="...">
                                    <div class='overlay'>
                                    <div class="carousel-caption d-md-block text-left">
                                        <small class="car-date">26 May 2021</small>
                                        <a href="" class="car-title" target="_blank"><h3>Bitcoin prices surpasses all time high in recent trends</h3></a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <a href="" target="_blank">
                                <div class="carimg-cover">
                                    <img src="images/posts/kingsjacobfrancis@gmail.com2021-09-081489592566.png" class="d-block w-100 car-img" alt="...">
                                    <div class='overlay'>
                                    <div class="carousel-caption d-md-block text-left">
                                        <small class="car-date">26 May 2021</small>
                                        <a href="" class="car-title" target="_blank"><h3>Bitcoin prices surpasses all time high in recent trends</h3></a>
                                    </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="carousel-item">
                            <div class="carimg-cover">
                                    <img src="images/posts/kingsjacobfrancis@gmail.com2021-09-081724339386.png" class="d-block w-100 car-img" alt="...">
                                    <div class='overlay'>
                                    <div class="carousel-caption d-md-block text-left">
                                        <small class="car-date">26 May 2021</small>
                                        <a href="" class="car-title" target="_blank"><h3>Bitcoin prices surpasses all time high in recent trends</h3></a>
                                    </div>
                                    </div>
                                </div>
                            </div>
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
                        <div class="card mt-3">
                            <div class="card-header text-center bg-white">
                            <h5>Some random ad here</h5>
                            </div>
                            <div class="card-body">
                            <p class="text-center text-dark">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Perspiciatis rem facere voluptateem esse!</p>
                            <!-- <a style="width: 100%;" href="https://www.crowndidactic.com/register" target="_blank" class="btn btn-default">Become a writer</a>   -->
                          </div>
                        </div>
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
                <div class="row">
                    <div class="col-lg-8">
                    <div class="section-header">
                <h3 class="section-title">Trending Posts</h3>
            </div>
            <div class="row">
                    <?php
                        $t_query = "SELECT P_ID, coverimg, W_email, title, category, excerpt, date_created FROM posts ORDER BY no_of_likes DESC LIMIT 4";
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
                                <div class="post mt-2">
                                    <a href="viewpost.php?pid=<?php echo base64_encode($t_data['P_ID']) ?>"><img decoding="async" class="ipost-img" src="<?php echo $t_data['coverimg']."?randomurl=$rand" ?>" alt=""></a>
                                    <div class="user mt-3">
                                        <ul class="list-inline" style="list-style-type: square !important;">
                                            <li class="list-inline-item"><a href="profile.php?wid=<?php echo base64_encode($w_details['email']) ?>" target="_blank"><img class="user-img" src="<?php echo $w_details['profilepic']."?randomurl=$rand" ?>" alt=""></a></li>
                                            <li class="list-inline-item"><a href="profile.php?wid=<?php echo base64_encode($w_details['email']) ?>" target="_blank"><small><?php echo substr($w_details['firstname'], 0, 1).". ".$w_details['lastname'] ?></small></a></li>
                                            <li class="list-inline-item"><a href="categories.php?cat=<?php echo $t_data['category'] ?>"><small>#<?php echo $t_data['category'] ?></small></a></li>
                                            <li class="list-inline-item"><small><?php echo format_date($t_data['date_created']) ?></small></li>
                                        </ul>    
                                    </div>
                                    <h5 class="post-title mb-2 mt-3">
                                            <a href="viewpost.php?pid=<?php echo base64_encode($t_data['P_ID']) ?>">
                                            <?php 
                                            if (strlen($t_data['title']) > 50) {
                                                echo substr($t_data['title'], 0, 50)."...";
                                            }
                                            else echo $t_data['title'] ?></a>
                                    </h5>
                                    <p class="excerpt mb-0">
                                        <?php echo substr($t_data['excerpt'], 0, 80)."..." ?>
                                    </p>
                                </div>
                            </div>
                            <?php
                                }
                            }
                        }
                            ?>
                            <div class="col-sm-6">
                                <a href="categories.php?gen=trending" class="v-all">View more posts &rsaquo;&rsaquo;</a>
                            </div>
                        </div> 
                        <div class="section-header mt-5">
                            <h3 class="section-title">Latest Posts</h3>
                        </div>
                        <div class="row justify-content-center mt-4">
                            <div class="col-sm-12">
                            <?php
                        $l_query = "SELECT P_ID, coverimg, W_email, title, category, excerpt, date_created FROM posts ORDER BY date_created DESC LIMIT 8";
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
                                        <a href="viewpost.php?pid=<?php echo base64_encode($l_data['P_ID']) ?>"><img decoding="async" class="ipost-img" src="<?php echo $l_data['coverimg']."?randomurl=$rand" ?>" alt=""></a>
                                    </div>
                                    <div class="p-details">
                                        <div class="user mt-2">
                                            <ul class="meta list-inline" style="list-style-type: square;">
                                                <li class="list-inline-item"><a href="profile.php?wid=<?php echo base64_encode($pw_details['email']) ?>" target="_blank"><img class="user-img" src="<?php echo $pw_details['profilepic']."?randomurl=$rand" ?>" alt=""></a></li>
                                                <li class="list-inline-item"><a href="profile.php?wid=<?php echo base64_encode($pw_details['email']) ?>" target="_blank"><small><?php echo substr($pw_details['firstname'], 0, 1).". ".$pw_details['lastname'] ?></small></a></li>
                                                <li class="list-inline-item"><a href="categories.php?cat=<?php echo $l_data['category'] ?>" target="_blank"><small>#<?php echo $l_data['category'] ?></small></a></li>
                                                <li class="list-inline-item"><small><?php echo format_date($l_data['date_created']) ?></small></li>
                                            </ul>    
                                        </div>
                                        <h5 class="post-title mb-2">
                                                <a href="viewpost.php?pid=<?php echo base64_encode($l_data['P_ID']) ?>">
                                                <?php 
                                                if (strlen($l_data['title']) > 50) {
                                                    echo substr($l_data['title'], 0, 50)."...";
                                                }
                                            else echo $l_data['title'] ?></a></a>
                                        </h5>
                                        <p class="excerpt mb-0">
                                           <?php echo substr($l_data['excerpt'], 0, 80)."..." ?>
                                        </p>
                                    </div>
                                </div>
                                <?php
                                }
                            }
                        }
                            ?>
                            <a href="categories.php?gen=latest" class="mt-5 v-all">View more posts &rsaquo;&rsaquo;</a>
                            </div>
                        </div>
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
                                        By signing up, you agree to our <a href="#">Privacy policy</a>
                                    </span>
                                </div>
                            </div>
                            <div class="widget rounded">
                                <div class="widget-header text-center">
                                    <h3 class="widget-title">Tag Clouds</h3>
                                </div>
                                <div class="widget-content">
                                    <a href="categories.php?tag=cooking" class="tag">#Cooking</a>
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
        <footer>
            <div class="container-xl">
                <div class="footer-inner">
                    <div class="row d-flex align-items-center gy-4">
                        <div class="col-md-4">
                            <span class="copyright">&copy; 2021 Edulearn</span>
                        </div>
                        <div class="col-md-4 text-center">
                            <ul class="social-icons list-unstyled list-inline mb-0">
                                <li class="list-inline-item">
                                    <a href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#">
                                        <i class="fab fa-telegram"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <a href="#" id="return-to-top" class="float-md-end">
                                <i class="icon-arrow-up"></i>
                                Back to Top
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>




    </div>


    <!-- canvas menu  -->
    <div class="canvas-menu d-flex align-items-end flex-column">
        <button class="btn-close" aria-label="Close" type="button"></button>

        <div class="logo">
            <img src="images/logo.svg" alt="">
        </div>
        <nav>
            <ul class="vertical-menu">
                <li class="active"><a href="index.php">Home</a></li>
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
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="login.php">Login</a></li>
                <li>
                    <a href="signup.php" class="btn btn-default text-light">Become a writer</a>
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

    <!-- javascripts  -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/jquery.sticky-sidebar.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(document).ready(function(){
            $("#sub-btn").click(function(e) {
                e.preventDefault();
                var email = $("#sub-email").val()
                if (email == "") {
                    Swal.fire({
                        title: 'Error!',
                        text: "Field is required",
                        icon: 'error',
                    })
                } 
                else{
                    $.ajax({
                        type: 'POST',
                        url: 'addsub.php',
                        data: { subemail: email }
                    }).done(function(msg) {
                        if (msg == "Subscription successful") {
                            Swal.fire({
                            title: 'Success!',
                            text: msg,
                            icon: 'success',
                            })   
                        }
                        else{
                            Swal.fire({
                            title: 'Error!',
                            text: msg,
                            icon: 'error',
                            })   
                        }
                    }).fail(function(msg){
                        Swal.fire({
                            title: 'Error!',
                            text: "Error in connection",
                            icon: 'error',
                        })
                    })
                }
            })

            $("#mysearch").keyup(function(e){
                e.preventDefault()
                value = $("#mysearch").val()
                if (value != "") {
                    $("#res_card").removeClass("d-none")
                    $.ajax({
                        type: 'POST',
                        url: 'searchlogic.php',
                        data: {search: value}
                    }).done(function(val){
                            // console.log(val)
                            $(".list-group").html(val)                        
                    }).fail(function(e){
                        Swal.fire({
                            title: 'Error!',
                            text: "Error in connection",
                            icon: 'error',
                        })
                    })
                }
                else{
                    $("#res_card").addClass("d-none")
                }
            })
        })
    </script>
</body>

</html>