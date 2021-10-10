<?php
include 'connection.php';
include 'functions.php';

$wid = "";
$rand = rand();

if (isset($_GET['wid'])) {
    $wid = check_string($connection, base64_decode($_GET['wid']));
}

$writer_details = get_writer_details($connection, $wid);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand ms-md-5 ms-sm-0" href="index.php"><img src="images/logo.svg" alt=""></a>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto me-5">
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fab fa-twitter"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fab fa-instagram"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fab fa-facebook"></i></a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    <div class="container">
        <div class="user-contain">
            <div class="user-image">
                <img class="dp-image" src="<?php echo $writer_details['profilepic']."?randomurl=$rand" ?>" alt="">
            </div>
            <div class="user-info">
                <h5 style="margin-bottom: 8px; color:#203656;"><?php echo $writer_details['firstname']." ".$writer_details['lastname'] ?></h5>
                <p style="margin-bottom: 0px;"><?php echo $writer_details['bio'] ?></p>
                <div class="w-social-con">
                    <ul class="list-inline">
                        <li class="list-inline-item"> <a href="#" class="w-social"><i class="fab fa-facebook"></i></a></li>
                        <li class="list-inline-item"> <a href="#" class="w-social"><i class="fab fa-twitter"></i></a></li>
                        <li class="list-inline-item"> <a href="#" class="w-social"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="row">
                    <?php
                        $gal_query = "SELECT imgurl, caption FROM gallery WHERE w_email = '$writer_details[email]'";
                        $gal_res = $connection->query($gal_query);
                        if ($gal_res) {
                            $num_rows = $gal_res->num_rows;
                            if ($num_rows >= 1) {
                                echo "<h5 class='mt-3 mb-3'>Gallery (".numFormatter($num_rows).")</h5>";
                                for ($i=0; $i < $num_rows; $i++) { 
                                    $gal_res->data_seek($i);
                                    $gal_data = $gal_res->fetch_array(MYSQLI_ASSOC);
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="img-cover">
                            <img class="gal-img" src="<?php echo $gal_data['imgurl']."?randomurl=$rand" ?>" alt="" srcset="">
                            <div class='overlay'>
                                <div class='text'><?php echo $gal_data['caption'] ?></div>
                            </div>
                        </div>
                    </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
                <div class="row">
                        <?php
                            $post_query = "SELECT P_ID, title, category, coverimg, date_created, excerpt FROM posts WHERE W_email = '$writer_details[email]' AND published = 'yes'";
                            $post_res = $connection->query($post_query);
                            if ($post_res) {
                                $pnum_rows = $post_res->num_rows;
                                if ($pnum_rows >= 1) {
                                    echo "<h5 class='mt-3 mb-3'>All posts (".numFormatter($pnum_rows).")</h5>";
                                    for ($i=0; $i < $pnum_rows; $i++) { 
                                        $post_res->data_seek($i);
                                        $post_data = $post_res->fetch_array(MYSQLI_ASSOC);
                        ?>
                                <div class="col-sm-4 mb-4">
                                <div class="post">
                                    <div class="p-img">
                                        <a target="_blank" href="viewpost.php?pid=<?php echo base64_encode($post_data['P_ID']) ?>"><img class="ipost-img" src="<?php echo $post_data['coverimg']."?randomurl=$rand" ?>" alt=""></a>
                                    </div>
                                    <div class="p-details mt-3">
                                        <small><?php echo format_date($post_data['date_created']) ?> &nbsp; <span class="post-cat"><a href="categories.php?cat=<?php echo $post_data['category'] ?>">#<?php echo $post_data['category'] ?></a></span> </small><br>
                                        <h5 class="post-title mt-2" >
                                            <a target="_blank" href="viewpost.php?pid=<?php echo base64_encode($post_data['P_ID']) ?>">
                                            <?php
                                            if (strlen($post_data['title']) > 50) {
                                                echo substr($post_data['title'], 0, 50)."...";
                                            }
                                            else echo $post_data['title'] ?></a>
                                        </h5>
                                        <p><?php echo substr($post_data['excerpt'], 0, 50)."..."  ?></p>
                                    </div>
                                </div>
                                </div>
                        <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>  
  <div id="myModal" class="cusmodal">

    <!-- The Close Button -->
    <span class="close">&times;</span>
  
    <!-- Modal Content (The Image) -->
    <img class="mymodal-content" id="img01">
  
    <!-- Modal Caption (Image Text) -->
    <div id="caption"></div>
  </div>
  
  <footer>
    <div class="container-xl">
        <div class="footer-inner">
            <div class="row d-flex align-items-center gy-4">
                <div class="col-md-4">
                    <span class="copyright">&copy; 2021 Acutelearn</span>
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
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fab fa-itunes"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fab fa-youtube"></i>
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
        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/slick.min.js"></script>
        <script src="js/jquery.sticky-sidebar.min.js"></script>
        <script src="js/profile.js"></script>
    </body>
</html>