 <?php 
	require_once('includ/db.php');
	require_once('includ/function.php');
	require_once('includ/sessions.php');
	$_SESSION['url_tracking'] = $_SERVER['PHP_SELF'];
	confirm_login();

	// fatching personal data_rows

		$user_id = $_SESSION['user_id'];

		global $connection;

		$sql = "SELECT * FROM admins where id='$user_id'";

		$stmt = $connection->query($sql);

		while ($user_data = $stmt->fetch()) {
		    $admin_user_name = $user_data['username'];
		    $admin_user_tag = $user_data['tagline'];
		    $admin_user_img = $user_data['img'];
		    $admin_user_bio = $user_data['bio'];
		    $admin_name = $user_data['adminname'];
		    $admin_email = $user_data['email'];
		    $admin_added_by = $user_data['addedby'];
		}

		// fatching personal data_rows

	if (isset($_POST['submit'])) {

		$user_name = $_POST['admin_user_name'];
		$admin_name = $_POST['admin_name'];
		$user_tag = $_POST['tagline'];
		$user_bio = $_POST['bio'];
		$post_image = $_FILES['post_image']['name'];
		$img_path = "img/".basename($_FILES['post_image']['name']);
		

		if (strlen($user_tag) > 50 ) {
		
		$_SESSION['error_message'] ='Tagline must be in 50 Charecter';

		redirect_to('myprofile.php');

		}elseif (strlen($user_bio) >= 999 ) {
		
		$_SESSION['error_message'] ='Bio must be less than 1000 charecter';
		redirect_to('myprofile.php');

		}else {
			
			if (!empty($post_image)) {

				$sql = "UPDATE admins SET username='$user_name', adminname='$admin_name' ,tagline='$user_tag', bio='$user_bio', img='$post_image' WHERE id='$user_id'";

			}else {

				$sql = "UPDATE admins SET username='$user_name', adminname='$admin_name' ,tagline='$user_tag', bio='$user_bio' WHERE id='$user_id'";				
			}
			$execute = $connection -> query($sql);
			
			move_uploaded_file($_FILES['post_image']['tmp_name'], $img_path);

			if ($execute) {

				$_SESSION['success_message'] ='Your Profile Updated Succesfully';
				redirect_to('myprofile.php');
			}else {
				
				$_SESSION['error_message'] ='Something went wrong. Try again!!';
				redirect_to('myprofile.php');
			}
		}
		
	}

 ?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Custom CMS | New Post</title>
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
				<h1> <i class="fas fa-user"></i> Profile </h1>
			</div>
		</div>
	</header>
	<!-- header area end -->

	<!-- main area start -->
	<section class="container py-2 mb-4">
		<div class="row">
			<div class="col-lg-4">
				<div class="card mt-3">
					<div class="card-header bg-dark text-light">
						<h3 class="card-title"><?php echo $admin_user_name ?></h3>
						<p  class="text-warning"><?php echo $admin_user_tag ?></p>
					</div>
					<div class="card-body">
						<img src="img/<?php echo $admin_user_img ?>" class="img-fluid d-block" alt="user image" style="border-radius: 50%;height: 150px;width: 150px; margin: 0px auto;">
						<p class="mt-2"><?php echo $admin_name ?><span class="text-success" style="margin-left: 150px;text-align: right;">Online</span></p>
						<p class="mt-2"><?php echo $admin_added_by ?><span class="text-warning" style="margin-left: 120px;text-align: right;">Added By</span></p>
						<p class="mt-2"><?php echo $admin_user_bio ?></p>
					</div>
				</div>
			</div>
			<div class="col-lg-8">
				<?php 

					echo error_message();
					echo success_message();

				 ?>
				<form action="myprofile.php" method="post" enctype="multipart/form-data">
					<div class="card mb-3 mt-3">
						<div class="card-header bg-dark text-light">
							<h3>Edit Profile</h3>
						</div>
						<div class="card-body bg-dark text-light">
							<div class="form-group">
								<input type="text" name="admin_name" placeholder="Your Name" class="form-control">
							</div>
							<div class="form-group">
								<input type="text" name="tagline" placeholder="Tag Line" class="form-control">
							</div>

							<div class="form-group">
								<textarea name="bio" placeholder="Bio" class="form-control" rows="6"></textarea>
							</div>

							<div class="form-group">
								<div class="custom-file">
									<input type="file" name="post_image" class="custom-file-input" id="customFile">
									<label for="customFile" class="custom-file-label">Upload Image</label>
								</div>
							</div>
							
							
							<div class="row">
								<div class="col-lg-6 mb-1">
									<a href="dashboard.php" class="btn btn-primary d-block text-white"> <i class="fas fa-arrow-left"></i>Back To Dashboard</a>
								</div>
								<div class="col-lg-6">
									<button type="submit" name="submit" class="btn btn-success d-block btn-block text-white"><i class="fas fa-check"></i>Update User</button>
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