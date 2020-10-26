<?php

    require_once('includ/db.php');
    require_once('includ/function.php');
    require_once('includ/sessions.php');
    $search_id_frm_url = $_GET['id'];


if (isset($_POST['submit'])) {
    $commenter_name = $_POST['commenter_name'];
    $commenter_mail = $_POST['commenter_mail'];
    $comment        = $_POST['comment'];

    date_default_timezone_set("Asia/Dhaka");
    $current_time = time();
    $date_time = strftime("%B-%d-%Y  %H:%M", $current_time);

    if (empty($commenter_name) || empty($commenter_mail) || empty($comment)) {
        $_SESSION['error_message'] ='All fields must be filled out';

        redirect_to("fullpage.php?id={$search_id_frm_url}");
    } else {
        $sql = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
        $sql .= "VALUES('$date_time','$commenter_name','$commenter_mail','$comment','Panding','OFF','$search_id_frm_url')";
        $stmt = $connection-> prepare($sql);
        $execute = $stmt-> execute();

        if ($execute) {
            $_SESSION['success_message'] ='Comment Added Succesfully';
            redirect_to("fullpage.php?id={$search_id_frm_url}");
        } else {
            $_SESSION['error_message'] ='Something went wrong!! Try again!!';
            redirect_to("fullpage.php?id={$search_id_frm_url}");
        }
    }
}
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
                    $sql = "SELECT * FROM post WHERE datetime LIKE :search OR title LIKE :search OR category LIKE :search OR author LIKE :search OR post LIKE :search";
                    $stmt = $connection -> prepare($sql);
                    $stmt -> bindValue(':search', '%'.$search_input.'%');
                    $stmt ->execute();
                } else {
                    $id_from_url = $_GET['id'];
                    if (!isset($id_from_url)) {
                        $_SESSION['error_message'] ='Bad Request!!!';
                        redirect_to('blog.php');
                    }

                    $sql = "SELECT * FROM post WHERE id='$id_from_url'";
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

            <div class="card">
                <img src="uploads/<?php echo htmlentities($image); ?>" alt="Post Image" class="img-fluid" style="max-height: 400px">
                <div class="card-body">
                    <h4 class="card-title"><?php echo htmlentities($post_title); ?></h4>
                    <small class="text-muted">Post By : <b><?php echo htmlentities($author); ?></b>  On <b><?php echo htmlentities($datetime); ?></b></small>
                    <hr>
                    <p class="card-text">
                        <?php
                            echo htmlentities($post_text);
                        ?>
                    </p>
                    
                </div>
            </div>
                <?php } ?>
            <!-- all comments area start -->
            <div class="comment-featching my-3">
                
                <h2 class="text-warning">Comments:</h2>

                <?php

                global $connection;

                $sql = "SELECT * FROM comments WHERE post_id='$search_id_frm_url' AND status='ON'";

                $stmt = $connection -> query($sql);

                while ($data_rows = $stmt->fetch()) {
                    $fetch_name     = $data_rows['name'];
                    $fetch_date     = $data_rows['datetime'];
                    $fetch_comment  = $data_rows['comment'];

                    ?>
                
                <div class="media bg-light p-3 mb-2">
                    <div class="media-body">
                        <h6 class="lead"><?php echo $fetch_name; ?></h6>
                        <hr>
                        <p class="small"><?php echo $fetch_date; ?></p>
                        <p class="text-primary"><?php echo $fetch_comment; ?></p>
                    </div>
                </div>

                    <?php
                }

                ?>
    
            </div>



            <!-- all comments area end -->


            <!-- post comment area -->
            <div class="viewer-comments mt-3">
            <form action="fullpage.php?id=<?php echo $search_id_frm_url ?>" method="post">
                <div class="card mb-2">
                    <div class="card-header">
                        <h4 class="text-info">Leave your reply.</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input name="commenter_name" type="text" class="form-control" placeholder="Name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input name="commenter_mail" type="email" class="form-control" placeholder="Email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <textarea name="comment" class="form-control" id="" cols="30" rows="6" placeholder="Message" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="form-control btn btn-primary btn-block">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
<!-- post comment area -->
            </div>
            <div class="col-md-4">
                <!-- ad -->
                <div class="card mt-4">
                    <div class="card-body">
                        <img src="img/sideber.jpg" class="img-fluid" style="" alt="">
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