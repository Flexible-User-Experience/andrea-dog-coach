<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250626083346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE contact_message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, message CLOB NOT NULL, has_been_read BOOLEAN DEFAULT 0 NOT NULL, reply_date DATETIME DEFAULT NULL, has_been_replied BOOLEAN DEFAULT 0 NOT NULL, reply_message CLOB DEFAULT NULL, legacy_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active BOOLEAN DEFAULT 1 NOT NULL, mobile_number VARCHAR(255) DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_2C9211FE184998FC ON contact_message (legacy_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE page_path_visit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, screen_page_views INTEGER DEFAULT 0 NOT NULL, legacy_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active BOOLEAN DEFAULT 1 NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_BDFC7079184998FC ON page_path_visit (legacy_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, year SMALLINT DEFAULT 2024 NOT NULL, description CLOB DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, begin_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, show_customer_name_in_frontend BOOLEAN DEFAULT 1 NOT NULL, legacy_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active BOOLEAN DEFAULT 1 NOT NULL, document_name VARCHAR(255) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INTEGER DEFAULT NULL, position SMALLINT DEFAULT 1 NOT NULL, show_in_frontend BOOLEAN DEFAULT 1 NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_2FB3D0EE5E237E06 ON project (name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_2FB3D0EE989D9B62 ON project (slug)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_2FB3D0EE184998FC ON project (legacy_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE project_project_category (project_id INTEGER NOT NULL, project_category_id INTEGER NOT NULL, PRIMARY KEY(project_id, project_category_id), CONSTRAINT FK_86875173166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_86875173DA896A19 FOREIGN KEY (project_category_id) REFERENCES project_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_86875173166D1F9C ON project_project_category (project_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_86875173DA896A19 ON project_project_category (project_category_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE project_category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, legacy_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active BOOLEAN DEFAULT 1 NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_3B02921A5E237E06 ON project_category (name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_3B02921A989D9B62 ON project_category (slug)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_3B02921A184998FC ON project_category (legacy_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE project_category_translation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, object_id INTEGER DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content CLOB DEFAULT NULL, CONSTRAINT FK_251134AB232D562B FOREIGN KEY (object_id) REFERENCES project_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_251134AB232D562B ON project_category_translation (object_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX lookup_project_category_unique_idx ON project_category_translation (locale, object_id, field)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE project_image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, project_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, legacy_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active BOOLEAN DEFAULT 1 NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INTEGER DEFAULT NULL, position SMALLINT DEFAULT 1 NOT NULL, CONSTRAINT FK_D6680DC1166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_D6680DC1184998FC ON project_image (legacy_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D6680DC1166D1F9C ON project_image (project_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE project_translation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, object_id INTEGER DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content CLOB DEFAULT NULL, CONSTRAINT FK_7CA6B294232D562B FOREIGN KEY (object_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7CA6B294232D562B ON project_translation (object_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX lookup_project_unique_idx ON project_translation (locale, object_id, field)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE service (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, legacy_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active BOOLEAN DEFAULT 1 NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INTEGER DEFAULT NULL, position SMALLINT DEFAULT 1 NOT NULL, show_in_frontend BOOLEAN DEFAULT 1 NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_E19D9AD2184998FC ON service (legacy_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE service_list_item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, service_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, legacy_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, active BOOLEAN DEFAULT 1 NOT NULL, position SMALLINT DEFAULT 1 NOT NULL, CONSTRAINT FK_244C0BDED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_244C0BD184998FC ON service_list_item (legacy_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_244C0BDED5CA9E6 ON service_list_item (service_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE service_list_item_translation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, object_id INTEGER DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content CLOB DEFAULT NULL, CONSTRAINT FK_189B0CB7232D562B FOREIGN KEY (object_id) REFERENCES service_list_item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_189B0CB7232D562B ON service_list_item_translation (object_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX lookup_service_list_item_unique_idx ON service_list_item_translation (locale, object_id, field)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE service_translation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, object_id INTEGER DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content CLOB DEFAULT NULL, CONSTRAINT FK_78F363C3232D562B FOREIGN KEY (object_id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_78F363C3232D562B ON service_translation (object_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX lookup_service_unique_idx ON service_translation (locale, object_id, field)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE contact_message
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE page_path_visit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE project
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE project_project_category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE project_category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE project_category_translation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE project_image
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE project_translation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE service
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE service_list_item
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE service_list_item_translation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE service_translation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
