<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190808165740 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE timeline_element (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, period VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, current TINYINT(1) NOT NULL, order_index INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skill_category CHANGE icon_path icon_path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE project_state CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE icon icon VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE `general` CHANGE subtitle subtitle VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE projet CHANGE state_id state_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE timeline_element');
        $this->addSql('ALTER TABLE `general` CHANGE subtitle subtitle VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE project_state CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE icon icon VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE projet CHANGE state_id state_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_category CHANGE icon_path icon_path VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
