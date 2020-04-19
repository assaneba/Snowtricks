<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191119171220 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP INDEX mail_trick');
        $this->addSql('ALTER TABLE tricks DROP INDEX name_trick');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON tricks(`name`)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E1D902C15E237E06 ON user(email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tricks DROP INDEX uniq_8d93d649e7927c74');
        $this->addSql('CREATE UNIQUE INDEX name_trick ON tricks(`name`)');
        $this->addSql('ALTER TABLE user DROP INDEX uniq_e1d902c15e237e06');
        $this->addSql('CREATE UNIQUE INDEX mail_trick ON user(email)');
    }
}
