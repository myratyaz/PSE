<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240503092032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vaideanu_cornel_pages ADD COLUMN slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__vaideanu_cornel_pages AS SELECT id, title, description, photo FROM vaideanu_cornel_pages');
        $this->addSql('DROP TABLE vaideanu_cornel_pages');
        $this->addSql('CREATE TABLE vaideanu_cornel_pages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, photo VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO vaideanu_cornel_pages (id, title, description, photo) SELECT id, title, description, photo FROM __temp__vaideanu_cornel_pages');
        $this->addSql('DROP TABLE __temp__vaideanu_cornel_pages');
    }
}
