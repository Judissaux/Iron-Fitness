<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230519083026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE general DROP stripe_session_id, CHANGE mention_legale mention_legale LONGTEXT NOT NULL, CHANGE cgu cgu VARCHAR(255) NOT NULL, CHANGE cgv cgv VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE general ADD stripe_session_id INT DEFAULT NULL, CHANGE mention_legale mention_legale LONGTEXT DEFAULT NULL, CHANGE cgu cgu VARCHAR(255) DEFAULT NULL, CHANGE cgv cgv VARCHAR(255) DEFAULT NULL');
    }
}
