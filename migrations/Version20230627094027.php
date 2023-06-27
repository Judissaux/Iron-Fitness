<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627094027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE general CHANGE email_client_refus page_erreur_paiement LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE program DROP day, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE general CHANGE page_erreur_paiement email_client_refus LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE program ADD day VARCHAR(20) DEFAULT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
    }
}
