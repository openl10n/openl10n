<?php

namespace Openl10n\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150124040423 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX idx_hash ON translation_keys');
        $this->addSql('CREATE UNIQUE INDEX idx_hashkey ON translation_keys (resource_id, hash)');
        $this->addSql('DROP INDEX slug ON users');
        $this->addSql('CREATE UNIQUE INDEX user_slug ON users (username)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX idx_hashkey ON translation_keys');
        $this->addSql('CREATE UNIQUE INDEX idx_hash ON translation_keys (resource_id, hash)');
        $this->addSql('DROP INDEX user_slug ON users');
        $this->addSql('CREATE UNIQUE INDEX slug ON users (username)');
    }
}
