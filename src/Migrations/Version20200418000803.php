<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200418000803 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F991A65C546');
        $this->addSql('DROP INDEX IDX_AC634F991A65C546 ON livre');
        $this->addSql('ALTER TABLE livre DROP no_id');
        $this->addSql('ALTER TABLE user ADD bibliotheque_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494419DE7D ON user (bibliotheque_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE livre ADD no_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F991A65C546 FOREIGN KEY (no_id) REFERENCES emprunteur (id)');
        $this->addSql('CREATE INDEX IDX_AC634F991A65C546 ON livre (no_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494419DE7D');
        $this->addSql('DROP INDEX IDX_8D93D6494419DE7D ON user');
        $this->addSql('ALTER TABLE user DROP bibliotheque_id');
    }
}
