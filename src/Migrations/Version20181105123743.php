<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181105123743 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE logement ADD id_proprietaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE logement ADD CONSTRAINT FK_F0FD44579F9BCDC2 FOREIGN KEY (id_proprietaire_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_F0FD44579F9BCDC2 ON logement (id_proprietaire_id)');
        $this->addSql('ALTER TABLE utilisateur CHANGE token_user token_user VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE logement DROP FOREIGN KEY FK_F0FD44579F9BCDC2');
        $this->addSql('DROP INDEX IDX_F0FD44579F9BCDC2 ON logement');
        $this->addSql('ALTER TABLE logement DROP id_proprietaire_id');
        $this->addSql('ALTER TABLE utilisateur CHANGE token_user token_user VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
