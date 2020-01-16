<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200116103408 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE camp_mealmoments ADD mealmoment_id INT NOT NULL');
        $this->addSql('ALTER TABLE camp_mealmoments ADD CONSTRAINT FK_1696C081E13BCF51 FOREIGN KEY (mealmoment_id) REFERENCES mealmoment (id)');
        $this->addSql('CREATE INDEX IDX_1696C081E13BCF51 ON camp_mealmoments (mealmoment_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE camp_mealmoments DROP FOREIGN KEY FK_1696C081E13BCF51');
        $this->addSql('DROP INDEX IDX_1696C081E13BCF51 ON camp_mealmoments');
        $this->addSql('ALTER TABLE camp_mealmoments DROP mealmoment_id');
    }
}
