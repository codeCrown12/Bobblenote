<?php
session_start();
include 'connection.php';
include 'functions.php';

$pid = "";
$rand = rand();

if (isset($_GET['pid'])) {
    $pid = check_string($connection, base64_decode($_GET['pid']));
}
$post_details = get_post_details($connection, $pid);
$writer_details = get_writer_details($connection, $post_details['W_email']);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <title><?php echo $post_details['title'] ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/viewpost.css">
    </head>
<body>
    <header class="header-default">
        <nav class="navbar navbar-expand-lg">
            <div class="container-xl">
                <!-- logo  -->
                <a href="index.php" class="navbar-brand">
                    <img src="images/logo.svg" alt="">
                </a>

                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">Home</a>
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
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="post-img">  
                            <img src="<?php echo $post_details['coverimg']."?randomurl=$rand" ?>" alt="" class="c-img">
                        </div>
                        <div class="post-body">
                            <div>
                                <h4 class="post-title mt-3"><?php echo $post_details['title'] ?></h4>
                                <div class="user">
                                    <a href="profile.php?wid=<?php echo base64_encode($writer_details['email']) ?>" target="_blank"><img src="<?php echo $writer_details['profilepic']."?randomurl=$rand" ?>" alt="" class="u-img"></a>
                                    <a href="profile.php?wid=<?php echo base64_encode($writer_details['email']) ?>" target="_blank"><p class="post-time"><?php echo $writer_details['firstname']." ".$writer_details['lastname'] ?> | <?php echo format_date($post_details['date_created']) ?></p></a>
                                </div>
                                <p class="post-text"><?php echo $post_details['content'] ?></p>
                                <h6>Tags</h6>
                                <p style="color: #686868;font-size: 14px !important;">
                                    <?php
                                        $tags_arr = explode(",", $post_details['tags']);
                                        for ($i=0; $i < sizeof($tags_arr); $i++) { 
                                            echo "<span class='post-tag'><a href='categories.php?tag=$tags_arr[$i]'>#".$tags_arr[$i]."</a></span> ";
                                        }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="social-interact">
                            <div class="section-like">
                                <div class="fs-6 mytooltip" id="likebtn"><i class="far fa-thumbs-up"></i>&nbsp; <?php 
                                    echo numFormatter($post_details['no_of_likes']);
                                    ?>
                                </div>
                            <span class="d-none" id="postid" data-id="<?php echo $pid ?>" data-likes="<?php echo $post_details['no_of_likes'] ?>"></span>
                            </div>
                            <div class="section-share">
                                <a href="#" class="share-link"><i class="fab fa-facebook"></i></a>
                                <a title="share to twitter" href="#" class="share-link"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="share-link"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="share-link"><i class="fab fa-telegram"></i></a>
                                <a href="#" class="share-link"><i class="fab fa-whatsapp"></i></a>
                            </div>
                        </div>
                        <div class="comments-section">
                            <h6>COMMENTS (<?php echo numFormatter($post_details['no_of_comments']) ?>)</h6>
                            <p>Add a comment</p>
                            <form>
                                <div class="form-group">
                                    <input type="text" id="name" class="form-control" placeholder="Full Name">
                                    <input type="text" id="prev_val" value="<?php echo $post_details['no_of_comments']; ?>" class="form-control" hidden>
                                    <input type="text" id="pid" value="<?php echo $post_details['P_ID']; ?>" hidden>
                                </div>
                                <div class="form-group mt-3">
                                    <small>(Not more than 280 characters)</small>
                                    <Textarea class="form-control" id="comment" placeholder="Share your thoughts..." rows="5"></Textarea>
                                </div>
                                <div class="mt-3 sub-btn">
                                    <button class="btn btn-default" id="btn-com">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="all-comments">
                            <h6>All Comments</h6>
                            <?php
                                $query = "SELECT name, comment_text, date_created FROM comments WHERE P_ID = $pid";
                                $result = $connection->query($query);
                                $num_rows = $result->num_rows;
                                if ($num_rows >= 1) {
                                    for ($i=0; $i < $num_rows; $i++) { 
                                        $result->data_seek($i);
                                        $data = $result->fetch_array(MYSQLI_ASSOC);
                            ?>
                            <div class="com-content">
                                <p class="com-head"><?php echo $data['name']. " - ".format_date($data['date_created']) ?></p>
                                <p class="com-body"><?php echo $data['comment_text']; ?></p>
                            </div>
                            <?php
                                }
                            }
                            else{
                                echo "<h5> No comments here! </h5>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mt-4">
                    <div class="card-header text-center bg-white">
                    <a href="https://www.crowndidactic.com" target="_blank">
                    <img src="images/crownEdLogo.png" style="object-fit: cover;" width="80%" alt="">
                    </a>
                    </div>
                    <div class="card-body p-3">
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

    <!-- canvas menu  -->
    <div class="canvas-menu d-flex align-items-end flex-column">
        <button class="btn-close" aria-label="Close" type="button"></button>

        <div class="logo">
            <img src="images/logo.svg" alt="">
        </div>
        <nav>
            <ul class="vertical-menu">
                <li class="active"><a href="index.html">Home</a></li>
                <li>
                    <a href="#">Categories</a>
                    <ul class="submenu">
                        <li><a href="#">Fashion</a></li>
                        <li><a href="#">Education</a></li>
                        <li><a href="#">Sports</a></li>
                        <li><a href="#">Technology</a></li>
                        <li><a href="#">Finance</a></li>
                    </ul>
                </li>
                <li><a href="#">About Us</a></li>
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
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/slick.min.js"></script>
        <script src="js/jquery.sticky-sidebar.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            $(document).ready(function(){

                //Snippet to check if a session has been created
                var check = "check"
                $.ajax({
                    type: 'POST',
                    url: 'readersession.php',
                    data: {check: check}
                }).done(function(msg){
                    if (msg == "false") {
                        Swal.fire({
                            title: 'Start session',
                            icon: 'info',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                            html: `<small>Session allows us to keep track of the posts you like.<br>To start your session please verify your email. <br> <strong>Note: </strong>Ensure your email is valid.</small><br>
                            <input type="email" id="email" class="swal2-input mb-1" placeholder="Email address...">
                            `,
                            confirmButtonText: 'Start session',
                            focusConfirm: false,
                            preConfirm: () => {
                                const email = Swal.getPopup().querySelector('#email').value
                                if (!email) {
                                    Swal.showValidationMessage(`Please enter a valid email address`)
                                }
                                return { email: email }
                            }
                            }).then((result) => {
                                    email = result.value.email
                                    $.ajax({
                                        type: 'POST',
                                        url: 'readersession.php',
                                        data: {v_email: email}
                                    }).done(function(msg){
                                        if (msg == "session started") {
                                            Swal.fire({
                                            title: 'Success!',
                                            text: msg,
                                            icon: 'success',
                                            showCancelButton: false
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    location.reload()
                                                }
                                            })
                                        }
                                        else{
                                            Swal.fire(
                                            'Error!',
                                            msg,
                                            'error'
                                            )
                                        }
                                    }).fail(function(){
                                        Swal.fire(
                                        'Error!',
                                         'Error in connection',
                                        'error'
                                        )
                                    })
                                })
                    }
                    else{
                        var pid = $("#postid").attr('data-id');
                        var likebtn = $("#likebtn")
                        $.ajax({
                            type: 'POST',
                            url: 'readersession.php',
                            data: {pid: pid}
                        }).done(function(msg){
                            if (msg == "true") {
                                likebtn.addClass("liked")
                            }
                        }).fail(function(msg){
                            console.log("error occured")
                        })
                    }
                })
                
                //Snippet to like post
                var likebtn = $("#likebtn")
                likebtn.click(function(e){
                    e.preventDefault()
                    if (!likebtn.hasClass("liked")) {
                        var pid = $("#postid").attr('data-id');
                        var prev_val = $("#postid").attr('data-likes');
                        $.ajax({
                            type: 'POST',
                            url: 'addlike.php',
                            data: {pid: pid, prev_val: prev_val}
                        }).done(function(val){
                            if (val != "Error in connection!") {
                                likebtn.addClass("liked")
                                likebtn.html("<i class='far fa-thumbs-up'></i>&nbsp; "+val)
                                $("#postid").attr('data-likes', val)
                            }
                        }).fail(function(){
                            console.log("Error in connection")
                        })   
                    }
                    else{
                        var pid = $("#postid").attr('data-id');
                        var prev_val = $("#postid").attr('data-likes');
                        $.ajax({
                            type: 'POST',
                            url: 'remlike.php',
                            data: {pid: pid, prev_val: prev_val}
                        }).done(function(val){
                            if (val != "Error in connection!") {
                                likebtn.removeClass("liked")
                                likebtn.html("<i class='far fa-thumbs-up'></i>&nbsp; "+val)
                                $("#postid").attr('data-likes', val)
                            }
                        }).fail(function(){
                            console.log("Error in connection")
                        })
                    }
                })


                //snippet to subscribe to newsletter
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
                //end of snippet

                //snippet to add a comment
                $("#btn-com").click(function(e){
                    e.preventDefault()
                    var name = $("#name").val()
                    var comment = $("#comment").val()
                    var prev_val = $("#prev_val").val()
                    var pid = $("#pid").val()

                    if (name == "" || comment == "") {
                        Swal.fire({
                            title: 'Error!',
                            text: "All fields are required",
                            icon: 'error',
                        })
                    }
                    else if(comment.length > 280){
                        Swal.fire({
                            title: 'Error!',
                            text: "Comment more than 280 characters",
                            icon: 'error',
                        })
                    }
                    else{
                        $.ajax({
                            type: 'POST',
                            url: 'addcomment.php',
                            data: {pid: pid, name: name, comment: comment, prev_val: prev_val}
                        }).done(function(msg){
                            if (msg == "Comment added successfully!") {
                                Swal.fire({
                                title: 'Success!',
                                text: msg,
                                icon: 'success',
                                showCancelButton: false
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload()
                                }
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
                                text: "Error in connection!",
                                icon: 'error',
                            })
                        })
                    }
                })
                //End of snippet

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