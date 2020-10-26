<?php 
	
	require_once('includ/function.php');
	require_once('includ/sessions.php');

	$_SESSION['User_Id'] = null;
	$_SESSION['user_name'] = null;


	session_destroy();

	redirect_to('login.php');

 ?>