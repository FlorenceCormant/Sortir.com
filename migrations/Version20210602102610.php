<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210602102610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participants (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(30) NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, telephone VARCHAR(15) DEFAULT NULL, mail VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, administrateur TINYINT(1) NOT NULL, actif TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscriptions_participants DROP FOREIGN KEY FK_C3252659838709D5');
        $this->addSql('ALTER TABLE inscriptions_participants ADD CONSTRAINT FK_C3252659838709D5 FOREIGN KEY (participants_id) REFERENCES participants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E8D936B2FA');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E8D936B2FA FOREIGN KEY (organisateur_id) REFERENCES participants (id)');
        $this->addSql('ALTER TABLE user DROP TYPE_ENTITE, DROP administrateur, DROP actif');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscriptions_participants DROP FOREIGN KEY FK_C3252659838709D5');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E8D936B2FA');
        $this->addSql('DROP TABLE participants');
        $this->addSql('ALTER TABLE inscriptions_participants DROP FOREIGN KEY FK_C3252659838709D5');
        $this->addSql('ALTER TABLE inscriptions_participants ADD CONSTRAINT FK_C3252659838709D5 FOREIGN KEY (participants_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E8D936B2FA');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E8D936B2FA FOREIGN KEY (organisateur_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD TYPE_ENTITE VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD administrateur TINYINT(1) DEFAULT NULL, ADD actif TINYINT(1) DEFAULT NULL');
    }
}
