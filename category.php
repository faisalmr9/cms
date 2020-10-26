 <?php
    require_once('includ/db.php');
    require_once('includ/function.php');
    require_once('includ/sessions.php');
    $_SESSION['url_tracking'] = $_SERVER['PHP_SELF'];
    confirm_login();

 if (isset($_POST['submit'])) {
     $category = $_POST['cat_title'];
     $author = $_SESSION['user_name'];

     date_default_timezone_set("Asia/Dhaka");
     $current_time = time();
     $date_time = strftime("%B-%d-%Y  %H:%M", $current_time);

     if (empty($category)) {
         $_SESSION['error_message'] ='All requried fields must be filled out';

         redirect_to('category.php');
     } elseif (strlen($category) <= 2) {
         $_SESSION['error_message'] ='Category must be more than 2 charecter';
        
         redirect_to('category.php');
     } elseif (strlen($category) >= 50) {
         $_SESSION['error_message'] ='Category must be less than 50 charecter';
         redirect_to('category.php');
     } else {
         $sql = "INSERT INTO category(title,author,datetime)";
         $sql .= "VALUES('$category','$author','$date_time')";


         $stmt = $connection-> prepare($sql);

         $execute = $stmt-> execute();

         if ($execute) {
             $_SESSION['success_message'] ='Category Added Succesfully';
             redirect_to('category.php');
         } else {
             $_SESSION['error_message'] ='Something went wrong!! Try again!!';
             redirect_to('category.php');
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
                <h1> <i class="fas fa-edit"></i> Manage Categories </h1>
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
                <form action="category.php" method="post">
                    <div class="card mb-3 mt-3">
                        <div class="card-header">
                            <h1>Add New Category</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title" class="text-white">Category Title</label>
                                <input type="text" name="cat_title" id="title" placeholder="Category title" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-1">
                                    <a href="dashboard.php" class="btn btn-primary d-block text-white"> <i class="fas fa-arrow-left"></i> Back To Dashboard </a>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" name="submit" class="btn btn-success d-block btn-block text-white"><i class="fas fa-check"></i> Create Category </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form><br>
                <h2 class="text-center">All Category</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Author</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                <?php

                global $connection;

                $sql = "SELECT * FROM category";

                $execute = $connection -> query($sql);

                $sl=0;

                while ($data_rows = $execute -> fetch()) {
                    $cat_id = $data_rows['id'];
                    $cat_title = $data_rows['title'];
                    $cat_author = $data_rows['author'];
                    $cat_datetime = $data_rows['datetime'];
                    $sl++;

                    ?>
                    
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($sl) ?></td>
                        <td><?php echo htmlentities($cat_datetime) ?></td>
                        <td><?php echo htmlentities($cat_title) ?></td>
                        <td><?php echo htmlentities($cat_author) ?></td>
                        <td><a href="delete_cat.php?id=<?php echo $cat_id ?>" class="btn btn-danger">Delete</a></td>
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