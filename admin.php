 <?php
    require_once('includ/db.php');
    require_once('includ/function.php');
    require_once('includ/sessions.php');
    $_SESSION['url_tracking'] = $_SERVER['PHP_SELF'];
    confirm_login();

 if (isset($_POST['submit'])) {
     $username       = $_POST['username'];
     $admin_name     = $_POST['admin_name'];
     $admin_email    = $_POST['admin_email'];
     $admin_pass     = $_POST['admin_pass'];
     $con_pass       = $_POST['con_pass'];
     $addedBy        = $_SESSION['user_name'];
     date_default_timezone_set("Asia/Dhaka");
     $current_time   = time();
     $date_time      = strftime("%B-%d-%Y  %H:%M", $current_time);


     if (empty($username) || empty($admin_email) || empty($admin_pass) || empty($con_pass)) {
         $_SESSION['error_message'] ='All requried fields must be filled out';

         redirect_to('admin.php');
     } elseif (strlen($admin_pass) <= 4) {
         $_SESSION['error_message'] ='Password must be more than 3 charecter';
        
         redirect_to('admin.php');
     } elseif (strlen($admin_pass) >= 50) {
         $_SESSION['error_message'] ='Password must be less than 50 charecter';
         redirect_to('admin.php');
     } elseif ($admin_pass !== $con_pass) {
         $_SESSION['error_message'] ='Both password must be same!!';
         redirect_to('admin.php');
     } elseif (check_user_name($username)) {
         $_SESSION['error_message'] ='User name already exist. Try another one!!!';
         redirect_to('admin.php');
     } else {
         $sql = "INSERT INTO admins(datetime,username,adminname,email,password,addedby)";
         $sql .= "VALUES('$date_time','$username','$admin_name','$admin_email','$admin_pass','$addedBy')";

         $stmt = $connection-> prepare($sql);

         $execute = $stmt-> execute();


         if ($execute) {
             $_SESSION['success_message'] ='Admin Added Succesfully';
             redirect_to('admin.php');
         } else {
             $_SESSION['error_message'] ='Something went wrong!! Try again!!';
             redirect_to('admin.php');
         }
     }
 }

    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Custom CMS</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="fonts/FontsAwesome/css/all.min.css">
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Main css -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <!-- header menu start-->
    <div class="header-menu bg-dark border-tb">
        <div class="container">
            <div class="row">
                <nav class="navbar navbar-expand-lg w-100 navbar-dark">
                    <a href="#" class="navbar-brand text-light"><img src="cms.png" alt="cms"></a>
                      <!-- Toggler/collapsibe Button -->
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav mx-auto">
                        
                        <li class="nav-item"><a class="nav-link text-light" href="dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="category.php">Categories</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="admin.php">Manage Admins</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="blog.php?page=1">Blog</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="posts.php">Posts</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="comments.php">Comments</a></li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link text-light" href="myprofile.php"> <i class="fas fa-user text-success"></i> My Profile</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="logout.php"><i class="fas fa-sign-out-alt text-danger"></i> Logout</a></li>
                    </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <!-- header menu end -->

    <!-- header area start -->
    <header class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <h1> <i class="fas fa-user"></i> Manage Admins </h1>
            </div>
        </div>
    </header>
    <!-- header area end -->

    <!-- main area start -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <?php

                    echo error_message();
                    echo success_message();

                ?>
                <form action="admin.php" method="post">
                    <div class="card mb-3 mt-3">
                        <div class="card-header">
                            <h1>Add New Admin</h1>
                        </div>
                        <div class="card-body bg-dark">

                            <div class="form-group">
                                <label for="username" class="text-white">User Name</label>
                                <input type="text" name="username" id="username" placeholder="User Name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="name" class="text-white">Name</label>
                                <input type="text" name="admin_name" id="name" placeholder="Your Name" class="form-control">
                                <span class="text-muted">*Optional*</span>
                            </div>

                            <div class="form-group">
                                <label for="email" class="text-white">Email</label>
                                <input type="email" name="admin_email" id="email" placeholder="Your Email Address" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="password" class="text-white">Password</label>
                                <input type="password" name="admin_pass" id="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="confirm_pass" class="text-white">Confirm Password</label>
                                <input type="password" name="con_pass" id="confirm_pass" class="form-control">
                            </div>

                            <div class="row">
                                <div class="col-lg-6 mb-1">
                                    <a href="dashboard.php" class="btn btn-danger d-block text-white"> <i class="fas fa-undo"> </i> Cancel </a>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" name="submit" class="btn btn-success d-block btn-block text-white"><i class="fas fa-check-double"> </i> Register </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <h2 class="text-center">All Admins</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                <?php

                global $connection;

                $sql = "SELECT * FROM admins";

                $execute = $connection -> query($sql);

                $sl=0;

                while ($data_rows = $execute -> fetch()) {
                    $ad_id = $data_rows['id'];
                    $date = $data_rows['datetime'];
                    $ad_username = $data_rows['username'];
                    $ad_name = $data_rows['adminname'];
                    $ad_email = $data_rows['email'];
                    $ad_addedby = $data_rows['addedby'];
                    $sl++;

                    ?>
                    
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($sl) ?></td>
                        <td><?php echo htmlentities($date) ?></td>
                        <td><?php echo htmlentities($ad_username) ?></td>
                        <td><?php echo htmlentities($ad_name) ?></td>
                        <td><?php echo htmlentities($ad_email) ?></td>
                        <td><?php echo htmlentities($ad_addedby) ?></td>
                        <td><a href="delete_admin.php?id=<?php echo $ad_id ?>" class="btn btn-danger">Delete</a></td>
                    </tr>
                </tbody>

                    <?php
                }
                ?>
                </table>

            </div>
        </div>
    </section>
    <!-- main area end -->


    <!-- Footer area start -->
    <footer class="bg-dark text-white  p-3 pt-4 border-tb">
        <div class="container">
            <div class="row ">
                <div class="col">
                    <p class="text-center">Developed By <a href="https://www.srftech-bd.net" class="text-success">faisalmr9</a> | All Right Reserved </p> 
                </div>              
            </div>
        </div>
    </footer>
    <!-- Footer area end -->

    <!-- jQuery Slim -->
    <script src="js/jquery-3.4.1.slim.min.js"></script>
    <!-- popper js -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>

</body>
</html>