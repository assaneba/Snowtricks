<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200422005704 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE trick_has_groups (tricks_id INT NOT NULL, group_of_tricks_id INT NOT NULL, INDEX IDX_55C7BE763B153154 (tricks_id), INDEX IDX_55C7BE76E037DB6B (group_of_tricks_id), PRIMARY KEY(tricks_id, group_of_tricks_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trick_has_groups ADD CONSTRAINT FK_55C7BE763B153154 FOREIGN KEY (tricks_id) REFERENCES tricks (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trick_has_groups ADD CONSTRAINT FK_55C7BE76E037DB6B FOREIGN KEY (group_of_tricks_id) REFERENCES group_of_tricks (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_e1d902c15e237e06 TO UNIQ_8D93D649E7927C74');
        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C1E037DB6B');
        $this->addSql('DROP INDEX IDX_E1D902C1E037DB6B ON tricks');
        $this->addSql('ALTER TABLE tricks DROP group_of_tricks_id, CHANGE default_image default_image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tricks RENAME INDEX uniq_8d93d649e7927c74 TO UNIQ_E1D902C15E237E06');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE trick_has_groups');
        $this->addSql('ALTER TABLE tricks ADD group_of_tricks_id INT NOT NULL, CHANGE default_image default_image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C1E037DB6B FOREIGN KEY (group_of_tricks_id) REFERENCES group_of_tricks (id)');
        $this->addSql('CREATE INDEX IDX_E1D902C1E037DB6B ON tricks (group_of_tricks_id)');
        $this->addSql('ALTER TABLE tricks RENAME INDEX uniq_e1d902c15e237e06 TO UNIQ_8D93D649E7927C74');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_8d93d649e7927c74 TO UNIQ_E1D902C15E237E06');
    }
}
