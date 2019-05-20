<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190304072212 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        //make current db migration ready
        $this->addSql('ALTER TABLE `galerij` ADD `status` varchar(20) NOT NULL; ALTER TABLE `images` ADD `status` varchar(20) NOT NULL; ALTER TABLE `items` ADD `status` varchar(20) NOT NULL; ALTER TABLE `leden` ADD `status` varchar(20) NOT NULL; UPDATE `galerij` SET status="actief" where actief="1"; UPDATE `galerij` SET status="inactief" where actief="0"; UPDATE `images` SET status="actief" where actief="1"; UPDATE `images` SET status="inactief" where actief="0"; UPDATE `items` SET status="actief" where actief="1"; UPDATE `items` SET status="inactief" where actief="0"; UPDATE `leden` SET status="actief" where actief="1"; UPDATE `leden` SET status="inactief" where actief="0"; ALTER TABLE `galerij` DROP `actief`; ALTER TABLE `images` DROP `actief`; ALTER TABLE `items` DROP `actief`; ALTER TABLE `leden` DROP `actief`;');

        //create new entities
        $this->addSql('CREATE TABLE gallery (id INT AUTO_INCREMENT NOT NULL, member_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date_created DATE NOT NULL, date_changed DATE NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_472B783A7597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, member_number VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competition_gallery (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date_created DATE NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competition_gallery_image (competition_gallery_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_D67516DCA7F04FB7 (competition_gallery_id), INDEX IDX_D67516DC3DA5256D (image_id), PRIMARY KEY(competition_gallery_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date_created DATE NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_140AB620C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, gallery_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, member_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, date_created DATETIME NOT NULL, sort_order INT NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_C53D045F4E7AF8F (gallery_id), INDEX IDX_C53D045F7597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783A7597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE competition_gallery_image ADD CONSTRAINT FK_D67516DCA7F04FB7 FOREIGN KEY (competition_gallery_id) REFERENCES competition_gallery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competition_gallery_image ADD CONSTRAINT FK_D67516DC3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620C54C8C93 FOREIGN KEY (type_id) REFERENCES page_type (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F7597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F4E7AF8F');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F7597D3FE');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620C54C8C93');
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783A7597D3FE');
        $this->addSql('ALTER TABLE competition_gallery_image DROP FOREIGN KEY FK_D67516DCA7F04FB7');
        $this->addSql('ALTER TABLE competition_gallery_image DROP FOREIGN KEY FK_D67516DC3DA5256D');
        $this->addSql('DROP TABLE gallery');
        $this->addSql('DROP TABLE page_type');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE competition_gallery');
        $this->addSql('DROP TABLE competition_gallery_image');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE image');

    }
}
