<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181228082054 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE logement ADD adresse VARCHAR(255) DEFAULT NULL, ADD code_postal VARCHAR(255) DEFAULT NULL, ADD nb_personne INT NOT NULL, CHANGE ville_id ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD date_creation DATETIME NOT NULL, ADD nb_personne INT NOT NULL');
        $this->addSql('ALTER TABLE type_logement ADD path_img VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD cgv TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE logement DROP adresse, DROP code_postal, DROP nb_personne, CHANGE ville_id ville_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation DROP date_creation, DROP nb_personne');
        $this->addSql('ALTER TABLE type_logement DROP path_img');
        $this->addSql('ALTER TABLE utilisateur DROP cgv');
    }
}
