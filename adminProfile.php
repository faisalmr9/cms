<?php

    require_once('includ/db.php');
    require_once('includ/function.php');
    require_once('includ/sessions.php');

    $search_query_peram = $_GET['username'];
    global $connection;
    $sql = "SELECT username,tagline,img,bio FROM admins WHERE username=:username";
    $stmt = $connection -> prepare($sql);
    $stmt -> bindValue(':username', $search_query_peram);
    $stmt -> execute();
    $result = $stmt -> rowcount();
if ($result==1) {
    while ($data_rows = $stmt -> fetch()) {
        $username = $data_rows['username'];
        $tagline  = $data_rows['tagline'];
        $img      = $data_rows['img'];
        $bio      = $data_rows['bio'];
    }
} else {
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

    <!-- header area start -->
    <header class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php echo $username; ?></h1>
                    <h6><?php echo htmlentities($tagline) ?></h6>
                </div>
            </div>
        </div>
    </header>
    <!-- header area end -->

    <!-- main area start -->
    <div class="container">
        <div class="row my-4">
            <div class="col-lg-3">
                <img src="img/<?php echo $img ?>" class="d-block img-fluid img-thumbnail" alt="Author">
            </div>
            <div class="col-lg-6">
                <p><?php echo htmlentities($bio) ?></p>
            </div>
        </div>
    </div>
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