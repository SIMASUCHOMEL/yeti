<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523113130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD frajer INT NOT NULL, ADD smradoch INT NOT NULL, ADD chytrak INT NOT NULL, ADD slusnak INT NOT NULL');
        $this->addSql('ALTER TABLE zkouska CHANGE datum datum DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP frajer, DROP smradoch, DROP chytrak, DROP slusnak');
        $this->addSql('ALTER TABLE zkouska CHANGE datum datum DATE DEFAULT NULL');
    }
}
