<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240301081749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joueur DROP victoire, DROP defaite, DROP titre, DROP top_classement, DROP taille, DROP poids, DROP age');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joueur ADD victoire INT NOT NULL, ADD defaite INT NOT NULL, ADD titre INT NOT NULL, ADD top_classement INT NOT NULL, ADD taille DOUBLE PRECISION NOT NULL, ADD poids INT NOT NULL, ADD age INT NOT NULL');
    }
}
