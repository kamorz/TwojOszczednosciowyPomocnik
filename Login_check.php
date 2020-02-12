<?php

	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['pass'])))
	{
		header('Location: Login.php');
		exit();
	}
	
	require_once "connect.php";

	$dbConnection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($dbConnection->connect_errno!=0)
	{
		echo "Error: ".$dbConnection->connect_errno;
	}
	else
	{
		
		
		$dbConnection->close();
	}
	
	
?>