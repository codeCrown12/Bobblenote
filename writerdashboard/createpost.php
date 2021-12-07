<?php
    session_start();
    $selector = "";
    if ($_SESSION['w_email'] == "") {
    header("Location: ../login.php");
    }
    else{
    $selector = $_SESSION['w_email'];
    }
    include '../connection.php';
    include '../functions.php';

    //snippet to get profile pic and name
    $details = get_writer_details($connection, $selector);
    $fullname = $details['firstname']. " ". $details['lastname'];
    $profile_img = $details['profilepic'];

    //variable declarations
    $msg =  "";
    $rand = rand();
    $allowed_image_extension = array(
        "png",
        "jpg",
        "jpeg"
    );

    
    //snippet to save as draft
    if (isset($_POST['save'])) {
        $newimg = "";

        //Get the value from the text input fields
        $title = check_string($connection, $_POST['title']);
        $category = check_string($connection, $_POST['category']);
        $tags = check_string($connection, $_POST['tags']);
        $content = $_POST['content'];
        $content_txt = check_string($connection, $_POST['content']);
        $content_txt = str_replace("rn", "", $content_txt);
        $published = "no";

    

        if ($title == "") {
            $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
           Title is required to save as a draft!
           <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
         </div>";
        } else {
            if (file_exists($_FILES['coverimg']['tmp_name'])) {
                // Get image file extension
                $file_extension = pathinfo($_FILES["coverimg"]["name"], PATHINFO_EXTENSION);
                if (!in_array($file_extension, $allowed_image_extension)) {
                    $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
                    Upload only valid image. Only PNG and JPEG formats are allowed!
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
                } else {
                    $newimg = "images/posts/".$selector.date('Y-m-d').rand().".png";
                    move_uploaded_file($_FILES['coverimg']['tmp_name'], "../".$newimg);
                }
            }
                //strip spaces in tags
                $tags_stripped = strip_spaces($tags);

                //get excerpt from the post
                $excerpt = substr($content_txt, 0, 150);

                //upload image to server
                $newimg = "images/posts/insp-1.jpg";
                $query = "INSERT INTO posts (W_email, coverimg, title, category, tags, content, excerpt, published) VALUES (?,?,?,?,?,?,?,?)";
                $ins_result = $connection->prepare($query);
                $ins_result->bind_param("ssssssss", $selector, $newimg, $title, $category, $tags_stripped, $content, $excerpt, $published);
                if ($ins_result->execute()) {
                    $msg = "<div class='alert alert-success alert-dismissible fade show mt-2' role='alert'>
                Post saved to drafts successfully! You can edit all the post details and publish later.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
                } else {
                    unlink($newimg);
                    $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
                Error in connection!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                }
        }
    }

    //snipppet to publish post
    if (isset($_POST['publish'])) {
        //Get the value from the text input fields
        $title = check_string($connection, $_POST['title']);
        $category = check_string($connection, $_POST['category']);
        $tags = check_string($connection, $_POST['tags']);
        $content = $_POST['content'];
        $content_txt = check_string($connection, $_POST['content']);
        $content_txt = str_replace("rn", "", $content_txt);
        $published = "yes";

        // Get image file extension
        $file_extension = pathinfo($_FILES["coverimg"]["name"], PATHINFO_EXTENSION);

        if ($title == "" || $category == "" || $tags == "" || $content == "") {
           $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
           All fields are required!
           <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
         </div>";
        }
        elseif (!file_exists($_FILES['coverimg']['tmp_name'])) {
            $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
            No image selected!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        }
        elseif (!in_array($file_extension, $allowed_image_extension)) {
            $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
            Upload only valid image. Only PNG and JPEG formats are allowed!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        }
        else{
            //strip spaces in tags
            $tags_stripped = strip_spaces($tags);

            //get excerpt from the post
            $excerpt = substr($content_txt, 0, 150);

            //upload image to server
            $newimg = "images/posts/".$selector.date('Y-m-d').rand().".png";
            $query = "INSERT INTO posts (W_email, coverimg, title, category, tags, content, excerpt, published) VALUES (?,?,?,?,?,?,?,?)";
            $ins_result = $connection->prepare($query);
            $ins_result->bind_param("ssssssss", $selector, $newimg, $title, $category, $tags_stripped, $content, $excerpt, $published);
            if ($ins_result->execute()) {
                move_uploaded_file($_FILES['coverimg']['tmp_name'], "../".$newimg);
                $msg = "<div class='alert alert-success alert-dismissible fade show mt-2' role='alert'>
                Post published successfully!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
            }
            else{
                $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
                Error in connection!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create post</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/post.css">
</head>
<body>
    <!-- my navigation bars start here -->
    <nav class="navbar navbar-expand-lg navbar-dark nav-one">
      <div class="container-fluid">
        <a class="navbar-brand ms-md-5 text-white" href="../index.php">Bobblenote</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav ms-auto" style="margin-right: 25px;">
              <li class="nav-item">
              <a class="nav-link text-white" href="settings.php"><img src="<?php echo "../".$profile_img."?randomurl= $rand" ?>" class="dp-img" alt=""> <?php echo $fullname ?></a>
              </li>
          </ul>
        </div>
      </div>
    </nav>
    <nav class="navbar navbar-light navbar-expand-lg bg-white">
        <div class="container-fluid">
          <div class="collapse navbar-collapse">
            <div class="navbar-nav ms-md-5">
              <a class="nav-link" href="home.php"><i class="fas fa-home"></i> Home</a>
              <a class="nav-link" href="mycompetitions.php"><i class="fas fa-trophy"></i> Competitions</a>
              <a class="nav-link active" href="createpost.php"><i class="fas fa-pen-alt"></i> Create post</a>
              <a class="nav-link" href="settings.php"><i class="fas fa-cog"></i> Settings</a>
            </div>
            <div class="navbar-nav ms-auto me-md-5">
                <a class="nav-link" href="logout.php"> <i class="fas fa-power-off"></i> Logout</a>
            </div>
          </div>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title mt-5" id="offcanvasNavbarLabel"><a class="text-dark text-decoration-none" href="settings.php"><img src="<?php echo "../".$profile_img."?randomurl= $rand" ?>" class="dp-img" alt=""> <?php echo $fullname ?></a></h5>
              <p type="button" data-bs-dismiss="offcanvas" aria-label="Close"><span class="nav-close">&times;</span></p>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link" href="home.php"> <i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="mycompetitions.php"><i class="fas fa-trophy"></i> Competitions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="createpost.php"><i class="fas fa-pen-alt"></i> Create post</a>
                  </li>
                <li class="nav-item">
                    <a class="nav-link" href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fas fa-power-off"></i> Logout</a>
                  </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
      <!-- my navigation bars end here -->
      <div class="container">
          <div class="row">
              <div class="col-sm-8">
              <form action="createpost.php" method="POST" enctype="multipart/form-data">
                  <div class="card mt-5">
                      <div class="card-header bg-white">
                          <div class="card-title d-flex align-items-center">
                              <h4><i class="fas fa-pen-alt"></i> Create post</h4>
                              <button name="publish" class="btn btn-default ms-auto">Publish post <i class="fas fa-paper-plane"></i></button>
                          </div>
                      </div>
                      <div class="card-body">
                            <?php
                                if ($msg != "") {
                                    echo $msg;
                                }
                            ?>
                            <label for="">Post cover image<br><small style="color: #777777;">(Hover and click the image below to change it)</small></label>
                            <div class="img-cover mt-1">
                                <input type="file" id="pimg-select" accept="image/*" name="coverimg" hidden>
                                <img class="coverimg" id="pimg-prev" src="../images/posts/insp-1.jpg" width="100%" height="200px" alt="preview image">
                                <div class='overlay' onclick="open_file()">
                                    <div class="cam-div">
                                        <p><i class="fas fa-camera cam-icon"></i></p>
                                    </div>
                                </div>
                            </div>
                            <small style="color: #777777;">(Note: Images will be displayed fully when viewed)</small>
                            <div class="form-group mt-3">
                                <input type="text" name="title" class="form-control" placeholder="Post title">
                            </div>
                            <div class="form-group mt-3">
                                <Select class="form-select" name="category">
                                <option value="">--Select category--</option>
                                    <?php
                                        $catquery = "SELECT * FROM categories";
                                        $result = $connection->query($catquery);
                                        if (!$result) {
                                            echo $connection->error;
                                        }
                                        else{
                                            $num_rows = $result->num_rows;
                                            if ($num_rows >= 1) {
                                                for ($i=0; $i < $num_rows; $i++) { 
                                                    $result->data_seek($i);
                                                    $row = $result->fetch_array(MYSQLI_ASSOC);
                                                    echo "<option value='$row[category]'>$row[category]</option>";
                                                }
                                            }
                                        }
                                    ?>
                                </Select>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" name="tags" placeholder="Post tags seperated by comma">
                            </div>
                            <div class="form-group mt-3">
                                <Textarea class="form-control" name="content" id="pbody" placeholder="Post content" rows="8"></Textarea>
                            </div>
                            <div class="form-group mt-3">
                                <button name="save" class="btn btn-outline-primary">Save as draft <i class="far fa-save"></i></button>
                            </div>
                      </div>
                  </div>
                  </form>
              </div>
              <div class="col-sm-4">
                <div class="card mt-5">
                    <div class="card-header text-center bg-white">
                    <a href="https://www.crowndidactic.com" target="_blank">
                    <img src="../images/crownEdLogo.png" style="object-fit: cover;" width="80%" alt="">
                    </a>
                    </div>
                    <div class="card-body">
                    <p class="text-center">Advertise your school with crowndidactic. Sign up! for <strong>free</strong> and enjoy our sweet features.</p>
                    <a style="width: 100%;" href="https://www.crowndidactic.com/register" target="_blank" class="btn btn-default">Sign up</a>  
                  </div>
                </div>
                <div class="guidelines mt-4">
                    <p>
                        <h4 class="text-center" style="color: #203656;">Tips for using the editor</h4>
                        <ul class="guide-ul">
                            <li>All fields must be completed before publishing a post.</li>
                            <li>Title is required before saving post as draft.</li>
                            <li>All post drafts information e.g cover-image, title, tags, etc can be edited and changed before publishing them.</li>
                            <li>Press <strong>Ctrl + Shift + F</strong> to toggle between full screen and normal screen of the post content text editor. </li>
                            <li>Ensure your post is complete and ready before publishing it. Published posts <strong>cannot</strong> be edited.</li>
                        </ul>
                    </p>
                </div>
              </div>
          </div>
        
      </div>
      <?php include '../footer.php' ?>
     <!-- javascripts  -->
     <script src="https://cdn.tiny.cloud/1/0h01t537dv5w80phd2kb1873sfhpg9mg6ek7ckr1aly3myzy/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
     <script>

        //Code to initialize tinymce text editor
        tinymce.init({
          selector: 'textarea#pbody',
          height: 400,
          plugins: [
            'advlist autolink link lists charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'table emoticons template paste help codesample'
            ],
            toolbar: 'fullscreen | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link codesample | preview fullpage | forecolor backcolor emoticons',
            menubar: ''
       });

       //function to use overlay to open file
       function open_file(){
          document.getElementById('pimg-select').click();
        }

        //code to select and preview image
        const imgselector = document.querySelector("#pimg-select")
        const imgpreview = document.querySelector("#pimg-prev")

        imgselector.addEventListener('change', function(){
            getImgData()
        })

        function getImgData() {
            const files = imgselector.files[0];
            if (files) {
                const fileReader = new FileReader();
                fileReader.readAsDataURL(files);
                fileReader.addEventListener("load",  function () {
                    imgpreview.setAttribute('src', this.result)
                });    
            }
        }
      </script>
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
</body>
</html>