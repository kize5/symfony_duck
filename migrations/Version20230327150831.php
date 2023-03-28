<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327150831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, duck_id_id INTEGER NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , author VARCHAR(255) NOT NULL, photo VARCHAR(2000) NOT NULL, tags VARCHAR(255) DEFAULT NULL, is_comment BOOLEAN NOT NULL, id_linked_post INTEGER DEFAULT NULL, CONSTRAINT FK_83D44F6F12D926C9 FOREIGN KEY (duck_id_id) REFERENCES duck (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_83D44F6F12D926C9 ON quack (duck_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE quack');
    }
}
