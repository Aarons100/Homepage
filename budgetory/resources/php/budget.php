<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Budgetory || An Inventory and Budgeting System</title>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery.js"></script>
	<script src="../bootstrap/js/bootstrap.min.js"></script>

	<?php
	require 'db_interact.php';
	//check session
	user_check();
	//get current budget id
	$bid = filter_input(INPUT_GET,"b",FILTER_SANITIZE_STRING);
	//start session
	if(!isset($_SESSION)){
		session_start();
	}
	//get current user id
	$uid = $_SESSION['uid'];

	if($_SERVER['REQUEST_METHOD'] == 'POST') {

		//if remove share
		if(isset($_POST['removeShare'])) {
			user_check();
			remove_share($_POST['uidToRemove'],$bid);
		}
		//if submit a share
		if(isset($_POST['shareSubmit'])) {
			user_check();
			//if the user being shared with can edit
			if($_POST['canEdit'] == 'on') {
				$foo = 1;
				//share_budget($bid,$_POST['userToShare'],1);
			}

			else {
				//foo tracks if the user can edit or just view
				$foo = 0;	
			}
			if($_POST['userToShare'] == '') {
				echo "<p class='useralert'>You must type in a user to share with!</p>";
			}
			//if valid, share budget
			else if (isset($_POST['userToShare'])){
				share_budget($bid,$_POST['userToShare'],$foo);
			}
		}
		//return to user menu
		if(isset($_POST['menuReturn'])) {
			header("Location: user_menu.php");
		}
		//subtract money
		if(isset($_POST['subMoney']))  {

			if($_POST['subMoney'] > 0) {
				user_check();
				subtract_money($bid,$_POST['subMoney']);
			}
			else echo "<p class='useralert'>Error: you cannot subtract that amount!</p>";
		}
				//remove item
		if(isset($_POST['rSubmit'])) {
			user_check();
			remove_item($_POST['itemId']);
		}
		if(isset($_POST['stockSubmit'])) {
			if($_POST['newStock'] >= 0) {
				user_check();
					//echo $_POST['iId'];
				update_stock($_POST['iId'],$_POST['newStock']);
			}
			else echo "<p class='useralert'>Error: Stock amount cannot be negative!</p>";

		}
		//delete budgetory
		if(isset($_POST['submitDelete'])) {
			user_check();
			delete_budgetory($bid);
		}
		//form validation for additem
		if(isset($_POST['addItem'])) {
		//initialize optional variables as default
		//$error tracks if any optional fields have an error
			$pdate='.';
			$edate='.';
			$price= -1;
			$error = 0;
					//if the user typed something in for the purchase date, validate it
			if($_POST['pMonth'] != '' || $_POST['pDay'] != '' || $_POST['pYear'] != '') {

				if (!checkdate($_POST['pMonth'],$_POST['pDay'],$_POST['pYear'])) {
					echo "<p class='useralert'>Error: purchase date is not valid.</p>";
					$error = 1;
				}
						//assign optional purchase date
				else if(isset($_POST['pDay']) && isset($_POST['pMonth']) && isset($_POST['pYear'])) {
					$pdate = date("Y-m-d", mktime(0,0,0,$_POST['pMonth'],$_POST['pDay'],$_POST['pYear']));
							//echo $pdate;
				}
			}
					//if the user typed something in for the expiration date, validate it
			if ($_POST['eMonth'] != '' || $_POST['eDay'] != '' || $_POST['eYear'] != '') {
				if (!checkdate($_POST['eMonth'],$_POST['eDay'],$_POST['eYear'])) {
					echo "<p class='useralert'>Error: expiration date is not valid.</p>";
					$error = 1;
				}
						//if valid, set $edate with an actual expiration date
				else if(isset($_POST['eDay']) && isset($_POST['eMonth']) && isset($_POST['eYear'])) {
					$edate = date("Y-m-d", mktime(0,0,0,$_POST['eMonth'],$_POST['eDay'],$_POST['eYear']));
							//echo $edate;
				}
			}
					//if user typed in optional field price, validate and set $price
			if ($_POST['itemPrice'] != '') {
				if($_POST['itemPrice'] < 0) {
					echo "<p class='useralert>Error: item price can't be negative</p>";
					$error = 1;
				}
				else { $price=$_POST['itemPrice'];}
			}
					//validation for required fields
			if(isset($_POST['itemName']) && $_POST['itemName'] == '') {
				echo "<p class='useralert>Error: you must enter an item name!</p>";
			} 
			else if (isset($_POST['itemStock']) && $_POST['itemStock'] <= 0) {
				$foo = $_POST['itemName'];
				echo "<p class='useralert>Error: you must enter how many $foo"."s"." you have!</p>";
			}	
					//add item to DB
			else if (isset($_POST['itemName']) && isset($_POST['itemStock']) && $error == 0) {
						//echo "adding";
						//echo $pdate;
						//echo $edate;
				user_check();
				add_item($bid,$_POST['itemName'],$_POST['itemStock'],$pdate,$edate,$price);
			}
		}
	}
			// verify this user has access (viewer or owner) to this budget
	if (!budget_check($bid)) {
		header( 'Location: user_menu.php' );
		echo "You do not have access to this budgetory.";
		return;
	}
	?>
