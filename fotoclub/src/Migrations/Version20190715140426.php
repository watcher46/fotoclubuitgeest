<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190715140426 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620C54C8C93');
        $this->addSql('CREATE TABLE agenda (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, date_created DATETIME NOT NULL, date_updated DATETIME NOT NULL, event_date DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE navigation (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, text LONGTEXT DEFAULT NULL, date_created DATETIME NOT NULL, date_updated DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE page_type');
        $this->addSql('DROP INDEX UNIQ_140AB620C54C8C93 ON page');
        $this->addSql('ALTER TABLE page ADD image_id INT DEFAULT NULL, ADD navigation_item_id INT DEFAULT NULL, ADD date_updated DATETIME NOT NULL, ADD enabled TINYINT(1) NOT NULL, DROP type_id, CHANGE date_created date_created DATETIME NOT NULL, CHANGE description text LONGTEXT NOT NULL, CHANGE active homepage TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB6203DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62054ED5C2D FOREIGN KEY (navigation_item_id) REFERENCES navigation (id)');
        $this->addSql('CREATE INDEX IDX_140AB6203DA5256D ON page (image_id)');
        $this->addSql('CREATE INDEX IDX_140AB62054ED5C2D ON page (navigation_item_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62054ED5C2D');
        $this->addSql('CREATE TABLE page_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE agenda');
        $this->addSql('DROP TABLE navigation');
        $this->addSql('DROP TABLE news');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB6203DA5256D');
        $this->addSql('DROP INDEX IDX_140AB6203DA5256D ON page');
        $this->addSql('DROP INDEX IDX_140AB62054ED5C2D ON page');
        $this->addSql('ALTER TABLE page ADD type_id INT NOT NULL, ADD active TINYINT(1) NOT NULL, DROP image_id, DROP navigation_item_id, DROP date_updated, DROP homepage, DROP enabled, CHANGE date_created date_created DATE NOT NULL, CHANGE text description LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620C54C8C93 FOREIGN KEY (type_id) REFERENCES page_type (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_140AB620C54C8C93 ON page (type_id)');
    }
}
