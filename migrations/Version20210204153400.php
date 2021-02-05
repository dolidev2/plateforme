<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210204153400 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tache_marketing ADD programme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tache_marketing ADD CONSTRAINT FK_CC52EC6862BB7AEE FOREIGN KEY (programme_id) REFERENCES programme_marketing (id)');
        $this->addSql('CREATE INDEX IDX_CC52EC6862BB7AEE ON tache_marketing (programme_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tache_marketing DROP FOREIGN KEY FK_CC52EC6862BB7AEE');
        $this->addSql('DROP INDEX IDX_CC52EC6862BB7AEE ON tache_marketing');
        $this->addSql('ALTER TABLE tache_marketing DROP programme_id');
    }
}
