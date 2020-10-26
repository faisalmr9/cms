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
    <title>Custom CMS | All Posts</title>
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
                <div class="col-md-12">
                    <?php

                    echo error_message();
                    echo success_message();


                    ?>
                    <h1> <i class="fab fa-dashcube"></i> Dashbord </h1>

                </div>

                <div class="col-lg-3 my-2">
                    <a href="add_new_post.php" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"> Manage Post</i>
                    </a>
                </div>

                <div class="col-lg-3 my-2">
                    <a href="category.php" class="btn btn-info btn-block">
                        <i class="fas fa-folder-plus"> Manage Category</i>
                    </a>
                </div>

                <div class="col-lg-3 my-2">
                    <a href="admin.php" class="btn btn-success btn-block">
                        <i class="fas fa-user-plus"> Manage Admin</i>
                    </a>
                </div>

                <div class="col-lg-3 my-2">
                    <a href="comments.php" class="btn btn-primary btn-block">
                        <i class="fas fa-check"> Manage Comments</i>
                    </a>
                </div>


            </div>
        </div>
    </header>
    <!-- header area end -->

    <!-- main area -->
    <section class="py-3 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 mt-3">
                    <div class="card bg-success mb-3 text-center text-light">
                        <div class="card-body">
                            <h1 class="lead">Total Post</h1>
                            <h4 class="display-5">
                                <i class="fab fa-readme"></i>
                                <?php
                                total_post();
                                ?>
                            </h4>
                        </div>
                    </div>
                    <div class="card bg-info mb-3 text-center text-light">
                        <div class="card-body">
                            <h1 class="lead">Categories</h1>
                            <h4 class="display-5">
                                <i class="fas fa-folder"></i>
                                <?php
                                total_category();
                                ?>
                            </h4>
                        </div>
                    </div>
                    <div class="card badge-dark mb-3 text-center text-light">
                        <div class="card-body">
                            <h1 class="lead">Admins</h1>
                            <h4 class="display-5">
                                <i class="fas fa-user"></i>
                                <?php
                                total_admin()
                                ?>
                            </h4>
                        </div>
                    </div>
                    <div class="card bg-primary mb-3 text-center text-light">
                        <div class="card-body">
                            <h1 class="lead">Comments</h1>
                            <h4 class="display-5">
                                <i class="fas fa-comment"></i>
                                <?php
                                total_comment();
                                ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-10 mt-2">
                    <h1 class="text-dark">Latest Post</h1>
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>SL.</th>
                                <th>Date & Time</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Comments</th>
                                <th>Preview</th>    
                            </tr>
                        </thead>
                        <?php

                        global $connection;

                        $sql = "SELECT * FROM post ORDER BY id desc LIMIT 0,6";
                        $stmt = $connection->query($sql);
                        $sl = 0;

                        while ($data_rows = $stmt->fetch()) {
                                $id = $data_rows['id'];
                                $datetime = $data_rows['datetime'];
                                $post_title = $data_rows['title'];
                                $category = $data_rows['category'];
                                $author = $data_rows['author'];
                                $image = $data_rows['image'];
                                $post_text = $data_rows['post'];
                                $sl++;
                            ?>

                        <tbody>

                            <tr>
                                <td><?php echo $sl; ?></td>
                                <td><?php echo $datetime ?></td>
                                <td>
                                    <?php
                                    if (strlen($post_title)>20) {
                                        $post_title = substr($post_title, 0, 15).'...';
                                    }
                                     echo $post_title
                                    ?>
                                </td>
                                <td><?php echo $author ?></td>
                                <td>
                                    <span class="badge badge-success">
                                        <?php
                                        global $connection;
                                        $sqlapp = "SELECT count(*) FROM comments WHERE post_id='$id' AND status='ON'";
                                        $stmtapp = $connection -> query($sqlapp);
                                        $total_rows = $stmtapp -> fetch();
                                        $total = array_shift($total_rows);
                                        echo $total;
                                        ?>
                                    </span>
                                    <span class="badge badge-danger">
                                        <?php
                                        global $connection;
                                        $sqlre = "SELECT count(*) FROM comments WHERE post_id='$id' AND status='OFF'";
                                        $stmtre = $connection -> query($sqlre);
                                        $total_rows = $stmtre -> fetch();
                                        $total_re = array_shift($total_rows);
                                        echo $total_re;
                                        ?>
                                    </span>
                                </td>
                                <td><a href="fullpage.php?id=<?php echo $id ?>" target="_blank" class="btn btn-info"> <span><i class="fas fa-eye"></i></span> </a></td>
                            </tr>
                            
                        </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- main area end-->


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