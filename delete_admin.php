<?php 

	require_once('includ/db.php');
	require_once('includ/function.php');
	require_once('includ/sessions.php');
	$_SESSION['url_tracking'] = $_SERVER['PHP_SELF'];
	confirm_login();

	if (isset($_GET['id'])) {
		$search_url_id = $_GET['id'];
		global $connection;
		$admin = $_SESSION['user_name'];
		$sql = "DELETE FROM admins WHERE id='$search_url_id'";
		$execute = $connection -> query($sql);
		if ($execute) {
			$_SESSION['success_message'] ='Admin Deleted.';
			redirect_to('admin.php');
			
		}else {

			$_SESSION['error_message'] ='Something went worng!! Try again.';
			redirect_to('admin.php');
				
			}
		
	}

 ?>