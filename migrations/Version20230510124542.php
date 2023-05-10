<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230510124542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE days DROP FOREIGN KEY FK_EBE4FC6665B49873');
        $this->addSql('DROP INDEX IDX_EBE4FC6665B49873 ON days');
        $this->addSql('ALTER TABLE days DROP exercise_set_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE days ADD exercise_set_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE days ADD CONSTRAINT FK_EBE4FC6665B49873 FOREIGN KEY (exercise_set_id) REFERENCES exercise_set (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_EBE4FC6665B49873 ON days (exercise_set_id)');
    }
}
