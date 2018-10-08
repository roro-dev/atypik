<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181008100247 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actvite_logement (id INT AUTO_INCREMENT NOT NULL, id_logement_id INT NOT NULL, id_activite_id INT NOT NULL, distance INT NOT NULL, INDEX IDX_35F94A9B40B934A2 (id_logement_id), INDEX IDX_35F94A9B831D4546 (id_activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, id_logement_id INT NOT NULL, photo VARCHAR(255) DEFAULT NULL, INDEX IDX_14B7841840B934A2 (id_logement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, id_utilisateur_id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, taxe INT NOT NULL, INDEX IDX_43C3D9C3C6EE5C49 (id_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actvite_logement ADD CONSTRAINT FK_35F94A9B40B934A2 FOREIGN KEY (id_logement_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE actvite_logement ADD CONSTRAINT FK_35F94A9B831D4546 FOREIGN KEY (id_activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B7841840B934A2 FOREIGN KEY (id_logement_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C3C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actvite_logement DROP FOREIGN KEY FK_35F94A9B831D4546');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE actvite_logement');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE ville');
    }
}
