ALTER TABLE company ADD logo_src varchar(255);
UPDATE company SET logo_src = 'square.png' WHERE id = 1;
UPDATE company SET logo_src = 'square2.jpg' WHERE id = 2;
UPDATE company SET logo_src = 'square3.png' WHERE id = 3;
UPDATE company SET logo_src = 'square4.gif' WHERE id = 4;
UPDATE company SET logo_src = 'square5.jpg' WHERE id = 5;