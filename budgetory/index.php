<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Budgetory || An Inventory and Budgeting System</title>
		<link rel="stylesheet" href="resources/css/style.css">
		<link rel="stylesheet" href="resources/bootstrap/css/bootstrap.min.css">
	</head>
	<body>
		<div id="header">
			Budgetory
		</div>
		<div id="subhead">
			bud·get·or·y: <em>proper noun</em><br/>(a) (portmanteau of <strong>budget</strong> and inven<strong>ory</strong>) a system for budgeting and inventory purposes
		</div>
		<?php
			require "./resources/php/phpass-0.3/PasswordHash.php";
			require "./resources/php/db_interact.php";
			require './resources/php/config.php';
			//start session
			if(!isset($_SESSION)){
  				session_start();
			}

			//automatically bring user to their user_menu page if they have a session
			if(isset($_SESSION['uid'])) {
				header("Location: ./resources/php/user_menu.php");
			}
			
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				//if a user is trying to log in
				if(isset($_POST['login'])) {
					if(isset($_POST['username']) && $_POST['username'] == '') {
						echo "<p class='useralert'>You must enter a username to log in!</p>";
					}
					else if (isset($_POST['password']) && $_POST['password'] == '') {
						echo "<p class='useralert'>You must enter a password to log in!</p>";
					}
					else if (isset($_POST['username']) && isset($_POST['password'])) {
						//if the user's form meets our form validation requirements, log them in
						login($_POST['username'],$_POST['password']);
					}
				}
				//if a user is making a new account
				else if (isset($_POST['newuser'])) {
					if(isset($_POST['newuname']) && $_POST['newuname'] == '') {
						echo "<p class='useralert'>You must enter a username for your new account!</p>";
					}
					else if (isset($_POST['password']) && $_POST['password'] == '') {
						echo "<p class='useralert'>You must enter a password for your new account!</p>";
					}
					else if (isset($_POST['passwordcheck']) && $_POST['password'] == '') {
						echo "<p class='useralert'>You must enter your password in both text fields for your new account!</p>";
					}
					else if (isset($_POST['password']) && strlen($_POST['password']) < 8) {
						echo "<p class='useralert'>Your password must be at least 8 characters long!</p>";
					}
					else if ($_POST['password'] != $_POST['passwordcheck']) {
						echo "<p class='useralert'>Passwords must match!</p>";
					}

					else if (isset($_POST['newuname']) && isset($_POST['password'])) {
						//if they meet all of our validation, create a user
						create_user($_POST['newuname'],$_POST['password']);
					}
				}
			}
		?>
		<div id="forms">
		<div id="login">
			<p class="frontlabel">Log in</p>
			<form method='POST' action='./'>
				<input class="text form-control" type='text' name='username' placeholder='Username'><br/>
				<input class="text form-control" type='password' name='password' placeholder='Password'><br/>
				<input type='submit' class='btn btn-primary' name='login' value='Login!'>
			</form>
		</div>
		<div id ="create_account">
			<p class="frontlabel">Create a new account</p>
			<form method='POST' action='./'>
				<input class="text form-control" type='text' name='newuname' placeholder = 'Username'><br/>
				<input class="text form-control" type='password' name='password' placeholder='Password'><br/>
				<input class="text form-control" type='password' name='passwordcheck' placeholder='Repeat password'><br/>
				<input type='submit' class='btn btn-success' name='newuser' value='Create account!'>
			</form>
		</div>
	</div>

	</body>
</html>
