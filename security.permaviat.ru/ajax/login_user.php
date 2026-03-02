<?php
	session_start();
	include("../settings/connect_datebase.php");
	
	$login = $_POST['login'];
	$password = $_POST['password'];
	$code = $_POST['code'];

	$token = rand(1000000, 9999999);
	
	// ищем пользователя
	$query_user = $mysqli->query("SELECT * FROM `users` WHERE `login`='".$login."';");
	
	$id = -1;
	while($user_read = $query_user->fetch_row()) {
		if(password_verify($password,$user_read[2]) ){
			$id = $user_read[0];
		}
	}


	// && $code == $_SESSION['code']


	$mysqli->query("UPDATE `users` SET `token` ='".$token."' WHERE `id`='".$id."';");

	$_SESSION['token'] = $token;
	
	if($id != -1) {
		$_SESSION['user'] = $id;
	}
	echo $_SESSION['code'];
?>