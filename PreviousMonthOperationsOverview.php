<?php
	session_start();

	if (!isset($_SESSION['isUserLoggedIn']))
	{
		header('Location: index.php');
		exit();
	}
	$currentMonth = date("m");
	$previousMonth = date("m")-1;

	$SESSION_['previousMonthIncomeSum']=0;
	$SESSION_['previousMonthExpenseSum']=0;

	require_once 'connect.php';

	$_SESSION['currentUserId']= $_SESSION['loggedUserId'];
	$idForSearching= $_SESSION['loggedUserId'];

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
				
				$resultPreviousMonthIncomes = $connection->query("SELECT * FROM `incomes` WHERE user_id='$idForSearching' AND EXTRACT(month FROM date_of_income) = '$previousMonth'");				
				if (!$resultPreviousMonthIncomes) throw new Exception($connection->error);
				$_SESSION['previousMonthIncomes'] = $resultPreviousMonthIncomes->fetch_all();
				
				
				$resultPreviousMonthExpenses = $connection->query("SELECT * FROM `expenses` WHERE user_id='$idForSearching' AND EXTRACT(month FROM date_of_expense) = '$previousMonth'");				
				if (!$resultPreviousMonthExpenses) throw new Exception($connection->error);
				$_SESSION['previousMonthExpenses'] = $resultPreviousMonthExpenses->fetch_all();
			
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
								
									<a class="dropdown-item" href="CurrentMonthOperationsOverview.php"> Bilans obecnego miesiąca </a>
									<a class="dropdown-item" href="PreviousMonthOperationsOverview.php"> Bilans poprzedniego miesiąca </a>
									<a class="dropdown-item" href="SelectedPeriodOperationsOverview.php"> Bilans wybranego okresu </a>
								
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
			
				<div class="col-10 offset-1 text-center mb-5 mt-lg-3 mr-0 bg-white">
				
					<div class="row">
										
										<div class="col-12 col-lg-10 offset-lg-1 text-center mb-5 mt-lg-3 mr-0 bg-white tab-content">
										
											<h1 class="h3">Przegląd przychodów - poprzedni miesiąc</h1>
											
											<table class="table table-bordered">
											  <thead>
													<tr>
													  <th>Data</th>
													  <th>Przychód</th>
													  <th>Kwota</th>
													  <th>Opis</th>
													</tr>
												
											  </thead>
											  <tbody>
												<?php
												foreach ($_SESSION['previousMonthIncomes'] as $income) 
												{			
													$searchedIncomeCategory=$income[2];
													$resultIncomeName = $connection->query("SELECT name FROM incomes_category_assigned_to_users WHERE id='$searchedIncomeCategory'");
													$row = $resultIncomeName->fetch_assoc();
													$incomeName = $row['name'];
													
													$SESSION_['previousMonthIncomeSum']+=$income[3];
													
													echo "<tr><td>{$income[4]}</td><td>{$incomeName}</td><td>{$income[3]}</td><td>{$income[5]}</td></tr>"; 
												}
												?>
											  </tbody>
											</table>
											<?php
											echo "Suma przychodów: ".$SESSION_['previousMonthIncomeSum']." zł";
											?>
											
										</div>
										
										<div class="col-12 col-lg-10 offset-lg-1 text-center mb-5 mt-lg-3 mr-0 bg-white tab-content">
											
											
											<h1 class="h3">Przegląd wydatków - poprzedni miesiąc</h1>
											
											<table class="table table-bordered">
											  <thead>
													<tr>
													  <th>Data</th>
													  <th>Wydatek</th>
													  <th>Kwota</th>
													  <th>Sposób płatności</th>
													  <th>Opis</th>
													</tr>
												
											  </thead>
											  <tbody>
												<?php
												foreach ($_SESSION['previousMonthExpenses'] as $expense) 
												{
													$searchedExpenseCategory=$expense[2];
													$searchedPaymentMethodCategory=$expense[3];
													
													$resultExpenseName = $connection->query("SELECT name FROM expenses_category_assigned_to_users WHERE id='$searchedExpenseCategory'");
													if (!$resultExpenseName) throw new Exception($connection->error);
													$row = $resultExpenseName->fetch_assoc();
													$expenseName = $row['name'];
													
													$resultPaymentMethodName = $connection->query("SELECT name FROM payment_methods_assigned_to_users WHERE id='$searchedPaymentMethodCategory'");
													if (!$resultPaymentMethodName) throw new Exception($connection->error);
													$row = $resultPaymentMethodName->fetch_assoc();
													$paymentMethodName = $row['name'];
													
													$SESSION_['previousMonthExpenseSum']+=$expense[4];
													
													echo "<tr><td>{$expense[5]}</td><td>{$expenseName}</td><td>{$expense[4]}</td><td>{$paymentMethodName}</td><td>{$expense[6]}</td></tr>"; 
												}
												?>
											  </tbody>
											</table>
											<?php
											echo "Suma wydatków: ".$SESSION_['previousMonthExpenseSum']." zł";
											?>	
											<h2 class="h3">
												<br/><br/>
												<?php
												$totalPreviousMonthBalance=$SESSION_['previousMonthIncomeSum']-$SESSION_['previousMonthExpenseSum'];
												echo "Bilans poprzedniego miesiąca: ".$totalPreviousMonthBalance." zł";
												?>	
											</h2>
											
										</div>

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

<?php
$connection->close();
?>