<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211125093953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite_categorie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activites (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, meta_description VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, histoire LONGTEXT NOT NULL, citation VARCHAR(255) DEFAULT NULL, discipline LONGTEXT NOT NULL, equipement LONGTEXT NOT NULL, aptitudes LONGTEXT NOT NULL, photo_en_avant VARCHAR(255) NOT NULL, legende_en_avant VARCHAR(255) NOT NULL, photo_histoire VARCHAR(255) NOT NULL, legende_histoire VARCHAR(255) NOT NULL, photo_discipline VARCHAR(255) NOT NULL, legende_photo_discipline VARCHAR(255) NOT NULL, INDEX IDX_766B5EB5BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, title VARCHAR(255) NOT NULL, created_date DATE NOT NULL, slug VARCHAR(255) NOT NULL, meta_description VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, image_en_avant VARCHAR(255) NOT NULL, INDEX IDX_BFDD3168BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centres (id INT AUTO_INCREMENT NOT NULL, categorie_centre_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, meta_description VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, localisation VARCHAR(255) NOT NULL, age_min VARCHAR(255) NOT NULL, age_max VARCHAR(255) NOT NULL, photo_cadre VARCHAR(255) NOT NULL, legende_photo_cadre VARCHAR(255) NOT NULL, photo_encadrement VARCHAR(255) NOT NULL, legende_photo_encadrement VARCHAR(255) NOT NULL, cadre_de_vie LONGTEXT NOT NULL, encadrement LONGTEXT NOT NULL, centre_plus LONGTEXT NOT NULL, photo_en_avant VARCHAR(255) NOT NULL, legende_photo_en_avant VARCHAR(255) NOT NULL, INDEX IDX_3BA7EA52EB63D8C4 (categorie_centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centres_categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe_decouverte (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, titre VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, meta_description VARCHAR(255) NOT NULL, introduction LONGTEXT NOT NULL, presentation LONGTEXT NOT NULL, encadrement LONGTEXT NOT NULL, hebergement LONGTEXT NOT NULL, decouverte LONGTEXT NOT NULL, animation LONGTEXT NOT NULL, photo_en_avant VARCHAR(255) NOT NULL, legende_photo_en_avant VARCHAR(255) NOT NULL, photo_classe VARCHAR(255) NOT NULL, legende_photo_classe VARCHAR(255) NOT NULL, INDEX IDX_ABA869DFBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe_decouverte_categorie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE duree_sejour (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE saisons (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sejours (id INT AUTO_INCREMENT NOT NULL, saisons_id INT NOT NULL, activite_id INT NOT NULL, centre_id INT NOT NULL, titre VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, meta_description VARCHAR(255) NOT NULL, introduction LONGTEXT NOT NULL, age_min VARCHAR(255) NOT NULL, age_max VARCHAR(255) NOT NULL, prix_min VARCHAR(255) NOT NULL, cadre_de_vie LONGTEXT NOT NULL, encadrement LONGTEXT NOT NULL, plus_du_sejour LONGTEXT NOT NULL, indispensables LONGTEXT NOT NULL, activites_dominantes LONGTEXT NOT NULL, activites_annexes LONGTEXT NOT NULL, photo_en_avant VARCHAR(255) NOT NULL, legende_photo_en_avant VARCHAR(255) NOT NULL, photo_cadre VARCHAR(255) NOT NULL, legende_photo_cadre VARCHAR(255) NOT NULL, photo_encadrement VARCHAR(255) NOT NULL, legende_photo_encadrement VARCHAR(255) NOT NULL, date_sejour LONGTEXT NOT NULL, INDEX IDX_2E2D92D198E2D5DF (saisons_id), INDEX IDX_2E2D92D19B0F88B1 (activite_id), INDEX IDX_2E2D92D1463CD7C3 (centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sejours_duree_sejour (sejours_id INT NOT NULL, duree_sejour_id INT NOT NULL, INDEX IDX_E3480C97ECA22EF4 (sejours_id), INDEX IDX_E3480C979CDD2F46 (duree_sejour_id), PRIMARY KEY(sejours_id, duree_sejour_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activites ADD CONSTRAINT FK_766B5EB5BCF5E72D FOREIGN KEY (categorie_id) REFERENCES activite_categorie (id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168BCF5E72D FOREIGN KEY (categorie_id) REFERENCES article_categories (id)');
        $this->addSql('ALTER TABLE centres ADD CONSTRAINT FK_3BA7EA52EB63D8C4 FOREIGN KEY (categorie_centre_id) REFERENCES centres_categories (id)');
        $this->addSql('ALTER TABLE classe_decouverte ADD CONSTRAINT FK_ABA869DFBCF5E72D FOREIGN KEY (categorie_id) REFERENCES classe_decouverte_categorie (id)');
        $this->addSql('ALTER TABLE sejours ADD CONSTRAINT FK_2E2D92D198E2D5DF FOREIGN KEY (saisons_id) REFERENCES saisons (id)');
        $this->addSql('ALTER TABLE sejours ADD CONSTRAINT FK_2E2D92D19B0F88B1 FOREIGN KEY (activite_id) REFERENCES activites (id)');
        $this->addSql('ALTER TABLE sejours ADD CONSTRAINT FK_2E2D92D1463CD7C3 FOREIGN KEY (centre_id) REFERENCES centres (id)');
        $this->addSql('ALTER TABLE sejours_duree_sejour ADD CONSTRAINT FK_E3480C97ECA22EF4 FOREIGN KEY (sejours_id) REFERENCES sejours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sejours_duree_sejour ADD CONSTRAINT FK_E3480C979CDD2F46 FOREIGN KEY (duree_sejour_id) REFERENCES duree_sejour (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activites DROP FOREIGN KEY FK_766B5EB5BCF5E72D');
        $this->addSql('ALTER TABLE sejours DROP FOREIGN KEY FK_2E2D92D19B0F88B1');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168BCF5E72D');
        $this->addSql('ALTER TABLE sejours DROP FOREIGN KEY FK_2E2D92D1463CD7C3');
        $this->addSql('ALTER TABLE centres DROP FOREIGN KEY FK_3BA7EA52EB63D8C4');
        $this->addSql('ALTER TABLE classe_decouverte DROP FOREIGN KEY FK_ABA869DFBCF5E72D');
        $this->addSql('ALTER TABLE sejours_duree_sejour DROP FOREIGN KEY FK_E3480C979CDD2F46');
        $this->addSql('ALTER TABLE sejours DROP FOREIGN KEY FK_2E2D92D198E2D5DF');
        $this->addSql('ALTER TABLE sejours_duree_sejour DROP FOREIGN KEY FK_E3480C97ECA22EF4');
        $this->addSql('DROP TABLE activite_categorie');
        $this->addSql('DROP TABLE activites');
        $this->addSql('DROP TABLE article_categories');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE centres');
        $this->addSql('DROP TABLE centres_categories');
        $this->addSql('DROP TABLE classe_decouverte');
        $this->addSql('DROP TABLE classe_decouverte_categorie');
        $this->addSql('DROP TABLE duree_sejour');
        $this->addSql('DROP TABLE saisons');
        $this->addSql('DROP TABLE sejours');
        $this->addSql('DROP TABLE sejours_duree_sejour');
        $this->addSql('DROP TABLE user');
    }
}
