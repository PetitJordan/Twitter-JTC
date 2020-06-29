<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200528095435 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, api_token VARCHAR(255) DEFAULT NULL, gender SMALLINT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, birthdate DATE DEFAULT NULL, phone VARCHAR(30) DEFAULT NULL, picture VARCHAR(50) DEFAULT NULL, password VARCHAR(100) NOT NULL, roles JSON NOT NULL, time_create DATETIME NOT NULL, time_update DATETIME DEFAULT NULL, time_last_login DATETIME DEFAULT NULL, id_status INT NOT NULL, UNIQUE INDEX UNIQ_8D93D6497BA2F5EB (api_token), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX gender (gender), INDEX email (email), INDEX birthdate (birthdate), INDEX id_status (id_status), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expertise (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, uid VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trusted_customer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, web_url VARCHAR(255) NOT NULL, active TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_media (id INT AUTO_INCREMENT NOT NULL, id_customer INT NOT NULL, media VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT NULL, position VARCHAR(255) NOT NULL, time_create DATETIME DEFAULT NULL, time_update DATETIME DEFAULT NULL, INDEX IDX_A419D437D1E2629C (id_customer), INDEX active (active), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, project_name VARCHAR(255) NOT NULL, descriptif VARCHAR(255) DEFAULT NULL, concept LONGTEXT DEFAULT NULL, context LONGTEXT DEFAULT NULL, mission LONGTEXT DEFAULT NULL, imaginer LONGTEXT DEFAULT NULL, developper LONGTEXT DEFAULT NULL, accompagner LONGTEXT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, web_url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, uid VARCHAR(255) NOT NULL, position INT DEFAULT NULL, active TINYINT(1) DEFAULT NULL, conseiller LONGTEXT DEFAULT NULL, cas_client TINYINT(1) DEFAULT NULL, slug VARCHAR(255) NOT NULL, conseiller_active TINYINT(1) NOT NULL, imaginer_active TINYINT(1) NOT NULL, developper_active TINYINT(1) NOT NULL, accompagner_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_expertise (customer_id INT NOT NULL, expertise_id INT NOT NULL, INDEX IDX_896727919395C3F3 (customer_id), INDEX IDX_896727919D5B92F9 (expertise_id), PRIMARY KEY(customer_id, expertise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE optin (id INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, email VARCHAR(100) NOT NULL, active TINYINT(1) DEFAULT NULL, time_create DATETIME NOT NULL, time_update DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_FBB2EB20E7927C74 (email), UNIQUE INDEX UNIQ_FBB2EB206B3CA4B (id_user), INDEX id_user (id_user), INDEX email (email), INDEX active (active), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE keyword (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, time_create DATETIME NOT NULL, time_update DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_log (id INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, action VARCHAR(20) NOT NULL, ip VARCHAR(20) DEFAULT NULL, user_agent VARCHAR(255) DEFAULT NULL, time_create DATETIME NOT NULL, date_create DATE NOT NULL, INDEX id_user (id_user), INDEX action (action), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer_media ADD CONSTRAINT FK_A419D437D1E2629C FOREIGN KEY (id_customer) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE customer_expertise ADD CONSTRAINT FK_896727919395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_expertise ADD CONSTRAINT FK_896727919D5B92F9 FOREIGN KEY (expertise_id) REFERENCES expertise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE optin ADD CONSTRAINT FK_FBB2EB206B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_log ADD CONSTRAINT FK_6429094E6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE optin DROP FOREIGN KEY FK_FBB2EB206B3CA4B');
        $this->addSql('ALTER TABLE user_log DROP FOREIGN KEY FK_6429094E6B3CA4B');
        $this->addSql('ALTER TABLE customer_expertise DROP FOREIGN KEY FK_896727919D5B92F9');
        $this->addSql('ALTER TABLE customer_media DROP FOREIGN KEY FK_A419D437D1E2629C');
        $this->addSql('ALTER TABLE customer_expertise DROP FOREIGN KEY FK_896727919395C3F3');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE expertise');
        $this->addSql('DROP TABLE trusted_customer');
        $this->addSql('DROP TABLE customer_media');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_expertise');
        $this->addSql('DROP TABLE optin');
        $this->addSql('DROP TABLE keyword');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE user_log');
    }
}
