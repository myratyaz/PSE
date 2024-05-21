<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240519125752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE octavian_vaideanu_pages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, link_slug VARCHAR(255) DEFAULT NULL)');
        $this->addSql('DROP TABLE messenger_messages_octavian');
        $this->addSql('DROP TABLE octavian_pages');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages_octavian (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL COLLATE "BINARY", headers CLOB NOT NULL COLLATE "BINARY", queue_name VARCHAR(190) NOT NULL COLLATE "BINARY", created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA11DB ON messenger_messages_octavian (delivered_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E2BD61CE ON messenger_messages_octavian (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F4 ON messenger_messages_octavian (queue_name)');
        $this->addSql('CREATE TABLE octavian_pages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE "BINARY", description CLOB NOT NULL COLLATE "BINARY", photo VARCHAR(255) NOT NULL COLLATE "BINARY", link_slug VARCHAR(255) NOT NULL COLLATE "BINARY")');
        $this->addSql('DROP TABLE octavian_vaideanu_pages');
    }
}
