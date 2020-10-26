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
					<h1> <i class="fas fa-blog"></i> All Post </h1>
				</div>

				<div class="col-lg-4 my-2">
					<a href="add_new_post.php" class="btn btn-primary btn-block">
						<i class="fas fa-edit"> Add New Post</i>
					</a>
				</div>

				<div class="col-lg-4 my-2">
					<a href="category.php" class="btn btn-info btn-block">
						<i class="fas fa-folder-plus"> Add New Category</i>
					</a>
				</div>

				<div class="col-lg-4 my-2">
					<a href="comments.php" class="btn btn-primary btn-block">
						<i class="fas fa-check"> Approve Comments</i>
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
				<div class="col-12">
					<table class="table table-hover">

						<thead class="thead-dark">
							<tr>
								<th>SL</th>
								<th>Title</th>
								<th>Category</th>
								<th>Post Date</th>
								<th>Author</th>
								<th>Image</th>
								<th>Comment</th>
								<th>View</th>
								<th>Action</th>
							</tr>
						</thead>
						<?php 

							global $connection;

							$sql = "SELECT * FROM post";

							$stmt = $connection -> query($sql);

							$sl = 0;

							while ($data_rows = $stmt -> fetch()) {
							    
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
						 		<td>
						 			<?php
						 			if (strlen($post_title)>20) {
						 				$post_title = substr($post_title,0,15).'...';	
						 			}
						 			 echo $post_title 
						 			 ?>
						 		</td>
						 		<td><?php echo $category ?></td>
						 		<td><?php echo $datetime ?></td>
						 		<td><?php echo $author ?></td>
						 		<td>
									<img src="uploads/<?php echo $image ?>" width='50px' height='50px' alt="">	
						 		</td>
						 		<td>comments</td>
						 		<td><a href="fullpage.php?id=<?php echo $id ?>" target="_blank"> <span><i class="fas fa-eye"></i></span> </a></td>
						 		<td>
						 			<a href="edit_post.php?id=<?php echo $id ?>"> <span class="btn btn-sm btn-warning btn-block"><i class="fas fa-edit"></i></span> </a>

						 			<a href="delete_post.php?id=<?php echo $id ?>"> <span class="btn btn-sm btn-danger btn-block"><i class="fas fa-trash"></i></span> </a>

						 		</td>
						 		
						 		
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