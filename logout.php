<?php 

	session_start();

	$_SESSION = array();

	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-86400, '/');
	}

	session_destroy();

	// this will be redirecting user back to login page
	header('Location: register.php?action=logout');

 ?>