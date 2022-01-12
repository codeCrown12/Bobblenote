<?php
session_start();
include 'connection.php';
include 'functions.php';

$rand = rand();
$selector = "";

//Check if user is logged in
if (isset($_SESSION['w_email'])) {
    $selector = $_SESSION['w_email'];
}
//Get user details
$user_details = get_writer_details($connection, $selector);
include 'compdefaulterscheck.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Competition guidelines</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
    <style>
        html{
            scroll-behavior: smooth;
        }
        .main-body{
            width: 90%;
            margin: auto;
        }
        .section{
            font-size: 18px;
            letter-spacing: -0.003em;
            text-rendering: optimizeLegibility;
            line-height: 1.8;
            word-spacing: 2px;
        }
        .guide-item{
            margin-bottom: 7px;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navbar component -->
    <?php include 'header.php'; ?>
    <!-- End of navbar component -->
    <div class="container">
        <div class="d-flex justify-content-center">
            <div>
                <p class="text-center"><img src="images/winners_cup.svg" width="300px" alt=""></p>
                <h2 class="text-center">Competition Guidelines</h2>
            </div>
        </div>
        <div class="row mt-5 justify-content-center">
            <div class="col-sm-10">
                <div class="main-body">
                    <div class="section">
                        <h4>What are competitions ?</h4>
                        <p>Competitions are events created or started by members of the Bobblenote community (i.e registered users of the Bobblenote application) that are aimed at rewarding outstanding content creators. Any registered user is eligible to start a competition on Bobblenote. All you need to do is <a href="signup.php" class="text-decoration-underline">create an account</a>  and get started.</p>
                    </div>
                    <div class="section mt-4">
                        <h4>Creating a competition 🔨</h4>
                        <p>
                            As mentioned earlier, you need to be a registered user in order to create an account on Bobblenote. In Bobblenote, the prizes for competitions are all monetary. A maximum number of five (5) winners can be awarded by competition. The total amount to be awarded to all the winners of the competition should be calculated When creating a competition.
                            <br><strong>For example: </strong><br> 1st Position: ₦20,000 <br> 2nd Position: ₦15,000 <br> 3rd Position: ₦10,000 <br> <strong>Total: </strong> ₦45,000
                            <br><strong>Note: </strong> A 10% fee is deducted from the total amount deposited to process the transaction hence you should factor this fee into your calculation so as to get accurate amounts for the winners of your competition. Also, the <strong>maximum</strong> amount that can be deposited for a competition at the moment is ₦ 2,000,000 (two million naira). This limit would be changed in the coming years.
                            <br> To get started in creating a competition, <a href="writerdashboard/mycompetitions.php" class="text-decoration-underline">Click here</a> and follow the instructions below 👍.
                        </p>
                        <ul>
                            <li>Login to your account</li>
                            <li>Click on your profile picture on the navigation bar</li>
                            <li>Click on 'start competition'</li>
                            <li>Fill the form and follow the sequence of steps.</li>
                        </ul>
                    </div>
                    <div class="section mt-4">
                        <h4>Joining a competition 🧐</h4>
                        <h6>Step 1:  Know the prerequisites, search & join</h6>
                        <p>To join a competition hosted on Bobblenote, all you have to do is <a href="signup.php" class="text-decoration-underline">create an account</a> if you're a new user or <a href="login.php" class="text-decoration-underline">sign in</a> to your account if you're already a registered user. Once you've successfully completed either of the steps above, click on 'Competitions' on the navigation bar and search for any competition of your choice and join🎉.</p>
                        <h6>Step 2: Create the award winning article for the competition</h6>
                        <p>Creating the article for the competition you join couldn't be any easier. Ensure you're logged in or if you're a new user <a href="signup.php" class="text-decoration-underline">create an account</a>. Then, you click on your profile picture on the navigation bar to view the dropdown menu. On the menu, you select <a href="writerdashboard/createpost.php" target="_blank" class="text-decoration-underline">Create post</a> and you will be directed to a form which you'll fill in order to create a post/article. In the tags section of the form, please include the tag of the competition along with any other 'non-competition' tags of your choice each seperated by a comma.
                        <br><strong>Note: </strong>   If the tag for the competition is not included, your post/article will not be seen by the host of the competition, meaning you will not be considered for the prize.
                        </p>
                        <p class="fw-bold m-0">General rules for competitions</p>
                        <ul>
                            <li>Only individual accounts are allowed to participate in competitions,</li>
                            <li>No participant should publish more than one article per competition,</li>
                            <li>Articles for competitions should be published on or after the start-date of the competition,</li>
                            <li>Also other rules set by the organizer/host of the competition should be adhered to.</li>
                        </ul>
                        <p><strong>Note: </strong> Failure to adhere to the rules above will lead to automatic disqualification from the competition.</p>
                    </div>
                    <div class="section mt-4">
                        <h4>Requesting payout for competition winners</h4>
                        <p>Every competition has a duration (which is set when you're creating the competition), and once the duration is over, the competition is expired. Once the competition is expired the host (you) should request payout from us so we can pay the winners of your competition. The individual prizes of the winners should be specified in the payout request form. After requesting payout successfully, you can proceed to renew the expired competition any time you're ready.<br>
                            <strong>Note: </strong> After requesting a payout from us, ensure you receive feedback from us acknowledging that we've received your request before attempting to renew the expired competition.
                        </p>
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
    <script src="js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="js/jquery.sticky-sidebar.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/general.js"></script>
</body>
</html>