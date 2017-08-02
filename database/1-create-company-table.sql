CREATE TABLE category (
	id int(10) NOT NULL AUTO_INCREMENT,
	category varchar(255),
	PRIMARY KEY (id)
);

CREATE TABLE radioChoices (
	id int(10) NOT NULL AUTO_INCREMENT,
	choice varchar(255),
	PRIMARY KEY (id)
);

CREATE TABLE company (
	id int(10) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    delivery tinyint(1) NOT NULL DEFAULT false,
    category_id int(10) NOT NULL,
    radioBtn_id int(10) NOT NULL,
    description varchar(255),
    PRIMARY KEY (id),
    FOREIGN KEY (`category_id`) REFERENCES `category`(`id`),
    FOREIGN KEY (`radioBtn_id`) REFERENCES `radioChoices`(`id`)
);

INSERT INTO category VALUES (NULL, 'Restaurant');
INSERT INTO category VALUES (NULL, 'Fast Food');
INSERT INTO category VALUES (NULL, 'Market');
INSERT INTO category VALUES (NULL, 'Drug Store');
INSERT INTO category VALUES (NULL, 'Other');

INSERT INTO radioChoices VALUES (NULL, 'Option A');
INSERT INTO radioChoices VALUES (NULL, 'Option B');
INSERT INTO radioChoices VALUES (NULL, 'Option C');

INSERT INTO Company VALUES (NULL, 'Company #1', 'First@mail.com', true, 4, 1, 'Company #1 Description: something something something something something something ');
INSERT INTO Company VALUES (NULL, 'Company #2', 'Second@mail.com', false, 3, 2, 'Company #2 Description: something something something something something something ');
INSERT INTO Company VALUES (NULL, 'Company #3', 'Third@mail.com', false, 1, 1, 'Company #3 Description: something something something something something something ');
INSERT INTO Company VALUES (NULL, 'Company #4', 'Fourth@mail.com', false, 5, 3, 'Company #4 Description: something something something something something something ');
INSERT INTO Company VALUES (NULL, 'Company #5', 'Fifth@mail.com', true, 2, 3, 'Company #5 Description: something something something something something something ');
