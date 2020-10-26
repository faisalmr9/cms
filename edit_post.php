 <?php
    require_once('includ/db.php');
    require_once('includ/function.php');
    require_once('includ/sessions.php');
    confirm_login();

    $query_ID = $_GET['id'];

 if (isset($_POST['submit'])) {
     $post_title = $_POST['post_title'];
     $post_cat = $_POST['post_cat'];
     $post_image = $_FILES['post_image']['name'];
     $img_path = "uploads/".basename($_FILES['post_image']['name']);
     $post_description = $_POST['post_description'];
     $author = $_SESSION['user_name'];
     date_default_timezone_set("Asia/Dhaka");
     $current_time = time();
     $date_time = strftime("%B-%d-%Y  %H:%M", $current_time);

     if (empty($post_title)) {
         $_SESSION['error_message'] ='Post title must be filled out';

         redirect_to('edit_post.php');
     } elseif (strlen($post_description) <= 10) {
         $_SESSION['error_message'] ='Post description must be more than 10 charecter';

         redirect_to('edit_post.php');
     } elseif (strlen($post_description) >= 9999) {
         $_SESSION['error_message'] ='Post description must be less than 1000 charecter';
         redirect_to('edit_post.php');
     } else {
         if (!empty($post_image)) {
             $sql = "UPDATE post SET title='$post_title', category='$post_cat', image='$post_image', post='$post_description' WHERE id='$query_ID'";
         } else {
             $sql = "UPDATE post SET title='$post_title', category='$post_cat', post='$post_description' WHERE id='$query_ID'";
         }
         $execute = $connection -> query($sql);
            
         move_uploaded_file($_FILES['post_image']['tmp_name'], $img_path);

         if ($execute) {
             $_SESSION['success_message'] ='Post Updated Succesfully';
             redirect_to('posts.php');
         } else {
             $_SESSION['error_message'] ='Something went wrong. Try again!!';
             redirect_to('posts.php');
         }
     }
 }

    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Custom CMS | Edit Post</title>
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
                <h1> <i class="fas fa-edit"></i> Manage Post </h1>
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

                    global $connection;

                    
                    $sql = "SELECT * FROM post WHERE id='$query_ID'";
                    $stmt = $connection -> query($sql);
                while ($data_rows = $stmt -> fetch()) {
                    $post_title = $data_rows['title'];
                    $category = $data_rows['category'];
                    $image = $data_rows['image'];
                    $post_text = $data_rows['post'];
                }

                ?>
                <form action="edit_post.php?id=<?php echo $query_ID; ?>" method="post" enctype="multipart/form-data">
                    <div class="card mb-3 mt-3">
                        <div class="card-header">
                            <h1>Edit Post</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title" class="text-white">Post Title</label>
                                <input value="<?php echo $post_title ?>" type="text" name="post_title" id="title" placeholder="Post Title" class="form-control">
                            </div>
                            <div class="form-group">
                                <span class="text-white">Current Category :</span> <span class="text-white"><?php echo $category; ?></span><br> 
                                <label for="" class="text-white">Choose Cagetory</label>
                                <select class="form-control" name="post_cat" id="">
                                    <option value="">Select Cagetory</option>
                                    
                                    <?php

                                    global $connection;

                                    $sql = "SELECT id,title FROM category";

                                    $stmt = $connection->query($sql);

                                    while ($data_rows = $stmt->fetch()) {
                                        $cat_id = $data_rows['id'];
                                        $cat_title= $data_rows['title'];

                                        ?>

                                    <option value="<?php echo $cat_title; ?>"><?php echo $cat_title; ?></option>
                                        <?php
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <span class="text-white">Current Category :</span> <span class="text-white"><?php echo $image; ?></span><br>
                                <label class="text-white">Post Image</label>
                                <div class="custom-file">
                                    <input type="file" name="post_image" class="custom-file-input" id="customFile">
                                    <label for="customFile" class="custom-file-label">Upload Image</label>
                            </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="text-white">Post</label>
                                <textarea name="post_description" placeholder="Post Description" class="form-control" id="" rows="5"><?php echo $post_text; ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-1">
                                    <a href="posts.php" class="btn btn-primary d-block text-white"> <i class="fas fa-arrow-left"></i>Back To Post</a>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" name="submit" class="btn btn-success d-block btn-block text-white"><i class="fas fa-check"></i>Update Post</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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

    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
          var fileName = $(this).val().split("\\").pop();
          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>

</body>
</html>