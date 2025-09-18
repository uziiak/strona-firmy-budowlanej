CREATE TABLE uslugi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    godziny INT NOT NULL,
    kilometry INT NOT NULL,
    pracownik TINYINT(1) NOT NULL,
    liczba_uslug INT NOT NULL,
    koszt DECIMAL(10,2) NOT NULL,
    data_zamowienia DATETIME NOT NULL
);
