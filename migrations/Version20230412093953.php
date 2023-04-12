<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230412093953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercises DROP FOREIGN KEY FK_FA14991C974DA02');
        $this->addSql('DROP TABLE exercice_set');
        $this->addSql('DROP INDEX IDX_FA14991C974DA02 ON exercises');
        $this->addSql('ALTER TABLE exercises DROP exercice_set_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercice_set (id INT AUTO_INCREMENT NOT NULL, repetition INT DEFAULT NULL, series INT DEFAULT NULL, break INT DEFAULT NULL, duration INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE exercises ADD exercice_set_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercises ADD CONSTRAINT FK_FA14991C974DA02 FOREIGN KEY (exercice_set_id) REFERENCES exercice_set (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_FA14991C974DA02 ON exercises (exercice_set_id)');
    }
}
