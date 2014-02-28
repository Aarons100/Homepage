DROP DATABASE IF EXISTS budgetory;

CREATE DATABASE budgetory;

USE budgetory;

DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS budget CASCADE;
DROP TABLE IF EXISTS items CASCADE;
DROP TABLE IF EXISTS userstobudget CASCADE;
DROP TABLE IF EXISTS access CASCADE;

CREATE TABLE users (
	
	userId INT PRIMARY KEY AUTO_INCREMENT,
	userName VARCHAR(255) UNIQUE NOT NULL,
	password VARCHAR(255) NOT NULL
);

CREATE TABLE budget (

	budgetId INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	currentTotal NUMERIC(10,2) NOT NULL,
	originalTotal NUMERIC(10,2) NOT NULL,
	startDate DATE NOT NULL,
	endDate DATE NOT NULL,

	CONSTRAINT current_lessthan_original CHECK (currentTotal <= originalTotal)
);

CREATE TABLE usertobudget (

	budgetId INT,
	userId INT,
	permission TINYINT, /*1 = owner 2 = write 3 = read*/

	CONSTRAINT pk_usertobudget PRIMARY KEY (budgetId,userId),
	FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE CASCADE,
	FOREIGN KEY (budgetId) REFERENCES budget(budgetId) ON DELETE CASCADE
);


CREATE TABLE item (

	itemId INT PRIMARY KEY AUTO_INCREMENT,
	budgetId INT,
	stock INT NOT NULL,
	alert INT,
	name VARCHAR(255) NOT NULL,
	price NUMERIC(10,2),
	dateOfPurchase DATE,
	expirationDate DATE,

	FOREIGN KEY (budgetId) REFERENCES budget(budgetId) ON DELETE CASCADE,

	CONSTRAINT stock_check CHECK(stock >= 0),
	CONSTRAINT alert_check CHECK(alert >= 0),
	CONSTRAINT price_check CHECK(price >= 0)
);

GRANT ALL ON `budgetory`.* to 'phpuser1'@'localhost';

SET PASSWORD FOR 'phpuser1'@'localhost' = PASSWORD('phppass');