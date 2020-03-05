<?php

	session_start();
	
	session_unset();
	
	unset($_SESSION['isUserLoggedIn']);
	
	header('Location: Login.php');

?>