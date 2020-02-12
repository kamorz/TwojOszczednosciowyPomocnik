<?php

	session_start();
	
	if ((isset($_SESSION['isUserLoggedIn'])) && ($_SESSION['isUserLoggedIn']==true))
	{
		header('Location: UserMainMenu.php');
		exit();
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
				<nav class="navbar navbar-dark bg-openMenu navbar-expand-md col-12">
				
					<a class="navbar-brand" href="MainPage.html"><i class="icon-dollar"></i> TWÓJ OP </a>
					
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
					<span class="navbar-toggler-icon"></span>
					</button>
					
					<div class="collapse navbar-collapse" id="mainmenu">
				
						<ul class="navbar-nav mr-auto">
						
							<li class="nav-item ml-3">
								<a class="nav-link" href="MainPage.html"> Start </a>
							</li>
							
							<li class="nav-item ml-3 active">
								<a class="nav-link" href="Login.html"> Logowanie </a>
							</li>
							
							<li class="nav-item ml-3">
								<a class="nav-link" href="Registration.html"> Rejestracja </a>
							</li>
						
						</ul>
						
						<a class="nav-link contactInvitation"  href="https://www.gmail.com" target="_blank"><i class="icon-mail-1"></i> Kontakt </a>
				
					</div>
								
				</nav>
			</div>
			<br/><br/>
			
			
				
			<div class="row">
				<div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-center mb-5 mr-0 bg-white loginForm">
					
				<h1 class="h2">LOGOWANIE </h1>
					
					<form action="Login_check.php" method="post">
							
						<div class="input-group mb-3 justify-content-center">
							<input type="text" id="loginName" name="login" placeholder="Podaj swój email" aria-label="Login użytkownika">
								
							<div class="input-group-append">
							<span class="input-group-text"><i class="icon-mail"></i></span>
							</div>
						</div>

							
						<div class="input-group mb-3 justify-content-center">
							<input type="password" id="loginPassword"  name="pass" placeholder="Podaj swoje hasło" aria-label="Hasło użytkownika">
								
							<div class="input-group-append">
							<span class="input-group-text"><i class="icon-lock"></i></span>
							</div>
						</div>
							
						<button type="submit" class="btn mb-2 accountIntroduction">ZALOGUJ SIĘ</button>
							
					</form>
					
				</div>
			</div>
				
			<div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-center mt-4 mb-2">
					<a href="Author.html" target="_blank" class="btn btn-secondary btn-sm" role="button" aria-pressed="true"><i class="icon-user"></i> Więcej o autorze strony</a>
			</div>
				
	</main>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
	
</body>
</html>