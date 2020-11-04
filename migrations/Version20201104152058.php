<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201104152058 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE correspondre DROP FOREIGN KEY FK_1B94C18DBAD26311');
        $this->addSql('ALTER TABLE correspondre DROP FOREIGN KEY FK_1B94C18DF347EFB');
        $this->addSql('DROP INDEX IDX_1B94C18DF347EFB ON correspondre');
        $this->addSql('DROP INDEX IDX_1B94C18DBAD26311 ON correspondre');
        $this->addSql('ALTER TABLE correspondre ADD id INT AUTO_INCREMENT NOT NULL, ADD id_tag_id INT NOT NULL, ADD id_produit_id INT NOT NULL, DROP id_tag, DROP id_produit, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE correspondre ADD CONSTRAINT FK_2AE140C49CE5D6FC FOREIGN KEY (id_tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE correspondre ADD CONSTRAINT FK_2AE140C4AABEFE2C FOREIGN KEY (id_produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_2AE140C49CE5D6FC ON correspondre (id_tag_id)');
        $this->addSql('CREATE INDEX IDX_2AE140C4AABEFE2C ON correspondre (id_produit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE correspondre MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE correspondre DROP FOREIGN KEY FK_2AE140C49CE5D6FC');
        $this->addSql('ALTER TABLE correspondre DROP FOREIGN KEY FK_2AE140C4AABEFE2C');
        $this->addSql('DROP INDEX IDX_2AE140C49CE5D6FC ON correspondre');
        $this->addSql('DROP INDEX IDX_2AE140C4AABEFE2C ON correspondre');
        $this->addSql('ALTER TABLE correspondre DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE correspondre ADD id_tag INT NOT NULL, ADD id_produit INT NOT NULL, DROP id, DROP id_tag_id, DROP id_produit_id');
        $this->addSql('ALTER TABLE correspondre ADD CONSTRAINT FK_1B94C18DBAD26311 FOREIGN KEY (id_tag) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE correspondre ADD CONSTRAINT FK_1B94C18DF347EFB FOREIGN KEY (id_produit) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_1B94C18DF347EFB ON correspondre (id_produit)');
        $this->addSql('CREATE INDEX IDX_1B94C18DBAD26311 ON correspondre (id_tag)');
        $this->addSql('ALTER TABLE correspondre ADD PRIMARY KEY (id_tag, id_produit)');
    }
}
