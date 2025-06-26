<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250626093009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE service ADD COLUMN description CLOB DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__service AS SELECT id, name, legacy_id, created_at, updated_at, active, image_name, image_size, position, show_in_frontend FROM service
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE service
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE service (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, legacy_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active BOOLEAN DEFAULT 1 NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INTEGER DEFAULT NULL, position SMALLINT DEFAULT 1 NOT NULL, show_in_frontend BOOLEAN DEFAULT 1 NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO service (id, name, legacy_id, created_at, updated_at, active, image_name, image_size, position, show_in_frontend) SELECT id, name, legacy_id, created_at, updated_at, active, image_name, image_size, position, show_in_frontend FROM __temp__service
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__service
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_E19D9AD2184998FC ON service (legacy_id)
        SQL);
    }
}
