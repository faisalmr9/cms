<?php

    require_once('includ/db.php');
    require_once('includ/function.php');
    require_once('includ/sessions.php');
    $page = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Custom CMS | Blog Posts</title>
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
                        <li class="nav-item"><a class="nav-link text-light" href="blog.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">About Us</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">Gallery</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="blog.php">Blog</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">Features</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">Contact Us</a></li>
                    </ul>
                    <ul class="navbar-nav">
                        <form action="blog.php" method="GET" class="form-inline">
                            <div class="form-group">
                                <input type="text" name="serarch_txt" placeholder="search" class="form-control">
                                <button class="btn btn-info ml-1" name="serarch_btn">Go</button>
                            </div>
                        </form>
                    </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <!-- header menu end -->

    <!-- Body area start -->


    <!-- Blog post -->

    <div class="container">
        <div class="row my-5">
            <div class="col-md-8">
                <h1 class="lead mb-4">Blog Posts</h1>

                <?php
                global $connection;
                echo error_message();
                echo success_message();
                if (isset($_GET['serarch_btn'])) {
                    $search_input = $_GET['serarch_txt'];
                    if (empty($search_input)) {
                        $_SESSION['error_message'] ='Oops !! Type Somthing to search.';
                        redirect_to('blog.php');
                    } else {
                        $sql = "SELECT * FROM post WHERE datetime LIKE :search OR title LIKE :search OR category LIKE :search OR author LIKE :search OR post LIKE :search";
                        $stmt = $connection -> prepare($sql);
                        $stmt -> bindValue(':search', '%'.$search_input.'%');
                        $stmt ->execute();
                    }
                } elseif (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    if ($page == 0 || $page < 1) {
                        $post_start = 0;
                    } else {
                        $post_start = ($page * 4) - 4;
                    }
                    $sqlp = "SELECT * FROM post ORDER BY id DESC LIMIT $post_start,4";
                    $stmt = $connection->query($sqlp);
                } else {
                    $sql = "SELECT * FROM post ORDER BY id DESC LIMIT 0,4";
                    $stmt = $connection -> query($sql);
                }
                
                while ($data_rows = $stmt -> fetch()) {
                        $id = $data_rows['id'];
                        $datetime = $data_rows['datetime'];
                        $post_title = $data_rows['title'];
                        $category = $data_rows['category'];
                        $author = $data_rows['author'];
                        $image = $data_rows['image'];
                        $post_text = $data_rows['post'];
                    ?>
            <br>
            <div class="card">
                <img src="uploads/<?php echo htmlentities($image); ?>" alt="Post Image" class="img-fluid" style="max-height: 400px">
                <div class="card-body">
                    <h4 class="card-title"><?php echo htmlentities($post_title); ?></h4>
                    <small class="text-muted">Category: <span class="text-success"><?php echo htmlentities($category) ?></span> | Post By : <span class="text-danger"><a href="adminProfile.php?username=<?php echo htmlentities($author) ?>"><?php echo htmlentities($author); ?></a></span>  On <b><?php echo htmlentities($datetime); ?></b></small>
                    <span class="badge badge-dark" style="float: right;cursor: pointer;">Comment (<?php

                        global $connection;
                        $sqlcomm = "SELECT count(*) FROM comments WHERE post_id='$id'";
                        $stmtcomm = $connection->query($sqlcomm);
                        $data_rows_comm = $stmtcomm->fetch();
                        $total_comment = array_shift($data_rows_comm);
                        echo $total_comment;
                        
                    ?>) </span>
                    <hr>
                    <p class="card-text">
                        <?php

                        if (strlen($post_text)>100) {
                                        $post_text = substr($post_text, 0, 80).'...';
                                        echo htmlentities($post_text);
                        } else {
                            echo htmlentities($post_text);
                        }
                          
                        ?>
                    </p>
                    <a href="fullpage.php?id=<?php echo $id ?>"><span style="float: right; cursor: pointer;" class="btn btn-sm btn-info">Read More </span></a>
                </div>
            </div>
                <?php } ?>

            <!-- pagination -->
                
                <div class="blog-pagination mt-5">
                    <ul class="pagination">

                        <?php
                        if ($page > 1) { ?>
                            <li class="page-item">
                                <a class="page-link" href="blog.php?page=<?php echo $page-1 ?>">&laquo;</a>
                            </li>
                        <?php } ?>

                      <?php
                        global $connection;
                        $sql = "SELECT count(*) FROM post ORDER BY id DESC";
                        $stmt = $connection->query($sql);
                        $pagination_row = $stmt->fetch();
                        $total_post = array_shift($pagination_row);
                        $post_pagination = ceil($total_post / 4);

                        for ($i = 1; $i <= $post_pagination; $i++) { ?>
                                <?php
                                if ($i == $page) {  ?>
                                        <li class="page-item active">
                                            <a class="page-link" href="blog.php?page=<?php echo $i; ?>">
                                            <?php echo $i ?></a>
                                        </li>
                                    <?php
                                } else { ?>
                                <li class="page-item">
                                    <a class="page-link" href="blog.php?page=<?php echo $i; ?>">
                                    <?php echo $i ?></a>
                                </li>
                                    
                                <?php } ?> 

                        <?php } ?>
                                

                        <?php
                        if (!empty($page)) {
                            if ($page+1 <= $post_pagination) { ?>
                            <li class="page-item">
                                <a class="page-link" href="blog.php?page=<?php echo $page+1 ?>">&raquo;</a>
                            </li>
                            <?php }
                        } ?>

                    </ul>
                </div>
            <!-- pagination end -->

            <!-- blog end -->

            </div>
            <!-- sidebar start -->
            <div class="col-md-4">
                <!-- ad -->
                <div class="card mt-4">
                    <div class="card-body">
                        <img src="img/sideber.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="text-center">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate unde animi nam, quidem maiores mollitia veniam doloribus optio rem deleniti?
                    </div>
                </div>
                <br>
                <!-- recent post -->

                <div class="card">
                    <div class="card-header bg-warning">
                        <h2 class="card-title text-light">Recent Post</h2>
                    </div>
                    <div class="card-body">

                        <?php

                        global $connection;

                        $sql = "SELECT * FROM post order by id desc limit 0,5";
                        $stmt = $connection->query($sql);
                        while ($data_rows = $stmt->fetch()) {
                            $post_id = $data_rows['id'];
                            $post_title = $data_rows['title'];
                            $post_date = $data_rows['datetime'];
                            $post_thumb = $data_rows['image'];
                            ?>

                        <div class="media mt-2">
                            <img src="uploads/<?php echo $post_thumb ?>" class="d-block img-fluid align-items-start" width="90" height="90" alt="img">
                            <div class="media-body ml-2">


                                <a href="fullpage.php?id=<?php echo $post_id ?>"><h5 class="lead"><?php
                                if (strlen($post_title)>20) {
                                    $post_title = substr($post_title, 0, 15).'...';
                                    echo htmlentities($post_title);
                                } else {
                                    echo htmlentities($post_title);
                                }

                                ?></h5></a>


                                <p class="small"><?php echo htmlentities($post_date) ?></p>
                            </div>
                        </div>
                        
                        <?php } ?>

                    </div>
                </div>
                <!-- newsletter <--><br>
                <div class="card">
                    <div class="card-header bg-info">
                        <h2 class="card-title text-light">Newsletter</h2>
                    </div>
                    <div class="card-body">
                        <form action="#">
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Your Email">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="form-control btn btn-info" value="Sign Up">
                            </div>
                        </form>
                    </div>
                </div><br>
                <!-- category -->
                <div class="card">
                    <div class="card-header bg-warning">
                        <h2 class="card-title text-light">Category</h2>
                    </div>
                    <div class="card-body">
                        <?php

                            global $connection;
                            $sql = "SELECT * FROM category order by id asc";
                            $stmt = $connection -> query($sql);

                        while ($data_rows = $stmt -> fetch()) {
                            $cat_name = $data_rows['title'];

                            ?>

                            <a href="#" class="mt-4 text-success text-uppercase"><?php echo $cat_name ?></a><br>
                                
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    
    


    <!-- Body area end -->




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