CREATE TABLE filmovi ( 
    id INT NOT NULL AUTO_INCREMENT, 
    naslov VARCHAR(255) NOT NULL, 
    id_zanr INT NOT NULL, 
    godina INT NOT NULL, 
    trajanje INT NOT NULL, 
    slika VARCHAR(255) NOT NULL, 
    PRIMARY KEY (id), 
    FOREIGN KEY (id_zanr) REFERENCES zanr(id)
);