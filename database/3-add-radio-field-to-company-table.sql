ALTER TABLE company ADD radio_choice ENUM('A', 'B', 'C');
UPDATE company SET radio_choice = 'A' WHERE id = 1;
UPDATE company SET radio_choice = 'B' WHERE id = 2;
UPDATE company SET radio_choice = 'B' WHERE id = 3;
UPDATE company SET radio_choice = 'A' WHERE id = 4;
UPDATE company SET radio_choice = 'C' WHERE id = 5;