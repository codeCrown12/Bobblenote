<?php
session_start();
include '../functions.php';
include '../connection.php';
$selector = "";
if ($_SESSION['w_email'] == "") {
  header("Location: ../login.php");
}
else{
  $selector = $_SESSION['w_email'];
}


//snippet to get user image and full name
$details = get_writer_details($connection, $selector);
$fullname = $details['firstname']. " ". $details['lastname'];
$profile_img = $details['profilepic'];

$msg = "";
$rand = rand();
$allowed_image_extension = array(
  "png",
  "jpg",
  "jpeg"
);

//upload new image script
if (isset($_POST['upload'])) {
  
  //get image caption
  $caption = check_string($connection, $_POST['caption']);
  
  // Get image file extension
  $file_extension = pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);

  if (!file_exists($_FILES['img']['tmp_name'])) {
    $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
        No image file selected!
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
    $newimg = "images/gallery/".$selector.date('Y-m-d').rand().".png";
    $query = "INSERT INTO gallery (w_email, imgurl, caption) VALUES (?,?,?)";
    $result = $connection->prepare($query);
    $result->bind_param("sss", $selector, $newimg, $caption);
    if ($result->execute()) {
      move_uploaded_file($_FILES['img']['tmp_name'], "../".$newimg);
      header("Refresh: 0");
    }
    else{
      $msg = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
      Error in connection!
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
  }
}
//End of snippet
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/gallery.css">
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
              <!-- <a class="nav-link active" href="gallery.php"><i class="fas fa-images"></i> Gallery</a> -->
              <a class="nav-link" href="createpost.php"><i class="fas fa-pen-alt"></i> Manage post</a>
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
                <!-- <li class="nav-item">
                  <a class="nav-link active" href="gallery.php"><i class="fas fa-images"></i> Gallery</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="createpost.php"><i class="fas fa-pen-alt"></i> Manage post</a>
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
      <div class="container mt-5">
          <div class="row justify-content-center">
              <div class="col-sm-12">
                      <?php
                          if ($msg != "") {
                            echo $msg;
                          }
                      ?> 
                   <small>(<strong>Optional!</strong> Suitable For photographers/artists)</small>    
                  <div class="card mt-1">
                      <div class="card-header bg-white" style="padding-top: 10px;">
                        <div class="card-title" style="display: flex; align-items: center;margin: 0;">
                            <h4><i class="fas fa-images"></i> Gallery</h4>
                            <button class="btn btn-default" style="margin-left: auto;" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Add photo</button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="row">
                        <?php
                          $gal_query = "SELECT * FROM gallery WHERE w_email = '$selector'";
                          $gal_res = $connection->query($gal_query);
                          if ($gal_res) {
                              $gal_numrows = $gal_res->num_rows;
                              if ($gal_numrows >= 1) {
                                  for ($i=0; $i < $gal_numrows; $i++) { 
                                    $gal_res->data_seek($i);
                                    $gal_data = $gal_res->fetch_array(MYSQLI_ASSOC);
                                  
                          ?>
                            <div class="col-md-4 mb-4">
                                <div class="img-cover">
                                    <img class="gal-img" src="<?php echo "../".$gal_data['imgurl']."?randomurl= $rand" ?>" alt="" srcset="">
                                    <span class="text d-none"><?php echo $gal_data['caption'] ?></span>
                                    <div class='overlay'>
                                    <div class="btn-contains">
                                        <button class="btn btn-sm btn-outline-light"><i class="fas fa-pen-square"></i> caption</button>
                                        <button class="btn btn-sm btn-outline-light v-img"><i class="fas fa-eye"></i> View</button>
                                        <button class="btn btn-sm btn-outline-light mydel" data-id="<?php echo $gal_data['G_ID'] ?>" data-img="<?php echo "../".$gal_data['imgurl']?>"><i class="fas fa-trash-alt"></i> Delete</button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                            <?php
                              }
                            }
                            else{
                              echo "<div class='error-container'>
                              <div class='text-center'>
                              <lord-icon
                                src='https://cdn.lordicon.com/dzllstvg.json'
                                trigger='loop'
                                colors='primary:#335fbe,secondary:#335fbe'
                                style='width:100px;height:100px'>
                            </lord-icon>
                              <h6 style='color: #203656;'>No images here</h6>
                              <button class='btn btn-default mb-3' type='button' data-bs-toggle='modal' data-bs-target='#exampleModal'>Add photo</i></button>
                              </div> 
                            </div>";
                            }
                          }
                            ?>
                            
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Upload photo <i class="fas fa-upload"></i></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="gallery.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Select image</label>
                    <input type="file" name="img" class="form-control-file mt-1">
                </div>
                <div class="form-group mb-2">
                    <small>(Optional)</small>
                    <input type="text" name="caption" class="form-control mt-1" placeholder="Add caption">
                </div>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 <button name="upload" type="submit" class="btn btn-default">Upload image</button>
               </div>
        </form>
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
                        <span class="copyright">&copy; 2021 Bobblenote</span>
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
     <!-- javascripts  -->
    <script src="../js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script>
         // Get the modal
        var modal = document.getElementById("myModal");
        var imgs = document.querySelectorAll('.gal-img');
        var vimgbtn = document.querySelectorAll('.v-img');
        var txts = document.querySelectorAll('.text');
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");

        for (let i = 0; i < imgs.length; i++) {
                vimgbtn[i].addEventListener('click', ()=>{
                    let src = imgs[i].getAttribute('src');
                    modal.style.display = 'block';
                    modalImg.setAttribute('src', src);
                    captionText.innerHTML = txts[i].innerHTML;
                })
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modal.style.display = "none";
        }

        $(document).ready(function(){
          $('.mydel').click(function(e){
            //variable declaration
            var pid = $(this).attr('data-id');
            var img = $(this).attr('data-img');
            var parent = $(this).parent(".btn-contains").parent(".overlay").parent(".img-cover").parent(".col-md-4")

            //sweet alert fire
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#335fbe',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                type: 'POST',
                url: 'delgalimg.php',
                data: {delete: pid, image: img}
              })
              .done(function(msg){
                parent.fadeOut('slow')
                Swal.fire({
                  title: 'Deleted!',
                  text: msg,
                  icon: 'success',
                  showCancelButton: false
                }).then((result) => {
                if (result.isConfirmed) {
                  location.reload()
                }
                })
              })
              .fail(function(msg){
                Swal.fire(
                'Deleted!',
                 msg,
                'success'
                )
              })
            }
          })
        })
      })
     </script>
</body>
</html>