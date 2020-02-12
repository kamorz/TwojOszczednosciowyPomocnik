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
		$login = $_POST['login'];
		$pass = $_POST['pass'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$pass = htmlentities($pass, ENT_QUOTES, "UTF-8");
		
		if ($result = @$dbConnection->query(
		sprintf("SELECT * FROM users WHERE username='%s' AND password='%s'",
		mysqli_real_escape_string($dbConnection,$login),
		mysqli_real_escape_string($dbConnection,$pass))))
		{
			$howManyUsers = $result->num_rows;
			if($howManyUsers>0)
			{
				$_SESSION['isUserLoggedIn'] = true;
				
				$lineWithDatas = $result->fetch_assoc();
				$_SESSION['loggedUserId'] = $lineWithDatas['id'];
				$_SESSION['userEmail'] = $lineWithDatas['email'];
				
				
				unset($_SESSION['loginError']);
				$result->free_result();
				header('Location: UserMainMenu.php');
				
			} 
			else 
			{	
				$_SESSION['loginError'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: Login.php');	
			}
		}
		
		$dbConnection->close();
	}
	
	
?>