<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430164226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transakcje DROP FOREIGN KEY FK_282D034955B2FA8F');
        $this->addSql('DROP TABLE klient');
        $this->addSql('DROP INDEX IDX_282D034955B2FA8F ON transakcje');
        $this->addSql('ALTER TABLE transakcje CHANGE klienci_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transakcje ADD CONSTRAINT FK_282D0349A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_282D0349A76ED395 ON transakcje (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE klient (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE transakcje DROP FOREIGN KEY FK_282D0349A76ED395');
        $this->addSql('DROP INDEX IDX_282D0349A76ED395 ON transakcje');
        $this->addSql('ALTER TABLE transakcje CHANGE user_id klienci_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transakcje ADD CONSTRAINT FK_282D034955B2FA8F FOREIGN KEY (klienci_id) REFERENCES klient (id)');
        $this->addSql('CREATE INDEX IDX_282D034955B2FA8F ON transakcje (klienci_id)');
    }
}
