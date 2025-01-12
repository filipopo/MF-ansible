<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250103095656 extends AbstractMigration {
    public function getDescription(): string {
        return 'Creates donation table';
    }

    public function up(Schema $schema): void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE donation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, time VARCHAR(8) NOT NULL, day INTEGER NOT NULL, month INTEGER NOT NULL, year INTEGER NOT NULL, name VARCHAR(255) NOT NULL, message CLOB NOT NULL, amount_sent DOUBLE PRECISION NOT NULL, amount_received DOUBLE PRECISION NOT NULL, kofi_tx VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_31E581A0CF4E6CFB ON donation(kofi_tx)');
        $this->addSql('CREATE INDEX year_month_idx ON donation(year, month)');
    }

    public function down(Schema $schema): void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE donation');
    }
}
