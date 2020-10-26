 <?php 
	require_once('includ/db.php');
	require_once('includ/function.php');
	require_once('includ/sessions.php');

	if (isset($_SESSION['user_id'])) {
		redirect_to('dashboard.php');	
	}

	if (isset($_POST['submit'])) {

		$username 		= $_POST['username'];
		$password 		= $_POST['password'];
		
		if (empty($username) && empty($password)) {

			$_SESSION['error_message'] ='All requried fields must be filled out';

			redirect_to('login.php');

		}else {
			
			$user_match = login_attempt($username,$password);

			if ($user_match) {
				$_SESSION['user_id'] = $user_match['id'];
				$_SESSION['user_name'] = $user_match['username'];
				$_SESSION['success_message'] ='Hello, '.$_SESSION['user_name'];
				if (isset($_SESSION['url_tracking'])) {
					redirect_to($_SESSION['url_tracking']);
					
				}else {
					redirect_to('dashboard.php');
				}
			}else {

				$_SESSION['error_message'] ='Username/Password did not match!! Try again!!';
				redirect_to('login.php');
			
			}
		}
		
	}

 ?>
 


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Custom CMS | Login</title>
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
				</nav>
			</div>
		</div>
	</div>

	<!-- header menu end -->

	<!-- main area start -->

	<div class="container">
		<div class="row">
			<div class="login-area col-md-6 offset-md-3 p-4 bg-dark my-5" style="min-height: 400px; border-radius: 5px;">
		<div class="login-header">
			<?php 

				echo error_message();
				echo success_message();

			 ?>
			<h4 class="text-center text-light">Login</h4>
		</div>
		<form action="login.php" method="post">
			<div class="form-group">
				<label for="username" class="text-light">Username:</label>
				<input type="text" name="username" placeholder="Ex. abcded123@" class="form-control">
			</div>
			<div class="form-group">
				<label for="password" class="text-light">Password:</label>
				<input type="password" name="password" class="form-control" placeholder="Ex. 123fea456">
			</div>
			<div class="form-group">
				<button class="btn btn-success btn-block form-control" type="submit" name="submit">Login</button>
			</div>
		</form>
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