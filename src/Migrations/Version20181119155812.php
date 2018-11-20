<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181119155812 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE parametres_logement (id INT AUTO_INCREMENT NOT NULL, parametre_id INT NOT NULL, logement_id INT NOT NULL, INDEX IDX_8D459AE06358FF62 (parametre_id), INDEX IDX_8D459AE058ABF955 (logement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametres_type (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_5578281C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametres_logement ADD CONSTRAINT FK_8D459AE06358FF62 FOREIGN KEY (parametre_id) REFERENCES parametres_type (id)');
        $this->addSql('ALTER TABLE parametres_logement ADD CONSTRAINT FK_8D459AE058ABF955 FOREIGN KEY (logement_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE parametres_type ADD CONSTRAINT FK_5578281C54C8C93 FOREIGN KEY (type_id) REFERENCES type_logement (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parametres_logement DROP FOREIGN KEY FK_8D459AE06358FF62');
        $this->addSql('DROP TABLE parametres_logement');
        $this->addSql('DROP TABLE parametres_type');
    }
}
