<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321091642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quack ADD COLUMN created_at DATETIME');
    }
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack AS SELECT id, content, date FROM quack');
        $this->addSql('DROP TABLE quack');
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content VARCHAR(255) NOT NULL, date VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO quack (id, content, date) SELECT id, content, date FROM __temp__quack');
        $this->addSql('DROP TABLE __temp__quack');
    }
}
