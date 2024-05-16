<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516082441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_transakcje DROP FOREIGN KEY FK_70C3DA6677F87CE1');
        $this->addSql('ALTER TABLE event_transakcje DROP FOREIGN KEY FK_70C3DA6671F7E88B');
        $this->addSql('DROP TABLE event_transakcje');
        $this->addSql('ALTER TABLE transakcje ADD events_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transakcje ADD CONSTRAINT FK_282D03499D6A1065 FOREIGN KEY (events_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_282D03499D6A1065 ON transakcje (events_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_transakcje (event_id INT NOT NULL, transakcje_id INT NOT NULL, INDEX IDX_70C3DA6671F7E88B (event_id), INDEX IDX_70C3DA6677F87CE1 (transakcje_id), PRIMARY KEY(event_id, transakcje_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE event_transakcje ADD CONSTRAINT FK_70C3DA6677F87CE1 FOREIGN KEY (transakcje_id) REFERENCES transakcje (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_transakcje ADD CONSTRAINT FK_70C3DA6671F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transakcje DROP FOREIGN KEY FK_282D03499D6A1065');
        $this->addSql('DROP INDEX IDX_282D03499D6A1065 ON transakcje');
        $this->addSql('ALTER TABLE transakcje DROP events_id');
    }
}
