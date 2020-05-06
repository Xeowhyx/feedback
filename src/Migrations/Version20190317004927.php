<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190317004927 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE bug DROP CONSTRAINT fk_358cbf14f987d8a8');
        $this->addSql('ALTER TABLE bug DROP CONSTRAINT fk_358cbf149f6fa8e8');
        $this->addSql('ALTER TABLE evolution DROP CONSTRAINT fk_420c2893f987d8a8');
        $this->addSql('ALTER TABLE evolution DROP CONSTRAINT fk_420c28934d335d58');
        $this->addSql('DROP SEQUENCE test_id_seq CASCADE');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE evolution DROP CONSTRAINT FK_420C28934D335D58');
        $this->addSql('DROP INDEX idx_420c2893f987d8a8');
        $this->addSql('ALTER TABLE evolution DROP user_created_id');
        $this->addSql('ALTER TABLE evolution ADD CONSTRAINT FK_420C28934D335D58 FOREIGN KEY (user_evolution_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vote DROP CONSTRAINT fk_5a108564fa3db3d5');
        $this->addSql('DROP INDEX idx_5a108564fa3db3d5');
        $this->addSql('ALTER TABLE vote ADD user_vote_id INT NOT NULL');
        $this->addSql('ALTER TABLE vote DROP bug_id');
        $this->addSql('ALTER TABLE vote DROP user_id');
        $this->addSql('ALTER TABLE vote DROP vote_id');
        $this->addSql('ALTER TABLE vote ALTER evolution_id DROP NOT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085642AD1C4F6 FOREIGN KEY (user_vote_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5A1085642AD1C4F6 ON vote (user_vote_id)');
        $this->addSql('ALTER TABLE comments DROP id_bug');
        $this->addSql('ALTER TABLE comments DROP id_evolution');
        $this->addSql('ALTER TABLE comments RENAME COLUMN id_user TO user_comments_id');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962ACA2C5C13 FOREIGN KEY (user_comments_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5F9E962ACA2C5C13 ON comments (user_comments_id)');
        $this->addSql('ALTER TABLE bug DROP CONSTRAINT FK_358CBF149F6FA8E8');
        $this->addSql('DROP INDEX idx_358cbf14f987d8a8');
        $this->addSql('ALTER TABLE bug DROP user_created_id');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF149F6FA8E8 FOREIGN KEY (user_bug_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE evolution DROP CONSTRAINT FK_420C28934D335D58');
        $this->addSql('ALTER TABLE vote DROP CONSTRAINT FK_5A1085642AD1C4F6');
        $this->addSql('ALTER TABLE comments DROP CONSTRAINT FK_5F9E962ACA2C5C13');
        $this->addSql('ALTER TABLE bug DROP CONSTRAINT FK_358CBF149F6FA8E8');
        $this->addSql('CREATE SEQUENCE test_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE test (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649e7927c74 ON users (email)');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('ALTER TABLE bug DROP CONSTRAINT fk_358cbf149f6fa8e8');
        $this->addSql('ALTER TABLE bug ADD user_created_id INT NOT NULL');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT fk_358cbf14f987d8a8 FOREIGN KEY (user_created_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT fk_358cbf149f6fa8e8 FOREIGN KEY (user_bug_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_358cbf14f987d8a8 ON bug (user_created_id)');
        $this->addSql('DROP INDEX IDX_5A1085642AD1C4F6');
        $this->addSql('ALTER TABLE vote ADD bug_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vote ADD vote_id INT NOT NULL');
        $this->addSql('ALTER TABLE vote ALTER evolution_id SET NOT NULL');
        $this->addSql('ALTER TABLE vote RENAME COLUMN user_vote_id TO user_id');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT fk_5a108564fa3db3d5 FOREIGN KEY (bug_id) REFERENCES bug (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5a108564fa3db3d5 ON vote (bug_id)');
        $this->addSql('ALTER TABLE evolution DROP CONSTRAINT fk_420c28934d335d58');
        $this->addSql('ALTER TABLE evolution ADD user_created_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evolution ADD CONSTRAINT fk_420c2893f987d8a8 FOREIGN KEY (user_created_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evolution ADD CONSTRAINT fk_420c28934d335d58 FOREIGN KEY (user_evolution_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_420c2893f987d8a8 ON evolution (user_created_id)');
        $this->addSql('DROP INDEX IDX_5F9E962ACA2C5C13');
        $this->addSql('ALTER TABLE comments ADD id_bug INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comments ADD id_evolution INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comments RENAME COLUMN user_comments_id TO id_user');
    }
}
