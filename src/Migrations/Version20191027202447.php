<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191027202447 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C13DC57CD0');
        $this->addSql('CREATE TABLE groupoftrciks (idgroup INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, UNIQUE INDEX name_UNIQUE (name), PRIMARY KEY(idgroup)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C13DC57CD0');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C13DC57CD0 FOREIGN KEY (group_idgroup) REFERENCES groupoftrciks (idgroup)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C13DC57CD0');
        $this->addSql('CREATE TABLE `group` (idgroup INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, UNIQUE INDEX name_UNIQUE (name), PRIMARY KEY(idgroup)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE groupoftrciks');
        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C13DC57CD0');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C13DC57CD0 FOREIGN KEY (group_idgroup) REFERENCES `group` (idgroup)');
    }
}
