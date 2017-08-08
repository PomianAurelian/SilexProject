CREATE TABLE review (
	id int(10) NOT NULL AUTO_INCREMENT,
	name varchar(255) NOT NULL,
	rating decimal(2, 1) NOT NULL,
	review_date datetime NOT NULL,
	comment varchar(255),
	company_id int(10) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (`company_id`) REFERENCES `company`(`id`)
);

INSERT INTO review VALUES (NULL, 'John Doe', 2.5, '2017-08-01 12:32:24', 'Fair enough!', 1);
INSERT INTO review VALUES (NULL, 'Eren Chima', 5, '2017-08-01 16:29:11', 'Briliant! Amazing work, never stop making these!', 1);
INSERT INTO review VALUES (NULL, 'Ananta Laurentin', 1.5, '2017-08-02 09:01:59', 'worst ting evar!', 1);
INSERT INTO review VALUES (NULL, 'Lake Gaizka', 4, '2017-08-01 12:32:24', 'What is this?', 2);