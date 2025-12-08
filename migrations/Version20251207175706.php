<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251207175706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY `employe_ibfk_1`');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE employe');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, tel VARCHAR(20) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, salaire NUMERIC(10, 2) NOT NULL, specialite ENUM(\'FULLSTACK\', \'BACKEND\', \'FRONTEND\') CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, departement_id INT DEFAULT NULL, INDEX departement_id (departement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT `employe_ibfk_1` FOREIGN KEY (departement_id) REFERENCES departement (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
