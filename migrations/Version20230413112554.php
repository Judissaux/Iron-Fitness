<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230413112554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercice_set ADD program_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercice_set ADD CONSTRAINT FK_739D823B3EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('CREATE INDEX IDX_739D823B3EB8070A ON exercice_set (program_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercice_set DROP FOREIGN KEY FK_739D823B3EB8070A');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP INDEX IDX_739D823B3EB8070A ON exercice_set');
        $this->addSql('ALTER TABLE exercice_set DROP program_id');
    }
}
