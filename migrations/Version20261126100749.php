<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261126100749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Modification de la base de données CoffeeShop';
    }

    public function up(Schema $schema): void
    {
        // Renommer les anciennes tables
        $this->addSql('RENAME TABLE marque TO brand');
        $this->addSql('RENAME TABLE categorie TO category');
        $this->addSql('RENAME TABLE produit TO product');
        $this->addSql('RENAME TABLE administrateur TO admin');
        $this->addSql('RENAME TABLE diaporama TO slider');

        // Modifier la table brand
        $this->addSql('ALTER TABLE brand CHANGE nom name VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX unique_brand_name ON brand (name)');

        // Modifier la table category
        $this->addSql('ALTER TABLE category CHANGE nom name VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX unique_category_name ON category (name)');

        // Supprimer les anciennes clés étrangères et les index
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY product_ibfk_1');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY product_ibfk_2');
        $this->addSql('ALTER TABLE product DROP INDEX marque_id');
        $this->addSql('ALTER TABLE product DROP INDEX categorie_id');

        // Modifier les colonnes de product
        $this->addSql('ALTER TABLE product CHANGE nom name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE prix price DOUBLE NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE famille family VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE pays country VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE meilleure_vente best_seller TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE marque_id brand_id INT NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE categorie_id category_id INT NOT NULL');

        // Créer les nouveaux index
        $this->addSql('CREATE INDEX IDX_D34A04AD44F5D008 ON product (brand_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');

        // Recréer les clés étrangères
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');

        // Ajouter la description des produits
        $this->addSql('ALTER TABLE product ADD description LONGTEXT DEFAULT NULL');

        $this->addSql("
            UPDATE product SET description =
            CASE name
                WHEN 'Espresso Intense' THEN 'Un café intense aux notes corsées, élaboré à partir de grains arabica de Colombie.'
                WHEN 'Moka Doux' THEN 'Un café doux et parfumé aux arômes délicats, issu de grains arabica d''Éthiopie.'
                WHEN 'Mélange Maison' THEN 'Un assemblage équilibré de café Robusta du Brésil.'
                WHEN 'Café du Matin' THEN 'Un café aux saveurs franches, parfait pour commencer la journée.'
                WHEN 'Grand Cru' THEN 'Un café arabica du Kenya aux arômes riches.'
                ELSE 'Un café sélectionné avec soin.'
            END
        ");

        $this->addSql('ALTER TABLE product MODIFY description LONGTEXT NOT NULL');

        // Modifier les notes pour les passer sur 20
        $this->addSql('UPDATE product SET note = note * 4');
        $this->addSql('ALTER TABLE product MODIFY note DOUBLE PRECISION NOT NULL');

        // Rendre le nom des produits unique
        $this->addSql('CREATE UNIQUE INDEX unique_product_name ON product (name)');

        // Modifier la table admin
        $this->addSql('ALTER TABLE admin DROP nom, DROP prenom');
        $this->addSql('ALTER TABLE admin CHANGE mot_de_passe password VARCHAR(255) NOT NULL');

        // Modifier la table contact
        $this->addSql('ALTER TABLE contact CHANGE nom last_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE contact CHANGE prenom first_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE contact MODIFY email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE contact CHANGE telephone phone VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE contact MODIFY message LONGTEXT NOT NULL');

        // Modifier la table slider
        $this->addSql('ALTER TABLE slider CHANGE titre title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE slider CHANGE contenu content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE slider CHANGE texte_bouton button_text VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE slider CHANGE lien_bouton button_link VARCHAR(255) DEFAULT NULL');

        // Créer la table messenger_messages
        $this->addSql("
            CREATE TABLE IF NOT EXISTS messenger_messages (
                id BIGINT AUTO_INCREMENT NOT NULL,
                body LONGTEXT NOT NULL,
                headers LONGTEXT NOT NULL,
                queue_name VARCHAR(190) NOT NULL,
                created_at DATETIME NOT NULL,
                available_at DATETIME NOT NULL,
                delivered_at DATETIME DEFAULT NULL,
                INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci`
            ENGINE = InnoDB
        ");
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException(
            'Restaurer la sauvegarde SQL pour revenir à la base précédente.'
        );
    }
}
