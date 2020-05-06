<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190305151225 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE comments_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE comments (id INT NOT NULL, evolution_id INT DEFAULT NULL, bug_id INT DEFAULT NULL, id_user INT NOT NULL, comment_desc VARCHAR(255) DEFAULT NULL, id_bug INT DEFAULT NULL, id_evolution INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5F9E962ACDFF215A ON comments (evolution_id)');
        $this->addSql('CREATE INDEX IDX_5F9E962AFA3DB3D5 ON comments (bug_id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962ACDFF215A FOREIGN KEY (evolution_id) REFERENCES evolution (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AFA3DB3D5 FOREIGN KEY (bug_id) REFERENCES bug (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE comment');
        $this->addSql('ALTER TABLE evolution DROP CONSTRAINT fk_420c2893139c32bd');
        $this->addSql('DROP INDEX idx_420c2893139c32bd');
        $this->addSql('ALTER TABLE evolution ADD user_evolution_id INT NOT NULL');
        $this->addSql('ALTER TABLE evolution RENAME COLUMN usercreated_id TO user_created_id');
        $this->addSql('ALTER TABLE evolution RENAME COLUMN evolution_name TO name');
        $this->addSql('ALTER TABLE evolution RENAME COLUMN evolution_date TO date');
        $this->addSql('ALTER TABLE evolution RENAME COLUMN evolution_description TO description');
        $this->addSql('ALTER TABLE evolution ADD CONSTRAINT FK_420C2893F987D8A8 FOREIGN KEY (user_created_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evolution ADD CONSTRAINT FK_420C28934D335D58 FOREIGN KEY (user_evolution_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_420C2893F987D8A8 ON evolution (user_created_id)');
        $this->addSql('CREATE INDEX IDX_420C28934D335D58 ON evolution (user_evolution_id)');
        $this->addSql('ALTER TABLE "user" ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE "user" DROP id_user');
        $this->addSql('ALTER TABLE "user" DROP pseudonyme');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(180)');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN role TO password');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE bug DROP CONSTRAINT fk_358cbf14139c32bd');
        $this->addSql('DROP INDEX idx_358cbf14139c32bd');
        $this->addSql('ALTER TABLE bug ADD user_created_id INT NOT NULL');
        $this->addSql('ALTER TABLE bug ADD user_bug_id INT NOT NULL');
        $this->addSql('ALTER TABLE bug ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE bug ADD location VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE bug DROP usercreated_id');
        $this->addSql('ALTER TABLE bug DROP bug_id');
        $this->addSql('ALTER TABLE bug DROP bug_name');
        $this->addSql('ALTER TABLE bug DROP bug_location');
        $this->addSql('ALTER TABLE bug RENAME COLUMN bug_date TO date');
        $this->addSql('ALTER TABLE bug RENAME COLUMN bug_description TO description');
        $this->addSql('ALTER TABLE bug RENAME COLUMN bug_os TO os');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF14F987D8A8 FOREIGN KEY (user_created_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF149F6FA8E8 FOREIGN KEY (user_bug_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_358CBF14F987D8A8 ON bug (user_created_id)');
        $this->addSql('CREATE INDEX IDX_358CBF149F6FA8E8 ON bug (user_bug_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE comments_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, evolution_id INT DEFAULT NULL, bug_id INT DEFAULT NULL, id_user INT NOT NULL, comment_desc VARCHAR(255) DEFAULT NULL, id_bug INT DEFAULT NULL, id_evolution INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_9474526ccdff215a ON comment (evolution_id)');
        $this->addSql('CREATE INDEX idx_9474526cfa3db3d5 ON comment (bug_id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526ccdff215a FOREIGN KEY (evolution_id) REFERENCES evolution (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526cfa3db3d5 FOREIGN KEY (bug_id) REFERENCES bug (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('ALTER TABLE "user" ADD id_user INT NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD pseudonyme VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" DROP roles');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN password TO role');
        $this->addSql('ALTER TABLE bug DROP CONSTRAINT FK_358CBF14F987D8A8');
        $this->addSql('ALTER TABLE bug DROP CONSTRAINT FK_358CBF149F6FA8E8');
        $this->addSql('DROP INDEX IDX_358CBF14F987D8A8');
        $this->addSql('DROP INDEX IDX_358CBF149F6FA8E8');
        $this->addSql('ALTER TABLE bug ADD usercreated_id INT NOT NULL');
        $this->addSql('ALTER TABLE bug ADD bug_id INT NOT NULL');
        $this->addSql('ALTER TABLE bug ADD bug_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE bug ADD bug_location VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE bug DROP user_created_id');
        $this->addSql('ALTER TABLE bug DROP user_bug_id');
        $this->addSql('ALTER TABLE bug DROP name');
        $this->addSql('ALTER TABLE bug DROP location');
        $this->addSql('ALTER TABLE bug RENAME COLUMN date TO bug_date');
        $this->addSql('ALTER TABLE bug RENAME COLUMN description TO bug_description');
        $this->addSql('ALTER TABLE bug RENAME COLUMN os TO bug_os');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT fk_358cbf14139c32bd FOREIGN KEY (usercreated_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_358cbf14139c32bd ON bug (usercreated_id)');
        $this->addSql('ALTER TABLE evolution DROP CONSTRAINT FK_420C2893F987D8A8');
        $this->addSql('ALTER TABLE evolution DROP CONSTRAINT FK_420C28934D335D58');
        $this->addSql('DROP INDEX IDX_420C2893F987D8A8');
        $this->addSql('DROP INDEX IDX_420C28934D335D58');
        $this->addSql('ALTER TABLE evolution DROP user_evolution_id');
        $this->addSql('ALTER TABLE evolution RENAME COLUMN user_created_id TO usercreated_id');
        $this->addSql('ALTER TABLE evolution RENAME COLUMN name TO evolution_name');
        $this->addSql('ALTER TABLE evolution RENAME COLUMN date TO evolution_date');
        $this->addSql('ALTER TABLE evolution RENAME COLUMN description TO evolution_description');
        $this->addSql('ALTER TABLE evolution ADD CONSTRAINT fk_420c2893139c32bd FOREIGN KEY (usercreated_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_420c2893139c32bd ON evolution (usercreated_id)');
    }
}
