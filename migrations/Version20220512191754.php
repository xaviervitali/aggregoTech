<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220512191754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE statement DROP FOREIGN KEY FK_C0DB51765F0EBBFF');
        $this->addSql('ALTER TABLE statement DROP FOREIGN KEY FK_C0DB5176A726DED4');
        $this->addSql('DROP TABLE statement_comment');
        $this->addSql('DROP INDEX IDX_C0DB51765F0EBBFF ON statement');
        $this->addSql('DROP INDEX IDX_C0DB5176A726DED4 ON statement');
        $this->addSql('ALTER TABLE statement DROP user_comment_id, DROP manager_comment_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE statement_comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, comment LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9E4DCD32A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE statement_comment ADD CONSTRAINT FK_9E4DCD32A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE statement ADD user_comment_id INT DEFAULT NULL, ADD manager_comment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE statement ADD CONSTRAINT FK_C0DB51765F0EBBFF FOREIGN KEY (user_comment_id) REFERENCES statement_comment (id)');
        $this->addSql('ALTER TABLE statement ADD CONSTRAINT FK_C0DB5176A726DED4 FOREIGN KEY (manager_comment_id) REFERENCES statement_comment (id)');
        $this->addSql('CREATE INDEX IDX_C0DB51765F0EBBFF ON statement (user_comment_id)');
        $this->addSql('CREATE INDEX IDX_C0DB5176A726DED4 ON statement (manager_comment_id)');
    }
}
