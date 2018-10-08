<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181008081638 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, id_utilisateur_id INT NOT NULL, id_logement_id INT NOT NULL, titre VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, note INT NOT NULL, photo VARCHAR(255) NOT NULL, date_commentaire DATETIME NOT NULL, INDEX IDX_67F068BCC6EE5C49 (id_utilisateur_id), INDEX IDX_67F068BC40B934A2 (id_logement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logement (id INT AUTO_INCREMENT NOT NULL, id_type_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, nb_voyageur INT NOT NULL, nb_lits INT NOT NULL, nb_sallede_bain INT NOT NULL, prix INT NOT NULL, INDEX IDX_F0FD44571BD125E3 (id_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payer (id INT AUTO_INCREMENT NOT NULL, id_paiement_id INT NOT NULL, id_utilisateur_id INT NOT NULL, INDEX IDX_41CB5B99325E898F (id_paiement_id), INDEX IDX_41CB5B99C6EE5C49 (id_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, id_logement_id INT DEFAULT NULL, id_utilisateur_id INT DEFAULT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, INDEX IDX_42C8495540B934A2 (id_logement_id), INDEX IDX_42C84955C6EE5C49 (id_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles_utilisateur (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_logement (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_paiement (id INT AUTO_INCREMENT NOT NULL, mode_paiement VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, id_role_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, INDEX IDX_1D1C63B389E8BDC (id_role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC40B934A2 FOREIGN KEY (id_logement_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE logement ADD CONSTRAINT FK_F0FD44571BD125E3 FOREIGN KEY (id_type_id) REFERENCES type_logement (id)');
        $this->addSql('ALTER TABLE payer ADD CONSTRAINT FK_41CB5B99325E898F FOREIGN KEY (id_paiement_id) REFERENCES type_paiement (id)');
        $this->addSql('ALTER TABLE payer ADD CONSTRAINT FK_41CB5B99C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495540B934A2 FOREIGN KEY (id_logement_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B389E8BDC FOREIGN KEY (id_role_id) REFERENCES roles_utilisateur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC40B934A2');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495540B934A2');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B389E8BDC');
        $this->addSql('ALTER TABLE logement DROP FOREIGN KEY FK_F0FD44571BD125E3');
        $this->addSql('ALTER TABLE payer DROP FOREIGN KEY FK_41CB5B99325E898F');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCC6EE5C49');
        $this->addSql('ALTER TABLE payer DROP FOREIGN KEY FK_41CB5B99C6EE5C49');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955C6EE5C49');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE logement');
        $this->addSql('DROP TABLE payer');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE roles_utilisateur');
        $this->addSql('DROP TABLE type_logement');
        $this->addSql('DROP TABLE type_paiement');
        $this->addSql('DROP TABLE utilisateur');
    }
}
