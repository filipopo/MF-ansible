<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250107003305 extends AbstractMigration {
    public function getDescription(): string {
        return 'Adds default users';
    }

    public function up(Schema $schema): void {
        $pass = getenv('ADMIN_PASSWORD') ?: 'P@ssword123!';
        $pass = password_hash($pass, PASSWORD_BCRYPT);
        $this->addSql("REPLACE INTO user VALUES (0, 'admin', '[\"ROLE_ADMIN\"]', '$pass'), (1, 'user', '[]', '$pass')");
    }

    public function down(Schema $schema): void {
        $this->addSql("DELETE FROM user WHERE username IN ('admin', 'user')");
    }
}
