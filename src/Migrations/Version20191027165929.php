<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191027165929 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `group` (idgroup INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, UNIQUE INDEX name_UNIQUE (name), PRIMARY KEY(idgroup)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (iduser INT UNSIGNED AUTO_INCREMENT NOT NULL, Login VARCHAR(35) NOT NULL, password VARCHAR(50) NOT NULL, first_name VARCHAR(45) NOT NULL, last_name VARCHAR(15) NOT NULL, email VARCHAR(155) NOT NULL, profile_image VARCHAR(255) NOT NULL, role VARCHAR(15) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX email_UNIQUE (email), UNIQUE INDEX Login_UNIQUE (Login), PRIMARY KEY(iduser)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (idvideo INT AUTO_INCREMENT NOT NULL, tricks_idtricks INT DEFAULT NULL, embed VARCHAR(255) NOT NULL, INDEX fk_video_tricks_idx (tricks_idtricks), PRIMARY KEY(idvideo)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (idcomment INT UNSIGNED AUTO_INCREMENT NOT NULL, tricks_idtricks INT DEFAULT NULL, user_iduser INT UNSIGNED DEFAULT NULL, content TINYTEXT NOT NULL, created_at DATETIME NOT NULL, last_modify_at DATETIME NOT NULL, published TINYINT(1) NOT NULL, INDEX fk_comment_user1_idx (user_iduser), INDEX fk_comment_tricks1_idx (tricks_idtricks), PRIMARY KEY(idcomment)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tricks (idtricks INT AUTO_INCREMENT NOT NULL, group_idgroup INT DEFAULT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, last_modify_at DATETIME NOT NULL, default_image VARCHAR(255) NOT NULL, INDEX fk_tricks_group1_idx (group_idgroup), UNIQUE INDEX name_UNIQUE (name), PRIMARY KEY(idtricks)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (idimage INT AUTO_INCREMENT NOT NULL, tricks_idtricks INT DEFAULT NULL, url VARCHAR(255) NOT NULL, INDEX fk_image_tricks1_idx (tricks_idtricks), PRIMARY KEY(idimage)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CA57E74CA FOREIGN KEY (tricks_idtricks) REFERENCES tricks (idtricks)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA57E74CA FOREIGN KEY (tricks_idtricks) REFERENCES tricks (idtricks)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C3B0E3CD4 FOREIGN KEY (user_iduser) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C13DC57CD0 FOREIGN KEY (group_idgroup) REFERENCES `group` (idgroup)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA57E74CA FOREIGN KEY (tricks_idtricks) REFERENCES tricks (idtricks)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C13DC57CD0');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C3B0E3CD4');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CA57E74CA');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA57E74CA');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA57E74CA');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE tricks');
        $this->addSql('DROP TABLE image');
    }
}
