<?php

	session_start();
	
	unset($_SESSION['loginError']);
	
	if (isset($_POST['userEmail']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$correctRegistration=true;
		
		unset($_SESSION['registrationSuccess']);
		unset($_SESSION['loginError']);
		
		$nick = $_POST['userNick'];
		
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$correctRegistration=false;
			$_SESSION['nickError']="Nick musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($nick)==false)
		{
			$correctRegistration=false;
			$_SESSION['nickError']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		$email = $_POST['userEmail'];
		$emailFiltered = filter_var($email, FILTER_SANITIZE_EMAIL);
		if ((filter_var($emailFiltered, FILTER_VALIDATE_EMAIL)==false) || ($emailFiltered!=$email))
		{
			$correctRegistration=false;
			$_SESSION['emailError']="Podaj poprawny adres e-mail!";
		}
		
		$pass1 = $_POST['userPassword1'];
		$pass2 = $_POST['userPassword2'];
		
		if ((strlen($pass1)<5) || (strlen($pass1)>25))
		{
			$correctRegistration=false;
			$_SESSION['passError']="Hasło musi mieć co najmniej 5 i nie więcej niż 25 znaków!";
		}
		
		if ($pass1!=$pass2)
		{
			$correctRegistration=false;
			$_SESSION['passError']="Podane hasła nie są identyczne!";
		}	

		$passwordHash = password_hash($pass1, PASSWORD_DEFAULT);
		
		$_SESSION['savedNick'] = $nick;
		$_SESSION['savedEmail'] = $email;
		$_SESSION['savedPass1'] = $pass1;
		$_SESSION['savedPass2'] = $pass2;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$result = $connection->query("SELECT id FROM users WHERE email='$email'");
				
				if (!$result) throw new Exception($connection->error);
				
				$emailsAmount= $result->num_rows;
				if($emailsAmount>0)
				{
					$correctRegistration=false;
					$_SESSION['emailError']="Istnieje już konto powiązane z tym adresem e-mail!";
				}		

				//Czy nick jest już zarezerwowany?
				$result = $connection->query("SELECT id FROM users WHERE username='$nick'");
				
				if (!$result) throw new Exception($connection->error);
				
				$nicksAmount = $result->num_rows;
				if($nicksAmount>0)
				{
					$correctRegistration=false;
					$_SESSION['nickError']="Ten nick jest już zajęty";
				}
				
				if ($correctRegistration==true)
				{
					
					if ($connection->query("INSERT INTO users VALUES (NULL, '$nick', '$passwordHash', '$email')"))
					{
						$_SESSION['registrationSuccess']=true;		
						unset($_SESSION['login Error']);
						$_SESSION['statementAfterRegistrationSuccess']="Konto założone! Możesz teraz się zalogować";			

					
						//Pobranie kategorii
						$resultId = $connection->query("SELECT id FROM users WHERE username='$nick'");
						if (!$resultId) throw new Exception($connection->error);
						$row = $resultId->fetch_assoc();
						$nickNumber = $row['id'];
						
						
						$resultIncomeCategories = $connection->query("SELECT * FROM incomes_category_default");
						if (!$resultIncomeCategories) throw new Exception($connection->error);
						while ($row = $resultIncomeCategories->fetch_assoc())
						{
							$categoryName = $row['name'];
							$connection->query("INSERT INTO incomes_category_assigned_to_users VALUES (NULL, '$nickNumber', '$categoryName')");
						}
						
						$resultExpenseCategories = $connection->query("SELECT * FROM expenses_category_default");
						if (!$resultExpenseCategories) throw new Exception($connection->error);
						while ($row = $resultExpenseCategories->fetch_assoc())
						{
							$categoryName = $row['name'];
							$connection->query("INSERT INTO expenses_category_assigned_to_users VALUES (NULL, '$nickNumber', '$categoryName')");
						}
						
						$resultPaymentMethods = $connection->query("SELECT * FROM payment_methods_default");
						if (!$resultPaymentMethods) throw new Exception($connection->error);
						while ($row = $resultPaymentMethods->fetch_assoc())
						{
							$paymentMethodName = $row['name'];
							$connection->query("INSERT INTO payment_methods_assigned_to_users VALUES (NULL, '$nickNumber', '$paymentMethodName')");
						}
						
						
						//koniec

						
						header('Location: Login.php');
					}
					else
					{
						throw new Exception($connection->error);
					}	
				}			
				$connection->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
	}
	
	
?>

<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Twój Oszczędnościowy Pomocnik</title>
	<meta name="description" content="Aplikacja ułatwiająca oszczędzanie pieniędzy">
	<meta name="keywords" content="pieniądze, oszczędzanie, wydatki, kontrola, budżet">
	<meta name="author" content="Budget Controller">
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="css/fontello.css" type="text/css" />
	
	<link href="https://fonts.googleapis.com/css?family=Courier+Prime:400,700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
	
	<!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body>
	
	<main>
		
			<div class="row">
				<div class="col-3  mx-0 text-center websideTopPct">
					<img src="img/websideTop.jpg" class="img-fluid" alt="websideTop">	
				</div>
				
				<div class="col-12 col-lg-6 mx-0 text-center websideTopTxt">	
					<h1>Twój oszczędnościowy pomocnik</h1>
				</div>
				
				<div class="col-3 mx-0 text-center websideTopPct">
					<img src="img/websideTop.jpg" class="img-fluid" alt="websideTop">	
				</div>
			</div>
			<div class="row">
				<nav class="navbar navbar-dark bg-openMenu navbar-expand-md col-12 ">
				
					<a class="navbar-brand" href="index.php"><i class="icon-dollar"></i> TWÓJ OP </a>
					
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
					<span class="navbar-toggler-icon"></span>
					</button>
					
					<div class="collapse navbar-collapse" id="mainmenu">
				
						<ul class="navbar-nav mr-auto">
						
							<li class="nav-item ml-3">
								<a class="nav-link" href="index.php"> Start </a>
							</li>
							
							<li class="nav-item ml-3">
								<a class="nav-link" href="Login.php"> Logowanie </a>
							</li>
							
							<li class="nav-item ml-3 active">
								<a class="nav-link" href="Registration.php"> Rejestracja </a>
							</li>
						
						</ul>
						
						<a class="nav-link contactInvitation"  href="https://www.gmail.com" target="_blank"><i class="icon-mail-1"></i> Kontakt </a>
				
					</div>
								
				</nav>
			</div>
			<br/><br/>
			
			
				
			<div class="row">
				<div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-center mb-5 mr-0 bg-white loginForm">
					
				<h1 class="h2">REJESTRACJA </h1>
					
					<form method="post">
							
						<div class="input-group mb-3 justify-content-center">
							<input type="text" id="registrationEmail" name="userEmail" placeholder="Podaj swój email" aria-label="Login użytkownika" value="<?php
								if (isset($_SESSION['savedEmail']))
								{
									echo $_SESSION['savedEmail'];
									unset($_SESSION['savedEmail']);
								}
							?>">
								
							<div class="input-group-append">
							<span class="input-group-text"><i class="icon-mail"></i></span>
							</div>
							
						</div>
						<?php
							if (isset($_SESSION['emailError']))
							{
								echo '<div style="color: red">'.$_SESSION['emailError'].'</div>';
								unset($_SESSION['emailError']);
							}
						?>

						<div class="input-group mb-4 justify-content-center">
							<input type="text" id="registrationName" name="userNick" placeholder="Podaj swój nick" aria-label="Nick użytkownika" value="<?php
								if (isset($_SESSION['savedNick']))
								{
									echo $_SESSION['savedNick'];
									unset($_SESSION['savedNick']);
								}
							?>">
								
							<div class="input-group-append">
							<span class="input-group-text"><i class="icon-user"></i></span>
							</div>
							
						</div>
						<?php
							if (isset($_SESSION['nickError']))
							{
								echo '<div style="color: red">'.$_SESSION['nickError'].'</div>';
								unset($_SESSION['nickError']);
							}
						?>
						
						
						
						<div class="input-group mb-3 justify-content-center">
							<input type="password" id="registrationPassword" name="userPassword1" placeholder="Podaj swoje hasło" aria-label="Hasło użytkownika" value="<?php
								if (isset($_SESSION['savedPass1']))
								{
									echo $_SESSION['savedPass1'];
									unset($_SESSION['savedPass1']);
								}
							?>">
								
							<div class="input-group-append">
							<span class="input-group-text"><i class="icon-lock"></i></span>
							</div>
						</div>
						
						<div class="input-group mb-3 justify-content-center">
							<input type="password" id="registrationConfirmedPassword" name="userPassword2" placeholder="Powtórz hasło" aria-label="Hasło użytkownika powtórzone" value="<?php
								if (isset($_SESSION['savedPass2']))
								{
									echo $_SESSION['savedPass2'];
									unset($_SESSION['savedPass2']);
								}
							?>">
								
							<div class="input-group-append">
							<span class="input-group-text"><i class="icon-lock"></i></span>
							</div>
							
						</div>
						<?php
							if (isset($_SESSION['passError']))
							{
								echo '<div style="color: red">'.$_SESSION['passError'].'</div>';
								unset($_SESSION['passError']);
							}
						?>
							
						<button type="submit" class="btn mb-2 accountIntroduction">ZAŁÓŻ KONTO</button>
							
					</form>
					
				</div>
			</div>
				
			<div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-center mt-1 mb-2">
					<a href="Author.html" target="_blank" class="btn btn-secondary btn-sm" role="button" aria-pressed="true"><i class="icon-user"></i> Więcej o autorze strony</a>
			</div>
				
	</main>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
	
</body>
</html>