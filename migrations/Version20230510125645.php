<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230510125645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise_set_days DROP FOREIGN KEY FK_784FBE073575FA99');
        $this->addSql('ALTER TABLE exercise_set_days DROP FOREIGN KEY FK_784FBE0765B49873');
        $this->addSql('DROP TABLE exercise_set_days');
        $this->addSql('DROP TABLE days');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercise_set_days (exercise_set_id INT NOT NULL, days_id INT NOT NULL, INDEX IDX_784FBE0765B49873 (exercise_set_id), INDEX IDX_784FBE073575FA99 (days_id), PRIMARY KEY(exercise_set_id, days_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE days (id INT AUTO_INCREMENT NOT NULL, day VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE exercise_set_days ADD CONSTRAINT FK_784FBE073575FA99 FOREIGN KEY (days_id) REFERENCES days (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_set_days ADD CONSTRAINT FK_784FBE0765B49873 FOREIGN KEY (exercise_set_id) REFERENCES exercise_set (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
