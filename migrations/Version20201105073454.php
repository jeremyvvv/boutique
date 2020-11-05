<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201105073454 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contenir (id INT AUTO_INCREMENT NOT NULL, id_produit_id INT NOT NULL, id_panier_id INT NOT NULL, INDEX IDX_3C914DFDAABEFE2C (id_produit_id), INDEX IDX_3C914DFD77482E5B (id_panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contenir ADD CONSTRAINT FK_3C914DFDAABEFE2C FOREIGN KEY (id_produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE contenir ADD CONSTRAINT FK_3C914DFD77482E5B FOREIGN KEY (id_panier_id) REFERENCES panier (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contenir');
    }
}
