CREATE DATABASE IF NOT EXISTS coffeeshop
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE coffeeshop;

-- ----------------------------
-- Table marque
-- ----------------------------
CREATE TABLE marque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- ----------------------------
-- Table categorie
-- ----------------------------
CREATE TABLE categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- ----------------------------
-- Table produit
-- ----------------------------
CREATE TABLE produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prix DECIMAL(6,2) NOT NULL,
    note DECIMAL(3,1) NOT NULL,
    famille VARCHAR(100) NOT NULL,
    pays VARCHAR(100) NOT NULL,
    meilleure_vente TINYINT(1) NOT NULL DEFAULT 0,
    marque_id INT NOT NULL,
    categorie_id INT NOT NULL,
    FOREIGN KEY (marque_id) REFERENCES marque(id),
    FOREIGN KEY (categorie_id) REFERENCES categorie(id)
) ENGINE=InnoDB;

-- ----------------------------
-- Table contact
-- ----------------------------
CREATE TABLE contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(20) NULL,
    message TEXT NOT NULL
) ENGINE=InnoDB;

-- ----------------------------
-- Table diaporama (le slider)
-- ----------------------------
CREATE TABLE diaporama (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    lien_bouton VARCHAR(255) NOT NULL,
    texte_bouton VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- ----------------------------
-- Table administrateur
-- ----------------------------
CREATE TABLE administrateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- ----------------------------
-- Quelques données de test
-- ----------------------------
INSERT INTO marque (nom) VALUES ('Lavazza'), ('Illy'), ('Malongo');

INSERT INTO categorie (nom) VALUES ('Grains'), ('Moulu'), ('Capsules');

INSERT INTO produit (nom, prix, note, famille, pays, meilleure_vente, marque_id, categorie_id) VALUES
('Espresso Intense', 12.50, 4.5, 'Arabica', 'Colombie', 1, 1, 1),
('Moka Doux', 14.00, 4.8, 'Arabica', 'Ethiopie', 1, 2, 2),
('Mélange Maison', 10.90, 4.2, 'Robusta', 'Brésil', 1, 3, 3),
('Café du Matin', 9.50, 3.9, 'Robusta', 'Vietnam', 0, 1, 2),
('Grand Cru', 16.00, 4.9, 'Arabica', 'Kenya', 0, 2, 1);

INSERT INTO diaporama (titre, contenu, lien_bouton, texte_bouton) VALUES
('Le bon café, torréfié avec soin',
 'Des grains sélectionnés chez de petits producteurs, torréfiés en petites quantités.',
 '/produits',
 'Découvrir nos cafés');