<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190318143101 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE bug DROP CONSTRAINT fk_358cbf1415349e01');
        $this->addSql('DROP INDEX idx_358cbf1415349e01');
        $this->addSql('ALTER TABLE bug RENAME COLUMN prority_id TO priority_id');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF14497B19F9 FOREIGN KEY (priority_id) REFERENCES priority (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_358CBF14497B19F9 ON bug (priority_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE bug DROP CONSTRAINT FK_358CBF14497B19F9');
        $this->addSql('DROP INDEX IDX_358CBF14497B19F9');
        $this->addSql('ALTER TABLE bug RENAME COLUMN priority_id TO prority_id');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT fk_358cbf1415349e01 FOREIGN KEY (prority_id) REFERENCES priority (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_358cbf1415349e01 ON bug (prority_id)');
    }
}
