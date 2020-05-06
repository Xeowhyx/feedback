<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190303195121 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE evolution_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE priority_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE vote_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE state_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE bug_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE evolution (id INT AUTO_INCREMENT NOT NULL, usercreated_id INT DEFAULT NULL, evolution_name VARCHAR(255) NOT NULL, evolution_date DATE NOT NULL, evolution_description VARCHAR(500) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_420C2893139C32BD ON evolution (usercreated_id)');
        $this->addSql('CREATE TABLE priority (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE vote (id INT NOT NULL, evolution_id INT NOT NULL, bug_id INT DEFAULT NULL, user_id INT NOT NULL, vote_id INT NOT NULL, value_vote INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5A108564CDFF215A ON vote (evolution_id)');
        $this->addSql('CREATE INDEX IDX_5A108564FA3DB3D5 ON vote (bug_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, id_user INT NOT NULL, email VARCHAR(255) NOT NULL, pseudonyme VARCHAR(255) DEFAULT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE state (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, evolution_id INT DEFAULT NULL, bug_id INT DEFAULT NULL, id_user INT NOT NULL, comment_desc VARCHAR(255) DEFAULT NULL, id_bug INT DEFAULT NULL, id_evolution INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526CCDFF215A ON comment (evolution_id)');
        $this->addSql('CREATE INDEX IDX_9474526CFA3DB3D5 ON comment (bug_id)');
        $this->addSql('CREATE TABLE bug (id INT NOT NULL, prority_id INT NOT NULL, severity_id INT NOT NULL, state_id INT DEFAULT NULL, usercreated_id INT NOT NULL, bug_id INT NOT NULL, bug_name VARCHAR(255) NOT NULL, bug_date DATE NOT NULL, bug_description VARCHAR(500) NOT NULL, bug_os VARCHAR(255) DEFAULT NULL, bug_location VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_358CBF1415349E01 ON bug (prority_id)');
        $this->addSql('CREATE INDEX IDX_358CBF14F7527401 ON bug (severity_id)');
        $this->addSql('CREATE INDEX IDX_358CBF145D83CC1 ON bug (state_id)');
        $this->addSql('CREATE INDEX IDX_358CBF14139C32BD ON bug (usercreated_id)');
        $this->addSql('ALTER TABLE evolution ADD CONSTRAINT FK_420C2893139C32BD FOREIGN KEY (usercreated_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564CDFF215A FOREIGN KEY (evolution_id) REFERENCES evolution (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564FA3DB3D5 FOREIGN KEY (bug_id) REFERENCES bug (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CCDFF215A FOREIGN KEY (evolution_id) REFERENCES evolution (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CFA3DB3D5 FOREIGN KEY (bug_id) REFERENCES bug (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF1415349E01 FOREIGN KEY (prority_id) REFERENCES priority (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF14F7527401 FOREIGN KEY (severity_id) REFERENCES severity (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF145D83CC1 FOREIGN KEY (state_id) REFERENCES state (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF14139C32BD FOREIGN KEY (usercreated_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE vote DROP CONSTRAINT FK_5A108564CDFF215A');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CCDFF215A');
        $this->addSql('ALTER TABLE bug DROP CONSTRAINT FK_358CBF1415349E01');
        $this->addSql('ALTER TABLE evolution DROP CONSTRAINT FK_420C2893139C32BD');
        $this->addSql('ALTER TABLE bug DROP CONSTRAINT FK_358CBF14139C32BD');
        $this->addSql('ALTER TABLE bug DROP CONSTRAINT FK_358CBF145D83CC1');
        $this->addSql('ALTER TABLE vote DROP CONSTRAINT FK_5A108564FA3DB3D5');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CFA3DB3D5');
        $this->addSql('DROP SEQUENCE evolution_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE priority_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE vote_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE state_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE bug_id_seq CASCADE');
        $this->addSql('DROP TABLE evolution');
        $this->addSql('DROP TABLE priority');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE bug');
    }
}
