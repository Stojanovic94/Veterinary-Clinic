CREATE DATABASE VeterinarskaAmbulanta;

CREATE TABLE Vlasnik (
    username VARCHAR(100) PRIMARY KEY,
    lozinka VARCHAR(255) NOT NULL,  -- heširana lozinka
    ime VARCHAR(100) NOT NULL,
    prezime VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL
);

CREATE TABLE Ljubimac (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ime VARCHAR(100) NOT NULL,
    rasa VARCHAR(100) DEFAULT NULL,
    datum_rodjenja DATE DEFAULT NULL,
    vlasnik_id VARCHAR(100) NOT NULL,
    FOREIGN KEY (vlasnik_id) REFERENCES Vlasnik(username) ON DELETE CASCADE
);

CREATE TABLE Veterinar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ime VARCHAR(100) NOT NULL,
    prezime VARCHAR(100) NOT NULL,
    specijalizacija VARCHAR(255) DEFAULT NULL -- Npr. ortopedija ili hirurgija
);

CREATE TABLE Pregled (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ljubimac_id INT NOT NULL,
    veterinar_id INT NOT NULL,
    opis VARCHAR(255) NOT NULL,
    datum DATETIME NOT NULL,
    FOREIGN KEY (ljubimac_id) REFERENCES Ljubimac(id) ON DELETE CASCADE,
    FOREIGN KEY (veterinar_id) REFERENCES Veterinar(id) ON DELETE CASCADE,
    UNIQUE (veterinar_id, datum) -- Jedan veterinar može imati samo jedan pregled u jednom terminu
);

-- Primer unosa
INSERT INTO Vlasnik (username, lozinka, ime, prezime, email) VALUES
    ('mmarkovic', SHA2('sifra123', 256), 'Milan', 'Marković', 'mmarkovic@mail.com'),
    ('ssimic', SHA2('lozinka456', 256), 'Sofija', 'Simić', 'ssimic@mail.com'),
    ('jpetrovic', SHA2('pass789', 256), 'Jovana', 'Petrović', 'jpetrovic@mail.com'),
    ('dnovak', SHA2('password1', 256), 'Dušan', 'Novak', 'dnovak@mail.com'),
    ('ikrstic', SHA2('1234abc', 256), 'Ivan', 'Krstič', 'ikrstic@mail.com');

INSERT INTO Ljubimac (ime, rasa, datum_rodjenja, vlasnik_id) VALUES
    ('Bobi', 'Zlatni retriver', '2021-04-15', 'mmarkovic'),
    ('Maza', 'Persijska mačka', '2019-07-20', 'ssimic'),
    ('Luna', 'Pudlica', '2020-12-05', 'mmarkovic'),
    ('Cezar', 'Labrador', '2022-01-10', 'jpetrovic'),
    ('Tara', 'Buldog', '2021-08-10', 'dnovak'),
    ('Rex', 'Pitbul', '2019-10-15', 'ikrstic'),
    ('Milo', 'Jack Russell', '2020-02-25', 'dnovak');

INSERT INTO Veterinar (ime, prezime, specijalizacija) VALUES
    ('Ivana', 'Stojković', 'Ortopedija'),
    ('Nikola', 'Jovanović', 'Hirurgija'),
    ('Milica', 'Milićević', 'Opsta veterina'),
    ('Jovana', 'Marković', 'Dermatologija'),
    ('Aleksandar', 'Petrović', 'Stomatologija');

INSERT INTO Pregled (ljubimac_id, veterinar_id, opis, datum) VALUES
    (1, 1, 'Rentgentski snimak', '2025-01-10 09:00:00'), -- Bobi kod Ivane Stojković
    (2, 2, 'Saniranje rane', '2025-01-10 10:00:00'), -- Maza kod Nikole Jovanovića
    (3, 3, 'Vakcijancija', '2025-01-11 11:00:00'), -- Luna kod Milice Milićević
    (4, 1, 'Stavljanje kragne', '2025-01-11 12:00:00'), -- Cezar kod Ivane Stojković
    (5, 2, 'Pregled zbog bola u stomaku', '2025-01-12 08:00:00'), -- Tara kod Nikole Jovanovića
    (6, 3, 'Kontrola stanja', '2025-01-12 09:00:00'), -- Rex kod Milice Milićević
    (7, 4, 'Pregled kože i dlake', '2025-01-12 10:00:00'), -- Milo kod Jovane Marković
    (1, 5, 'Pregled zuba', '2025-01-13 14:00:00'), -- Bobi kod Aleksandra Petrovića
    (2, 5, 'Kontrola usne šupljine', '2025-01-13 15:00:00'), -- Maza kod Aleksandra Petrovića
    (4, 1, 'Zdravstvena provera', '2025-01-14 09:00:00'); -- Cezar kod Ivane Stojković
