<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190315204922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE evolution DROP CONSTRAINT fk_420c2893f987d8a8');
        $this->addSql('DROP INDEX idx_420c2893f987d8a8');
        $this->addSql('ALTER TABLE evolution DROP user_created_id');
        $this->addSql('ALTER TABLE vote DROP CONSTRAINT fk_5a108564fa3db3d5');
        $this->addSql('DROP INDEX idx_5a108564fa3db3d5');
        $this->addSql('ALTER TABLE vote ADD user_vote_id INT NOT NULL');
        $this->addSql('ALTER TABLE vote DROP bug_id');
        $this->addSql('ALTER TABLE vote DROP user_id');
        $this->addSql('ALTER TABLE vote DROP vote_id');
        $this->addSql('ALTER TABLE vote ALTER evolution_id DROP NOT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085642AD1C4F6 FOREIGN KEY (user_vote_id) REFERENCES user_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5A1085642AD1C4F6 ON vote (user_vote_id)');
        $this->addSql('ALTER TABLE comments DROP id_bug');
        $this->addSql('ALTER TABLE comments DROP id_evolution');
        $this->addSql('ALTER TABLE comments RENAME COLUMN id_user TO user_comments_id');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962ACA2C5C13 FOREIGN KEY (user_comments_id) REFERENCES user_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5F9E962ACA2C5C13 ON comments (user_comments_id)');
        $this->addSql('ALTER TABLE bug DROP CONSTRAINT fk_358cbf14f987d8a8');
        $this->addSql('DROP INDEX idx_358cbf14f987d8a8');
        $this->addSql('ALTER TABLE bug DROP user_created_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE comments DROP CONSTRAINT FK_5F9E962ACA2C5C13');
        $this->addSql('DROP INDEX IDX_5F9E962ACA2C5C13');
        $this->addSql('ALTER TABLE comments ADD id_bug INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comments ADD id_evolution INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comments RENAME COLUMN user_comments_id TO id_user');
        $this->addSql('ALTER TABLE bug ADD user_created_id INT NOT NULL');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT fk_358cbf14f987d8a8 FOREIGN KEY (user_created_id) REFERENCES user_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_358cbf14f987d8a8 ON bug (user_created_id)');
        $this->addSql('ALTER TABLE vote DROP CONSTRAINT FK_5A1085642AD1C4F6');
        $this->addSql('DROP INDEX IDX_5A1085642AD1C4F6');
        $this->addSql('ALTER TABLE vote ADD bug_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vote ADD vote_id INT NOT NULL');
        $this->addSql('ALTER TABLE vote ALTER evolution_id SET NOT NULL');
        $this->addSql('ALTER TABLE vote RENAME COLUMN user_vote_id TO user_id');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT fk_5a108564fa3db3d5 FOREIGN KEY (bug_id) REFERENCES bug (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5a108564fa3db3d5 ON vote (bug_id)');
        $this->addSql('ALTER TABLE evolution ADD user_created_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evolution ADD CONSTRAINT fk_420c2893f987d8a8 FOREIGN KEY (user_created_id) REFERENCES user_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_420c2893f987d8a8 ON evolution (user_created_id)');
    }
}
