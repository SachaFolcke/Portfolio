<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190807145756 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE skill_category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, icon_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_row (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, text VARCHAR(255) NOT NULL, INDEX IDX_77633B3512469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skill_row ADD CONSTRAINT FK_77633B3512469DE2 FOREIGN KEY (category_id) REFERENCES skill_category (id)');
        $this->addSql('ALTER TABLE project_state CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE icon icon VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE `general` CHANGE subtitle subtitle VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE projet CHANGE state_id state_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE skill_row DROP FOREIGN KEY FK_77633B3512469DE2');
        $this->addSql('DROP TABLE skill_category');
        $this->addSql('DROP TABLE skill_row');
        $this->addSql('ALTER TABLE `general` CHANGE subtitle subtitle VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE project_state CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE icon icon VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE projet CHANGE state_id state_id INT DEFAULT NULL');
    }
}
