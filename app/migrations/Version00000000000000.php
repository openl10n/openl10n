<?php

namespace Openl10n\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version00000000000000 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE translation_keys (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, resource_id INT NOT NULL, identifier VARCHAR(255) NOT NULL, hash VARCHAR(40) NOT NULL, INDEX IDX_99ACE777166D1F9C (project_id), INDEX IDX_99ACE77789329D25 (resource_id), UNIQUE INDEX idx_hash (resource_id, hash), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE languages (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, locale VARCHAR(20) NOT NULL, INDEX IDX_A0D15379166D1F9C (project_id), UNIQUE INDEX language (project_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translation_phrases (id INT AUTO_INCREMENT NOT NULL, key_id INT NOT NULL, locale VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, is_approved TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B3163134D145533 (key_id), UNIQUE INDEX locale (key_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(64) NOT NULL, name VARCHAR(64) NOT NULL, default_locale VARCHAR(8) NOT NULL, UNIQUE INDEX slug (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resources (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, pathname VARCHAR(255) NOT NULL, hash VARCHAR(40) NOT NULL, INDEX IDX_EF66EBAE166D1F9C (project_id), UNIQUE INDEX idx_hash (project_id, hash), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_credentials (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, password VARCHAR(255) NOT NULL, salt VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_531EE19BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, display_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, prefered_locale VARCHAR(64) NOT NULL, UNIQUE INDEX slug (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE translation_keys ADD CONSTRAINT FK_99ACE777166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE translation_keys ADD CONSTRAINT FK_99ACE77789329D25 FOREIGN KEY (resource_id) REFERENCES resources (id)');
        $this->addSql('ALTER TABLE languages ADD CONSTRAINT FK_A0D15379166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE translation_phrases ADD CONSTRAINT FK_B3163134D145533 FOREIGN KEY (key_id) REFERENCES translation_keys (id)');
        $this->addSql('ALTER TABLE resources ADD CONSTRAINT FK_EF66EBAE166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE user_credentials ADD CONSTRAINT FK_531EE19BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE translation_phrases DROP FOREIGN KEY FK_B3163134D145533');
        $this->addSql('ALTER TABLE translation_keys DROP FOREIGN KEY FK_99ACE777166D1F9C');
        $this->addSql('ALTER TABLE languages DROP FOREIGN KEY FK_A0D15379166D1F9C');
        $this->addSql('ALTER TABLE resources DROP FOREIGN KEY FK_EF66EBAE166D1F9C');
        $this->addSql('ALTER TABLE translation_keys DROP FOREIGN KEY FK_99ACE77789329D25');
        $this->addSql('ALTER TABLE user_credentials DROP FOREIGN KEY FK_531EE19BA76ED395');
        $this->addSql('DROP TABLE translation_keys');
        $this->addSql('DROP TABLE languages');
        $this->addSql('DROP TABLE translation_phrases');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE resources');
        $this->addSql('DROP TABLE user_credentials');
        $this->addSql('DROP TABLE users');
    }
}
