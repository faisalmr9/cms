
<?php


    require_once('includ/db.php');
    require_once('includ/function.php');
    require_once('includ/sessions.php');
    $_SESSION['url_tracking'] = $_SERVER['PHP_SELF'];
    confirm_login();

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
                <h1> <i class="fas fa-comments"></i> Manage Post Comments </h1>
            </div>
        </div>
    </header>
    <!-- header area end -->

    <!-- main area start -->

    <section class="container py-2 mb-3">
        <div class="row" style="min-height: 50px;">
            <div class="col-lg-12" style="min-height: 400px;">
                <h2 class="text-center">All Unapproved Comments</h2>
                <?php

                    echo error_message();
                    echo success_message();

                ?>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>SL</th>
                            <th>Date Time</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                <?php

                // echo error_message();
                // echo success_message();

                global $connection;

                $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY datetime ASC";

                $execute = $connection -> query($sql);

                $sl=0;

                while ($data_rows = $execute -> fetch()) {
                    $comment_id = $data_rows['id'];
                    $comment_time = $data_rows['datetime'];
                    $comment_by = $data_rows['name'];
                    $comment_email = $data_rows['email'];
                    $comment_comment = $data_rows['comment'];
                    $comment_approvedby = $data_rows['approvedby'];
                    $comment_status = $data_rows['status'];
                    $comment_post_id = $data_rows['post_id'];

                    $sl++;

                    ?>
                    
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($sl) ?></td>
                        <td><?php echo htmlentities($comment_time) ?></td>
                        <td><?php echo htmlentities($comment_by) ?></td>
                        <td><?php echo htmlentities($comment_comment) ?></td>
                        <td><a href="approve_comment.php?id=<?php echo $comment_id ?>" class="btn btn-success">Approve</a></td>
                        <td><a href="delete_comment.php?id=<?php echo $comment_id ?>" class="btn btn-danger">Delete</a></td>
                        <td><a href="fullpage.php?id=<?php echo $comment_id ?>" class="btn btn-primary" target="_blank"><i class="fas fa-eye"></i></a></td>
                        
                    </tr>
                </tbody>

                    <?php
                }
                ?>
                </table>
                <h2 class="text-center">All approved Comments</h2>
                <?php

                    echo error_message();
                    echo success_message();

                ?>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>SL</th>
                            <th>Date Time</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Reject</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                <?php

                global $connection;

                $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY datetime ASC";

                $execute = $connection -> query($sql);

                $sl=0;

                while ($data_rows = $execute -> fetch()) {
                    $comment_id = $data_rows['id'];
                    $comment_time = $data_rows['datetime'];
                    $comment_by = $data_rows['name'];
                    $comment_email = $data_rows['email'];
                    $comment_comment = $data_rows['comment'];
                    $comment_approvedby = $data_rows['approvedby'];
                    $comment_status = $data_rows['status'];
                    $comment_post_id = $data_rows['post_id'];

                    $sl++;

                    ?>
                    
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($sl) ?></td>
                        <td><?php echo htmlentities($comment_time) ?></td>
                        <td><?php echo htmlentities($comment_by) ?></td>
                        <td><?php echo htmlentities($comment_comment) ?></td>
                        <td><a href="reject.php?id=<?php echo $comment_id ?>" class="btn btn-success">Reject</a></td>
                        <td><a href="delete_comment.php?id=<?php echo $comment_id ?>" class="btn btn-danger">Delete</a></td>
                        <td><a href="fullpage.php?id=<?php echo $comment_id ?>" class="btn btn-primary" target="_blank"><i class="fas fa-eye"></i></a></td>
                        
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
                    <p class="text-center">Developed By <a href="https://www.srftech-bd.net" class="text-success">Faisal Ahmed</a> | All Right Reserved </p> 
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