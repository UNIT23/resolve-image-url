<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201121215829 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entity_with_image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entity_with_media_and_image (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_28E0EA45EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entity_with_media_list (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, entity_with_media_list_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, INDEX IDX_6A2CA10C6283B1BD (entity_with_media_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entity_with_media_and_image ADD CONSTRAINT FK_28E0EA45EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C6283B1BD FOREIGN KEY (entity_with_media_list_id) REFERENCES entity_with_media_list (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C6283B1BD');
        $this->addSql('ALTER TABLE entity_with_media_and_image DROP FOREIGN KEY FK_28E0EA45EA9FDD75');
        $this->addSql('DROP TABLE entity_with_image');
        $this->addSql('DROP TABLE entity_with_media_and_image');
        $this->addSql('DROP TABLE entity_with_media_list');
        $this->addSql('DROP TABLE media');
    }
}
