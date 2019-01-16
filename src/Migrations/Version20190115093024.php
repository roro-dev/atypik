<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190115093024 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE paiement');
        $this->addSql('ALTER TABLE reservation ADD mode_id INT NOT NULL, ADD token_paiement VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495577E5854A FOREIGN KEY (mode_id) REFERENCES type_paiement (id)');
        $this->addSql('CREATE INDEX IDX_42C8495577E5854A ON reservation (mode_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, mode_id INT NOT NULL, INDEX IDX_B1DC7A1E77E5854A (mode_id), INDEX IDX_B1DC7A1EFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E77E5854A FOREIGN KEY (mode_id) REFERENCES type_paiement (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495577E5854A');
        $this->addSql('DROP INDEX IDX_42C8495577E5854A ON reservation');
        $this->addSql('ALTER TABLE reservation DROP mode_id, DROP token_paiement');
    }
}
