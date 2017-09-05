ALTER TABLE company
    ADD user_id int(10) DEFAULT NULL,
    ADD CONSTRAINT FOREIGN KEY (user_id) REFERENCES user (id);
