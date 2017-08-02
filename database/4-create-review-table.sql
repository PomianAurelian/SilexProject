CREATE TABLE review (
	id int(10) NOT NULL AUTO_INCREMENT,
	name varchar(255) NOT NULL,
	review_date date NOT NULL,
	comment varchar(255),
	company_id int(10) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (`company_id`) REFERENCES `company`(`id`)
);