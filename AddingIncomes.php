<?php
session_start();

require_once 'connect.php';

	$currentUserId= $_SESSION['loggedUserId'];
	
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
				$result = $connection->query("SELECT * FROM incomes_category_assigned_to_users");
				
				if (!$result) throw new Exception($connection->error);
				$_SESSION['categoriesAmount']= $result->num_rows;
			}

		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności.</span>';
			echo '<br />Informacja developerska: '.$e;
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
				
					<a class="navbar-brand" href="UserMainMenu.php"><i class="icon-dollar"></i> Strona główna </a>
					
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
								
									<a class="dropdown-item" href="OperationsOverview.php#currentMonth-tab"> Bilans obecnego miesiąca </a>
									<a class="dropdown-item" href="OperationsOverview.php#previousMonth-tab"> Bilans poprzedniego miesiąca </a>
									<a class="dropdown-item" href="OperationsOverview.php#selectedPeriod-tab"> Bilans wybranego okresu </a>
								
								</div>
						
							</li>
							
							<li class="nav-item  ml-1">
								<a class="nav-link" href="Settings.php"> Ustawienia<i class="icon-cog"></i></a>
							</li>
						
						</ul>
						
						<a class="nav-link contactInvitation"  href="Logout.php">Wyloguj się</a>
				
					</div>
								
				</nav>
			</div>		
				
			<div class="row">
				<div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-center mb-5 mr-0 bg-white loginForm">
					
				<h1 class="h2 mb-3">DODAWANIE PRZYCHODÓW </h1>
					
					
					<form>
							
						<div class="form-group col-6 offset-3">
							<label for="incomeType">Rodzaj przychodu</label>
							<select class="form-control" id="incomeType" >
							
									<?php
									foreach ($_SESSION['categories'] as $category) 
									{
										echo "<option>{$category['name']}</option>";
									}
									?>
							
							</select>
						</div>
							
						<div class="form-group col-6 offset-3">
							<label for="amount">Kwota (zł)</label>
							<input type="number" class="form-control" id="amount" step="0.01" required>
						</div>	
						
						<div class="form-group col-6 offset-3">
							<label for="incomeDate">Data</label>
							<input type="date" class="form-control" id="incomeDate" required>
							
						</div>
						
						<div class="form-group col-6 offset-3">
							<label for="extraDescription">Dodatkowy opis</label>
							<textarea class="form-control" id="extraDescription" rows="2" placeholder="Pole opcjonalne"></textarea>
						</div>
						
						<button type="submit" class="btn mb-2 accountIntroduction">ZATWIERDŹ</button>
						

										<?php
										echo $_SESSION['categoriesAmount'];
										?>

							
					</form>
					
				</div>
			</div>
				
			
				
	</main>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
	
</body>
</html>
