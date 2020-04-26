<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200417235827 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE emprunteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livre ADD category_id INT NOT NULL, ADD bibliotheque_id INT NOT NULL, ADD no_id INT DEFAULT NULL, ADD emprunteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F9912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F994419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F991A65C546 FOREIGN KEY (no_id) REFERENCES emprunteur (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99F0840037 FOREIGN KEY (emprunteur_id) REFERENCES emprunteur (id)');
        $this->addSql('CREATE INDEX IDX_AC634F9912469DE2 ON livre (category_id)');
        $this->addSql('CREATE INDEX IDX_AC634F994419DE7D ON livre (bibliotheque_id)');
        $this->addSql('CREATE INDEX IDX_AC634F991A65C546 ON livre (no_id)');
        $this->addSql('CREATE INDEX IDX_AC634F99F0840037 ON livre (emprunteur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F991A65C546');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99F0840037');
        $this->addSql('DROP TABLE emprunteur');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F9912469DE2');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F994419DE7D');
        $this->addSql('DROP INDEX IDX_AC634F9912469DE2 ON livre');
        $this->addSql('DROP INDEX IDX_AC634F994419DE7D ON livre');
        $this->addSql('DROP INDEX IDX_AC634F991A65C546 ON livre');
        $this->addSql('DROP INDEX IDX_AC634F99F0840037 ON livre');
        $this->addSql('ALTER TABLE livre DROP category_id, DROP bibliotheque_id, DROP no_id, DROP emprunteur_id');
    }
}
