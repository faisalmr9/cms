<?php 

require_once('includ/db.php');
	
	function redirect_to($new_Location){

		header("Location:".$new_Location);
		exit;

	}


	function check_user_name($username){
		global $connection;

		$sql = "SELECT username FROM admins WHERE username=:username";
		$stmt = $connection->prepare($sql);
		$stmt -> bindValue(':username',$username);
		$stmt -> execute();
		$result = $stmt -> rowcount();
		if ($result==1) {
			return true;
		}else {
			return false;
		}
	}


	function login_attempt($username,$password){
		global $connection;

		$sql = "SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
		$stmt = $connection->prepare($sql);
		$stmt -> bindValue(':userName',$username);
		$stmt -> bindValue(':passWord',$password);
		$stmt -> execute();
		$result = $stmt -> rowcount();
		if ($result==1) {
			return $user_match = $stmt -> fetch();
		}else {
			return null;
		}
	}

	function confirm_login(){
		if (isset($_SESSION['user_id'])) {
			return true;
			
		}else {

			$_SESSION['error_message'] = "Please Login!!";
			redirect_to('login.php');
		}
	}

	function total_post(){
		global $connection;
		$sql = "SELECT count(*) FROM post";
		$stmt = $connection->query($sql);
		$data_rows = $stmt->fetch();
		$total_post = array_shift($data_rows);
		echo $total_post;
	}

	function total_category(){
		global $connection;
		$sql = "SELECT count(*) FROM category";
		$stmt = $connection->query($sql);
		$data_rows = $stmt->fetch();
		$total_cat = array_shift($data_rows);
		echo $total_cat;
	}

	function total_admin(){
		global $connection;
		$sql = "SELECT count(*) FROM admins";
		$stmt = $connection->query($sql);
		$data_rows = $stmt->fetch();
		$total_admin = array_shift($data_rows);
		echo $total_admin;
	}

	function total_comment(){
		global $connection;
		$sql = "SELECT count(*) FROM comments";
		$stmt = $connection->query($sql);
		$data_rows = $stmt->fetch();
		$total_comment = array_shift($data_rows);
		echo $total_comment;
	}

	

 ?>