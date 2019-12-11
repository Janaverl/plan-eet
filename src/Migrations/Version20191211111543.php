<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191211111543 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE rayon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingredient ADD rayon_id INT NOT NULL');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870D3202E52 FOREIGN KEY (rayon_id) REFERENCES rayon (id)');
        $this->addSql('CREATE INDEX IDX_6BAF7870D3202E52 ON ingredient (rayon_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870D3202E52');
        $this->addSql('DROP TABLE rayon');
        $this->addSql('DROP INDEX IDX_6BAF7870D3202E52 ON ingredient');
        $this->addSql('ALTER TABLE ingredient DROP rayon_id');
    }
}
