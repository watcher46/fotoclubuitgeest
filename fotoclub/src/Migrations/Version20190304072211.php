<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190304072211 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

            $this->addSql('ALTER TABLE `galerij` ADD `status` varchar(20) NOT NULL');
            $this->addSql('ALTER TABLE `images` ADD `status` varchar(20) NOT NULL');
            $this->addSql('ALTER TABLE `items` ADD `status` varchar(20) NOT NULL');
            $this->addSql('ALTER TABLE `leden` ADD `status` varchar(20) NOT NULL');
            $this->addSql('UPDATE `galerij` SET status="actief" where actief="1"');
            $this->addSql('UPDATE `galerij` SET status="inactief" where actief="0"');
            $this->addSql('UPDATE `images` SET status="actief" where actief="1"');
            $this->addSql('UPDATE `images` SET status="inactief" where actief="0"');
            $this->addSql('UPDATE `items` SET status="actief" where actief="1"');
            $this->addSql('UPDATE `items` SET status="inactief" where actief="0"');
            $this->addSql('UPDATE `leden` SET status="actief" where actief="1"');
            $this->addSql('UPDATE `leden` SET status="inactief" where actief="0"');
            $this->addSql('ALTER TABLE `galerij` DROP `actief`');
            $this->addSql('ALTER TABLE `images` DROP `actief`');
            $this->addSql('ALTER TABLE `items` DROP `actief`');
            $this->addSql('ALTER TABLE `leden` DROP `actief`');


    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `galerij` ADD `actief` enum(\'1\', \'0\') NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE `images` ADD `actief` enum(\'1\', \'0\') NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE `items` ADD `actief` enum(\'1\', \'0\') NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE `leden` ADD `actief` enum(\'1\', \'0\') NOT NULL DEFAULT 1');
        $this->addSql('UPDATE `galerij` SET actief="1" where status="actief"');
        $this->addSql('UPDATE `galerij` SET actief="0" where status="inactief"');
        $this->addSql('UPDATE `images` SET actief="1" where status="actief"');
        $this->addSql('UPDATE `images` SET actief="0" where status="inactief"');
        $this->addSql('UPDATE `items` SET actief="1" where status="actief"');
        $this->addSql('UPDATE `items` SET actief="0" where status="inactief"');
        $this->addSql('UPDATE `leden` SET actief="1" where status="actief"');
        $this->addSql('UPDATE `leden` SET actief="0" where status="inactief"');
        $this->addSql('ALTER TABLE `galerij` DROP `status`');
        $this->addSql('ALTER TABLE `images` DROP `status`');
        $this->addSql('ALTER TABLE `items` DROP `status`');
        $this->addSql('ALTER TABLE `leden` DROP `status`');
    }
}
