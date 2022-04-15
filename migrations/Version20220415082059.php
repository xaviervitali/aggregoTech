<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415082059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address_book (id INT AUTO_INCREMENT NOT NULL, company_name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, address VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address_book_activity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address_book_activity_address_book (address_book_activity_id INT NOT NULL, address_book_id INT NOT NULL, INDEX IDX_BA31E8576005A31B (address_book_activity_id), INDEX IDX_BA31E8574D474419 (address_book_id), PRIMARY KEY(address_book_activity_id, address_book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address_book_contact (id INT AUTO_INCREMENT NOT NULL, address_book_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, role VARCHAR(255) DEFAULT NULL, INDEX IDX_D3E31AB54D474419 (address_book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attendance (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, added_by_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6DE30D91A76ED395 (user_id), INDEX IDX_6DE30D9155B127A4 (added_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avatar (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, image_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1677722FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE collaboration (id INT AUTO_INCREMENT NOT NULL, collaboration_choice_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_DA3AE3236875D18F (collaboration_choice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE collaboration_choice (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, firm_name VARCHAR(255) DEFAULT NULL, message LONGTEXT NOT NULL, request VARCHAR(255) NOT NULL, entity VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field_category (field_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_D0749E0C443707B0 (field_id), INDEX IDX_D0749E0C12469DE2 (category_id), PRIMARY KEY(field_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_upload (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, file_category_id INT DEFAULT NULL, file_uploaded_name VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_AFAAC0A0A76ED395 (user_id), INDEX IDX_AFAAC0A030FD6380 (file_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE survey (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, field_id INT DEFAULT NULL, user_id INT DEFAULT NULL, answer LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_AD5F9BFC12469DE2 (category_id), INDEX IDX_AD5F9BFC443707B0 (field_id), INDEX IDX_AD5F9BFCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', leave_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', gender VARCHAR(255) NOT NULL, signature LONGTEXT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address_book_activity_address_book ADD CONSTRAINT FK_BA31E8576005A31B FOREIGN KEY (address_book_activity_id) REFERENCES address_book_activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE address_book_activity_address_book ADD CONSTRAINT FK_BA31E8574D474419 FOREIGN KEY (address_book_id) REFERENCES address_book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE address_book_contact ADD CONSTRAINT FK_D3E31AB54D474419 FOREIGN KEY (address_book_id) REFERENCES address_book (id)');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D91A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D9155B127A4 FOREIGN KEY (added_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE avatar ADD CONSTRAINT FK_1677722FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE collaboration ADD CONSTRAINT FK_DA3AE3236875D18F FOREIGN KEY (collaboration_choice_id) REFERENCES collaboration_choice (id)');
        $this->addSql('ALTER TABLE field_category ADD CONSTRAINT FK_D0749E0C443707B0 FOREIGN KEY (field_id) REFERENCES field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE field_category ADD CONSTRAINT FK_D0749E0C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE file_upload ADD CONSTRAINT FK_AFAAC0A0A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE file_upload ADD CONSTRAINT FK_AFAAC0A030FD6380 FOREIGN KEY (file_category_id) REFERENCES file_category (id)');
        $this->addSql('ALTER TABLE survey ADD CONSTRAINT FK_AD5F9BFC12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE survey ADD CONSTRAINT FK_AD5F9BFC443707B0 FOREIGN KEY (field_id) REFERENCES field (id)');
        $this->addSql('ALTER TABLE survey ADD CONSTRAINT FK_AD5F9BFCA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address_book_activity_address_book DROP FOREIGN KEY FK_BA31E8574D474419');
        $this->addSql('ALTER TABLE address_book_contact DROP FOREIGN KEY FK_D3E31AB54D474419');
        $this->addSql('ALTER TABLE address_book_activity_address_book DROP FOREIGN KEY FK_BA31E8576005A31B');
        $this->addSql('ALTER TABLE field_category DROP FOREIGN KEY FK_D0749E0C12469DE2');
        $this->addSql('ALTER TABLE survey DROP FOREIGN KEY FK_AD5F9BFC12469DE2');
        $this->addSql('ALTER TABLE collaboration DROP FOREIGN KEY FK_DA3AE3236875D18F');
        $this->addSql('ALTER TABLE field_category DROP FOREIGN KEY FK_D0749E0C443707B0');
        $this->addSql('ALTER TABLE survey DROP FOREIGN KEY FK_AD5F9BFC443707B0');
        $this->addSql('ALTER TABLE file_upload DROP FOREIGN KEY FK_AFAAC0A030FD6380');
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D91A76ED395');
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D9155B127A4');
        $this->addSql('ALTER TABLE avatar DROP FOREIGN KEY FK_1677722FA76ED395');
        $this->addSql('ALTER TABLE file_upload DROP FOREIGN KEY FK_AFAAC0A0A76ED395');
        $this->addSql('ALTER TABLE survey DROP FOREIGN KEY FK_AD5F9BFCA76ED395');
        $this->addSql('DROP TABLE address_book');
        $this->addSql('DROP TABLE address_book_activity');
        $this->addSql('DROP TABLE address_book_activity_address_book');
        $this->addSql('DROP TABLE address_book_contact');
        $this->addSql('DROP TABLE attendance');
        $this->addSql('DROP TABLE avatar');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE collaboration');
        $this->addSql('DROP TABLE collaboration_choice');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE field');
        $this->addSql('DROP TABLE field_category');
        $this->addSql('DROP TABLE file_category');
        $this->addSql('DROP TABLE file_upload');
        $this->addSql('DROP TABLE survey');
        $this->addSql('DROP TABLE `user`');
    }
}
