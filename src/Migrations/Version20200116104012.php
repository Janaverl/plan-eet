<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200116104012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE campday (id INT AUTO_INCREMENT NOT NULL, camp_id INT NOT NULL, campdaycount INT NOT NULL, INDEX IDX_F4E6B61B77075ABB (camp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campmeal (id INT AUTO_INCREMENT NOT NULL, camp_mealmoment_id INT NOT NULL, campday_id INT NOT NULL, INDEX IDX_E48D92AB3792A5F8 (camp_mealmoment_id), INDEX IDX_E48D92AB8DC4C726 (campday_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE campday ADD CONSTRAINT FK_F4E6B61B77075ABB FOREIGN KEY (camp_id) REFERENCES camp (id)');
        $this->addSql('ALTER TABLE campmeal ADD CONSTRAINT FK_E48D92AB3792A5F8 FOREIGN KEY (camp_mealmoment_id) REFERENCES camp_mealmoments (id)');
        $this->addSql('ALTER TABLE campmeal ADD CONSTRAINT FK_E48D92AB8DC4C726 FOREIGN KEY (campday_id) REFERENCES campday (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campmeal DROP FOREIGN KEY FK_E48D92AB8DC4C726');
        $this->addSql('DROP TABLE campday');
        $this->addSql('DROP TABLE campmeal');
    }
}
