<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230510123921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise_set DROP FOREIGN KEY FK_704B80A03575FA99');
        $this->addSql('DROP INDEX IDX_704B80A03575FA99 ON exercise_set');
        $this->addSql('ALTER TABLE exercise_set DROP days_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise_set ADD days_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercise_set ADD CONSTRAINT FK_704B80A03575FA99 FOREIGN KEY (days_id) REFERENCES days (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_704B80A03575FA99 ON exercise_set (days_id)');
    }
}
