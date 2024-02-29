<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229124825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notas ADD id_cread_id INT NOT NULL');
        $this->addSql('ALTER TABLE notas ADD CONSTRAINT FK_65776388C145E9C4 FOREIGN KEY (id_cread_id) REFERENCES usuarios (id)');
        $this->addSql('CREATE INDEX IDX_65776388C145E9C4 ON notas (id_cread_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notas DROP FOREIGN KEY FK_65776388C145E9C4');
        $this->addSql('DROP INDEX IDX_65776388C145E9C4 ON notas');
        $this->addSql('ALTER TABLE notas DROP id_cread_id');
    }
}
