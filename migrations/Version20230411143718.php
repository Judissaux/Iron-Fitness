<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411143718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE program_set_exercises DROP FOREIGN KEY FK_F2BEFCC31AFA70CA');
        $this->addSql('ALTER TABLE program_set_exercises DROP FOREIGN KEY FK_F2BEFCC344BB3342');
        $this->addSql('DROP TABLE program_set');
        $this->addSql('DROP TABLE program_set_exercises');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE program_set (id INT AUTO_INCREMENT NOT NULL, repetition INT DEFAULT NULL, series INT DEFAULT NULL, break INT DEFAULT NULL, duration INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE program_set_exercises (program_set_id INT NOT NULL, exercises_id INT NOT NULL, INDEX IDX_F2BEFCC344BB3342 (program_set_id), INDEX IDX_F2BEFCC31AFA70CA (exercises_id), PRIMARY KEY(program_set_id, exercises_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE program_set_exercises ADD CONSTRAINT FK_F2BEFCC31AFA70CA FOREIGN KEY (exercises_id) REFERENCES exercises (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_set_exercises ADD CONSTRAINT FK_F2BEFCC344BB3342 FOREIGN KEY (program_set_id) REFERENCES program_set (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
