<?php

	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['pass'])))
	{
		header('Location: Login.php');
		exit();
	}
	
	unset($_SESSION['registrationSuccess']);
	unset($_SESSION['login Error']);
	
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
		sprintf("SELECT * FROM users WHERE username='%s'",
		mysqli_real_escape_string($dbConnection,$login))))
		{
			$howManyUsers = $result->num_rows;
			if($howManyUsers>0)
			{
				$lineWithDatas = $result->fetch_assoc();
				
				if (password_verify($pass, $lineWithDatas['password']))
				{
					$_SESSION['isUserLoggedIn'] = true;
					
					
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
			else 
			{	
				$_SESSION['loginError'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: Login.php');	
			}
		}
		
		$dbConnection->close();
	}
	
	
?>