<?php
	//this function removes a share of a budget.
	function remove_share(&$uid,&$bid) {
		//connect to mysql
		require 'config.php';
		try {	
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];

			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}
		catch (PDOException $e) {
  		 	die("DB ERROR: ". $e->getMessage());
		}
		//use our db
		$check = $dbh->query("use budgetory;");
		//delete tuple from usertobudget
		$result = $dbh->query("DELETE FROM usertobudget WHERE userId = $uid AND budgetId=$bid;");
		//inform user
		if($result) {
			echo "<p class='useralert'>Share removed!</p>";
		}
		else echo "<p class='useralert'>Error: could not remove user share.</p>";
		//disconnect from DB
		$dbh=NULL;
	}
	//this function creates a table of users that the current budgetory is shared with
	function get_shared(&$bid) {
		//start session connect
		if(!isset($_SESSION)){
   			session_start();
		}
		//connect to mysql
		require 'config.php';
		try {	
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];

			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}
		catch (PDOException $e) {
  		 	die("DB ERROR: ". $e->getMessage());
		}
		//use our db
		$check = $dbh->query("use budgetory;");
		//get data we need
		$stmt = $dbh->query("SELECT ub.userId, ub.permission, u.userName FROM  usertobudget ub, users u WHERE u.userId = ub.userId AND budgetId = '$bid';");	
		//echo "hello";
		$result = $stmt->fetchAll();
		//echo count($result[0][0]);
		//$i stores how many tuples we get, it removes any tuples that list the current user
		$i = count($result);
		foreach ($result AS $row) {
			if($row[1] == 1) {
				$i--;
			}
		}
		//we now print our table
		if($stmt) {
			//if shared users >= 1 we execute, else echo no shared users.
			if($i >= 1) {

				echo '<table class="table table-bordered table-hover">';
				//grammar
				if ($i > 1) {
					echo '<caption>This Budgetory is shared with '.$foo.' members:</caption>';
				}
				//grammar
				else if ($i == 1) {
					echo '<caption>This Budgetory is shared with:</caption>';
				}
				//start table
				echo '<th>User</th><th>Permission</th>';
				foreach($result as $row) {
					//if the tuple is not the current user,
					if($row[0] != $_SESSION['uid']) {

						if($row[1] == 3) {
							echo '<tr><td>'.$row[2].'</td><td>View Only</td><td><form method="POST" action=""><input type="hidden" name="uidToRemove" value="'.$row[0].'"/><input type="submit" name="removeShare" value="Remove share!"/></form></td></tr>';
						}
						else echo '<tr><td>'.$row[2].'</td><td>Edit and View</td><td><form method="POST" action=""><input type="hidden" name="uidToRemove" value="'.$row[0].'"/><input type="submit" name="removeShare" value="Remove share!"/></form></td></tr>';
					}
				}
				echo '</table>';
				$dbh=NULL;
			}
			else {
				echo '<caption>You have not shared this budgetory</caption>';
			}
		}
		else echo "<p class='useralert'>Error: could not get shared budgetories.</p>";
		//disconnect from db
		$dbh=NULL;
	}
	//this function shares the current budgetory with a user
	function share_budget(&$bid,&$user,&$permission) {

		//echo $user;
		require 'config.php';
		$temp = $user;
		//connect to DB
		try {	
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];

			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}
		catch (PDOException $e) {
  		 	die("DB ERROR: ". $e->getMessage());
		}
		//use our db
		$check = $dbh->query("use budgetory;");
		//make sure that the user exists
		$stmt=$dbh->prepare("SELECT userId FROM users WHERE userName = :user LIMIT 1;");
		$foo = $stmt->execute(array(':user'=> $temp));
		//get data
		$result = $stmt->fetchAll();
		//if the user to be shared with is found 
		if($foo) {
			//if we want to give the user write permission
			if($permission == 1) {
				//inser into database
				$stmt=$dbh->prepare("INSERT INTO usertobudget VALUES (:bid,:uid,:permission);");
				$success = $stmt->execute(array(':bid'=>$bid,':uid'=>$result[0][0],':permission'=> 2));
				//inform user of success or failure
				if($success) {
					echo "<p class='useralert'> Budget shared with editor ".$temp."!";
				}
				else {
					echo "<p class='useralert'>Error: could not share budget</p>";
				}
			}
			//if we want to give the user read only permission
			else if($permission == 0) {
				//add to database
				$stmt=$dbh->prepare("INSERT INTO usertobudget VALUES (:bid,:uid,:permission);");
				$success = $stmt->execute(array(':bid'=>$bid,':uid'=>$result[0][0],':permission'=> 3));
				//inform user of success or failure
				if($success) {
					echo "<p class='useralert'> Budget shared with viewer ".$temp."!";
				}
				else {
					echo "<p class='useralert'>Error: could not share budget</p>";
				}
			}	
		}
		//if user not found, inform user.
		else {
			echo "<p class='useralert'> User not found, could not share budget</p>";
		}
		//disconnect from db
		$dbh=NULL;
	}
	//this function removes money from the current total
	function subtract_money(&$bid, $sub) {

		//connect to DB
		require 'config.php';

		try {	
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];

			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}
		catch (PDOException $e) {
  		 	die("DB ERROR: ". $e->getMessage());
		}
		//use our db
		$check = $dbh->query("use budgetory;");
		//update current total with user input
		$stmt=$dbh->prepare("UPDATE budget SET currentTotal = currentTotal - :sub WHERE budgetId = :bid;");
		$success=$stmt->execute(array(':sub'=>$sub,':bid'=>$bid));
		//inform user of success or failure
		if ($success) {
			echo "<p class='useralert'>Current total Updated!</p>";
		}
		else echo "Error, could not update Current total";
		//disconnect from db
		$dbh=NULL;
	}
	//creates a table with the users money information
	function get_money(&$bid) {
		//connect to mysql
		require 'config.php';

		try {	
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];

			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}
		catch (PDOException $e) {
  		 	die("DB ERROR: ". $e->getMessage());
		}
		//use our db
		$check = $dbh->query("use budgetory;");
		//get original total and current total from db
		$stmt=$dbh->prepare("SELECT originalTotal, currentTotal FROM budget WHERE budgetId = :bid LIMIT 1;");
		$success = $stmt->execute(array(':bid' => $bid));

		$result = $stmt->fetchAll();
		//inform user of success or failure
		if(!$success) {
			echo "<p class='useralert'>Error: could not get financial information.</p>";
		}
		//create table if successful
		else {
			echo "
				<div id='moneyTable'>
					<table class='table table-bordered table-hover'>
						<th>Original total</th><th>Current total</th>
						<tr><td>$".$result[0][0]."</td><td>$".$result[0][1]."</td></tr>
					</table>
				</div>
		";
		}
		//disconnect from DB
		$dbh=NULL;
	}
	//this function allows the user to update the stock of an item
	function update_stock(&$iId, &$newStock) {
		//validate form
		if($newStock < 0) {
			echo "<p class='useralert'>You cannot have less than 0 stock, just remove the item!</p>";
		}
		//if valid
		else{
			//connect to mysql
			require 'config.php';

			try {	
				$host=$config['host'];
				$user=$config['db_username'];
				$user_password=$config['db_password'];

				$dbh= new PDO("mysql:host=$host",$user,$user_password);
			}
			catch (PDOException $e) {
  			 	die("DB ERROR: ". $e->getMessage());
			}
			//use our db
			$check = $dbh->query("use budgetory;");
			//update database with new stock
			$stmt=$dbh->prepare("UPDATE item SET stock= :newStock WHERE itemId = :iId;");
			$success=$stmt->execute(array(':newStock'=>$newStock, ':iId'=>$iId));
			//inform user of success or failure
			if($success) {
				echo "<p class='useralert'>Stock updated!</p>";
			}

			else echo "Update failure";
			//disconnect from db
			$dbh=NULL;
		}
	}
	//this function removes an item from the database
	function remove_item(&$iid) {
		//connect to Db
		require 'config.php';

		try {	
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];

			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}
		catch (PDOException $e) {
  		 	die("DB ERROR: ". $e->getMessage());
		}
		//use our db
		$check = $dbh->query("use budgetory;");
		//delete item
		$success = $dbh->query("DELETE FROM item WHERE itemId = $iid");
		//inform user of success or failure
		if($success) {
			echo "<p class='useralert'>Item deleted!</p>";
		}

		else echo "deletion failure.";
		//disconnect from DB
		$dbh=NULL;
	}
	//additem to the budgetory
	function add_item(&$bid,&$name,&$stock,&$pdate, &$edate, &$price) {
		//connect to mysql
		require 'config.php';

		try {	
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];

			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}
		catch (PDOException $e) {
  		 	die("DB ERROR: ". $e->getMessage());
		}
		//use our db
		$check = $dbh->query("use budgetory;");

		//add item to the database
		//different conditions for varying user inputs. The correct case is chosen based on what optional fields the user enters.
		if($pdate !='.' && $edate !='.' && $price != -1) {
			$stmt=$dbh->prepare("INSERT INTO item (budgetId,name,stock,dateOfPurchase,expirationDate,price) VALUES (:bid,:name,:stock,:pdate,:edate,:price);");
			$success = $stmt->execute(array(':bid'=>$bid, ':name'=>$name, ':stock'=>$stock, ':pdate' =>$pdate, ':edate'=>$edate,':price'=>$price));
		}
		else if($pdate !='.' && $edate !='.') {
			$stmt=$dbh->prepare("INSERT INTO item (budgetId,name,stock,dateOfPurchase,expirationDate) VALUES (:bid,:name,:stock,:pdate,:edate);");
			$success = $stmt->execute(array(':bid'=>$bid,':name'=>$name,':stock'=>$stock,':pdate'=>$pdate,':edate'=>$edate));
		}
		else if($pdate !='.' && $price != -1) {
			$stmt=$dbh->prepare("INSERT INTO item (budgetId,name,stock,dateOfPurchase,price) VALUES (:bid,:name,:stock,:pdate,:price);");
			$success = $stmt->execute(array(':bid'=>$bid, ':name'=>$name, ':stock'=>$stock,':pdate'=>$pdate, ':price'=>$price));
		}
		else if($edate !='.' && $price != -1) {
			$stmt=$dbh->prepare("INSERT INTO item (budgetId,name,stock,expirationDate,price) VALUES (:bid,:name,:stock,:edate,:price);");
			$success = $stmt->execute(array(':bid'=>$bid, ':name'=>$name, ':stock'=>$stock, ':edate'=>$edate, ':price'=>$price));
		}
		else if($pdate != '.') {
			$stmt=$dbh->prepare("INSERT INTO item (budgetId,name,stock,dateOfPurchase) VALUES (:bid,:name,:stock,:pdate);");
			$success = $stmt->execute(array(':bid'=>$bid, ':name'=>$name, ':stock'=>$stock,':pdate'=>$pdate));
		}
		else if($edate!= '.') {
			$stmt=$dbh->prepare("INSERT INTO item (budgetId,name,stock,expirationDate) VALUES (:bid,:name,:stock,:edate);");
			$success = $stmt->execute(array(':bid'=>$bid, ':name'=>$name, ':stock'=>$stock, ':edate'=>$edate));
		}
		else if ($price != -1 ){
			$stmt=$dbh->prepare("INSERT INTO item (budgetId,name,stock,price) VALUES (:bid,:name,:stock,:price);");
			$success = $stmt->execute(array(':bid'=>$bid, ':name'=>$name, ':stock'=>$stock,':price'=>$price));
		}
		//these are the required fields
		else {
			$stmt=$dbh->prepare("INSERT INTO item (budgetId,name,stock) VALUES (:bid,:name,:stock);");
			$success = $stmt->execute(array(':bid'=>$bid, ':name'=>$name, ':stock'=>$stock));
		}
		//if data is added successfully:
		if($success) {
			echo "<p class='useralert'>Item added!</p>";
		}
		else echo "<p class='useralert'>Insertion Error.</p>";
		$dbh=NULL;
	}
	//check to see if the current user has edit permissions for this budgetory
	function is_editor(&$bid) {
		//connect to mysql
		require 'config.php';
		//start session
		if(!isset($_SESSION)){
   			session_start();
		}
		//get userid
		$uid = $_SESSION['uid'];

		try {
		
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];

			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}
		catch (PDOException $e) {
  		 	die("DB ERROR: ". $e->getMessage());
		}
		//use our db
		$check = $dbh->query("use budgetory;");
		//if the user has edit permissions, return true. else return false.
		$stmt = $dbh->prepare("SELECT permission FROM usertobudget WHERE budgetId = :bid AND userID = :uid;");
		$success = $stmt->execute(array(':bid'=>$bid, ':uid'=>$uid));
		//if we get the permission, do our comparison
		if($success) {
			$result = $stmt->fetchAll();
			//return true if is editor
			if($result[0][0]==2) {
				return true;
			}
			else return false;
		}
		else { 
			echo "error";
		}
		//disconnect from DB
		$dbh=NULL;
	}
	//check to see if the current user is an owner for the current budgetory on screen
	function is_owner(&$bid) {
		//connect to mysql
		require 'config.php';
		//start session
		if(!isset($_SESSION)){
    		session_start();
		}	
		//get user id
		$uid = $_SESSION['uid'];

		try {
		
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];

			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}
		catch (PDOException $e) {
  		 	die("DB ERROR: ". $e->getMessage());
		}
		//use our db
		$check = $dbh->query("use budgetory;");

		$stmt = $dbh->prepare("SELECT permission FROM usertobudget WHERE budgetId = :bid AND userID = :uid;");
		$success = $stmt->execute(array(':bid'=>$bid, ':uid'=>$uid));
		//if the user is an owner, return true, else return false
		if($success) {
			$result = $stmt->fetchAll();
			if($result[0][0]==1) {
				return true;
			}
			else return false;
		}
		else { 
			echo "error";
		}
		$dbh=NULL;
	}
	//this function deletes the budgetory
	function delete_budgetory(&$bid) {
		//connect to mysql
		require 'config.php';

		try {
		
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];

			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}
		catch (PDOException $e) {
  		 	die("DB ERROR: ". $e->getMessage());
		}
		//use our db
		$check = $dbh->query("use budgetory;");
		//delete from DB
		$stmt = $dbh->prepare("DELETE FROM budget WHERE budgetId = :bid;");
		$success = $stmt->execute(array(':bid'=> $bid));
		//inform user
		if($success) {
			//echo "<p class='useralert>Budgetory $name deleted!</p>";
			header('Location: user_menu.php');
			//echo "<p class='useralert'>Budgetory $name deleted!</p>";
		}
		else {
			echo "<p class='useralert'>error, could not delete the Budgetory</p>";
		}
		$dbh=NULL;
	}
	function create_new_budgetory(&$name,&$total,&$endDate) {
		//connect to mysql
		if(!isset($_SESSION)){
   			session_start();
		}
		//get start date as current date.
		require 'config.php';
		$startDate = date("Y-M-D");

		try {
		
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];

			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}
		catch (PDOException $e) {
  		 	die("DB ERROR: ". $e->getMessage());
		}
		//use our db
		$check = $dbh->query("use budgetory;");
		//insert data into database
		$stmt = $dbh->prepare("INSERT INTO budget (name,currentTotal,originalTotal,startDate,endDate) VALUES (:name,:total,:total2,:start,:end);");
		$success = $stmt->execute(array(':name' => $name, ':total'=>$total, ':total2'=>$total, ':start'=>$startDate, ':end'=>$endDate));
		//echo $dbh->lastInsertId();
		if ($success) {

			$budgetId = $dbh->lastInsertId();
			$userId = $_SESSION['uid'];

			$foo = $dbh->query("INSERT INTO usertobudget VALUES ($budgetId, $userId,1);");
	
			if($foo) {		
				echo "<p class='useralert'> Success! Budget $name created!</p>";
			}
			//for Acidity
			else {
				echo "<p class='useralert'>Error! Contact your System Administrator.";
			}
		}
		//if the username is taken
		else {
			echo "<p class='useralert'>Error! Contact your System Administrator.";
		}
		//disconnect from the database
		$dbh=NULL;
	}
	//logs a user out
	function logout() {
		session_destroy();
		header('Location: ../../index.php');
	}
	//this function checks the session timer and logs the user out if there has been no activity for 5 minutes.
	//else it resets the sesssion timer.
	function user_check() {

        	if(!isset($_SESSION)){
    			session_start();
			} 
   		 

		if($_SESSION["lastactivity"]+300 < time()) {
			//	setcookie('uid',$result[0][0],time() + 600);
			session_destroy();

			header('Location: ../../index.php');
		}			
		else {
			$_SESSION["lastactivity"] = time();
		}
	}
	// checks to see if the current user is allowed to view the given budget
	function budget_check($bid) {
		require 'config.php';
		try {
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];

			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}

		catch (PDOException $e) {
  		  	die("DB ERROR: ". $e->getMessage());
		}
		//use our db
		$check = $dbh->query("use budgetory;");

		if(!isset($_SESSION)){
    		session_start();
		}
		$uid = $_SESSION['uid'];

		//echo $bid;
		//echo $uid;
		//echo intval($bid);
		$verify = $dbh->prepare("SELECT * FROM usertobudget WHERE budgetId=:bid AND userId=:uid LIMIT 1;");
		
		$success = $verify->execute(array(':bid'=>intval($bid), ':uid'=>$uid));

		$verify = $verify->fetchAll();
		return (count($verify) > 0);
		$dbh=NULL;
	}
	//this function adds a new user to the database
	function create_user(&$uname, &$pass) { 
		//connect to mysql
		require './resources/php/config.php';
		try {
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];

			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}

		catch (PDOException $e) {
  		  	die("DB ERROR: ". $e->getMessage());
		}
		//use our db
		$check = $dbh->query("use budgetory;");

		//if($check) {
		//	echo "connected!";
		//}

		//else echo "derp";
		//here we use the bcrypt encryption method which utilizes the blowfish cipher.
		$passwordhash = new PasswordHash(8,false);
		//this hashes the password and stores it in the $storedpass variable
		$storedpass = $passwordhash->HashPassword($pass);
		//we add the user's information to the database,
		$foo = $dbh->prepare('INSERT INTO users (userName,password) VALUES (:uname,:pass);');
		//success will be true if a new user is added, and false if a user already exists (AKA could not be inserted)
		$success = $foo->execute(array(':uname' => $uname, ':pass' => $storedpass));

		if ($success) {
			echo "<p class='useralert'> Success! User $uname created! Please login.</p>";
		}
		//if the username is taken
		else {
			echo "<p class='useralert'>failure! Username is taken. ";
		}
		//disconnect from the database and PasswordHash Object
		unset($passwordhash);
		$dbh=NULL;
	}
	//this function is to log a user in, it checks with data in our mysql database and if the user is authentic, it logs them in.
	function login(&$uname, &$pass) {
		//connect to Mysql
		require './resources/php/config.php';
		try {
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];

			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}

		catch (PDOException $e) {
    		die("DB ERROR: ". $e->getMessage());
		}
		//use our db
		$check = $dbh->query("use budgetory;");

		/*if($check) {
		echo "connected!";
		}
		else echo "derp";*/

		//we get the password of the user attempting to log in.
		$stmt = $dbh->prepare("SELECT password FROM users WHERE userName = :uname LIMIT 1;");
		$stmt->execute(array(':uname' => $uname));

		$result = $stmt->fetchAll();
		//$hash has the hash of the password from our database
		$hash= $result[0][0];
		if($hash) {
			//these two lines check to see if the user's password matches our stored hash
			$passwordhash = new PasswordHash(8,false);
			$check = $passwordhash->CheckPassword($pass,$hash);

			if($check) {

				$stmt = $dbh->prepare("SELECT userId FROM users WHERE userName = :uname LIMIT 1;");
				$stmt->execute(array(':uname' => $uname));
				//get the users Id
				$result = $stmt->fetchAll();
				//start session.
				session_set_cookie_params(0);
				if(!isset($_SESSION)){
   					session_start();
				}
				//store Userid in a session
				$_SESSION["uid"] = $result[0][0];
				//this variable keeps track of time, the user gets logged out after 5 minutes of inactivity.
				$_SESSION["lastactivity"] = time();

				header('Location: ./resources/php/user_menu.php');
			}
			else {
				echo "<p class='useralert'>Incorrect username/password</p>";
			}
		}
		else {
			echo "<p class='useralert'>Incorrect username/password</p>";
		}
		//deallocate memory and disconnect from MYSQL
		unset($passwordhash);
		$dbh=NULL;
	}
	//this function gets budgetories that the user owns and makes a table
	function get_owner_budgets() {
		//connect to DB
		require 'config.php';

		try {
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];
			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}

		catch (PDOException $e) {
  		  	die("DB ERROR: ". $e->getMessage());
		}
		//start session
       	if(!isset($_SESSION)){
    		session_start();
		} 
		$uid = $_SESSION['uid'];
		//use our db
		$check = $dbh->query("use budgetory;");
		//get data that we need for the table, where the budgetory belongs to the current user
		$budgets = $dbh->prepare("SELECT b.name, b.budgetId, b.endDate, b.originalTotal, b.currentTotal FROM budget b, usertobudget ub, users u WHERE u.userId=:uid AND u.userId=ub.userId AND ub.budgetId=b.budgetId AND ub.permission = 1");
		$budgets->execute(array(':uid' => $uid));
		$budgets = $budgets->fetchAll();
		//count for grammar
		$foo = count($budgets);
		echo '<table class="table table-bordered table-hover">';

		//these statements are for grammar
		if ($foo > 1) {
			echo '<caption>You own '.$foo.' budgetories</caption>';
		}

		else if ($foo == 1) {
			echo '<caption>You own '.$foo.' budgetory</caption>';

		}
		else {
			echo '<caption>You own no budgetories</caption>';
		}
		//table header
		echo '<tr class="nohover"><th>Name</th><th>End Date(yyyy-mm-dd)</th><th>Original Total</th><th>Current Total</th></tr>';
		//create each row in the table.
		foreach($budgets as $row) {
			$bid=$row[1];
			echo '<tr><td><a href="budget.php?b='.$bid.'">'.$row[0].'</a></td><td>'.$row[2].'</td><td>$'.$row[3].'</td><td>$'.$row[4].'</td></tr>';
		}
		echo '</table>';
		//disconnect from DB
		$dbh=NULL;
	}
	//this function is the same as the above function, but it gets budgets that are shared with the current user
	function get_shared_budgets() {
		//connect to DB
		require 'config.php';
		try {
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];
			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}

		catch (PDOException $e) {
  		  	die("DB ERROR: ". $e->getMessage());
		}
		//start session
       	if(!isset($_SESSION)){
    		session_start();
		} 
		$uid = $_SESSION['uid'];
		//use our db
		$check = $dbh->query("use budgetory;");
		//get information for each table row
		$budgets = $dbh->prepare("SELECT b.name, b.budgetId, b.endDate, b.originalTotal, b.currentTotal FROM budget b, usertobudget ub, users u WHERE u.userId=:uid AND u.userId=ub.userId AND ub.budgetId=b.budgetId AND ub.permission > 1");
		$budgets->execute(array(':uid' => $uid));
		$budgets = $budgets->fetchAll();
		//count for grammar
		$foo = count($budgets);
		echo '<table class="table table-bordered table-hover">';
		//statements for grammar
		if ($foo > 1) {
			echo '<caption>You have '.$foo.' budgetories shared with you</caption>';
		}

		else if ($foo == 1) {
			echo '<caption>You have '.$foo.' budgetory shared with you</caption>';

		}
		else {
			echo '<caption>You have no budgetories shared with you</caption>';
		}
		//table header
		echo '<th>Name</th><th>End Date(yyyy-mm-dd)</th><th>Original Total</th><th>Current Total</th>';
		//create rows
		foreach($budgets as $row) {
			$bid=$row[1];
			echo '<tr><td><a href="budget.php?b='.$bid.'">'.$row[0].'</a></td><td>'.$row[2].'</td><td>$'.$row[3].'</td><td>$'.$row[4].'</td></tr>';
		}
		echo '</table>';
		//disconnect frm db
		$dbh=NULL;


	}
	//this function gets the items in a budgetory for the budget.php page
	function get_budget($bid) {
		//connect to db
		require 'config.php';
		//start session
		if(!isset($_SESSION)){
    		session_start();
		}
		try {
			$host=$config['host'];
			$user=$config['db_username'];
			$user_password=$config['db_password'];
			$dbh= new PDO("mysql:host=$host",$user,$user_password);
		}
		catch (PDOException $e) {
			  die("DB ERROR: ". $e->getMessage());
		}

		$check = $dbh->query("use budgetory;");
		//get budget name and store it
		$budget_name = $dbh->prepare("SELECT b.name FROM budget b WHERE b.budgetId=:bid;");
		$budget_name->execute(array(':bid' => $bid));
		$budget_name = $budget_name->fetchAll();
		$budget_name = $budget_name[0][0];
		//get item information and store it in $items
		$items = $dbh->prepare("SELECT i.itemId, i.name, i.stock, i.price, i.dateOfPurchase, i.expirationDate FROM budget b, item i WHERE b.budgetID=:bid AND i.budgetId=b.budgetId;");
		$items->execute(array(':bid' => $bid));
		$items = $items->fetchAll();
		//print budget name header
		echo '<h1>'.$budget_name.'</h1>';
		//if statement for grammar
		if(count($items) == 1) {
			echo '<h3>'.$budget_name.' has '.count($items).' item</h3>';
		}
		else {
			echo '<h3>'.$budget_name.' has '.count($items).' items</h3>';
		}
		echo '<table class="table table-bordered table-hover">';
		//if is editor, they get additional features (remove item, update stock, etc)
		if(is_editor($bid) || is_owner($bid)) {

			echo '<th>Name</th><th>Stock</th><th>Price</th><th>Purchase Date(yyyy-mm-dd)</th><th>Expiration Date</th><th>Delete item</th><th>Update stock</th>';
			foreach($items as $row) {
				echo '<tr><td>'.$row['name'].'</td><td>'.$row['stock'].'</td><td>'.$row['price'].'</td><td>'.$row['dateOfPurchase'].'</td><td>'.$row['expirationDate'].'</td><td><form method="POST" name="removeMe"><input type="hidden" name="itemId" value="'.$row['itemId'].'"/><input type="submit" name="rSubmit" class="btn btn-danger" value="Remove me!"/></form></td><td><form method="POST" action=""><div class="col-md-7"><input type="number" name="newStock" class="form-control" placeholder="New stock"/></div><input type="hidden" name="iId" value="'.$row['itemId'].'"/><input type="submit" name="stockSubmit" class="btn btn-primary col-md-4" style="display:inline" value="Update"/></form></td></tr>';
			}
			echo '</table>';
		}
		//if is not owner or editor, get a read only budgetory
		else {

			echo '<th>Name</th><th>Stock</th><th>Price</th><th>Purchase Date(yyyy-mm-dd)</th><th>Expiration Date</th>';
			foreach($items as $row) {
				echo '<tr><td>'.$row['name'].'</td><td>'.$row['stock'].'</td><td>'.$row['price'].'</td><td>'.$row['dateOfPurchase'].'</td><td>'.$row['expirationDate'].'</td></tr>';
			}
			echo '</table>';
		}
		//disconnect from $dbh
		$dbh=NULL;
	}
?>