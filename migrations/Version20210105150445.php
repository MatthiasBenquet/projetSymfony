<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105150445 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, nom VARCHAR(30) NOT NULL, domaine VARCHAR(30) NOT NULL, adresse VARCHAR(30) NOT NULL, url_site_web VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, nom VARCHAR(30) NOT NULL, type_formation VARCHAR(30) NOT NULL, domaine VARCHAR(30) NOT NULL, ville VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT NOT NULL, code VARCHAR(10) NOT NULL, nom VARCHAR(30) NOT NULL, description LONGTEXT NOT NULL, date_debut DATE NOT NULL, duree SMALLINT NOT NULL, competences_requises LONGTEXT NOT NULL, experience_requise LONGTEXT NOT NULL, email VARCHAR(50) NOT NULL, contact VARCHAR(40) NOT NULL, INDEX IDX_C27C9369A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage_formation (stage_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_734BDB9E2298D193 (stage_id), INDEX IDX_734BDB9E5200282E (formation_id), PRIMARY KEY(stage_id, formation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE stage_formation ADD CONSTRAINT FK_734BDB9E2298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage_formation ADD CONSTRAINT FK_734BDB9E5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369A4AEAFEA');
        $this->addSql('ALTER TABLE stage_formation DROP FOREIGN KEY FK_734BDB9E5200282E');
        $this->addSql('ALTER TABLE stage_formation DROP FOREIGN KEY FK_734BDB9E2298D193');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE stage_formation');
    }
}
