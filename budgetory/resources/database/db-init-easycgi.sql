USE budgetory;

CREATE TABLE users (
	
	userId INT PRIMARY KEY AUTO_INCREMENT,
	userName VARCHAR(255) UNIQUE NOT NULL,
	password VARCHAR(255) NOT NULL
);

CREATE TABLE access (

	userId INT,
	accessId INT PRIMARY KEY AUTO_INCREMENT,
	ownerOf INT,
	canWrite INT,
	canRead INT,

	FOREIGN KEY (userId) REFERENCES users(userId)
);

CREATE TABLE budget (

	budgetId INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	currentTotal NUMERIC NOT NULL,
	originalTotal NUMERIC NOT NULL,
	weeklyAverage NUMERIC,
	startDate DATE NOT NULL,
	endDate DATE NOT NULL,

	CONSTRAINT current_lessthan_original CHECK (currentTotal <= originalTotal)
);

CREATE TABLE userstobudget (

	budgetId INT,
	userId INT,

	CONSTRAINT pk_userstobudget PRIMARY KEY (budgetId,userId),
	FOREIGN KEY (userId) REFERENCES users(userId),
	FOREIGN KEY (budgetId) REFERENCES budget(budgetId)
);

CREATE TABLE items (

	itemId INT PRIMARY KEY AUTO_INCREMENT,
	budgetId INT,
	stock INT NOT NULL,
	alert INT,
	name VARCHAR(255) NOT NULL,
	price NUMERIC NOT NULL,
	dateOfPurchase DATE NOT NULL,
	expirationDate DATE NOT NULL,

	FOREIGN KEY (budgetId) REFERENCES budget(budgetId),

	CONSTRAINT stock_check CHECK(stock >= 0),
	CONSTRAINT alert_check CHECK(alert >= 0),
	CONSTRAINT price_check CHECK(price >= 0)
);