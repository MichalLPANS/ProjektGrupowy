<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240502090901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_transakcje (event_id INT NOT NULL, transakcje_id INT NOT NULL, INDEX IDX_70C3DA6671F7E88B (event_id), INDEX IDX_70C3DA6677F87CE1 (transakcje_id), PRIMARY KEY(event_id, transakcje_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_transakcje ADD CONSTRAINT FK_70C3DA6671F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_transakcje ADD CONSTRAINT FK_70C3DA6677F87CE1 FOREIGN KEY (transakcje_id) REFERENCES transakcje (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bilety DROP FOREIGN KEY FK_3DBA2ED477F87CE1');
        $this->addSql('ALTER TABLE bilety DROP FOREIGN KEY FK_3DBA2ED4F2D7F001');
        $this->addSql('DROP TABLE bilety');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bilety (id INT AUTO_INCREMENT NOT NULL, eventy_id INT DEFAULT NULL, transakcje_id INT DEFAULT NULL, rodzaj VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_3DBA2ED4F2D7F001 (eventy_id), INDEX IDX_3DBA2ED477F87CE1 (transakcje_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bilety ADD CONSTRAINT FK_3DBA2ED477F87CE1 FOREIGN KEY (transakcje_id) REFERENCES transakcje (id)');
        $this->addSql('ALTER TABLE bilety ADD CONSTRAINT FK_3DBA2ED4F2D7F001 FOREIGN KEY (eventy_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event_transakcje DROP FOREIGN KEY FK_70C3DA6671F7E88B');
        $this->addSql('ALTER TABLE event_transakcje DROP FOREIGN KEY FK_70C3DA6677F87CE1');
        $this->addSql('DROP TABLE event_transakcje');
    }
}
