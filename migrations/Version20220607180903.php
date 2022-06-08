<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220607180903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resume ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE resume ADD CONSTRAINT FK_60C1D0A0A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_60C1D0A0A76ED395 ON resume (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resume DROP FOREIGN KEY FK_60C1D0A0A76ED395');
        $this->addSql('DROP INDEX UNIQ_60C1D0A0A76ED395 ON resume');
        $this->addSql('ALTER TABLE resume DROP user_id');
    }
}
