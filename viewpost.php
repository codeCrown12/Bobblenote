<?php
session_start();
include 'connection.php';
include 'functions.php';

$pid = "";
$rand = rand();
$selector = "";

//Check if user is logged in
if (isset($_SESSION['w_email'])) {
    $selector = $_SESSION['w_email'];
}


if (isset($_GET['pid'])) {
    $pid = check_string($connection, base64_decode($_GET['pid']));
}
//Get post details
$post_details = get_post_details($connection, $pid);
//Get post creator details
$writer_details = get_writer_details($connection, $post_details['W_email']);
//Get user details
$user_details = get_writer_details($connection, $selector);
include 'compdefaulterscheck.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo substr($post_details['excerpt'],0,40)."..." ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="<?php echo $post_details['title'] ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="<?php echo $post_details['coverimg']."?randomurl=$rand" ?>" />
    <meta property="og:url" content="https://bobblenote.com/viewpost?pid=<?php echo $_GET['pid'] ?>" />
    <meta property="og:description" content="<?php echo substr($post_details['excerpt'],0,40)."..." ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <title><?php echo $post_details['title'] ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/prism.css">
    <link rel="stylesheet" href="css/viewpost.css">
    </head>
<body>
    <!-- Navbar component -->
    <?php include 'header.php'; ?>
    <!-- End of navbar component -->
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
                                <div class="post-text mt-4"><?php echo $post_details['content'] ?></div>
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
                                <div class="fs-6 mytooltip" id="likebtn" title="Boost this post 🚀"><i class="fas fa-rocket"></i>&nbsp; <?php 
                                    echo numFormatter($post_details['no_of_likes']);
                                    ?>
                                </div>
                            <span class="d-none" id="postid" data-id="<?php echo $pid ?>" data-likes="<?php echo $post_details['no_of_likes'] ?>"></span>
                            </div>
                            <div class="section-share">
                                <!-- AddToAny BEGIN -->
                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-icon-color="#335fbe">
                                <!-- <a class="a2a_dd" href="https://www.addtoany.com/share"></a> -->
                                <a class="a2a_button_facebook"></a>
                                <a class="a2a_button_twitter"></a>
                                <a class="a2a_button_linkedin"></a>
                                <a class="a2a_button_whatsapp"></a>
                                <a class="a2a_button_telegram"></a>
                                <!-- <a class="a2a_button_email"></a> -->
                                </div>
                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                                <!-- AddToAny END -->
                            </div>
                        </div>
                        <div class="comments-section">
                            <h6>COMMENTS (<?php echo numFormatter($post_details['no_of_comments']) ?>)</h6>
                            <p>Add a comment</p>
                            <form>
                                <div class="form-group">
                                    <!-- <label for="">(<small><strong>Note:</strong> Go to settings to change name</small>)</label> -->
                                    <!-- <input type="hidden" id="name" class="form-control" readonly value="<?php echo $selector ?>"> -->
                                    <input type="text" id="prev_val" value="<?php echo $post_details['no_of_comments']; ?>" class="form-control" hidden>
                                    <input type="text" id="pid" value="<?php echo $post_details['P_ID']; ?>" hidden>
                                </div>
                                <div class="form-group mt-3">
                                    <small>(Not more than 280 characters)</small>
                                    <Textarea class="form-control" id="comment" placeholder="Share your thoughts..." rows="5"></Textarea>
                                </div>
                                <div class="mt-3 sub-btn">
                                    <button class="btn btn-default <?php if ($selector == "") {
                                        echo "disabled";
                                    } ?>" id="btn-com">Post Comment <i class="fas fa-paper-plane"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="all-comments">
                            <h6>All Comments</h6>
                            <?php
                                $query = "SELECT u_email, comment_text, date_created FROM comments WHERE P_ID = $pid";
                                $result = $connection->query($query);
                                $num_rows = $result->num_rows;
                                if ($num_rows >= 1) {
                                    for ($i=0; $i < $num_rows; $i++) { 
                                        $result->data_seek($i);
                                        $data = $result->fetch_array(MYSQLI_ASSOC);
                                        //Details of the owner of the comment
                                        $u_details = get_writer_details($connection, $data['u_email']);
                            ?>
                            <div class="d-flex">
                                <div class="mt-3 me-2"><img class="com-img" src="<?php echo $u_details['profilepic']."?randomurl=".rand() ?>" alt=""></div>
                                <div class="com-content">
                                    <p class="com-head mb-0 mt-1"><?php echo $u_details['firstname']." ".$u_details['lastname']?></p>
                                    <div class="m-0 text-muted"><small>
                                        <?php 
                                        if (strlen($u_details['bio']) > 150) {
                                            echo substr($u_details['bio'], 0, 150)."...";
                                        }
                                        else echo $u_details['bio'];
                                    ?></small></div>
                                    <div class="com-body mt-1"><?php echo $data['comment_text']; ?></div>
                                </div>
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
                    <div class="card-header text-center bg-white p-3">
                    <h5 class="card-title m-0 text-dark">Start a competition 🏆!</h5>
                    </div>
                    <div class="card-body p-3">
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
        <script src="js/prism.js"></script>
        <script src="https://cdn.tiny.cloud/1/0h01t537dv5w80phd2kb1873sfhpg9mg6ek7ckr1aly3myzy/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
          selector: 'textarea#comment',
          height: 250,
          plugins: [
            'emoticons paste'
            ],
            toolbar: 'insertfile undo redo | bold italic | fullpage | emoticons',
            menubar: ''
       });
            $(document).ready(function(){
                
                //Snippet to check if a user is logged in
                var check = "check"
                $.ajax({
                    type: 'POST',
                    url: 'readersession.php',
                    data: {check: check}
                }).done(function(msg){
                    if (msg == "true") {
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
                //End of snippet to check if user is logged in

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
                            if (val != "Error in connection!" && val != "not logged in") {
                                likebtn.addClass("liked")
                                likebtn.html("<i class='fas fa-rocket'></i>&nbsp; "+val)
                                $("#postid").attr('data-likes', val)
                                Swal.fire({
                                    toast: 'true',
                                    position: 'top-end',
                                    title: "You gave boosts! 🚀",
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                })
                            }
                            else if(val == "not logged in"){
                                Swal.fire({
                                title: 'Sorry!',
                                text: "You're not logged in. Login to like post!",
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonText: 'Login'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.replace("login.php")
                                }
                                })
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
                            if (val != "Error in connection!" && val != "not logged in") {
                                likebtn.removeClass("liked")
                                likebtn.html("<i class='fas fa-rocket'></i>&nbsp; "+val)
                                $("#postid").attr('data-likes', val)
                            }
                            else if(val == "not logged in"){
                                Swal.fire({
                                title: 'Warning!',
                                text: "You're not logged in",
                                icon: 'warning',
                                showCancelButton: false
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.replace("login.php")
                                }
                                })
                            }
                        }).fail(function(){
                            console.log("Error in connection")
                        })
                    }
                })
                //End of snippet to like post
                
                //snippet to add a comment
                $("#btn-com").click(function(e){
                    e.preventDefault()
                    tinyMCE.triggerSave();
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
                            data: {pid: pid, comment: comment, prev_val: prev_val}
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
                            else if(msg == "not logged in"){
                                Swal.fire({
                                title: 'Warning!',
                                text: "You're not logged in. Login to comment on this post!",
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonText: 'Login'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.replace("login.php")
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
            })
        </script>
</body>
</html>