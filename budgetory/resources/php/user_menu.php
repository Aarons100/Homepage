<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Budgetory || An Inventory and Budgeting System</title>
		<link rel="stylesheet" href="../css/style.css">
		<link rel="stylesheet" href="../css/jquery-ui.css">
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="../jquery-1.7.1.js"></script>
		<script type="text/javascript" src="../jquery-ui.js"></script>
	</head>
	<body>
		<div id="header">
			Budgetory
		</div>
		<div id="subhead">
			bud·get·or·y: <em>proper noun</em><br/>(a) (portmanteau of <strong>budget</strong> and invent<strong>ory</strong>) a system for budgeting and inventory purposes
		</div>
		<?php
			require "./db_interact.php";
			user_check();

			if($_SERVER['REQUEST_METHOD'] == 'POST') {

				if(isset($_POST['logout'])) {
					logout();
				}
				//form validation for new budgetory
				if(isset($_POST['newBudgetory'])) {
					//Budgetory Name validation
					if(isset($_POST['budgetoryName']) && $_POST['budgetoryName'] == '') {
						echo "<p class='useralert'>You must enter a name for your new budgetory!</p>";
					}
					//money validation
					else if(isset($_POST['total']) && $_POST['total'] <= 0) {
						echo "<p class='useralert1'>Your Budget needs Money</p>";
					}
					else if (!checkdate($_POST['endMonth'],$_POST['endDay'],$_POST['endYear'])) {
						echo "<p class='useralert1'>Your date is not valid.</p>";
					}
					else if(isset($_POST['endYear']) && $_POST['endYear'] < intval(date("Y")) && intval(date("m")) && intval(date("d"))) {
						echo "<p class='useralert1'>Please use a date that has not happened yet.</p>";
					}
					else if(isset($_POST['budgetoryName']) && isset($_POST['total']) && isset($_POST['endDay']) && isset($_POST['endMonth']) && isset($_POST['endYear'])) {
						$endDate = date("Y-m-d", mktime(0,0,0,$_POST['endMonth'],$_POST['endDay'],$_POST['endYear']));
						user_check();
						create_new_budgetory($_POST['budgetoryName'],$_POST['total'],$endDate);
					}
				}
				else if(isset($_POST['submitDelete'])) {

					if(isset($_POST['toDelete']) && $_POST['toDelete'] == '') {
						echo "<p>You must enter a name for your new budgetory!</p>";
					}

					else if(isset($_POST['toDelete'])) {
						user_check();
						delete_budgetory($_POST['toDelete']);
					}
				}
			}	
		?>
		<br/>
		<div id="content">
			<div id='newBudgetory' class='well col-md-3'>
				<form method='POST' action=''>
					<input class='txtip form-control' type='text' name='budgetoryName' placeholder='New budgetory name' /><br/>
					<input type="number form-control" class='form-control' name="total" placeholder="$ Starting funds">
					<p id="end">End date: </p>
					<input type="number" class='form-control' name="endMonth" placeholder="mm"/><br/>
					<input type="number" class='form-control' name="endDay" placeholder="dd"/><br/>
					<input type="number" class='form-control' name="endYear" placeholder="yyyy"/><br/>
					<input type="submit" class='btn btn-success' name='newBudgetory' value="Create new budgetory!"/>
				</form>
			</div>
	<!--this page needs: Delete Budgetory, a table with links to owned budgetories, a table with links to friend's budgetories -->
			<div id="friends" class='col-md-8'>
				<?php
					user_check();
					get_owner_budgets();
					get_shared_budgets();
				?>
			</div>
			<footer>
				<div id='logout'>
					<form method='POST' action = ''>
						<input type='submit' class='btn' name='logout' value='Logout'/>
					</form>
				</div>
			</footer>
		</div>
	</body>
</html>