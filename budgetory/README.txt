budgetory
=========

Installation Instructions:

1. Run db-init.sql by piping it into mysql like this:

	$~/Desktop/Classes/budgetory/resources/database#mysql --password=rootpass < db-init.sql

 	db-init.sql is located in the resources/database folder.

2. Set up an apache2 virtual server such that the webroot folder is the budgetory folder.

Contents:

1. index.php

	this is the homepage of our website, It's the default page that gets loaded. it contains create account and login forms

2. this README

3. our favicon

4. docs folder
	
	This folder holds human readable data, 

		1. Entity Relationship diagram of the database in a variety of formats.
		2. Our project proposal.
		3. Our report on our final result.
		4. the .tex file of our report.

5. the resources folder

	This folder contains the large majority of our project

	a. the bg folder which contains files for our background.

	b. the bootstrap folder which contains bootstrap.

	c. the css folder which contains the css for our website and for jquery.

	d. the database folder which contains the db-init.sql script for initializing the database.

	e. the fonts folder which contains the fonts for our website.

	f. the php folder which contains most of our code.

		i. phpass-0.3 contains the necessary code for our implementation of bcrypt, namely the PasswordHash.php file
		ii. budget.php is the page that a user is presented with upon loading a budgetory.
		iii. config.php contains information for our database connections.
		iv. db_interact.php contains the large majority of our functions that require interacting with the database.
		v. user_menu.php is the page a user is presented with once he logs in.

	g. the pieces folder which contains the break.png file for our styling.

	h. jquery library.