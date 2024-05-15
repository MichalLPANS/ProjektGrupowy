<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240419065415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bilety (id INT AUTO_INCREMENT NOT NULL, eventy_id INT DEFAULT NULL, transakcje_id INT DEFAULT NULL, rodzaj VARCHAR(255) NOT NULL, INDEX IDX_3DBA2ED4F2D7F001 (eventy_id), INDEX IDX_3DBA2ED477F87CE1 (transakcje_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE klient (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transakcje (id INT AUTO_INCREMENT NOT NULL, klienci_id INT DEFAULT NULL, INDEX IDX_282D034955B2FA8F (klienci_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bilety ADD CONSTRAINT FK_3DBA2ED4F2D7F001 FOREIGN KEY (eventy_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE bilety ADD CONSTRAINT FK_3DBA2ED477F87CE1 FOREIGN KEY (transakcje_id) REFERENCES transakcje (id)');
        $this->addSql('ALTER TABLE transakcje ADD CONSTRAINT FK_282D034955B2FA8F FOREIGN KEY (klienci_id) REFERENCES klient (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bilety DROP FOREIGN KEY FK_3DBA2ED4F2D7F001');
        $this->addSql('ALTER TABLE bilety DROP FOREIGN KEY FK_3DBA2ED477F87CE1');
        $this->addSql('ALTER TABLE transakcje DROP FOREIGN KEY FK_282D034955B2FA8F');
        $this->addSql('DROP TABLE bilety');
        $this->addSql('DROP TABLE klient');
        $this->addSql('DROP TABLE transakcje');
    }
}
