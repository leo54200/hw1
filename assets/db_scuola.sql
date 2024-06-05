
CREATE TABLE materia (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL
);

CREATE TABLE utente (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nome VARCHAR(255) NOT NULL,
    cognome VARCHAR(255) NOT NULL,
    ruolo INTEGER NOT NULL,
    CHECK(ruolo IN (1,2))
);

CREATE TABLE materia_utente (
    id_materia INTEGER NOT NULL,
    id_utente INTEGER NOT NULL,
    PRIMARY KEY (id_materia, id_utente),
    FOREIGN KEY (id_materia) REFERENCES materia(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE,
    FOREIGN KEY (id_utente) REFERENCES utente(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
);

-- tipo: 1 (spiegazione), 2(esercizio)
CREATE TABLE chat (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_utente INTEGER NOT NULL,
    id_materia INTEGER NOT NULL,
    tipo INTEGER,
    data DATETIME NOT NULL,
    valutazione INTEGER,
	FOREIGN KEY (id_materia) REFERENCES materia(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE,
    FOREIGN KEY (id_utente) REFERENCES utente(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
);

-- mittente: 1 (utente), 2(AI)
CREATE TABLE messaggio (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_chat INTEGER NOT NULL,
    testo TEXT NOT NULL,
    correzione TEXT,
    data DATETIME NOT NULL,
    chiarezza INTEGER DEFAULT NULL,
	correttezza INTEGER DEFAULT NULL,
    mittente INTEGER NOT NULL,
	CHECK(mittente IN (1,2)),
    FOREIGN KEY (id_chat) REFERENCES chat(id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
);
INSERT INTO materia VALUES(1, "Matematica");
INSERT INTO materia VALUES(2, "Fisica");
INSERT INTO materia VALUES(3, "Informatica");
INSERT INTO materia VALUES(4, "Chimica");
INSERT INTO materia VALUES(5, "Scienze della terra e Biologia");
