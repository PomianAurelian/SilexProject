ALTER TABLE company ADD radio_choice ENUM('A', 'B', 'C');
UPDATE company SET radio_choice = 'A' WHERE id = 6;
UPDATE company SET radio_choice = 'B' WHERE id = 7;
UPDATE company SET radio_choice = 'B' WHERE id = 8;
UPDATE company SET radio_choice = 'A' WHERE id = 9;
UPDATE company SET radio_choice = 'C' WHERE id = 10;
UPDATE company SET radio_choice = 'A' WHERE id = 11;