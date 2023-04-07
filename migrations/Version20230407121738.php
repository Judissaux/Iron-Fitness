<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407121738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercise (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, illustration VARCHAR(255) NOT NULL, video VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercise_set (id INT AUTO_INCREMENT NOT NULL, exercise_id INT DEFAULT NULL, program_id INT DEFAULT NULL, repetition INT NOT NULL, series INT NOT NULL, rest INT NOT NULL, INDEX IDX_704B80A0E934951A (exercise_id), INDEX IDX_704B80A03EB8070A (program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercise_set ADD CONSTRAINT FK_704B80A0E934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE exercise_set ADD CONSTRAINT FK_704B80A03EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise_set DROP FOREIGN KEY FK_704B80A0E934951A');
        $this->addSql('ALTER TABLE exercise_set DROP FOREIGN KEY FK_704B80A03EB8070A');
        $this->addSql('DROP TABLE exercise');
        $this->addSql('DROP TABLE exercise_set');
        $this->addSql('DROP TABLE program');
    }
}
