<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181126093908 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE parametres_type (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_5578281C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametres_logement (id INT AUTO_INCREMENT NOT NULL, parametre_id INT NOT NULL, logement_id INT NOT NULL, valeur VARCHAR(255) NOT NULL, INDEX IDX_8D459AE06358FF62 (parametre_id), INDEX IDX_8D459AE058ABF955 (logement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametres_type ADD CONSTRAINT FK_5578281C54C8C93 FOREIGN KEY (type_id) REFERENCES type_logement (id)');
        $this->addSql('ALTER TABLE parametres_logement ADD CONSTRAINT FK_8D459AE06358FF62 FOREIGN KEY (parametre_id) REFERENCES parametres_type (id)');
        $this->addSql('ALTER TABLE parametres_logement ADD CONSTRAINT FK_8D459AE058ABF955 FOREIGN KEY (logement_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE logement ADD id_proprietaire_id INT NOT NULL, ADD ville_id INT NOT NULL, DROP nb_voyageur, DROP nb_lits, DROP nb_sallede_bain');
        $this->addSql('ALTER TABLE logement ADD CONSTRAINT FK_F0FD44579F9BCDC2 FOREIGN KEY (id_proprietaire_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE logement ADD CONSTRAINT FK_F0FD4457A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_F0FD44579F9BCDC2 ON logement (id_proprietaire_id)');
        $this->addSql('CREATE INDEX IDX_F0FD4457A73F0036 ON logement (ville_id)');
        $this->addSql('ALTER TABLE utilisateur ADD password VARCHAR(255) NOT NULL, ADD valide_user TINYINT(1) NOT NULL, ADD token_user VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C3C6EE5C49');
        $this->addSql('DROP INDEX IDX_43C3D9C3C6EE5C49 ON ville');
        $this->addSql('ALTER TABLE ville DROP id_utilisateur_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parametres_logement DROP FOREIGN KEY FK_8D459AE06358FF62');
        $this->addSql('DROP TABLE parametres_type');
        $this->addSql('DROP TABLE parametres_logement');
        $this->addSql('ALTER TABLE logement DROP FOREIGN KEY FK_F0FD44579F9BCDC2');
        $this->addSql('ALTER TABLE logement DROP FOREIGN KEY FK_F0FD4457A73F0036');
        $this->addSql('DROP INDEX IDX_F0FD44579F9BCDC2 ON logement');
        $this->addSql('DROP INDEX IDX_F0FD4457A73F0036 ON logement');
        $this->addSql('ALTER TABLE logement ADD nb_voyageur INT NOT NULL, ADD nb_lits INT NOT NULL, ADD nb_sallede_bain INT NOT NULL, DROP id_proprietaire_id, DROP ville_id');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP password, DROP valide_user, DROP token_user');
        $this->addSql('ALTER TABLE ville ADD id_utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C3C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_43C3D9C3C6EE5C49 ON ville (id_utilisateur_id)');
    }
}
