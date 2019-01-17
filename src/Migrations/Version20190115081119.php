<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190115081119 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, mode_id INT NOT NULL, INDEX IDX_B1DC7A1EFB88E14F (utilisateur_id), INDEX IDX_B1DC7A1E77E5854A (mode_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E77E5854A FOREIGN KEY (mode_id) REFERENCES type_paiement (id)');
        $this->addSql('DROP TABLE payer');
        $this->addSql('ALTER TABLE reservation ADD prix_total DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD newsletter TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE payer (id INT AUTO_INCREMENT NOT NULL, id_paiement_id INT NOT NULL, id_utilisateur_id INT NOT NULL, INDEX IDX_41CB5B99325E898F (id_paiement_id), INDEX IDX_41CB5B99C6EE5C49 (id_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payer ADD CONSTRAINT FK_41CB5B99325E898F FOREIGN KEY (id_paiement_id) REFERENCES type_paiement (id)');
        $this->addSql('ALTER TABLE payer ADD CONSTRAINT FK_41CB5B99C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('ALTER TABLE reservation DROP prix_total');
        $this->addSql('ALTER TABLE utilisateur DROP newsletter');
    }
}
