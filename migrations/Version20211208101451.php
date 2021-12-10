<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211208101451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date DATETIME NOT NULL, priority VARCHAR(255) NOT NULL, release_date DATETIME NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_9067F23C19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission_villain (mission_id INT NOT NULL, villain_id INT NOT NULL, INDEX IDX_D6011FE1BE6CAE90 (mission_id), INDEX IDX_D6011FE1363C6CE2 (villain_id), PRIMARY KEY(mission_id, villain_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission_user (mission_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A4D17A46BE6CAE90 (mission_id), INDEX IDX_A4D17A46A76ED395 (user_id), PRIMARY KEY(mission_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C19EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE mission_villain ADD CONSTRAINT FK_D6011FE1BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_villain ADD CONSTRAINT FK_D6011FE1363C6CE2 FOREIGN KEY (villain_id) REFERENCES villain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_user ADD CONSTRAINT FK_A4D17A46BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_user ADD CONSTRAINT FK_A4D17A46A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission_villain DROP FOREIGN KEY FK_D6011FE1BE6CAE90');
        $this->addSql('ALTER TABLE mission_user DROP FOREIGN KEY FK_A4D17A46BE6CAE90');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE mission_villain');
        $this->addSql('DROP TABLE mission_user');
    }
}
