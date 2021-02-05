<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210201114101 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comptabilite (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, type VARCHAR(20) DEFAULT NULL, description LONGTEXT DEFAULT NULL, client VARCHAR(100) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_A737A41BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comptabilite ADD CONSTRAINT FK_A737A41BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE fichier_comptabilite ADD comptabilite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fichier_comptabilite ADD CONSTRAINT FK_E51F73EF4E455E4 FOREIGN KEY (comptabilite_id) REFERENCES comptabilite (id)');
        $this->addSql('CREATE INDEX IDX_E51F73EF4E455E4 ON fichier_comptabilite (comptabilite_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichier_comptabilite DROP FOREIGN KEY FK_E51F73EF4E455E4');
        $this->addSql('DROP TABLE comptabilite');
        $this->addSql('DROP INDEX IDX_E51F73EF4E455E4 ON fichier_comptabilite');
        $this->addSql('ALTER TABLE fichier_comptabilite DROP comptabilite_id');
    }
}
