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
    <title>
        <?php
            if ($writer_details['account_type'] == "individual") {
                echo $writer_details['firstname']." ".$writer_details['lastname'];
            }
            else echo $writer_details['organization_name'];
        ?>
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand ms-md-5 ms-sm-0" href="index.php"><h1>Bobblenote</h1></a>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto me-5">
            <?php
                if ($writer_details['twitter'] != "") {
                    echo "<li class='nav-item'> <a href='$writer_details[twitter]' class='nav-link'><i class='fab fa-twitter'></i></a></li>";
                }
                if ($writer_details['instagram'] != "") {
                    echo "<li class='nav-item'> <a href='$writer_details[instagram]' class='nav-link'><i class='fab fa-instagram'></i></a></li>";
                }
                if ($writer_details['linkedin'] != "") {
                    echo "<li class='nav-item'> <a class='nav-link' href='$writer_details[linkedin]'><i class='fab fa-linkedin'></i></a></li>";
                }
            ?>  
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
                <h5 style="margin-bottom: 8px; color:#203656;">
                <?php
                 if ($writer_details['account_type'] == "individual") {
                    echo $writer_details['firstname']." ".$writer_details['lastname'];
                 }
                 else echo $writer_details['organization_name'];
                 ?></h5>
                <p style="margin-bottom: 0px;"><?php echo $writer_details['bio'] ?></p>
                <div class="w-social-con">
                    <ul class="list-inline">
                        <?php
                            if ($writer_details['twitter'] != "") {
                                echo "<li class='list-inline-item'> <a href='$writer_details[twitter]' class='w-social'><i class='fab fa-twitter'></i></a></li>";
                            }
                            if ($writer_details['instagram'] != "") {
                                echo "<li class='list-inline-item'> <a href='$writer_details[instagram]' class='w-social'><i class='fab fa-instagram'></i></a></li>";
                            }
                            if ($writer_details['linkedin'] != "") {
                                echo "<li class='list-inline-item'> <a class='w-social' href='$writer_details[linkedin]'><i class='fab fa-linkedin'></i></a></li>";
                            }
                        ?>      
                    </ul>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="row">
                        <?php
                            $post_query = "SELECT P_ID, title, category, coverimg, date_created, excerpt FROM posts WHERE W_email = '$writer_details[email]' AND published = 'yes'";
                            $post_res = $connection->query($post_query);
                            if ($post_res) {
                                $pnum_rows = $post_res->num_rows;
                                if ($pnum_rows >= 1) {
                                    echo "<h5 class='mt-3 mb-3'>All articles (".numFormatter($pnum_rows).")</h5>";
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
                                    </div>
                                </div>
                                </div>
                        <?php
                            }
                        }
                        else{
                    ?>
                        <div class="d-flex justify-content-center mb-5 mt-3">
                          <div>
                            <img src="writerdashboard/images/Content creation_Monochromatic.svg" alt="" width="250px">
                            <p class="text-center m-0" style="font-size: 16px;">No Articles here yet</p>
                            <div class="d-flex justify-content-center"><button class="btn btn-default mt-2">Create an article</button></div>
                          </div>
                        </div>
                    <?php
                    }
                }
                    ?>
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
    </body>
</html>