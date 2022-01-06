<header class="header-default">
            <nav class="navbar navbar-expand-lg">
                <div class="container-xl">
                    <!-- logo  -->
                    <a href="index.php" class="navbar-brand">
                        <h1>Bobblenote</h1>
                    </a>

                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a href="index.php" class="nav-link">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
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
                                <a href="competitions.php" class="nav-link">Competitions</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="#" class="nav-link">Jobs</a>
                            </li> -->
                            <li class="nav-item">
                                <a href="about.php" class="nav-link">About</a>
                            </li>
                            <li class="nav-item">
                                <a href="contact.php" class="nav-link">Contact</a>
                            </li>
                            
                        </ul>
                        <!-- <img src="images/moon.png" id="icon"> -->
                    </div>

                    <!-- right side of header  -->
                    <div class="header-right">
                        <!-- buttons  -->
                        <div class="header-buttons d-flex align-items-center">
                            <?php
                                if ($selector == "") {
                                    ?>
                            <a href="login.php" class="btn btn-outline-default btn-write me-2">Login</a>
                            <a href="signup.php" class="btn btn-default btn-write">Create account</a>
                            <?php
                                }
                            ?>
                            <button class="search icon-button">
                            <i class="icon-magnifier"></i>
                            </button>
                            <?php
                                if ($selector != "") {
                                    ?>
                                <div class="dropdown ms-2">
                                    <a href="#" class="dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false"><img src="<?php echo $user_details['profilepic']."?randomurl=".rand() ?>" style="width: 37px; height: 37px; border-radius: 50%;object-fit:cover;" alt=""></a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                                        <li>
                                            <a href="profile.php?wid=<?php echo base64_encode($user_details['email']) ?>" class="dropdown-item">
                                                <?php
                                                if ($user_details['account_type'] == "individual") {
                                                    echo "@".$user_details['firstname']." ".$user_details['lastname'];
                                                }
                                                else echo "@".$user_details['organization_name']; 
                                                ?>
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a href='writerdashboard/home.php' class='dropdown-item'>Dashboard</a></li>
                                        <li><a href='writerdashboard/createpost.php' class='dropdown-item'>Create post</a></li>
                                        <li><a href='writerdashboard/mycompetitions.php' class='dropdown-item'>Start competition</a></li>
                                        <li><a href='writerdashboard/settings.php' class='dropdown-item'>settings</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a href='writerdashboard/logout.php' class='dropdown-item'>Sign out</a></li>
                                    </ul>
                                </div>
                            <?php
                                }
                            ?>
                            <button class="burger-menu icon-button">
                                <span class="burger-icon"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>


        </header>