</head>
<body>
	<div id="header">
		Budgetory
	</div>

	<div id='content'>
		<div id='budget' class=''>
			<?php
			user_check();
			get_budget($bid);
			?>
		</div>

		<?php
		//special features for owners and editors
		if(is_owner($bid) || is_editor($bid)) {
			echo "
			<div id='addItem' class='well'>
			<h2>Add new item</h2>
			<form method='POST' action=''>
			<input type='text' class='form-control' name='itemName' placeholder='Item name'/><br/>
			<input type='number' class='form-control' name='itemStock' placeholder='Item stock'/> <br/>
			<input type='number' class='form-control' name='itemPrice' placeholder='Item price (optional)'/> <br/>
			<div class='col-md-6'>
			<p class='smalllbl'>Purchase date: (optional)</p>
				<input type='number' class='form-control' name='pMonth' placeholder='mm'/>
				<input type='number' class='form-control' name='pDay' placeholder='dd'/>
				<input type='number' class='form-control' name='pYear' placeholder='yyyy'/>
			</div>
			<div class='col-md-6'>
				<p class='smalllbl'>Expiration date: (optional)</p>
				<input type='number' class='form-control' name='eMonth' placeholder='mm'/>
				<input type='number' class='form-control' name='eDay' placeholder='dd'/>
				<input type='number' class='form-control' name='eYear' placeholder='yyyy'/>
			</div>

			<input type='submit' class='btn btn-success' name='addItem' value='Add new item!'/><br/>
			</form>
			</div>
			";
			get_money($bid);

			echo "
			<div id='removeFromTotal' class='col-md-4 well'>
			<h3>Spend</h3>
			<form method='POST' action=''>
			<input type='number' class='form-control' name='subMoney' placeholder='how much? ($)'/>
			<input type='submit' name='submitSub' class='btn btn-warning' value='Subtract from current total'/>
			</form>
			</div>
			";
		}
		//special features for just owners
		if(is_owner($bid)) {


			get_shared($bid);

			echo "
			<div id='shareBudgetory' class='col-md-4 well'>
			<h3>Share</h3>
			<form method='POST' action=''>
			<input type='text' name='userToShare' class='form-control' placeholder='User to share with'/>
			<div>Can this user edit? <input type='checkbox' name='canEdit'/></div>
			<input type='submit' class='btn btn-info' name='shareSubmit' value='Share!'/>
			</form>
			</div>
			";

			echo "
			<div id='deleteBudgetoryy' class='col-md-3'>
			<form method='POST' action=''>
			<input type='submit' class='btn btn-danger' name='submitDelete' value='Delete Budgetory!'/>
			</form>		
			</div>";

		}
		?>
	</div>
	<footer>
		<div id="logout">
			<form method="POST" action=''>
				<input type="submit" class="btn" name = "menuReturn" value = "Return to Menu"/>
			</form>
		</div>
	</footer>	
</body>
</html>