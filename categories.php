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
$rand = rand();
include 'compdefaulterscheck.php';

//Posts filtering logic
$query = "SELECT P_ID, coverimg, W_email, title, category, excerpt, date_created FROM posts WHERE published = 'yes' ORDER BY P_ID DESC";;
$count_query = "SELECT COUNT(*) As total_records FROM posts WHERE published = 'yes' ORDER BY P_ID DESC";
$cap = "All posts";

if (isset($_GET['cat'])) {
    $cat = check_string($connection, $_GET['cat']);
    $cap = $cat;
    $query = "SELECT P_ID, coverimg, W_email, title, category, excerpt, date_created FROM posts WHERE category = '$cat' AND published = 'yes' ORDER BY P_ID DESC";
    $count_query = "SELECT COUNT(*) As total_records FROM posts WHERE category = '$cat' AND published = 'yes' ORDER BY P_ID DESC";
}
elseif (isset($_GET['tag'])) {
    $tag = check_string($connection, $_GET['tag']);
    $cap = "#$tag";
    $query = "SELECT P_ID, coverimg, W_email, title, category, excerpt, date_created FROM posts WHERE tags LIKE '%$tag%' AND published = 'yes' ORDER BY P_ID DESC";
    $count_query = "SELECT COUNT(*) As total_records FROM posts WHERE tags LIKE '%$tag%' AND published = 'yes' ORDER BY P_ID DESC";
}

/** Pagination logic here **/
if (isset($_GET['page_no']) && $_GET['page_no']!="") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}
$total_records_per_page = 10;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";
$total_no_of_pages = total_page_no($connection, $count_query, $total_records_per_page);
$second_last = $total_no_of_pages - 1; // total pages minus 1

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
            <h4 class="section-title" style="color: #203656;"><?php echo $cap ?></h4>
        </div>
            <div class="col-lg-8 col-md-12 mt-3">
            <?php
                        $result = $connection->query($query." LIMIT $offset, $total_records_per_page");
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
                <a href="viewpost.php?pid=<?php echo base64_encode($data['P_ID']) ?>"><img decoding="async" loading="lazy" class="ipost-img" src="<?php echo $data['coverimg']."?randomurl=$rand" ?>" alt=""></a>
                    </div>
                        <div class="p-details">
                     <div class="user mt-2">
                        <ul class="meta list-inline">
                        <li class="list-inline-item"><a href="profile.php?wid=<?php echo base64_encode($w_details['email']) ?>" target="_blank"><img decoding="async" loading="lazy" class="user-img" src="<?php echo $w_details['profilepic']."?randomurl=$rand" ?>" alt=""></a></li>
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
            ?>
            <div class="d-flex justify-content-center align-items-center mt-5">
                <p class="m-0"><strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong></p>
                <nav aria-label="Page navigation example" class="ms-auto">
                    <ul class="pagination">    
                    <li class="page-item <?php if($page_no <= 1){ echo "disabled"; } ?>">
                        <a class="page-link" <?php if($page_no > 1){
                        echo "href='?page_no=$previous_page'";
                        } ?>>Previous</a>
                        </li> 
                        <?php
                            if ($total_no_of_pages <= 10){  	 
                                for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                                if ($counter == $page_no) {
                                echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
                                        }else{
                                    echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                            }
                                    }
                            }
                            elseif ($total_no_of_pages > 10){
                                if($page_no <= 4) {			
                                    for ($counter = 1; $counter < 8; $counter++){		 
                                        if ($counter == $page_no) {
                                          echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
                                        } 
                                        else{
                                            echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                        }
                                   }
                                   echo "<li class='page-item'><a>...</a></li>";
                                   echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last'>$second_last</a></li>";
                                   echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                                }
                                elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
                                    echo "<li class='page-item'><a class='page-link' href='?page_no=1'>1</a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='?page_no=2'>2</a></li>";
                                    echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                    for (
                                         $counter = $page_no - $adjacents;
                                         $counter <= $page_no + $adjacents;
                                         $counter++
                                         ) {		
                                        if ($counter == $page_no) {
                                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
                                        }
                                        else{
                                            echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                        }                  
                                    }
                                    echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last'>$second_last</a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                                }
                                else{
                                    echo "<li class='page-item'><a class='page-link' href='?page_no=1'>1</a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='?page_no=2'>2</a></li>";
                                    echo "<li class='page-item'><a class='page-link'>...</a></li>";
                                    for (
                                        $counter = $total_no_of_pages - 6;
                                        $counter <= $total_no_of_pages;
                                        $counter++
                                        ) {
                                        if ($counter == $page_no) {
                                            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
                                        }
                                        else{
                                            echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                        }                   
                                    }
                                }
                            }
                        ?>
                        <li class="page-item <?php if($page_no >= $total_no_of_pages){
                        echo "disabled";
                        } ?>">
                        <a class="page-link" <?php if($page_no < $total_no_of_pages) {
                        echo "href='?page_no=$next_page'";
                        } ?>>Next</a>
                        </li>
                        <?php if($page_no < $total_no_of_pages){
                            echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                        } ?>
                    </ul>
                </nav>
            </div>
            <?php
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
                                    <span class="newsletter-headline text-center mb-3">Join the early subscribers</span>
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
    <!-- javascripts  -->
    <script src="js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="js/jquery.sticky-sidebar.min.js"></script>
    <script src="js/pagination.js"></script>
    <script src="js/main.js"></script>
    <script src="js/general.js"></script>
</body>
</html>