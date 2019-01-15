<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190114182732 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE payer');
        $this->addSql('ALTER TABLE paiement ADD mode_id INT NOT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E77E5854A FOREIGN KEY (mode_id) REFERENCES type_paiement (id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E77E5854A ON paiement (mode_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE payer (id INT AUTO_INCREMENT NOT NULL, id_paiement_id INT NOT NULL, id_utilisateur_id INT NOT NULL, INDEX IDX_41CB5B99C6EE5C49 (id_utilisateur_id), INDEX IDX_41CB5B99325E898F (id_paiement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE payer ADD CONSTRAINT FK_41CB5B99325E898F FOREIGN KEY (id_paiement_id) REFERENCES type_paiement (id)');
        $this->addSql('ALTER TABLE payer ADD CONSTRAINT FK_41CB5B99C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E77E5854A');
        $this->addSql('DROP INDEX IDX_B1DC7A1E77E5854A ON paiement');
        $this->addSql('ALTER TABLE paiement DROP mode_id');
    }
}
