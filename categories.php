<?php
session_start();
include 'connection.php';
include 'functions.php';

$selector = "";

//Check if user is logged in and get user details
if (isset($_SESSION['w_email'])) {
    $selector = $_SESSION['w_email'];
}
$user_details = get_writer_details($connection, $selector);
include 'compdefaulterscheck.php';

//Posts filtering logic
$query = "SELECT P_ID, coverimg, W_email, title, category, excerpt, date_created FROM posts WHERE published = 'yes' ORDER BY P_ID DESC";;
$cap = "All posts";
$rand = rand();

if (isset($_GET['cat'])) {
    $cat = check_string($connection, $_GET['cat']);
    $cap = $cat;
    $query = "SELECT P_ID, coverimg, W_email, title, category, excerpt, date_created FROM posts WHERE category = '$cat' AND published = 'yes'";
}
elseif (isset($_GET['tag'])) {
    $tag = check_string($connection, $_GET['tag']);
    $cap = "#$tag";
    $query = "SELECT P_ID, coverimg, W_email, title, category, excerpt, date_created FROM posts WHERE tags LIKE '%$tag%' AND published = 'yes'";
}
elseif (isset($_GET['gen']) && $_GET['gen'] == "trending") {
    $cap = "#Trending";
    $query = "SELECT P_ID, coverimg, W_email, title, category, excerpt, date_created FROM posts WHERE published = 'yes' ORDER BY no_of_likes DESC";
}
elseif (isset($_GET['gen']) && $_GET['gen'] == "latest") {
    $cap = "#Latest";
    $query = "SELECT P_ID, coverimg, W_email, title, category, excerpt, date_created FROM posts WHERE published = 'yes' ORDER BY date_created DESC";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $cap ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Navbar component -->
    <?php include 'header.php'; ?>
    <!-- End of navbar component -->
    <div class="container">
        <div class="row">
        <div class="section-header mt-2">
            <h2 class="section-title" style="color: #203656;"><?php echo $cap ?></h2>
        </div>
            <div class="col-lg-8 col-md-12 mt-3">
            <?php
                        $result = $connection->query($query);
                        if ($result) {
                            $numrows = $result->num_rows;
                            if ($numrows >= 1) {
                               for ($i=0; $i < $numrows; $i++) { 
                                   $result->data_seek($i);
                                   $data = $result->fetch_array(MYSQLI_ASSOC);
                                   $w_details = get_writer_details($connection, $data['W_email']);
                            ?>
            <div class="hor-post mb-4">
                <div class="p-img">
                <a href="viewpost.php?pid=<?php echo base64_encode($data['P_ID']) ?>"><img class="ipost-img" src="<?php echo $data['coverimg']."?randomurl=$rand" ?>" alt=""></a>
                    </div>
                        <div class="p-details">
                     <div class="user mt-2">
                        <ul class="meta list-inline">
                        <li class="list-inline-item"><a href="profile.php?wid=<?php echo base64_encode($w_details['email']) ?>" target="_blank"><img class="user-img" src="<?php echo $w_details['profilepic']."?randomurl=$rand" ?>" alt=""></a></li>
                        <li class="list-inline-item"><a href="profile.php?wid=<?php echo base64_encode($w_details['email']) ?>" target="_blank"><small><?php echo substr($w_details['firstname'], 0, 1).". ".$w_details['lastname'] ?></small></a></li>
                        <li class="list-inline-item"><a href="categories.php?cat=<?php echo $data['category'] ?>"><small>#<?php echo $data['category'] ?></small></a></li>
                        <li class="list-inline-item"><small class="text-muted"><?php echo format_date($data['date_created']) ?></small></li>
                        </ul>    
                     </div>
                     <h5 class="post-title mb-2">
                      <a href="viewpost.php?pid=<?php echo base64_encode($data['P_ID']) ?>">
                      <?php 
                        if (strlen($data['title']) > 60) {
                            echo substr($data['title'], 0, 60)."...";
                        }
                        else echo $data['title'] ?>
                      </a>
                       </h5>
                       <p class="excerpt mb-0 text-muted">
                       <?php echo substr($data['excerpt'], 0, 80)."..." ?>
                    </p>
                </div>
            </div>
            <?php
                    }
                }
                else{
                    echo "<h4 style='color: #203656;' class='text-center'><i style='font-size:50px;' class='fas fa-cat'></i> <br> No posts here yet!</h4>
                    <h4 class='text-center mt-3'><a href='signup.php' class='btn btn-default'>Become a writer</a></h4>";
                }
            }
            ?>
            </div>
            <div class="col-lg-4 col-md-12 mt-3">
            <div class="card">
                <div class="card-header text-center bg-white p-3">
                   <h5 class="card-title m-0 text-dark">Start a competition 🏆!</h5>
                </div>
                <div class="card-body">
                  <p class="text-center text-dark">Host article/essay writing competitions on our platform easily and seamlessly !</p>
                  <a style="width: 100%;" href="writerdashboard/mycompetitions.php" target="_blank" class="btn btn-default">Start a competition</a>
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
                    <a href="#" class="active">Categories</a>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="js/jquery.sticky-sidebar.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/general.js"></script>
</body>
</html>