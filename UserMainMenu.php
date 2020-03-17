<?php
	session_start();

	if (!isset($_SESSION['isUserLoggedIn']))
	{
		header('Location: index.php');
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
				<nav class="navbar navbar-dark bg-openMenu navbar-expand-lg col-12">
				
					<a class="navbar-brand" href="#"><i class="icon-dollar"></i> Strona główna </a>
					
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
					<span class="navbar-toggler-icon"></span>
					</button>
					
					<div class="collapse navbar-collapse" id="mainmenu">
				
						<ul class="navbar-nav mr-auto">
						
							<li class="nav-item dropdown ml-1">
								<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false" id="submenu1" aria-haspopup="true"><i class="icon-plus"></i>Dodaj operację</a>
								
								<div class="dropdown-menu" aria-labelledby="submenu1">
								
									<a class="dropdown-item" href="AddingIncomes.php"> Dodaj przychód </a>
									<a class="dropdown-item" href="AddingExpenses.php"> Dodaj wydatek </a>
								
								</div>
						
							</li>
							
							
							
							<li class="nav-item dropdown ml-1">
								<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false" id="submenu2" aria-haspopup="false"><i class="icon-eye"></i>Przegląd</a>
								
								<div class="dropdown-menu" aria-labelledby="submenu2">
								
									<a class="dropdown-item" href="CurrentMonthOperationsOverview.php"> Bilans obecnego miesiąca </a>
									<a class="dropdown-item" href="PreviousMonthOperationsOverview.php"> Bilans poprzedniego miesiąca </a>
									<a class="dropdown-item" href="SelectedPeriodOperationsOverview.php"> Bilans wybranego okresu </a>
								
								</div>
						
							</li>
							
							<li class="nav-item  ml-1">
								<a class="nav-link" href="Settings.html"> Ustawienia<i class="icon-cog"></i></a>
							</li>
						
						</ul>
						
						<a class="nav-link contactInvitation"  href="logout.php">Wyloguj się</a>
				
					</div>
								
				</nav>
			</div>		
				
			<div class="row">
				<div class="col-8 offset-2 col-md-10 offset-md-1 text-center mb-5 mt-lg-3 mr-0 bg-white">
					
					<div class="row">
					
						<div class="col-10 offset-1 col-md-3 offset-md-0 ml-0  my-auto justify-content-center">
							<img src="img/dollar-bills.jpg" class="img-fluid" alt="Money bills">
						</div>
						
						<div class="col-10 offset-1 col-md-5 offset-md-0 ml-0  my-auto justify-content-center">
							<h2 class="h3">Witaj, Oszczędzaczu!</h2>
							<p>Cieszymy się, że jesteś z nami- to oznacza, że chcesz zadbać o swoje finanse. Bardzo dobra decyzja! Wybierz z menu, co chciałbyś teraz zrobić.</p>
						</div>
						
						<div class="col-10 offset-1 col-md-4 offset-md-0 mb-2 mx-0 my-md-auto justify-content-center">
							<ul class="list-group">
								<li><a href="OperationsOverview.html" class="list-group-item list-group-item-dark list-group-item-action">Przeglądaj wydatki</a></li>
								<li><a href="AddingExpenses.php" class="list-group-item list-group-item-dark list-group-item-action ">Dodaj wydatek</a><li>
								<li><a href="AddingIncomes.php" class="list-group-item list-group-item-dark list-group-item-action">Dodaj przychód</a></li>
								<li><a href="Settings.html" class="list-group-item list-group-item-dark list-group-item-action">Ustawienia konta</a></li>
							</ul>
						</div>
					</div>
					
				</div>
			</div>
				
			
				
	</main>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
	
</body>
</html>